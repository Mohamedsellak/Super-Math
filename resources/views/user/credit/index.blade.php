@extends('layouts.user')

@section('title', 'My Credits')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">Credit History</h1>
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="bg-blue-100 px-4 py-2 rounded-lg">
                    <span class="text-sm text-gray-600">Current Balance:</span>
                    <span class="text-xl font-bold text-blue-600">{{ $user->credit ?? 0 }} Credits</span>
                </div>
                <a href="{{ route('user.credit.purchase') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 text-center">
                    Purchase Credits
                </a>
            </div>
        </div>

        <!-- Quick Stats -->
        @if($creditHistory->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-gradient-to-r from-green-50 to-green-100 p-4 rounded-lg border border-green-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm text-green-600 font-medium">Total Earned</div>
                            <div class="text-lg font-bold text-green-700">
                                {{ $creditHistory->where('action', 'earned')->sum('amount') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-red-50 to-red-100 p-4 rounded-lg border border-red-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-8 h-8 bg-red-500 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm text-red-600 font-medium">Total Spent</div>
                            <div class="text-lg font-bold text-red-700">
                                {{ $creditHistory->where('action', 'spent')->sum('amount') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-lg border border-blue-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm text-blue-600 font-medium">Transactions</div>
                            <div class="text-lg font-bold text-blue-700">
                                {{ $creditHistory->count() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-purple-50 to-purple-100 p-4 rounded-lg border border-purple-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm text-purple-600 font-medium">This Month</div>
                            <div class="text-lg font-bold text-purple-700">
                                {{ $creditHistory->where('created_at', '>=', now()->startOfMonth())->count() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Credit History Table -->
        @if($creditHistory->count() > 0)
            <!-- Filter Options -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Recent Transactions</h2>
                    <p class="text-sm text-gray-600">Your complete credit transaction history</p>
                </div>
                <div class="flex gap-2">
                    <select class="border border-gray-300 rounded-md px-3 py-2 text-sm" onchange="filterTransactions(this.value)">
                        <option value="all">All Actions</option>
                        <option value="earned">Earned Only</option>
                        <option value="spent">Spent Only</option>
                        <option value="purchased">Purchased Only</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date & Time
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Description
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="transactionTableBody">
                        @foreach($creditHistory as $history)
                            <tr class="hover:bg-gray-50 transaction-row" data-action="{{ $history->action }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $history->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $history->created_at->format('g:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($history->action === 'earned') bg-green-100 text-green-800
                                        @elseif($history->action === 'spent') bg-red-100 text-red-800
                                        @elseif($history->action === 'purchased') bg-blue-100 text-blue-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        @if($history->action === 'earned')
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        @elseif($history->action === 'spent')
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                            </svg>
                                        @elseif($history->action === 'purchased')
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                            </svg>
                                        @endif
                                        {{ ucfirst($history->action) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium
                                        @if($history->action === 'earned') text-green-600
                                        @elseif($history->action === 'spent') text-red-600
                                        @elseif($history->action === 'purchased') text-blue-600
                                        @else text-gray-600
                                        @endif">
                                        @if($history->action === 'earned' || $history->action === 'purchased')
                                            +{{ $history->amount }}
                                        @elseif($history->action === 'spent')
                                            -{{ $history->amount }}
                                        @else
                                            {{ $history->amount }}
                                        @endif
                                        <span class="text-xs text-gray-500 ml-1">Credits</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    @if($history->action === 'earned')
                                        Credits earned from completing math problems
                                    @elseif($history->action === 'spent')
                                        Credits used for premium features
                                    @elseif($history->action === 'purchased')
                                        Credits purchased from credit store
                                    @else
                                        {{ ucfirst($history->action) }} transaction
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="mx-auto w-32 h-32 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-medium text-gray-900 mb-4">No Credit History Yet</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">
                    You haven't earned or spent any credits yet. Start by solving math problems to earn credits, 
                    or purchase credits to unlock premium features.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('user.dashboard') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200">
                        Start Solving Problems
                    </a>
                    <a href="{{ route('user.credit.purchase') }}" 
                       class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200">
                        Purchase Credits
                    </a>
                </div>
            </div>
        @endif

        <!-- Information Panel -->
        <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-100 rounded-lg p-6 border border-blue-200">
            <h3 class="text-xl font-semibold text-blue-800 mb-4">How Credits Work</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-semibold text-blue-700 mb-2">Earning Credits</h4>
                    <ul class="text-blue-600 text-sm space-y-1">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Solve basic problems: 1-2 credits
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Solve advanced problems: 3-5 credits
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Complete daily challenges: 10+ credits
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-blue-700 mb-2">Using Credits</h4>
                    <ul class="text-blue-600 text-sm space-y-1">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            View detailed solutions: 2 credits
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Get step-by-step explanations: 3 credits
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Access premium problem sets: 5+ credits
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function filterTransactions(action) {
    const rows = document.querySelectorAll('.transaction-row');
    
    rows.forEach(row => {
        const rowAction = row.getAttribute('data-action');
        if (action === 'all' || rowAction === action) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Add some animation to the stats cards
document.addEventListener('DOMContentLoaded', function() {
    const statsCards = document.querySelectorAll('.bg-gradient-to-r');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    });
    
    statsCards.forEach((card) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.5s ease-in-out, transform 0.5s ease-in-out';
        observer.observe(card);
    });
});
</script>
@endsection

@push('styles')
@endpush
