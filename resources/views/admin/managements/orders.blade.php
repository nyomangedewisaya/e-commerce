@extends('layouts.master')
@section('title', 'Transaksi - Pesanan')
@section('content')
    @include('partial._alert')
    <div x-data="{ loaded: false }" x-init="setTimeout(() => {
        loaded = true;
        $dispatch('page-loaded')
    }, 200)">
        <div x-show="loaded" x-cloak x-transition:enter="transition-all ease-out duration-1000"
            x-transition:enter-start="opacity-0 transform translate-y-8"
            x-transition:enter-end="opacity-100 transform translate-y-0">
            <div class="container mx-auto" x-data="{ isFilterModalOpen: false }">
                <div
                    class="rounded-lg border border-gray-300 px-4 py-3 flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 gap-2">
                    <h2 class="text-2xl font-bold text-gray-800">Pesanan</h2>
                    <div>
                        @php
                            $isFilterActive = request()->hasAny([
                                'search',
                                'category',
                                'price_min',
                                'price_max',
                                'sort_by',
                                'sort_dir',
                                'per_page',
                                'status',
                            ]);
                        @endphp
                        <div class="flex items-center gap-x-4">
                            <form action="{{ url()->current() }}" method="GET" class="flex items-center gap-x-2">
                                <label for="per_page" class="text-md font-medium text-gray-700">Tampilkan</label>
                                <select name="per_page" id="per_page"
                                    class="bg-white hover:bg-gray-100 border border-gray-300 rounded-lg shadow-md p-2 cursor-pointer"
                                    onchange="this.form.submit()">
                                    @foreach ([10, 25, 50, 100] as $value)
                                        <option value="{{ $value }}"
                                            {{ request('per_page', 10) == $value ? 'selected' : '' }}>{{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                @foreach (request()->except('per_page') as $key => $value)
                                    <input type="hidden" name="{{ $key }}" id="{{ $value }}">
                                @endforeach
                            </form>
                            <button @click="isFilterModalOpen = true"
                                class="px-4 py-2 rounded-lg shadow-md flex items-center gap-2 {{ $isFilterActive
                                    ? 'bg-green-100 hover:bg-green-200 border border-green-300 font-medium text-green-700'
                                    : 'bg-white hover:bg-gray-100 border border-gray-300 text-gray-700' }}">
                                <span class="font-bold text-gray-700">Filter</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h18M6 9.75h12M9 15h6" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="space-y-3">
                    @foreach ($orders as $order)
                        <div x-data="{ open: false }"
                            class="bg-white rounded-lg shadow-md border border-gray-300 hover:bg-gray-50 hover:-translate-y-1 transition-all duration-300">
                            <div @click="open = !open" class="p-4 flex items-center justify-between cursor-pointer">
                                <div class="flex items-center gap-x-3">
                                    <span
                                        class="bg-violet-100 border border-violet-300 text-violet-700 rounded-lg w-10 h-12 p-3 text-center">{{ $loop->iteration }}</span>
                                    <div class="flex flex-col">
                                        <span class="text-lg font-semibold text-gray-800">{{ $order->order_code }}</span>
                                        <span class="text-sm font-medium text-gray-500">Rp
                                            {{ number_format($order->total_amount, '0', ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-start gap-x-4">
                                    @php
                                        $statusClasses = [
                                            'success' => 'bg-green-100 border border-green-300 text-green-700',
                                            'pending' => 'bg-yellow-100 border border-yellow-300 text-yellow-700',
                                            'cancelled' => 'bg-gray-100 border border-gray-300 text-gray-700',
                                            'failed' => 'bg-red-100 border border-red-300 text-red-700',
                                        ];
                                        $statusIcons = [
                                            'success' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                            </svg>',
                                            'pending' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                            </svg>',
                                            'cancelled' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                            </svg>',
                                            'failed' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                                            </svg>',
                                        ];
                                        $status = $order->status;
                                    @endphp

                                    @if (isset($statusClasses[$status]))
                                        <span
                                            class="w-30 rounded-xl px-2 py-0.5 text-sm flex items-center justify-center gap-2 {{ $statusClasses[$status] }}">
                                            {!! $statusIcons[$status] !!}
                                            {{ ucwords(str_replace('_', ' ', $status)) }}
                                        </span>
                                    @else
                                        <span class="text-sm">Unknown</span>
                                    @endif
                                    <p class="text-sm text-gray-500 hidden md:block">
                                        {{ $order->created_at->translatedFormat('d M Y, H:i') }}</p>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="size-5 text-gray-500 transition-transform duration-300"
                                        :class="{ 'rotate-180': open }">
                                        <path fill-rule="evenodd"
                                            d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <div x-show="open" x-transition class="p-6 bg-white rounded-b-lg border-t border-gray-300">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="bg-gray-100 rounded-lg border border-gray-300 p-3 flex flex-col">
                                        <div class="flex items-center gap-x-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                            </svg>
                                            <p class="text-lg font-medium text-gray-800">Informasi Pelanggan</p>
                                        </div>
                                        <div class="space-y-2 mt-4 px-4">
                                            <div class="flex items-center justify-between text-md">
                                                <span class="text-gray-600">Nama:</span>
                                                <span class="font-medium text-gray-800">{{ $order->user->name }}</span>
                                            </div>
                                            <div class="flex items-center justify-between text-md">
                                                <span class="text-gray-600">Email:</span>
                                                <span class="font-medium text-gray-800">{{ $order->user->email }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-100 rounded-lg border border-gray-300 p-3 flex flex-col">
                                        <div class="flex items-center gap-x-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M21 12a2.25 2.25 0 0 0-2.25-2.25H15a3 3 0 1 1-6 0H5.25A2.25 2.25 0 0 0 3 12m18 0v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 9m18 0V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v3" />
                                            </svg>

                                            <p class="text-lg font-medium text-gray-800">Informasi Pembayaran</p>
                                        </div>
                                        <div class="space-y-2 mt-4 px-4">
                                            <div class="flex items-center justify-between text-md">
                                                <span class="text-gray-600">Invoice:</span>
                                                <span
                                                    class="font-medium text-gray-800">{{ $order->payment->invoice }}</span>
                                            </div>
                                            <div class="flex items-center justify-between text-md">
                                                <span class="text-gray-600">Metode:</span>
                                                <span
                                                    class="font-medium text-gray-800">{{ ucwords(str_replace('_', ' ', $order->payment->method)) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-100 rounded-lg border border-gray-300 p-4 mt-6">
                                    <div class="flex items-center gap-x-3 mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6 text-gray-700">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                        </svg>
                                        <h4 class="text-lg font-bold text-gray-800">Detail Pesanan</h4>
                                    </div>

                                    <div class="space-y-3">
                                        @forelse ($order->orderItems as $item)
                                            <div
                                                class="flex items-center justify-between bg-white p-2 rounded-md border border-gray-200">
                                                <div class="flex items-center gap-x-3 min-w-0">
                                                    <img src="{{ $item->product?->image_url ?? asset('images/placeholder.png') }}"
                                                        alt="{{ $item->product?->name ?? 'Produk Dihapus' }}"
                                                        class="w-12 h-12 object-cover rounded flex-shrink-0">

                                                    <div class="min-w-0">
                                                        <p class="font-semibold text-gray-800 truncate">
                                                            {{ $item->product?->name ?? 'Produk Dihapus' }}</p>
                                                        <p class="text-xs text-gray-500">
                                                            {{ $item->quantity }} item x Rp
                                                            {{ number_format($item->product?->price ?? 0, 0, ',', '.') }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="flex flex-col items-end">
                                                    <p class="text-gray-600 text-sm  pl-3">
                                                        Subtotal
                                                    </p>
                                                    <p class="font-bold text-gray-800 text-sm whitespace-nowrap pl-3">
                                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-sm text-gray-500 text-center py-4">Item pesanan tidak ditemukan.
                                            </p>
                                        @endforelse
                                    </div>
                                </div>
                                <div class="mt-6 flex justify-end">
                                    <a href="{{ route('payments', ['search' => $order->payment->invoice]) }}"
                                        class="flex items-center gap-x-3 bg-violet-100 hover:bg-violet-200 border border-violet-300 text-violet-700 px-4 py-3 rounded-lg font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
                                        </svg>

                                        Lihat Pembayaran
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div x-show="isFilterModalOpen" x-cloak x-transition
                    class="fixed inset-0 bg-[rgba(0,0,0,0.5)] flex items-center justify-center bg-opacity-40 backdrop-blur-sm z-40 p-4">
                    <div class="bg-white rounded-lg shadow-2xl w-full max-w-lg p-6">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-medium text-gray-800">Filter Pembayaran</h2>
                            <button @click="isFilterModalOpen = false"
                                class="hover:bg-gray-200 p-2 rounded-xl transition-colors duration-200">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                                </svg>
                            </button>
                        </div>
                        <form action="{{ url()->current() }}" method="GET" class="flex flex-col h-full">
                            <div class="mt-6 space-y-4 overflow-y-auto flex-grow">
                                <div>
                                    <label for="search" class="block text-sm font-medium text-gray-700">Kode Pesanan</label>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        class="mt-1 w-full rounded-lg shadow-md px-4 py-3 border border-gray-300 focus:outline-none focus:border-violet-500 focus:ring-violet-500"
                                        placeholder="Cari kode pesanan...">
                                </div>
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select name="status"
                                        class="mt-1 w-full rounded-lg shadow-md px-4 py-3 border border-gray-300 focus:outline-none cursor-pointer focus:border-violet-500 focus:ring-violet-500">
                                        <option value="">Semua Status</option>
                                        @foreach (['success', 'pending', 'cancelled', 'failed'] as $status)
                                            <option value="{{ $status }}"
                                                {{ request('status') == $status ? 'selected' : '' }}>
                                                {{ ucwords($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="method" class="block text-sm font-medium text-gray-700">Metode
                                        Pembayaran</label>
                                    <select name="method"
                                        class="mt-1 w-full rounded-lg shadow-md px-4 py-3 border border-gray-300 focus:outline-none cursor-pointer">
                                        <option value="">Semua Metode</option>
                                        @foreach (['credit_card', 'bank_transfer', 'e-wallet'] as $method)
                                            <option value="{{ $method }}"
                                                {{ request('method') == $method ? 'selected' : '' }}>
                                                {{ ucwords(str_replace('_', ' ', $method)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="sort_by" class="block text-sm font-medium text-gray-700">Urutkan
                                            Berdasarkan</label>
                                        <select name="sort_by"
                                            class="mt-1 w-full rounded-lg shadow-md px-4 py-3 border border-gray-300 focus:outline-none cursor-pointer focus:border-violet-500 focus:ring-violet-500">
                                            <option value="created_at"
                                                {{ request('sort_by', 'created_at') == 'created_at' ? 'selected' : '' }}>
                                                Tanggal
                                            </option>
                                            <option value="amount" {{ request('sort_by') == 'amount' ? 'selected' : '' }}>
                                                Jumlah
                                            </option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="sort_dir"
                                            class="block text-sm font-medium text-gray-700">Urutan</label>
                                        <select name="sort_dir"
                                            class="mt-1 w-full rounded-lg shadow-md px-4 py-3 border border-gray-300 focus:outline-none cursor-pointer focus:border-violet-500 focus:ring-violet-500">
                                            <option value="desc"
                                                {{ request('sort_dir', 'desc') == 'desc' ? 'selected' : '' }}>
                                                Descending</option>
                                            <option value="asc" {{ request('sort_dir') == 'asc' ? 'selected' : '' }}>
                                                Ascending
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label for="per_page_modal" class="block text-sm font-medium text-gray-700">Jumlah
                                        data per
                                        halaman</label>
                                    <select name="per_page" id="per_page_modal"
                                        class="mt-1 w-full rounded-lg shadow-md px-4 py-3 border border-gray-300 focus:outline-none cursor-pointer focus:border-violet-500 focus:ring-violet-500">
                                        @foreach ([10, 25, 50, 100] as $value)
                                            <option value="{{ $value }}"
                                                {{ request('per_page', 10) == $value ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="flex items-center justify-between bg-gray-50 mt-6">
                                <a href="{{ url()->current() }}"
                                    class="bg-red-100 rounded-lg shadow-lg px-4 py-3 text-red-700 hover:bg-red-200 border border-red-300 transition-colors duration-200">Reset</a>
                                <div class="flex items-center gap-x-3">
                                    <button type="button" @click="isFilterModalOpen = false"
                                        class="bg-gray-200 rounded-lg shadow-lg px-4 py-3 text-gray-700 hover:bg-gray-300 border border-gray-300 transition-colors duration-200">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="bg-violet-100 hover:bg-violet-200 border border-violet-400 text-violet-700 rounded-lg shadow-lg px-4 py-3 transition-colors duration-200">
                                        Terapkan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
