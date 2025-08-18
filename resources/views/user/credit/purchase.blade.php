@extends('layouts.user')

@section('title', 'Purchase Credits')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Flash & Validation Messages -->
    @if($errors->any())
        <div class="mb-6 rounded-lg border border-red-300 bg-red-50 px-5 py-4 text-sm text-red-700">
            <p class="font-semibold mb-2">Please fix the following:</p>
            <ul class="list-disc ml-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('payment_error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('payment_error') }}</span>
        </div>
    @endif
    @if(session('payment_pending'))
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6" role="alert">
            <strong class="font-bold">Pending!</strong>
            <span class="block sm:inline">{{ session('payment_pending') }}</span>
        </div>
    @endif

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <h1 class="text-3xl font-bold text-gray-800 flex items-center space-x-3">
            <span>Purchase Credits</span>
            <span class="inline-flex items-center text-xs font-semibold px-2 py-1 rounded-full bg-blue-100 text-blue-700 tracking-wide">Secure Checkout</span>
        </h1>
        <div class="flex items-center gap-4">
            <div class="bg-blue-100 px-4 py-2 rounded-lg">
                <span class="text-sm text-gray-600">Current Balance:</span>
                <span class="text-xl font-bold text-blue-600" data-balance>{{ Auth::user()->credit ?? 0 }} Credits</span>
            </div>
            <a href="{{ route('user.credits.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 underline">History</a>
        </div>
    </div>

    <!-- Purchase / Summary Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Purchase Card -->
        <div class="lg:col-span-2">
            <div class="w-full bg-gradient-to-br from-blue-100 via-purple-50 to-green-100 border border-blue-200 rounded-2xl shadow-xl p-8">
                <form action="{{ route('user.credit.create-payment') }}" method="POST" id="creditPurchaseForm" novalidate>
                    @csrf
                    <div class="mb-8 text-center">
                        <h2 class="inline-block bg-gradient-to-r from-blue-500 to-green-400 text-white px-6 py-2 rounded-full text-lg font-bold shadow">Customize Your Purchase</h2>
                        <p class="mt-2 text-gray-600 text-sm">Adjust amount & validity to see real-time pricing and savings</p>
                    </div>

                    <!-- Presets -->
                    <div class="mb-8">
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-3 tracking-wider">Quick Presets</p>
                        <div class="grid grid-cols-3 sm:grid-cols-6 gap-2" id="presetContainer">
                            @foreach([50,100,150,250,500,1000] as $preset)
                                <button type="button" data-credits="{{ $preset }}" aria-pressed="false" class="preset-btn relative px-3 py-2 rounded-lg text-sm font-semibold border border-blue-300/60 bg-white text-blue-600 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-1 transition-all">
                                    {{ $preset }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Sliders -->
                    <div class="flex flex-col space-y-10">
                        <!-- Credit Amount -->
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <label for="creditProgress" class="block text-base font-semibold text-blue-700">Credit Amount</label>
                                <span class="text-xs text-gray-500">Min 50 • Max 1000 • Step 50</span>
                            </div>
                            <div class="flex items-center w-full space-x-5">
                                <span id="creditAmountLabel" class="text-blue-700 font-bold text-2xl w-14 text-right">50</span>
                                <input aria-label="Credit amount" type="range" id="creditProgress" name="credit_amount" min="50" max="1000" value="50" step="50" class="flex-1 h-3 bg-blue-200/60 rounded-lg appearance-none cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all">
                                <span class="text-gray-500 text-sm w-16">/ 1000</span>
                            </div>
                        </div>
                        <!-- Months -->
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <label for="monthProgress" class="block text-base font-semibold text-purple-700">Validity (Months)</label>
                                <span class="text-xs text-gray-500">1 - 12 Months</span>
                            </div>
                            <div class="flex items-center w-full space-x-5">
                                <span id="monthLabel" class="text-purple-700 font-bold text-2xl w-14 text-right">1</span>
                                <input aria-label="Months until expiry" type="range" id="monthProgress" name="months" min="1" max="12" value="1" class="flex-1 h-3 bg-purple-200/60 rounded-lg appearance-none cursor-pointer focus:outline-none focus:ring-2 focus:ring-purple-400 transition-all">
                                <span class="text-gray-500 text-sm w-16">/ 12</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row w-full mt-10 gap-4">
                        <a href="{{ route('user.dashboard') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 px-6 rounded-lg transition-colors duration-150 text-center">Cancel</a>
                        <button type="submit" id="purchaseBtn" class="group relative flex-1 bg-gradient-to-r from-green-500 to-blue-500 hover:from-green-600 hover:to-blue-600 text-white font-semibold py-3 px-6 rounded-lg shadow transition-all duration-150 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span id="purchaseBtnText" class="inline-flex items-center">
                                <svg id="loadingSpinner" class="hidden animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                                Complete Purchase
                            </span>
                            <span id="purchaseBtnPrice" class="ml-2 font-bold tracking-wide text-white/90 text-sm">(ARS $<span id="priceDisplay">50.00</span>)</span>
                            <span id="discountBadge" class="hidden absolute -top-2 -right-2 bg-emerald-500 text-white text-[10px] px-2 py-1 rounded-full font-semibold shadow">-0%</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Panel -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 sticky top-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center space-x-2">
                    <i class="fas fa-receipt text-blue-500"></i><span>Order Summary</span>
                </h3>
                <dl class="text-sm space-y-3" id="orderSummary">
                    <div class="flex justify-between"><dt class="text-gray-600">Credits</dt><dd class="font-semibold text-gray-900" data-summary-credits>50</dd></div>
                    <div class="flex justify-between"><dt class="text-gray-600">Validity</dt><dd class="font-semibold text-gray-900" data-summary-months>1 Month</dd></div>
                    <div class="flex justify-between"><dt class="text-gray-600">Base Price</dt><dd class="text-gray-700" data-summary-base>ARS $50.00</dd></div>
                    <div class="flex justify-between" id="discountRow" class="hidden"><dt class="text-gray-600">Discount</dt><dd class="text-emerald-600 font-semibold" data-summary-discount>- ARS $0.00</dd></div>
                    <div class="pt-3 border-t border-dashed border-gray-300 flex justify-between items-center"><dt class="text-gray-700 font-semibold">Total</dt><dd class="text-xl font-bold text-gray-900" data-summary-total>ARS $50.00</dd></div>
                    <div class="flex justify-between text-xs text-gray-500 mt-1"><span>Effective / Credit</span><span data-summary-per-credit>ARS $1.00</span></div>
                    <div class="flex justify-between text-xs text-gray-500"><span>Estimated Expiry</span><span data-summary-expiry>--</span></div>
                </dl>
                <p class="mt-4 text-[11px] text-gray-500 leading-relaxed">By continuing you agree to the <a href="#" class="text-blue-600 hover:underline">Terms</a>. Payments are processed securely via MercadoPago. Credits are non-refundable once used.</p>
            </div>
            <div class="bg-gradient-to-br from-indigo-600 to-blue-600 text-white rounded-2xl shadow-lg p-5 text-sm">
                <h4 class="font-semibold mb-2 flex items-center space-x-2"><i class="fas fa-shield-alt"></i><span>Security & Tips</span></h4>
                <ul class="space-y-1 list-disc list-inside text-white/90">
                    <li>Your payment session is encrypted</li>
                    <li>Unused credits auto-expire on selected date</li>
                    <li>Download activity logged for transparency</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
/* Quick Preset Buttons Enhanced Styles */
.preset-btn { position:relative; overflow:hidden; }
.preset-btn:before { content:""; position:absolute; inset:0; background:linear-gradient(120deg,rgba(59,130,246,0.12),rgba(16,185,129,0.12)); opacity:0; transition:opacity .3s; }
.preset-btn:hover:before { opacity:1; }
.preset-btn.preset-active { background:linear-gradient(90deg,#2563eb,#1d4ed8); color:#fff !important; border-color:#1d4ed8; box-shadow:0 4px 14px -2px rgba(29,78,216,.5),0 0 0 1px rgba(255,255,255,.2) inset; transform:translateY(-2px); }
.preset-btn.preset-active:before { display:none; }
.preset-btn.preset-active:after { content:"✓"; position:absolute; top:4px; right:6px; font-size:.65rem; font-weight:700; opacity:.9; }
.preset-btn:not(.preset-active):active { transform:scale(.95); }
.preset-btn, .preset-btn.preset-active { transition:all .25s ease; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const creditProgress = document.getElementById('creditProgress');
    const monthProgress = document.getElementById('monthProgress');
    const creditAmountLabel = document.getElementById('creditAmountLabel');
    const monthLabel = document.getElementById('monthLabel');
    const priceDisplay = document.getElementById('priceDisplay');
    const purchaseBtn = document.getElementById('purchaseBtn');
    const purchaseBtnText = document.getElementById('purchaseBtnText');
    const discountBadge = document.getElementById('discountBadge');

    // Summary elements
    const summaryCredits = document.querySelector('[data-summary-credits]');
    const summaryMonths = document.querySelector('[data-summary-months]');
    const summaryBase = document.querySelector('[data-summary-base]');
    const summaryDiscount = document.querySelector('[data-summary-discount]');
    const summaryTotal = document.querySelector('[data-summary-total]');
    const summaryPerCredit = document.querySelector('[data-summary-per-credit]');
    const summaryExpiry = document.querySelector('[data-summary-expiry]');
    const discountRow = document.getElementById('discountRow');
    const presetButtons = document.querySelectorAll('.preset-btn');
    const loadingSpinner = document.getElementById('loadingSpinner');

    function plural(n, word){return n + ' ' + word + (n === 1 ? '' : 's');}

    function basePrice(creditAmount){
        return creditAmount * 1; // ARS 1 per credit base
    }

    function discountMultiplier(months){
        if (months >= 10) return 0.80;
        if (months >= 7) return 0.85;
        if (months >= 4) return 0.90;
        if (months >= 2) return 0.95;
        return 1.00;
    }

    function calculatePrice(creditAmount, months) {
        const multiplier = discountMultiplier(months);
        const raw = basePrice(creditAmount);
        const total = raw * multiplier;
        return { raw, total, multiplier };
    }

    function format(v){return 'ARS $' + v.toFixed(2);}    

    function updateExpiry(months){
        const d = new Date();
        d.setMonth(d.getMonth() + months);
        return d.toLocaleDateString(undefined, { day: '2-digit', month: 'short', year: 'numeric' });
    }

    function updateUI(){
        const credits = parseInt(creditProgress.value, 10);
        const months = parseInt(monthProgress.value, 10);
        const { raw, total, multiplier } = calculatePrice(credits, months);
        const discountPercent = Math.round((1 - multiplier) * 100);

        // Labels
        creditAmountLabel.textContent = credits;
        monthLabel.textContent = months;
        priceDisplay.textContent = total.toFixed(2);

        // Summary
        summaryCredits.textContent = credits;
        summaryMonths.textContent = plural(months, 'Month');
        summaryBase.textContent = format(raw);
        summaryTotal.textContent = format(total);
        summaryPerCredit.textContent = 'ARS $' + (total / credits).toFixed(2);
        summaryExpiry.textContent = updateExpiry(months);

        if(discountPercent > 0){
            discountRow.classList.remove('hidden');
            summaryDiscount.textContent = '- ' + format(raw - total);
            discountBadge.textContent = '-' + discountPercent + '%';
            discountBadge.classList.remove('hidden');
        } else {
            discountRow.classList.add('hidden');
            discountBadge.classList.add('hidden');
        }

        // Highlight active preset (improved styling)
        presetButtons.forEach(btn => {
            const val = parseInt(btn.getAttribute('data-credits'),10);
            const active = val === credits;
            btn.classList.toggle('preset-active', active);
            btn.setAttribute('aria-pressed', active ? 'true' : 'false');
        });
    }

    // Events
    creditProgress.addEventListener('input', updateUI);
    monthProgress.addEventListener('input', updateUI);

    presetButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            creditProgress.value = btn.getAttribute('data-credits');
            updateUI();
        });
    });

    // Initial
    updateUI();

    // Form submission handler
    document.getElementById('creditPurchaseForm').addEventListener('submit', function() {
        purchaseBtn.disabled = true;
        purchaseBtnText.textContent = 'Processing...';
        loadingSpinner.classList.remove('hidden');
    });
});
</script>
@endsection
