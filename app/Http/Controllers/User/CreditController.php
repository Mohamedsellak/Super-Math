<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CreditHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
    
}
