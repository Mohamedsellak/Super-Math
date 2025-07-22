<?php

namespace App\Services;

use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Resources\Preference;
use App\Models\User;
use App\Models\CreditHistory;
use Illuminate\Support\Facades\Log;

class MercadoPagoService
{
    private $client;

    public function __construct()
    {
        // Configure MercadoPago SDK - try multiple ways to get the token
        $accessToken = config('services.mercadopago.access_token') ?: env('MERCADOPAGO_ACCESS_TOKEN');
        
        if (!$accessToken) {
            throw new \Exception('MercadoPago access token not configured');
        }

        MercadoPagoConfig::setAccessToken($accessToken);
        
        // Set runtime environment using proper constants
        $sandbox = config('services.mercadopago.sandbox') ?? env('MERCADOPAGO_SANDBOX', true);
        if ($sandbox) {
            MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);
        } else {
            MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::SERVER);
        }

        $this->client = new PreferenceClient();
    }

    /**
     * Create a payment preference for credit purchase
     */
    public function createCreditPurchasePreference(User $user, int $creditAmount, int $months, float $price): Preference
    {
        $preference = [
            'items' => [
                [
                    'title' => $creditAmount . ' Credits for Super Math',
                    'description' => "Purchase of {$creditAmount} credits for {$months} months",
                    'quantity' => 1,
                    'unit_price' => $price,
                    'currency_id' => 'ARS',
                ]
            ],
            'payer' => [
                'email' => $user->email,
            ],
            'external_reference' => $user->id . '_' . $creditAmount . '_' . $months . '_' . time(),
        ];

        // Only add back URLs if not in local development or if we have a proper URL
        if (!app()->environment('local') || env('NGROK_URL') || !config('services.mercadopago.sandbox')) {
            $baseUrl = env('NGROK_URL') ?: config('app.url');
            $preference['back_urls'] = [
                'success' => $baseUrl . '/dashboard/credits/payment/success',
                'failure' => $baseUrl . '/dashboard/credits/payment/failure',
                'pending' => $baseUrl . '/dashboard/credits/payment/pending',
            ];
            $preference['auto_return'] = 'approved';
        }

        try {
            Log::info('Creating MercadoPago preference', [
                'preference' => $preference,
                'price_received' => $price,
                'credit_amount' => $creditAmount,
                'months' => $months
            ]);
            $result = $this->client->create($preference);
            Log::info('MercadoPago preference created successfully', ['id' => $result->id ?? 'unknown']);
            return $result;
        } catch (\Exception $e) {
            // Log detailed error information including the full exception
            Log::error('MercadoPago API Error', [
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'preference_data' => $preference,
                'user_id' => $user->id,
                'access_token_length' => strlen(config('services.mercadopago.access_token') ?: env('MERCADOPAGO_ACCESS_TOKEN')),
                'full_trace' => $e->getTraceAsString(),
            ]);

            throw new \Exception('MercadoPago API Error: ' . $e->getMessage());
        }
    }

    /**
     * Calculate price based on credit amount and months (in ARS)
     */
    public function calculatePrice(int $creditAmount, int $months): float
    {
        // Base price per credit in ARS (much smaller for testing)
        $pricePerCredit = 1; // 1 ARS per credit for testing
        
        // Discount for longer periods
        $monthlyMultiplier = match($months) {
            1 => 1.0,
            2, 3 => 0.95,
            4, 5, 6 => 0.90,
            7, 8, 9 => 0.85,
            default => 0.80, // 10+ months
        };

        $calculatedPrice = round($creditAmount * $pricePerCredit * $monthlyMultiplier, 2);
        
        // Debug logging to see what's happening
        Log::info('Price calculation debug', [
            'creditAmount' => $creditAmount,
            'months' => $months,
            'pricePerCredit' => $pricePerCredit,
            'monthlyMultiplier' => $monthlyMultiplier,
            'before_round' => $creditAmount * $pricePerCredit * $monthlyMultiplier,
            'calculatedPrice' => $calculatedPrice,
            'final_price' => max($calculatedPrice, 1.0)
        ]);
        
        // Ensure price is never 0 (MercadoPago doesn't allow 0 prices)
        return max($calculatedPrice, 1.0);
    }

    /**
     * Process successful payment and add credits to user
     */
    public function processSuccessfulPayment(User $user, string $paymentId, int $creditAmount, int $months, float $paidAmount): void
    {
        // Calculate expiry date
        $expiryDate = now()->addMonths($months);

        // Add credits to user
        $user->increment('credit', $creditAmount);

        // Update credit expiry date - extend if current expiry is earlier than new expiry
        if (!$user->credit_expires_at || $user->credit_expires_at < $expiryDate) {
            $user->credit_expires_at = $expiryDate;
            $user->save();
        }

        // Create credit history record
        CreditHistory::create([
            'user_id' => $user->id,
            'amount' => '+' . $creditAmount,
            'action' => 'Payment',
            'description' => "Purchased {$creditAmount} credits via MercadoPago. Valid until {$expiryDate->format('Y-m-d')}. Payment ID: {$paymentId}",
        ]);
    }
}
