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
                    
                    
                    {{ $user->credit_expires_at ? 'Credit expire at ' . $user->credit_expires_at->format('Y-m-d') : '' }}
                </div>
                <a href="{{ route('user.credit.purchase') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 text-center">
                    Purchase Credits
                </a>
            </div>
        </div>

        <!-- Enhanced Stats Dashboard -->
        @if($creditHistory->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Downloads Card -->
                <div class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-blue-100 to-blue-200 rounded-2xl border border-blue-200 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-300 rounded-full opacity-20 -translate-y-16 translate-x-16"></div>
                    <div class="relative p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-4-4m4 4l4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-blue-700 uppercase tracking-wide">Downloads</p>
                                    <p class="text-xs text-blue-600">Question packages</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-3xl font-bold text-blue-800">{{ $creditHistory->where('action', 'Download')->count() }}</p>
                                <p class="text-xs text-blue-600 font-medium">Total Files</p>
                            </div>
                        </div>
                        <div class="w-full bg-blue-200 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full transition-all duration-500" style="width: {{ $creditHistory->count() > 0 ? ($creditHistory->where('action', 'Download')->count() / $creditHistory->count()) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Payments Card -->
                <div class="relative overflow-hidden bg-gradient-to-br from-green-50 via-green-100 to-green-200 rounded-2xl border border-green-200 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-green-300 rounded-full opacity-20 -translate-y-16 translate-x-16"></div>
                    <div class="relative p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-green-700 uppercase tracking-wide">Payments</p>
                                    <p class="text-xs text-green-600">Credit purchases</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-3xl font-bold text-green-800">{{ $creditHistory->where('action', 'Payment')->count() }}</p>
                                <p class="text-xs text-green-600 font-medium">Transactions</p>
                            </div>
                        </div>
                        <div class="w-full bg-green-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full transition-all duration-500" style="width: {{ $creditHistory->count() > 0 ? ($creditHistory->where('action', 'Payment')->count() / $creditHistory->count()) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Expired Card -->
                <div class="relative overflow-hidden bg-gradient-to-br from-red-50 via-red-100 to-red-200 rounded-2xl border border-red-200 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-red-300 rounded-full opacity-20 -translate-y-16 translate-x-16"></div>
                    <div class="relative p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-red-700 uppercase tracking-wide">Expired</p>
                                    <p class="text-xs text-red-600">Credit expiry</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-3xl font-bold text-red-800">{{ $creditHistory->where('action', 'Expired')->count() }}</p>
                                <p class="text-xs text-red-600 font-medium">Instances</p>
                            </div>
                        </div>
                        <div class="w-full bg-red-200 rounded-full h-2">
                            <div class="bg-red-500 h-2 rounded-full transition-all duration-500" style="width: {{ $creditHistory->count() > 0 ? ($creditHistory->where('action', 'Expired')->count() / $creditHistory->count()) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Summary Bar -->
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-4 mb-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-blue-500 rounded-full animate-pulse"></div>
                            <span class="text-sm font-medium text-gray-700">Total Activity</span>
                        </div>
                        <span class="text-lg font-bold text-gray-800">{{ $creditHistory->count() }} transactions</span>
                    </div>
                    <div class="text-xs text-gray-500">
                        Last activity: {{ $creditHistory->first()->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        @endif

        <!-- Credit History Table -->
        @if($creditHistory->count() > 0)
            <!-- Filter Options -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Transaction History</h2>
                    <p class="text-sm text-gray-600 mt-1">Track all your credit activities and downloads</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        <span>{{ $creditHistory->count() }} transactions</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                            {{ $creditHistory->where('action', 'Download')->count() }} Downloads
                        </span>
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                            {{ $creditHistory->where('action', 'Payment')->count() }} Payments
                        </span>
                        <span class="px-3 py-1 bg-red-100 text-red-800 text-xs rounded-full">
                            {{ $creditHistory->where('action', 'Expired')->count() }} Expired
                        </span>
                    </div>
                </div>
            </div>

            <!-- Enhanced Table with Cards Design -->
            <div class="space-y-4">
                @foreach($creditHistory as $index => $history)
                    <div class="transaction-card bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 p-6" data-action="{{ $history->action }}">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <!-- Left Section: Action & Description -->
                            <div class="flex items-start gap-4 flex-1">
                                <!-- Action Icon & Badge -->
                                <div class="flex-shrink-0">
                                    @if($history->action === 'Download')
                                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-4-4m4 4l4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    @elseif($history->action === 'Payment')
                                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                            </svg>
                                        </div>
                                    @elseif($history->action === 'Expired')
                                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Details -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            @if($history->action === 'Download')
                                                Document Download
                                            @elseif($history->action === 'Payment')
                                                Credit Purchase
                                            @elseif($history->action === 'Expired')
                                                Credits Expired
                                            @else
                                                {{ ucfirst($history->action) }}
                                            @endif
                                        </h3>
                                        
                                        <!-- Action Badge -->
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($history->action === 'Download') bg-blue-50 text-blue-700 border border-blue-200
                                            @elseif($history->action === 'Payment') bg-green-50 text-green-700 border border-green-200
                                            @elseif($history->action === 'Expired') bg-red-50 text-red-700 border border-red-200
                                            @else bg-gray-50 text-gray-700 border border-gray-200
                                            @endif">
                                            {{ $history->action }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-sm text-gray-600 mb-2">
                                        {{ $history->description }}
                                    </p>
                                    
                                    <!-- Timestamp -->
                                    <div class="flex items-center gap-2 text-xs text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ $history->created_at->format('M d, Y \a\t g:i A') }}</span>
                                        <span class="text-gray-300">•</span>
                                        <span>{{ $history->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Section: Amount -->
                            <div class="flex flex-col items-end gap-2 flex-shrink-0">
                                <div class="text-right">
                                    <div class="text-2xl font-bold 
                                        @if($history->action === 'Download' ) text-blue-500
                                        @elseif ( $history->action === 'Expired') text-red-500
                                        @elseif($history->action === 'Payment') text-green-500
                                        @else text-gray-600
                                        @endif">
                                        {{ $history->amount }}
                                    </div>
                                    <div class="text-xs text-gray-500 font-medium">CREDITS</div>
                                </div>
                                
                                <!-- Transaction ID -->
                                <div class="text-xs text-gray-400 font-mono bg-gray-50 px-2 py-1 rounded">
                                    #{{ str_pad($history->id, 6, '0', STR_PAD_LEFT) }}
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Pagination would go here if needed -->
            <div class="mt-8 flex justify-center">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 border border-blue-100">
                    <p class="text-sm text-blue-700 text-center">
                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        Showing {{ $creditHistory->count() }} recent transactions
                    </p>
                </div>
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

    </div>
</div>

@endsection

@push('styles')
@endpush
