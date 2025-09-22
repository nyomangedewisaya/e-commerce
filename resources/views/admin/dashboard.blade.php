@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    <div x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 200)">
        <div x-show="loaded" x-cloak x-transition:enter="transition-all ease-out duration-1000"
            x-transition:enter-start="opacity-0 transform translate-y-8"
            x-transition:enter-end="opacity-100 transform translate-y-0">
            <div class="bg-violet-700 w-full rounded-lg shadow-md px-6 py-8 flex flex-col sm:flex-row items-end sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-3xl text-white font-black">Selamat Datang, Admin!</h2>
                    <p class="text-md text-white font-semibold">Pantau dan kelola toko digital Anda dengan lebih mudah di
                        sini.
                    </p>
                </div>
                <div class="flex items-center gap-x-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="size-8 text-white">
                        <path
                            d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8.25 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM9.75 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM10.5 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12.75 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM14.25 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 13.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                        <path fill-rule="evenodd"
                            d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z"
                            clip-rule="evenodd" />
                    </svg>
                    <form action="{{ route('dashboard') }}" method="GET">
                        <select name="year" id="year" class="bg-white w-23 rounded-lg px-3 py-2 cursor-pointer"
                            onchange="this.form.submit()">
                            @foreach ($availableYears as $year)
                                <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                {{-- Available Products --}}
                <div
                    class="bg-white rounded-lg shadow-xl px-5 py-3 text-violet-800 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl cursor-pointer">
                    <div class="flex flex-col items-start">
                        <div class="flex items-center gap-x-3 mb-2">
                            <div class="bg-violet-200 border border-violet-300 rounded-lg p-5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                                </svg>
                            </div>
                            <div class="flex flex-col items-start">
                                <h2 class="text-xl font-bold text-gray-800">{{ $availableProducts }}</h2>
                                <p class="text-sm text-gray-500">Produk Tersedia</p>
                            </div>
                        </div>
                        @if ($selectedYear == \Carbon\Carbon::now()->year)
                            <p
                                class="text-sm font-medium {{ $productsPercentageChange >= 0 ? 'text-green-700' : 'text-red-700' }}">
                                {{ $productsPercentageChange >= 0 ? '+' : '' }}
                                {{ number_format($productsPercentageChange, 1) }}%
                                dari
                                bulan lalu
                            </p>
                        @endif
                    </div>
                </div>
                {{-- Used Categories --}}
                <div
                    class="bg-white rounded-lg shadow-xl px-5 py-3 text-violet-800 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl cursor-pointer">
                    <div class="flex flex-col items-start">
                        <div class="flex items-center gap-x-3 mb-2">
                            <div class="bg-violet-200 border border-violet-300 rounded-lg p-5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                                </svg>

                            </div>
                            <div class="flex flex-col items-start">
                                <h2 class="text-xl font-bold text-gray-800">{{ $usedCategories }} / {{ $categoriesTotal }}
                                </h2>
                                <p class="text-sm text-gray-500">Kategori Digunakan</p>
                            </div>
                        </div>
                        @if ($selectedYear == \Carbon\Carbon::now()->year)
                            <p
                                class="text-sm font-medium {{ $categoriesPercentageChange >= 0 ? 'text-green-700' : 'text-red-700' }}">
                                {{ $categoriesPercentageChange >= 0 ? '+' : '' }}
                                {{ number_format($categoriesPercentageChange, 1) }}%
                                dari bulan lalu
                            </p>
                        @endif
                    </div>
                </div>
                {{-- Sales Total --}}
                <div
                    class="bg-white rounded-lg shadow-xl px-5 py-3 text-violet-800 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl cursor-pointer">
                    <div class="flex flex-col items-start">
                        <div class="flex items-center gap-x-3 mb-2">
                            <div class="bg-violet-200 border border-violet-300 rounded-lg p-5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                </svg>

                            </div>
                            <div class="flex flex-col items-start">
                                <h2 class="text-xl font-bold text-gray-800">{{ $salesTotal }}</h2>
                                <p class="text-sm text-gray-500">Total Penjualan</p>
                            </div>
                        </div>
                        @if ($selectedYear == \Carbon\Carbon::now()->year)
                            <p
                                class="text-sm font-medium {{ $salesPercentageChange >= 0 ? 'text-green-700' : 'text-red-700' }}">
                                {{ $salesPercentageChange >= 0 ? '+' : '' }}
                                {{ number_format($salesPercentageChange, 1) }}%
                                dari
                                bulan lalu
                            </p>
                        @endif
                    </div>
                </div>
                {{-- Revenue Total --}}
                <div
                    class="bg-white rounded-lg shadow-xl px-5 py-3 text-violet-800 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl cursor-pointer">
                    <div class="flex flex-col items-start">
                        <div class="flex items-center gap-x-3 mb-2">
                            <div class="bg-violet-200 border border-violet-300 rounded-lg p-5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>

                            </div>
                            <div class="flex flex-col items-start">
                                <h2 class="text-xl font-bold text-gray-800">Rp
                                    {{ number_format($revenueTotal, '0', ',', '.') }}
                                </h2>
                                <p class="text-sm text-gray-500">Total Pendapatan</p>
                            </div>
                        </div>
                        @if ($selectedYear == \Carbon\Carbon::now()->year)
                            <p
                                class="text-sm font-medium {{ $revenuePercentageChange >= 0 ? 'text-green-700' : 'text-red-700' }}">
                                {{ $revenuePercentageChange >= 0 ? '+' : '' }}
                                {{ number_format($revenuePercentageChange, 1) }}%
                                dari
                                bulan lalu
                            </p>
                        @endif
                    </div>
                </div>
            </div>
            <div
                class="bg-white rounded-lg shadow-xl mt-4 p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl cursor-pointer">
                <div style="height: 400px;">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div
                    class="bg-white rounded-lg shadow-xl p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl cursor-pointer">
                    <h3 class="text-xl font-bold text-gray-800">Status Pesanan</h3>
                    <div class="space-y-3 mt-4">
                        {{-- Success Stats --}}
                        <div
                            class="w-full bg-green-100 rounded-lg px-3 py-2 border border-green-200 text-green-600 flex items-center justify-between">
                            <div class="flex items-center gap-x-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>

                                <p class="text-md font-medium">Success</p>
                            </div>
                            <p class="text-lg font-semibold">{{ $orderStats['success'] }} Orders</p>
                        </div>
                        {{-- Pending Stats --}}
                        <div
                            class="w-full bg-yellow-100 rounded-lg px-3 py-2 border border-yellow-200 text-yellow-600 flex items-center justify-between">
                            <div class="flex items-center gap-x-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <p class="text-md font-medium">Pending</p>
                            </div>
                            <p class="text-lg font-semibold">{{ $orderStats['pending'] }} Orders</p>
                        </div>
                        {{-- Cancelled Stats --}}
                        <div
                            class="w-full bg-gray-100 rounded-lg px-3 py-2 border border-gray-200 text-gray-600 flex items-center justify-between">
                            <div class="flex items-center gap-x-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <p class="text-md font-medium">Cancelled</p>
                            </div>
                            <p class="text-lg font-semibold">{{ $orderStats['cancelled'] }} Orders</p>
                        </div>
                        {{-- Failed Stats --}}
                        <div
                            class="w-full bg-red-100 rounded-lg px-3 py-2 border border-red-200 text-red-600 flex items-center justify-between">
                            <div class="flex items-center gap-x-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                </svg>
                                <p class="text-md font-medium">Failed</p>
                            </div>
                            <p class="text-lg font-semibold">{{ $orderStats['failed'] }} Orders</p>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white rounded-lg shadow-xl p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl cursor-pointer">
                    <h3 class="text-xl font-bold text-gray-800">Metode Pembayaran</h3>
                    <div class="mx-auto mt-3" style="max-width: 250px;">
                        <canvas id="paymentMethodChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-4">
                {{-- Latest Products --}}
                <div
                    class="bg-white rounded-lg shadow-xl p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl cursor-pointer">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-gray-800">Produk Terbaru</h3>
                        <div class="flex items-center gap-x-2 text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-6">
                                <path
                                    d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8.25 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM9.75 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM10.5 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12.75 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM14.25 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 13.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                                <path fill-rule="evenodd"
                                    d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <p class="text-sm font-medium">{{ \Carbon\Carbon::now()->year }}</p>
                        </div>
                    </div>
                    <div class="space-y-3 mt-4">
                        @forelse ($latestProducts as $product)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-x-2">
                                    <span
                                        class="bg-blue-100 rounded-lg w-8 p-2 border border-blue-200 text-blue-600 text-center">{{ $loop->iteration }}</span>
                                    <span class="text-md font-medium text-gray-700">{{ $product->name }}</span>
                                </div>
                                <p class="text-sm text-gray-500">Rp {{ number_format($product->price, '0', ',', '.') }}
                                </p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 text-center p-4">Belum ada produk baru yang ditambahkan.</p>
                        @endforelse
                    </div>
                </div>
                {{-- Popular Products --}}
                <div
                    class="bg-white rounded-lg shadow-xl p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl cursor-pointer">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-gray-800">Produk Terpopuler</h3>
                        <div class="flex items-center gap-x-2 text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-6">
                                <path
                                    d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8.25 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM9.75 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM10.5 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12.75 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM14.25 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 13.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                                <path fill-rule="evenodd"
                                    d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <p class="text-sm font-medium">{{ \Carbon\Carbon::now()->year }}</p>
                        </div>
                    </div>
                    <div class="space-y-3 mt-4">
                        @forelse ($popularProducts as $product)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-x-2">
                                    <span
                                        class="bg-green-100 rounded-lg w-8 p-2 border border-green-200 text-green-600 text-center">{{ $loop->iteration }}</span>
                                    <span class="text-md font-medium text-gray-700">{{ $product->name }}</span>
                                </div>
                                <p class="text-sm text-gray-500">{{ $product->total_sold }} Pembelian</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 text-center p-4">Belum ada produk yang dipesan.</p>
                        @endforelse
                    </div>
                </div>
                {{-- Lowest Stock Products --}}
                <div
                    class="bg-white rounded-lg shadow-xl p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl cursor-pointer">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-gray-800">Stok paling Sedikit </h3>
                        <div class="flex items-center gap-x-2 text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-6">
                                <path
                                    d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8.25 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM9.75 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM10.5 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12.75 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM14.25 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 13.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                                <path fill-rule="evenodd"
                                    d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <p class="text-sm font-medium">{{ \Carbon\Carbon::now()->year }}</p>
                        </div>
                    </div>
                    <div class="space-y-3 mt-4">
                        @forelse ($lowestStockProducts as $product)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-x-2">
                                    <span
                                        class="bg-red-100 rounded-lg w-8 p-2 border border-red-200 text-red-600 text-center">{{ $loop->iteration }}</span>
                                    <span class="text-md font-medium text-gray-700">{{ $product->name }}</span>
                                </div>
                                <p class="text-sm text-gray-500">{{ $product->stock }} Item</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 text-center p-4">Belum ada produk yang ditambahkan.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        Chart.register(ChartDataLabels);

        const chartLabels = @json($chartLabels);
        const salesData = @json($salesData);
        const revenueData = @json($revenueData);

        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                        label: 'Total Penjualan',
                        data: salesData,
                        borderColor: 'rgb(109, 40, 217)',
                        backgroundColor: 'rgba(109, 40, 217, 0.1)',
                        yAxisID: 'y',
                        tension: 0.4
                    },
                    {
                        label: 'Total Pendapatan (Juta Rp)',
                        data: revenueData,
                        borderColor: 'rgb(2, 132, 199)',
                        backgroundColor: 'rgba(2, 132, 199, 0.1)',
                        yAxisID: 'y1',
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                        }
                    }
                },
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                stacked: false,
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Jumlah Penjualan'
                        },
                        beginAtZero: true,
                        grace: '10%',
                        ticks: {
                            precision: 0
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Pendapatan (Juta Rp)'
                        },
                        beginAtZero: true,
                        grace: '10%',
                        grid: {
                            drawOnChartArea: false,
                        },
                    },
                }
            }
        });

        const paymentLabels = @json($paymentLabels);
        const paymentTotals = @json($paymentTotals);

        const paymentCtx = document.getElementById('paymentMethodChart');

        new Chart(paymentCtx, {
            type: 'doughnut',
            data: {
                labels: paymentLabels,
                datasets: [{
                    label: 'Jumlah Pengguna',
                    data: paymentTotals,
                    backgroundColor: [
                        'rgb(255, 163, 5)',
                        'rgb(17, 199, 141)',
                        'rgb(78, 33, 240)',
                        'rgb(220, 38, 38)'
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                        }
                    },
                    datalabels: {
                        formatter: (value, ctx) => {
                            return value;
                        },
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 14,
                        }
                    }
                }
            }
        });
    </script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
@endsection
