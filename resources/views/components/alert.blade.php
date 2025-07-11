@props(['type' => 'success', 'message' => '', 'timeout' => 5000])

@if($errors->any() || $message)
<div x-data="{ show: true }"
     x-show="show"
     x-init="setTimeout(() => show = false, {{ $timeout }})"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform translate-x-6 scale-95"
     x-transition:enter-end="opacity-100 transform translate-x-0 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 transform translate-x-0 scale-100"
     x-transition:leave-end="opacity-0 transform translate-x-6 scale-95"
     class="fixed bottom-4 right-4 z-50 max-w-md {{ $type === 'success' ? 'bg-gradient-to-r from-green-500 to-emerald-600' : 'bg-gradient-to-r from-red-500 to-pink-600' }} text-white px-6 py-4 rounded-xl shadow-2xl border {{ $type === 'success' ? 'border-green-300' : 'border-red-300' }}">
    <div class="flex items-{{ $type === 'success' ? 'center' : 'start' }}">
        <div class="flex-shrink-0">
            @if($type === 'success')
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            @else
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            @endif
        </div>
        <div class="ml-3 {{ $type === 'error' ? 'flex-1' : '' }}">
            @if ($errors->any())
                <ul class="text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>

            @elseif($type === 'success')
                <p class="text-sm font-semibold">{{ $message }}</p>

            @elseif ($type === 'error')
                <p class="text-sm font-semibold mb-1">Please fix the following errors:</p>
                @if(is_array($message))
                    <ul class="text-sm space-y-1">
                        @foreach($message as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm">{{ $message }}</p>
                @endif
            @endif
        </div>
        <div class="ml-auto pl-3">
            <button @click="show = false" class="text-white hover:text-gray-200 transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
</div>
@endif
