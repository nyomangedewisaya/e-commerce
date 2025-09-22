@if (session()->has('success') || session()->has('error'))
    @php
        $type = session()->has('success') ? 'success' : 'error';
        $message = session('success') ?? session('error');
        
        $bgColor = $type == 'success' ? 'bg-green-100 border-green-300' : 'bg-red-100 border-red-300';
        $textColor = $type == 'success' ? 'text-green-700' : 'text-red-700';
        $iconColor = $type == 'success' ? 'text-green-700' : 'text-red-700';
    @endphp

    <div x-data="{ show: false }"
         @page-loaded.window="show = true; setTimeout(() => show = false, 5000)"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform -translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-4"
         class="fixed top-5 left-1/2 -translate-x-1/2 w-auto max-w-md p-4 border rounded-lg shadow-lg z-50 {{ $bgColor }}"
         role="alert"
         x-cloak>

        <div class="flex items-start">
            <div class="flex-shrink-0">
                @if ($type == 'success')
                    <svg class="w-6 h-6 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                @else
                    <svg class="w-6 h-6 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                @endif
            </div>
            <div class="ml-3">
                <p class="font-bold {{ $textColor }}">{{ ucfirst($type) }}!</p>
                <p class="text-sm {{ $textColor }}">{{ $message }}</p>
            </div>
            <button @click="show = false" class="ml-auto -mt-1 -mr-1 p-1 rounded-md text-gray-500 hover:bg-gray-200 focus:outline-none">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
        </div>
    </div>
@endif