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

        <!-- Credit Packages -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Choose a Credit Package</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Basic Package -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-lg p-6 hover:shadow-lg transition-shadow duration-300">
                    <div class="text-center">
                        <h3 class="text-xl font-bold text-blue-800 mb-2">Basic Package</h3>
                        <div class="text-3xl font-bold text-blue-600 mb-2">100 Credits</div>
                        <div class="text-lg text-gray-600 mb-4">$9.99</div>
                        <div class="text-sm text-gray-500 mb-4">Perfect for light usage</div>
                        <button onclick="selectPackage('basic', 100, 9.99)" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200">
                            Select Package
                        </button>
                    </div>
                </div>

                <!-- Standard Package -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-lg p-6 hover:shadow-lg transition-shadow duration-300 relative">
                    <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold">Most Popular</span>
                    </div>
                    <div class="text-center">
                        <h3 class="text-xl font-bold text-green-800 mb-2">Standard Package</h3>
                        <div class="text-3xl font-bold text-green-600 mb-2">500 Credits</div>
                        <div class="text-lg text-gray-600 mb-2">$39.99</div>
                        <div class="text-sm text-green-600 mb-4">Save 20% - Best Value!</div>
                        <button onclick="selectPackage('standard', 500, 39.99)" 
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200">
                            Select Package
                        </button>
                    </div>
                </div>

                <!-- Premium Package -->
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-lg p-6 hover:shadow-lg transition-shadow duration-300">
                    <div class="text-center">
                        <h3 class="text-xl font-bold text-purple-800 mb-2">Premium Package</h3>
                        <div class="text-3xl font-bold text-purple-600 mb-2">1000 Credits</div>
                        <div class="text-lg text-gray-600 mb-2">$69.99</div>
                        <div class="text-sm text-purple-600 mb-4">Save 30% - Maximum Value!</div>
                        <button onclick="selectPackage('premium', 1000, 69.99)" 
                                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200">
                            Select Package
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Purchase Form -->
        <div id="purchaseForm" class="hidden">
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Order Summary</h3>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-600">Package:</span>
                    <span id="selectedPackage" class="font-semibold"></span>
                </div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-600">Credits:</span>
                    <span id="selectedCredits" class="font-semibold"></span>
                </div>
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-600">Total:</span>
                    <span id="selectedPrice" class="text-xl font-bold text-green-600"></span>
                </div>
            </div>

            <div class="space-y-6">
                <!-- Payment Method -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <input id="credit_card" name="payment_method" type="radio" value="credit_card" 
                                   class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" checked>
                            <label for="credit_card" class="ml-3 block text-sm font-medium text-gray-700">
                                Credit Card
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input id="paypal" name="payment_method" type="radio" value="paypal" 
                                   class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                            <label for="paypal" class="ml-3 block text-sm font-medium text-gray-700">
                                PayPal
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Credit Card Details -->
                <div id="creditCardDetails" class="space-y-4">
                    <div>
                        <label for="card_number" class="block text-sm font-medium text-gray-700">Card Number</label>
                        <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="expiry_date" class="block text-sm font-medium text-gray-700">Expiry Date</label>
                            <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YY"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="cvv" class="block text-sm font-medium text-gray-700">CVV</label>
                            <input type="text" id="cvv" name="cvv" placeholder="123"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    <div>
                        <label for="cardholder_name" class="block text-sm font-medium text-gray-700">Cardholder Name</label>
                        <input type="text" id="cardholder_name" name="cardholder_name" placeholder="John Doe"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-4">
                    <button type="button" onclick="cancelPurchase()" 
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-6 rounded-lg transition-colors duration-200">
                        Cancel
                    </button>
                    <button type="button" onclick="showComingSoon()"
                            class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200">
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

<script>
function selectPackage(type, credits, price) {
    document.getElementById('selectedPackage').textContent = type.charAt(0).toUpperCase() + type.slice(1) + ' Package';
    document.getElementById('selectedCredits').textContent = credits + ' Credits';
    document.getElementById('selectedPrice').textContent = '$' + price.toFixed(2);
    
    document.getElementById('purchaseForm').classList.remove('hidden');
    document.getElementById('purchaseForm').scrollIntoView({ behavior: 'smooth' });
}

function cancelPurchase() {
    document.getElementById('purchaseForm').classList.add('hidden');
}

function showComingSoon() {
    alert('Payment processing feature coming soon! This is just a preview of the purchase interface.');
}

// Toggle payment method details
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const creditCardDetails = document.getElementById('creditCardDetails');
    
    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            if (this.value === 'credit_card') {
                creditCardDetails.style.display = 'block';
            } else {
                creditCardDetails.style.display = 'none';
            }
        });
    });
});
</script>
@endsection

@push('styles')
<style>
    .transition-all {
        transition: all 0.3s ease-in-out;
    }
</style>
@endpush
