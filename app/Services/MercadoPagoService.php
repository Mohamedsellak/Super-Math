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
        // Configure MercadoPago SDK - get from config
        $accessToken = config('services.mercadopago.access_token');

        if (!$accessToken) {
            throw new \Exception('MercadoPago access token not configured in services.php');
        }

        MercadoPagoConfig::setAccessToken($accessToken);

        // Set runtime environment using proper constants
        $sandbox = config('services.mercadopago.sandbox', false);
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
                    'id' => 'credits_' . $creditAmount,
                    'title' => $creditAmount . ' Credits for Super Math',
                    'description' => "Purchase of {$creditAmount} credits valid for {$months} month(s)",
                    'quantity' => 1,
                    'unit_price' => $price,
                    'currency_id' => 'USD',
                ]
            ],
            'payer' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
            'back_urls' => [
                'success' => route('user.credit.payment.success'),
                'failure' => route('user.credit.payment.failure'),
                'pending' => route('user.credit.payment.pending'),
            ],
            'auto_return' => 'approved',
            'external_reference' => $user->id . '_' . time(),
            'notification_url' => route('credit.payment.webhook'),
            'statement_descriptor' => 'SuperMath Credits',
        ];

        try {
            return $this->client->create($preference);
        } catch (\Exception $e) {
            // Log detailed error information
            Log::error('MercadoPago API Error', [
                'error_message' => $e->getMessage(),
                'preference_data' => $preference,
                'user_id' => $user->id,
                'access_token_length' => strlen(config('services.mercadopago.access_token') ?: env('MERCADOPAGO_ACCESS_TOKEN')),
            ]);

            throw new \Exception('MercadoPago API Error: ' . $e->getMessage());
        }
    }

    /**
     * Calculate price based on credit amount and months
     */
    public function calculatePrice(int $creditAmount, int $months): float
    {
        // Base price per credit (you can adjust this)
        $pricePerCredit = 0.10; // $0.10 per credit

        // Discount for longer periods
        $monthlyMultiplier = match($months) {
            1 => 1.0,
            2, 3 => 0.95,
            4, 5, 6 => 0.90,
            7, 8, 9 => 0.85,
            default => 0.80, // 10+ months
        };

        return round($creditAmount * $pricePerCredit * $monthlyMultiplier, 2);
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

        // Create credit history record
        CreditHistory::create([
            'user_id' => $user->id,
            'amount' => '+' . $creditAmount,
            'action' => 'Payment',
            'description' => "Purchased {$creditAmount} credits via MercadoPago. Valid until {$expiryDate->format('Y-m-d')}. Payment ID: {$paymentId}",
        ]);
    }
}
