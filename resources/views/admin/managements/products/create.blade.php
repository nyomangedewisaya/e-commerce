@extends('layouts.master')
@section('title', 'Produk - Tambah Produk')
@section('content')
    <div x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 200)">
        <div x-show="loaded" x-cloak x-transition:enter="transition-all ease-out duration-1000"
            x-transition:enter-start="opacity-0 transform translate-y-8"
            x-transition:enter-end="opacity-100 transform translate-y-0">

            <div class="container mx-auto">
                <div class="flex flex-col items-start gap-y-4 mb-6">
                    <a href="{{ route('managements.products.index') }}"
                        class="bg-violet-100 hover:bg-violet-200 border border-violet-400 text-violet-600 rounded-lg shadow-md px-4 py-2 font-medium flex items-center gap-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                            <path fill-rule="evenodd"
                                d="M7.72 12.53a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 1 1 1.06 1.06L9.31 12l6.97 6.97a.75.75 0 1 1-1.06 1.06l-7.5-7.5Z"
                                clip-rule="evenodd" />
                        </svg>
                        Kembali
                    </a>
                    <h2 class="text-2xl font-bold text-gray-800">Tambah produk baru</h2>
                </div>
                <form action="{{ route('managements.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-md font-medium text-gray-700 mb-1">Nama Produk</label>
                        <input type="text" id="name" name="name" placeholder="Masukan nama produk baru..."
                            value="{{ old('name') }}"
                            class="bg-gray-100 w-full rounded-lg border border-gray-300 shadow-lg px-4 py-2 outline-none">
                    </div>
                    @error('name')
                        <p class="text-xs text-red-700">{{ $message }}</p>
                    @enderror
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="price" class="block text-md font-medium text-gray-700 mb-1">Harga Produk</label>
                            <input type="number" id="price" name="price" placeholder="0" min="0"
                                value="{{ old('price') }}"
                                class="bg-gray-100 w-full rounded-lg border border-gray-300 shadow-lg px-4 py-2 outline-none">
                                @error('price')
                                    <p class="text-xs text-red-700 mt-3">{{ $message }}</p>
                                @enderror
                        </div>
                        <div>
                            <label for="stock" class="block text-md font-medium text-gray-700 mb-1">Stok</label>
                            <input type="number" id="stock" name="stock" placeholder="0" min="0"
                                value="{{ old('stock') }}"
                                class="bg-gray-100 w-full rounded-lg border border-gray-300 shadow-lg px-4 py-2 outline-none">
                                @error('stock')
                                    <p class="text-xs text-red-700 mt-3">{{ $message }}</p>
                                @enderror
                        </div>
                    </div>
        
                    <div>
                        <label for="category_id" class="block text-md font-medium text-gray-700 mb-1">Kategori</label>
                        <select id="category_id" name="category_id" value="{{ old('category_id') }}"
                            class="bg-gray-100 w-full rounded-lg border border-gray-300 shadow-lg px-4 py-2 outline-none cursor-pointer">
                            <option value="" disabled {{ old('category_id') ? '' : 'selected' }} class="text-gray-400">Pilih
                                kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('category_id')
                        <p class="text-xs text-red-700">{{ $message }}</p>
                    @enderror
                    <div>
                        <label for="description" class="block text-md font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="description" id="description" rows="3" placeholder="Masukan deskripsi untuk produk ini..."
                            class="bg-gray-100 w-full rounded-lg shadow-lg border border-gray-300 px-4 py-2 outline-none">{{ old('description') }}</textarea>
                    </div>
                    @error('description')
                        <p class="text-xs text-red-700">{{ $message }}</p>
                    @enderror
                    
                    <div x-data="{ imageUrl: '{{ old('image_url', $product->image_url ?? '') }}' }" x-init="if (!imageUrl) imageUrl = null">
                        <label for="image" class="block text-md font-medium text-gray-700 mb-2">Gambar</label>
                        <template x-if="!imageUrl">
                            <label for="image"
                                class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6 text-gray-500">
                                    <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6h.1a5 5 0 010 10h-1M12 12v9m0-9l-3 3m3-3l3 3">
                                        </path>
                                    </svg>
                                    <p class="mb-2 text-sm"><span class="font-semibold">Klik untuk upload</span> atau drag & drop
                                        gambar disini</p>
                                    <p class="text-xs text-gray-400">JPEG, JPG, PNG, GIF, WEBP (max. 2MB)</p>
                                </div>
                                <input id="image" name="image" type="file" class="hidden" accept="image/*"
                                    @change="imageUrl = URL.createObjectURL($event.target.files[0])" />
                            </label>
                        </template>
                        <template x-if="imageUrl">
                            <div class="relative w-40 h-40 mt-3">
                                <img :src="imageUrl" class="w-50 h-40 object-cover rounded-lg shadow-md border border-gray-300" />
                                <label for="image"
                                    class="absolute bottom-2 right-2 bg-white px-2 py-1 text-xs rounded shadow cursor-pointer border hover:bg-gray-100">
                                    Ganti
                                    <input id="image" name="image" type="file" class="hidden" accept="image/*"
                                        @change="imageUrl = URL.createObjectURL($event.target.files[0])" />
                                </label>
                            </div>
                        </template>
                    </div>
                    @error('image')
                        <p class="text-xs text-red-700">{{ $message }}</p>
                    @enderror
        
                    <div class="flex items-center gap-x-2 mt-3">
                        <a href="{{ route('managements.products.create') }}"
                            class="w-20 bg-red-100 hover:bg-red-200 border border-red-400 text-red-600 rounded-lg shadow-sm px-4 py-2 text-center font-medium transition-colors duration-200">
                            Reset
                        </a>
                        <button type="submit"
                            class="w-20 bg-violet-100 hover:bg-violet-200 border border-violet-400 text-violet-600 rounded-lg shadow-sm px-4 py-2 text-center font-medium transition-colors duration-200">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
