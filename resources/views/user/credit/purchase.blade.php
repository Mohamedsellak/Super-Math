@extends('layouts.user')

@section('title', 'Purchase Credits')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Purchase Credits</h1>
            <div class="bg-blue-100 px-4 py-2 rounded-lg">
                <span class="text-sm text-gray-600">Current Balance:</span>
                <span class="text-xl font-bold text-blue-600" data-balance>{{ Auth::user()->credit ?? 0 }} Credits</span>
            </div>
        </div>

        <!-- Modern Purchase Card -->
        <div class="mb-8 flex flex-col items-center justify-center">
            <div class="w-full md:w-2/3 lg:w-1/2 bg-gradient-to-br from-blue-100 via-purple-50 to-green-100 border border-blue-200 rounded-2xl shadow-xl p-10 flex flex-col items-center">
                <div class="mb-6 flex flex-col items-center">
                    <span class="inline-block bg-gradient-to-r from-blue-500 to-green-400 text-white px-6 py-2 rounded-full text-lg font-bold shadow">Purchase Custom Credits</span>
                    <span class="mt-2 text-gray-500 text-sm">Set your desired credit amount and expiry period</span>
                </div>
                <div class="w-full flex flex-col md:flex-row md:space-x-8 space-y-6 md:space-y-0">
                    <div class="flex-1 flex flex-col items-center">
                        <label for="creditProgress" class="block text-base font-semibold text-blue-700 mb-2">Credit Amount</label>
                        <div class="flex items-center w-full space-x-4">
                            <span id="creditAmountLabel" class="text-blue-700 font-bold text-xl">50</span>
                            <input type="range" id="creditProgress" min="50" max="1000" value="50" step="50" class="w-full h-3 bg-blue-200 rounded-lg appearance-none cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all">
                            <span class="text-gray-500">/ 1000</span>
                        </div>
                    </div>
                    <div class="flex-1 flex flex-col items-center">
                        <label for="monthProgress" class="block text-base font-semibold text-purple-700 mb-2">Months Until Expiry</label>
                        <div class="flex items-center w-full space-x-4">
                            <span id="monthLabel" class="text-purple-700 font-bold text-xl">1</span>
                            <input type="range" id="monthProgress" min="1" max="12" value="1" class="w-full h-3 bg-purple-200 rounded-lg appearance-none cursor-pointer focus:outline-none focus:ring-2 focus:ring-purple-400 transition-all">
                            <span class="text-gray-500">/ 12</span>
                        </div>
                    </div>
                </div>
                <div class="flex w-full mt-8 space-x-4">
                    <a href="{{ route('user.dashboard') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-6 rounded-lg transition-colors duration-200 text-center block">Cancel</a>
                    <button type="button"
                            class="flex-1 bg-gradient-to-r from-green-500 to-blue-500 hover:from-green-600 hover:to-blue-600 text-white font-semibold py-3 px-6 rounded-lg shadow transition-all duration-200">
                        Complete Purchase
                    </button>
                </div>
            </div>
        </div>


        <!-- Benefits Section -->
        <div class="mt-8 bg-blue-50 rounded-lg p-6">
            <h3 class="text-xl font-semibold text-blue-800 mb-4">Why Purchase Credits?</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center mr-3 mt-1">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-blue-800">Access Premium Features</h4>
                        <p class="text-blue-600 text-sm">Unlock advanced math problems and detailed solutions</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center mr-3 mt-1">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-blue-800">Step-by-Step Solutions</h4>
                        <p class="text-blue-600 text-sm">Get detailed explanations for complex problems</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center mr-3 mt-1">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-blue-800">Priority Support</h4>
                        <p class="text-blue-600 text-sm">Get faster responses from our support team</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center mr-3 mt-1">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-blue-800">No Expiration</h4>
                        <p class="text-blue-600 text-sm">Credits never expire, use them whenever you need</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
