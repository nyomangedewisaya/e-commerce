@extends('layouts.homepage')
@section('title', 'E-Commerce')
@section('content')
    <div>
        <div class="py-6 space-y-3 sm:space-y-0 sm:flex sm:items-center sm:justify-center">
            <h2 class="flex-2 text-2xl font-bold text-gray-800">Jelajahi Produk Kami</h2>
            <div class="flex items-center justify-between gap-x-4">
                @php
                    $isFilterActive = request()->hasAny([
                        'category',
                        'price_min',
                        'price_max',
                        'sort_by',
                        'sort_dir',
                        'per_page',
                    ]);
                @endphp
                <button @click="filterModalOpen = true"
                    class="flex-1 w-1/2 sm:w-auto px-4 py-2 rounded-lg shadow-sm flex items-center gap-2 {{ $isFilterActive
                        ? 'bg-green-100 border border-green-300 text-green-800 font-medium hover:bg-green-200'
                        : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-100' }}">
                    <span class="font-bold text-gray-700">Filter</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h18M6 9.75h12M9 15h6" />
                    </svg>
                </button>
                <form action="{{ route('home') }}" method="GET" class="relative w-full sm:w-auto">
                    <input type="text" name="search" x-model="searchQuery"
                        class="w-full bg-gray-100 rounded-3xl border border-gray-300 pl-4 pr-10 py-3 focus:outline-none"
                        placeholder="Cari nama produk...">

                    <button type="button" x-show="searchQuery" @click="window.location.href = '{{ route('home') }}'"
                        class="absolute inset-y-0 right-0 flex items-center pr-5 text-gray-500 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                            <path
                                d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                        </svg>
                    </button>

                    <button type="submit" x-show="!searchQuery"
                        class="absolute inset-y-0 right-0 flex items-center pr-5 text-gray-500 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
        @forelse ($products as $product)
            <div @click="selectedProduct = {{ json_encode($product) }}; productModalOpen = true; quantity = 1"
                class="bg-white rounded-lg shadow-md overflow-hidden group transition-all duration-300 {{ $product->stock == 0 ? 'opacity-60 grayscale' : 'hover:-translate-y-1 hover:shadow-xl cursor-pointer' }}">
                <div class="relative h-58 overflow-hidden">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                        class="w-full h-full object-cover transition-transform duration-300 {{ $product->stock > 0 ? 'group-hover:scale-110' : '' }}">
                    @if ($product->stock == 0)
                        <div
                            class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-md">
                            Stok Habis</div>
                    @endif
                </div>
                <div class="p-4">
                    <p class="text-xs font-semibold text-violet-500">{{ $product->category->name }}
                    </p>
                    <h3 class="text-md font-bold text-gray-600 truncate">{{ $product->name }}</h3>
                    <p class="text-lg font-extrabold text-gray-800 mt-2">Rp
                        {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>
            </div>
        @empty
            <div class="sm:col-span-3 md:col-span-4 lg:col-span-6 text-center py-12">
                <p class="text-gray-500">Produk tidak ditemukan.</p>
            </div>
        @endforelse
    </div>
    <div class="my-8">{{ $products->links() }}</div>

    <div x-show="productModalOpen" x-cloak x-transition.opacity class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50">
    </div>
    <div x-show="productModalOpen" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div @click.outside="productModalOpen = false"
            class="bg-white rounded-lg shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col">
            <template x-if="selectedProduct">
                <div class="flex-grow overflow-y-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="p-4">
                            <img :src="selectedProduct.image_url" :alt="selectedProduct.name"
                                class="w-full h-full object-cover rounded-lg max-h-96">
                        </div>
                        <div class="p-6 flex flex-col">
                            <div class="flex items-center justify-between">
                                <h3 class="text-2xl font-bold text-gray-700" x-text="selectedProduct.name">
                                </h3>
                                <button @click="productModalOpen = false">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6 text-gray-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <p class="text-sm font-semibold text-violet-700" x-text="selectedProduct.category.name">
                            </p>
                            <h3 class="text-3xl font-extrabold text-gray-900 mt-2"
                                x-text="new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(selectedProduct.price)">
                            </h3>

                            <div class="mt-6 border-t border-gray-200 pt-4">
                                <h4 class="font-semibold text-gray-700">Deskripsi</h4>
                                <p class="text-gray-600 text-sm mt-1" x-text="selectedProduct.description">
                                </p>
                            </div>

                            <div class="flex-grow"></div>

                            <div class="mt-6 pt-4 border-t border-gray-200">
                                <template x-if="selectedProduct.stock > 0">
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" :value="selectedProduct.id">
                                        <input type="hidden" name="quantity" x-bind:value="quantity">

                                        <div>
                                            <div class="flex items-center justify-between mb-2">
                                                <label for="quantity" class="text-gray-700 font-semibold">Jumlah</label>
                                                <span class="text-gray-500 text-sm">Stok Tersedia: <strong
                                                        x-text="selectedProduct.stock"></strong></span>
                                            </div>
                                            <div class="flex items-center">
                                                <button type="button" @click="quantity > 1 ? quantity-- : ''"
                                                    :disabled="quantity <= 1"
                                                    class="p-3 border rounded-l-lg disabled:opacity-50 disabled:cursor-not-allowed">
                                                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M5 12h14" />
                                                    </svg>
                                                </button>

                                                <input type="number" id="quantity" x-model.number="quantity" readonly
                                                    @input="
                                                            if (quantity > selectedProduct.stock) quantity = selectedProduct.stock;
                                                            if (!quantity || quantity < 1) quantity = 1;
                                                        "
                                                    class="text-center w-16 py-2 border-y font-bold text-lg focus:outline-none focus:ring-2 focus:ring-violet-600">
                                                <button type="button"
                                                    @click="quantity < selectedProduct.stock ? quantity++ : ''"
                                                    :disabled="quantity >= selectedProduct.stock"
                                                    class="p-3 border rounded-r-lg disabled:opacity-50 disabled:cursor-not-allowed">
                                                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 4.5v15m7.5-7.5h-15" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <button type="submit"
                                                class="mt-4 w-full rounded-lg bg-violet-600 hover:bg-violet-700 text-white font-semibold py-3 transition-colors duration-300 flex items-center justify-center gap-3">
                                                <svg class="size-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                                </svg>
                                                Tambah ke Keranjang
                                            </button>
                                        </div>
                                    </form>
                                </template>
                                <template x-if="selectedProduct.stock == 0">
                                    <div
                                        class="w-full bg-gray-200 text-gray-500 font-semibold py-3 rounded-lg text-center cursor-not-allowed">
                                        Stok Habis
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <div x-show="logoutModal" x-cloak x-transition.opacity class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50">
    </div>
    <div x-show="logoutModal" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-md p-6">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="h-10 w-10 text-red-500 flex-shrink-0">
                    <path fill-rule="evenodd"
                        d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                        clip-rule="evenodd" />
                </svg>
                <h2 class="text-lg font-semibold text-gray-800">Konfirmasi Logout</h2>
            </div>
            <p class="mt-4 text-gray-600">Apakah anda yakin ingin logout?</p>
            <div class="flex justify-end gap-3 mt-6">
                <button @click="logoutModal = false;"
                    class="bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 px-4 py-2 rounded-lg">
                    Batal
                </button>
                <button type="submit" form="logout-form"
                    class="bg-red-100 hover:bg-red-200 border border-red-300 text-red-700 px-4 py-2 rounded-lg">
                    Ya, Logout
                </button>
            </div>
        </div>
    </div>

    <div x-show="filterModalOpen" x-cloak x-transition.opacity class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50">
    </div>
    <div x-show="filterModalOpen" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-xl mx-auto overflow-hidden flex flex-col items-stretch">
            <div class="flex items-center justify-between px-6 py-4">
                <h2 class="text-xl font-medium text-gray-800">Filter Produk</h2>
                <button @click="filterModalOpen = false"
                    class="hover:bg-gray-200 p-2 rounded-xl transition-colors duration-200">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                    </svg>
                </button>
            </div>
            <form id="filterForm" action="{{ route('home') }}" method="GET" class="py-4">
                <div class="px-6 space-y-3">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700">Kategori
                            Produk</label>
                        <select name="category"
                            class="w-full rounded-lg shadow-md px-4 py-3 border border-gray-300 focus:outline-none cursor-pointer">
                            <option value="" {{ !request('category') ? 'selected' : '' }}>Semua
                            </option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->slug }}"
                                    {{ request('category') == $category->slug ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="price_min" class="block text-sm font-medium text-gray-700">Harga
                                Minimum</label>
                            <input type="number" name="price_min" min="0" value="{{ request('price_min') }}"
                                placeholder="0"
                                class="w-full rounded-lg shadow-md px-4 py-3 border border-gray-300 focus:outline-none">
                        </div>
                        <div>
                            <label for="price_max" class="block text-sm font-medium text-gray-700">Harga
                                Maksimal</label>
                            <input type="number" name="price_max" min="0" max="100000000"
                                value="{{ request('price_max') }}" placeholder="100000000"
                                class="w-full rounded-lg shadow-md px-4 py-3 border border-gray-300 focus:outline-none">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="sort_by" class="block text-sm font-medium text-gray-700">Urutkan
                                berdasarkan</label>
                            <select name="sort_by"
                                class="w-full rounded-lg shadow-md px-4 py-3 border border-gray-300 focus:outline-none cursor-pointer">
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>
                                    Nama
                                    Produk</option>
                                <option value="stock" {{ request('sort_by') == 'stock' ? 'selected' : '' }}>
                                    Jumlah
                                    Stok</option>
                                <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>
                                    Harga
                                    Produk</option>
                            </select>
                        </div>
                        <div>
                            <label for="sort_dir" class="block text-sm font-medium text-gray-700">Urutkan
                                ke</label>
                            <select name="sort_dir"
                                class="w-full rounded-lg shadow-md px-4 py-3 border border-gray-300 focus:outline-none cursor-pointer">
                                <option value="asc" {{ request('sort_dir') == 'asc' ? 'selected' : '' }}>
                                    Ascending
                                </option>
                                <option value="desc" {{ request('sort_dir') == 'desc' ? 'selected' : '' }}>
                                    Descending</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="per_page" class="block text-sm font-medium text-gray-700">Jumlah data
                            per
                            halaman</label>
                        <select name="per_page"
                            class="w-full rounded-lg shadow-md px-4 py-3 border border-gray-300 focus:outline-none cursor-pointer">
                            <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10
                            </option>
                            <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25
                            </option>
                            <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50
                            </option>
                            <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>
                                100
                            </option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center justify-between px-6 mt-6 pb-3">
                    <button type="button" @click="window.location.href = '{{ route('home') }}'"
                        class="bg-red-100 rounded-lg shadow-lg px-4 py-3 text-red-700 hover:bg-red-200 border border-red-300 transition-colors duration-200">Reset</button>
                    <div class="flex items-center gap-x-3">
                        <button type="button" @click="filterModalOpen = false"
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
@endsection
