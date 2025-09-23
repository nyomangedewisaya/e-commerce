@extends('layouts.master')
@section('title', 'Master Data - Produk')
@section('content')
@include('partial._alert')
    <div x-data="{ loaded: false }" x-init="setTimeout(() => { loaded = true; $dispatch('page-loaded') }, 200)">
        <div x-show="loaded" x-cloak x-transition:enter="transition-all ease-out duration-1000"
            x-transition:enter-start="opacity-0 transform translate-y-8"
            x-transition:enter-end="opacity-100 transform translate-y-0">
            <div class="container mx-auto" x-data="productFilterModal()" @keydown.escape.window="close()">
                <div class="rounded-lg border border-gray-300 px-4 py-3 flex flex-col sm:flex-row items-start sm:items-center gap-4 justify-between mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Data Produk</h2>
                    <div class="flex items-center gap-x-2">
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
                        <button @click="open()"
                            class="px-4 py-2 rounded-lg shadow-sm flex items-center gap-2 {{ $isFilterActive
                                ? 'bg-green-100 border border-green-300 text-green-800 font-medium hover:bg-green-200'
                                : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-100' }}">
                            <span class="font-bold text-gray-700">Filter</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h18M6 9.75h12M9 15h6" />
                            </svg>
                        </button>
                        <a href="{{ route('managements.products.create') }}"
                            class="bg-violet-100 hover:bg-violet-200 border border-violet-400 text-violet-600 font-bold rounded-lg shadow-md px-4 py-2 flex items-center gap-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                <path
                                    d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 -1.5h-4.5v-4.5Z" />
                            </svg>
                            Tambah Produk
                        </a>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md border border-gray-300 overflow-x-auto md:overflow-hidden">
                    <table class="min-w-full divide divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col"
                                    class="px-5 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    No</th>
                                <th scope="col"
                                    class="px-5 py-3 text-center text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Gambar
                                </th>
                                <th scope="col"
                                    class="px-5 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Produk
                                </th>
                                <th scope="col"
                                    class="px-5 py-3 text-center text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Stok
                                </th>
                                <th scope="col"
                                    class="px-5 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Kategori
                                </th>
                                <th scope="col"
                                    class="px-5 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Harga
                                </th>
                                <th scope="col"
                                    class="px-5 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-5 py-3 text-center text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($products as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-4">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-4">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                            class="w-16 h-16 object-cover rounded-md shadow-sm mx-auto">
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="flex flex-col" x-data="{ expanded: false }">
                                            <span class="text-md font-medium text-gray-900">{{ $product->name }}</span>
                                            <span class="text-sm text-gray-500 cursor-pointer"
                                                :class="expanded ? '' : 'max-w-xs truncate'" @click="expanded = !expanded"
                                                title="Lihat semua">
                                                {{ $product->description }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        {{ $product->stock }}
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-md text-gray-700 max-w-xs truncate">
                                        {{ $product->category->name }}</td>
                                    <td class="px-5 py-4 whitespace-nowrap text-left text-sm font-medium">Rp
                                        {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td class="px-5 py-4 whitespace-nowrap text-center text-xs font-medium">
                                        @if ($product->stock === 0)
                                            <span
                                                class="bg-red-100 border border-red-200 rounded-lg px-2 py-1 text-red-600">Kosong</span>
                                        @else
                                            <span
                                                class="bg-green-100 border border-green-200 rounded-lg px-2 py-1 text-green-600">Tersedia</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex items-center justify-center gap-x-2">
                                            <button
                                                @click="restockModal = true; restockProductName = '{{ addslashes($product->name) }}'; restockProductSlug = '{{ $product->slug }}'; restockCurrentStock = '{{ $product->stock }}'"
                                                class="bg-green-200 hover:bg-green-300 border border-green-400 text-green-600 rounded-xl shadow-md p-2 transition-all duration-200 hover:-translate-y-1 hover:shadow-xl"
                                                title="Re-stock">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.8" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>

                                            </button>
                                            <a href="{{ route('managements.products.edit', $product->slug) }}"
                                                class="bg-blue-200 hover:bg-blue-300 border border-blue-400 text-blue-600 rounded-xl shadow-md p-2 transition-all duration-200 hover:-translate-y-1 hover:shadow-xl"
                                                title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                                </svg>

                                            </a>
                                            <button
                                                @click="deleteModal = true; productSlug='{{ $product->slug }}'; productName='{{ $product->name }}'"
                                                class="bg-red-200 hover:bg-red-300 border border-red-400 text-red-600 rounded-xl shadow-md p-2 transition-all duration-200 hover:-translate-y-1 hover:shadow-xl"
                                                title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>

                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-5 py-8 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-400 mb-3"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                                            </svg>
                                            <span class="text-lg font-medium">Produk tidak ditemukan.</span>
                                            <span class="text-sm text-gray-400">Coba rubah atau reset filter
                                                pencarian</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="p-4">{{ $products->links() }}</div>
                </div>

                <div x-show="isOpen" x-cloak x-transition.opacity
                    class="fixed inset-0 bg-[rgba(0,0,0,0.5)] bg-opacity-40 backdrop-blur-sm z-50" @click="close()"
                    aria-hidden="true">
                </div>
                <div x-show="isOpen" x-cloak x-transition class="fixed inset-0 flex items-center justify-center z-50 p-4">
                    <div
                        class="bg-white rounded-xl shadow-2xl w-full max-w-xl mx-auto overflow-hidden flex flex-col items-stretch">
                        <div class="flex items-center justify-between px-6 py-4">
                            <h2 class="text-xl font-medium text-gray-800">Filter Produk</h2>
                            <button @click="close()"
                                class="hover:bg-gray-200 p-2 rounded-xl transition-colors duration-200">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                                </svg>
                            </button>
                        </div>
                        <form id="filterForm" action="{{ route('managements.products.index') }}" method="GET" class="py-4">
                            <div class="px-6 space-y-3">
                                <div>
                                    <label for="search" class="block text-sm font-medium text-gray-700">Nama
                                        Produk</label>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        class="w-full rounded-lg shadow-md px-4 py-3 border border-gray-300 focus:outline-none"
                                        placeholder="Cari nama produk...">
                                </div>
                                <div>
                                    <label for="search" class="block text-sm font-medium text-gray-700">Kategori
                                        Produk</label>
                                    <select name="category"
                                        class="w-full rounded-lg shadow-md px-4 py-3 border border-gray-300 focus:outline-none cursor-pointer">
                                        <option value="" {{ !request('category') ? 'selected' : '' }}>Semua</option>
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
                                        <input type="number" name="price_min" min="0"
                                            value="{{ request('price_min') }}" placeholder="0"
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
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status
                                        Produk</label>
                                    <select name="status"
                                        class="w-full rounded-lg shadow-md px-4 py-3 border border-gray-300 focus:outline-none cursor-pointer">
                                        <option value="" {{ request('status') == '' ? 'selected' : '' }}>Semua
                                        </option>
                                        <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>
                                            Tersedia
                                        </option>
                                        <option value="kosong" {{ request('status') == 'kosong' ? 'selected' : '' }}>
                                            Kosong
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <label for="per_page" class="block text-sm font-medium text-gray-700">Jumlah data per
                                        halaman</label>
                                    <select name="per_page"
                                        class="w-full rounded-lg shadow-md px-4 py-3 border border-gray-300 focus:outline-none cursor-pointer">
                                        <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10
                                        </option>
                                        <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25
                                        </option>
                                        <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50
                                        </option>
                                        <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex items-center justify-between px-6 mt-6 pb-4">
                                <button type="button" @click="resetForm()"
                                    class="bg-red-100 rounded-lg shadow-lg px-4 py-3 text-red-700 hover:bg-red-200 border border-red-300 transition-colors duration-200">Reset</button>
                                <div class="flex items-center gap-x-3">
                                    <button type="button" @click="close()"
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

                <div x-show="deleteModal" x-cloak x-transition
                    class="fixed inset-0 bg-[rgba(0,0,0,0.5)] flex items-center justify-center bg-opacity-40 backdrop-blur-sm z-50">
                    <div class="bg-white rounded-lg shadow-2xl w-full max-w-md p-6">
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="h-10 w-10 text-red-500 flex-shrink-0">
                                <path fill-rule="evenodd"
                                    d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <h2 class="text-lg font-semibold text-gray-800">Konfirmasi Hapus</h2>
                        </div>
                        <p class="mt-4 text-gray-600">Apakah anda yakin ingin menghapus <span
                                class="font-semibold text-red-600" x-text="productName"></span>? Tindakan ini tidak bisa
                            dibatalkan.</p>

                        <div class="flex justify-end gap-3 mt-6">
                            <button @click="deleteModal = false; productSlug = ''; productName = ''"
                                class="bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 px-4 py-2 rounded-lg">
                                Batal
                            </button>

                            <form method="POST" :action="`/managements/products/${productSlug}`">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-100 hover:bg-red-200 border border-red-300 text-red-700 px-4 py-2 rounded-lg">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div x-show="restockModal" x-cloak x-transition
                    class="fixed inset-0 bg-[rgba(0,0,0,0.5)] flex items-center justify-center bg-opacity-40 backdrop-blur-sm z-50">
                    <div class="bg-white rounded-lg shadow-2xl w-full max-w-md p-6">
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="h-10 w-10 text-green-600 flex-shrink-0">
                                <path fill-rule="evenodd"
                                    d="M5.478 5.559A1.5 1.5 0 0 1 6.912 4.5H9A.75.75 0 0 0 9 3H6.912a3 3 0 0 0-2.868 2.118l-2.411 7.838a3 3 0 0 0-.133.882V18a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3v-4.162c0-.299-.045-.596-.133-.882l-2.412-7.838A3 3 0 0 0 17.088 3H15a.75.75 0 0 0 0 1.5h2.088a1.5 1.5 0 0 1 1.434 1.059l2.213 7.191H17.89a3 3 0 0 0-2.684 1.658l-.256.513a1.5 1.5 0 0 1-1.342.829h-3.218a1.5 1.5 0 0 1-1.342-.83l-.256-.512a3 3 0 0 0-2.684-1.658H3.265l2.213-7.191Z"
                                    clip-rule="evenodd" />
                                <path fill-rule="evenodd"
                                    d="M12 2.25a.75.75 0 0 1 .75.75v6.44l1.72-1.72a.75.75 0 1 1 1.06 1.06l-3 3a.75.75 0 0 1-1.06 0l-3-3a.75.75 0 0 1 1.06-1.06l1.72 1.72V3a.75.75 0 0 1 .75-.75Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <h2 class="text-lg font-semibold text-gray-800">Tambah Stok Produk</h2>
                        </div>
                        <p class="mt-4 text-gray-600">Anda akan menambah stok untuk produk <span
                                class="font-semibold text-green-600" x-text="restockProductName"></span> </p>
                        <form method="POST" :action="`/managements/products/${restockProductSlug}/restock`"
                            class="mt-4 space-y-4">
                            @csrf
                            @method('PATCH')

                            <div>
                                <label for="current_stock" class="block text-sm font-medium text-gray-700">Stok Saat
                                    Ini</label>
                                <input type="text" id="current_stock" name="current_stock"
                                    :value="restockCurrentStock"
                                    class="mt-1 w-full bg-gray-100 rounded-lg shadow-md px-3 py-2 border border-gray-300 focus:outline-none"
                                    readonly>
                            </div>
                            <div>
                                <label for="additional_stock" class="block text-sm font-medium text-gray-700">Jumlah Stok
                                    Tambahan</label>
                                <input type="number" id="additional_stock" name="additional_stock" min="1"
                                    placeholder="Masukan jumlah stok baru..."
                                    class="mt-1 w-full bg-gray-100 rounded-lg shadow-md px-3 py-2 border border-gray-300"
                                    required>
                            </div>
                            <div class="flex justify-end gap-3 mt-6">
                                <button type="button" @click="restockModal = false;"
                                    class="bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 px-4 py-2 rounded-lg">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="bg-green-100 hover:bg-green-200 border border-green-300 text-green-700 px-4 py-2 rounded-lg">
                                    Tambah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <script>
            function productFilterModal() {
                return {
                    isOpen: false,
                    // delete modal
                    deleteModal: false,
                    productSlug: '',
                    productName: '',
                    // restock modal
                    restockModal: false,
                    restockProductName: '',
                    restockProductSlug: '',
                    restockCurrentStock: 0,
                    open() {
                        this.isOpen = true;
                        document.body.classList.add('overflow-hidden');
                    },
                    close() {
                        this.isOpen = false;
                        document.body.classList.remove('overflow-hidden');
                    },
                    resetForm() {
                        window.location.href = "{{ route('managements.products.index') }}";
                    }
                }
            }
        </script>

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
    </div>
@endsection