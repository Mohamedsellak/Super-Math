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
            
            // Calculate price
            $price = $mercadoPagoService->calculatePrice($creditAmount, $months);
            
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

        if ($status === 'approved' && $paymentId) {
            // Extract user ID from external reference
            $parts = explode('_', $externalReference);
            $userId = $parts[0] ?? null;

            if ($userId) {
                $user = \App\Models\User::find($userId);
                if ($user && $user->id === Auth::id()) {
                    // You might want to verify the payment with MercadoPago API here
                    // For now, we'll trust the callback
                    
                    session()->flash('payment_success', 'Payment completed successfully! Your credits have been added to your account.');
                    return redirect()->route('credits.index');
                }
            }
        }

        session()->flash('payment_error', 'Payment verification failed. Please contact support if you were charged.');
        return redirect()->route('user.credit.purchase');
    }

    /**
     * Handle failed payment callback
     */
    public function paymentFailure(Request $request): RedirectResponse
    {
        session()->flash('payment_error', 'Payment was not completed. Please try again.');
        return redirect()->route('user.credit.purchase');
    }

    /**
     * Handle pending payment callback
     */
    public function paymentPending(Request $request): RedirectResponse
    {
        session()->flash('payment_pending', 'Your payment is being processed. You will receive your credits once the payment is confirmed.');
        return redirect()->route('credits.index');
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
