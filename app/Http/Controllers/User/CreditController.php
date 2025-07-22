<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CreditHistory;
use App\Services\MercadoPagoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class CreditController extends Controller
{
    /**
     * Display the credit history page for the authenticated user.
     */
    public function index(): View
    {
        $user = Auth::user();
        
        // Get credit history ordered by latest first
        $creditHistory = $user->creditHistories()
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('user.credit.index', compact('user', 'creditHistory'));
    }

    public function purchase()
    {
        return view('user.credit.purchase');
    }

    /**
     * Create payment preference and redirect to MercadoPago
     */
    public function createPayment(Request $request): RedirectResponse
    {
        $request->validate([
            'credit_amount' => 'required|integer|min:50|max:1000',
            'months' => 'required|integer|min:1|max:12',
        ]);

        try {
            // Instantiate MercadoPago service only when needed
            $mercadoPagoService = new MercadoPagoService();
            
            $user = Auth::user();
            $creditAmount = $request->credit_amount;
            $months = $request->months;
            
            // Debug: Log what we're receiving from the form
            Log::info('Credit purchase form data received', [
                'user_id' => $user->id,
                'credit_amount' => $creditAmount,
                'months' => $months,
                'all_request_data' => $request->all()
            ]);
            
            // Calculate price
            $price = $mercadoPagoService->calculatePrice($creditAmount, $months);
            
            Log::info('Calculated price', [
                'credit_amount' => $creditAmount,
                'months' => $months,
                'calculated_price' => $price
            ]);
            
            // Create payment preference
            $preference = $mercadoPagoService->createCreditPurchasePreference(
                $user, 
                $creditAmount, 
                $months, 
                $price
            );

            // Redirect to MercadoPago checkout
            $redirectUrl = config('services.mercadopago.sandbox') 
                ? $preference->sandbox_init_point 
                : $preference->init_point;
                
            return redirect($redirectUrl);

        } catch (\Exception $e) {
            // Log the full error for debugging
            Log::error('MercadoPago payment creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            session()->flash('payment_error', 'Failed to create payment: ' . $e->getMessage());
            return redirect()->route('user.credit.purchase');
        }
    }

    /**
     * Handle successful payment callback
     */
    public function paymentSuccess(Request $request): RedirectResponse
    {
        $paymentId = $request->get('payment_id');
        $status = $request->get('status');
        $externalReference = $request->get('external_reference');

        Log::info('Payment success callback received', [
            'payment_id' => $paymentId,
            'status' => $status,
            'external_reference' => $externalReference,
            'all_request_data' => $request->all()
        ]);

        if ($status === 'approved' && $paymentId && $externalReference) {
            // Parse external reference: userId_creditAmount_months_timestamp
            $parts = explode('_', $externalReference);
            
            Log::info('Parsing external reference', [
                'external_reference' => $externalReference,
                'parts' => $parts,
                'parts_count' => count($parts)
            ]);
            
            if (count($parts) >= 3) {
                $userId = $parts[0];
                $creditAmount = (int)$parts[1];
                $months = (int)$parts[2];

                $user = \App\Models\User::find($userId);
                
                Log::info('User verification', [
                    'user_id_from_reference' => $userId,
                    'authenticated_user_id' => Auth::id(),
                    'user_found' => $user ? 'yes' : 'no',
                    'credit_amount' => $creditAmount,
                    'months' => $months,
                    'user_match' => $user && $user->id === Auth::id() ? 'yes' : 'no'
                ]);
                
                // Verify this is the authenticated user (for security)
                if ($user && $user->id === Auth::id() && $creditAmount > 0) {
                    
                    // Check if this payment was already processed (prevent duplicates)
                    $existingRecord = CreditHistory::where('description', 'LIKE', "%Payment ID: {$paymentId}%")->first();
                    
                    if (!$existingRecord) {
                        // Process the payment using the service
                        $mercadoPagoService = new MercadoPagoService();
                        $paidAmount = $mercadoPagoService->calculatePrice($creditAmount, $months);
                        
                        // Use the service method to process the payment
                        $mercadoPagoService->processSuccessfulPayment(
                            $user, 
                            $paymentId, 
                            $creditAmount, 
                            $months, 
                            $paidAmount
                        );

                        Log::info('Payment processed successfully', [
                            'user_id' => $user->id,
                            'credits_added' => $creditAmount,
                            'amount_paid' => $paidAmount,
                            'payment_id' => $paymentId
                        ]);

                        session()->flash('payment_success', "🎉 Successfully purchased {$creditAmount} credits for {$months} months! Your account has been updated.");
                    } else {
                        session()->flash('payment_info', 'This payment has already been processed.');
                        Log::info('Duplicate payment attempt detected', ['payment_id' => $paymentId]);
                    }

                    return redirect()->route('user.credits.index');
                }
            }
        }

        Log::warning('Payment success callback failed validation', [
            'status' => $status,
            'payment_id' => $paymentId,
            'external_reference' => $externalReference,
            'auth_user_id' => Auth::id()
        ]);

        session()->flash('payment_error', 'Payment verification failed. Please contact support if you were charged.');
        return redirect()->route('user.credit.purchase');
    }

    /**
     * Handle failed payment callback
     */
    public function paymentFailure(Request $request): RedirectResponse
    {
        Log::info('Payment failure callback received', $request->all());
        
        session()->flash('payment_error', 'Payment was not completed. Please try again.');
        return redirect()->route('user.credit.purchase');
    }

    /**
     * Handle pending payment callback
     */
    public function paymentPending(Request $request): RedirectResponse
    {
        Log::info('Payment pending callback received', $request->all());
        
        session()->flash('payment_pending', 'Your payment is being processed. You will receive your credits once the payment is confirmed.');
        return redirect()->route('user.credits.index');
    }

    /**
     * Handle MercadoPago webhook notifications
     */
    public function webhook(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            
            if ($data['type'] === 'payment') {
                $paymentId = $data['data']['id'];
                
                // Here you would typically verify the payment with MercadoPago API
                // and update the credit history and user credits accordingly
                
                Log::info('MercadoPago webhook received', $data);
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('MercadoPago webhook error: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }
    
    
}
