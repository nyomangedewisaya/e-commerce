@extends('layouts.master')
@section('title', 'Kategori - Tambah Kategori')
@section('content')
    <div x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 200)">
        <div x-show="loaded" x-cloak x-transition:enter="transition-all ease-out duration-1000"
            x-transition:enter-start="opacity-0 transform translate-y-8"
            x-transition:enter-end="opacity-100 transform translate-y-0">

            <div class="container mx-auto">
                <div class="flex flex-col items-start gap-y-4 mb-6">
                    <a href="{{ route('managements.categories.index') }}"
                        class="bg-violet-100 hover:bg-violet-200 border border-violet-400 text-violet-600 rounded-lg shadow-md px-4 py-2 font-medium flex items-center gap-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                            <path fill-rule="evenodd"
                                d="M7.72 12.53a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 1 1 1.06 1.06L9.31 12l6.97 6.97a.75.75 0 1 1-1.06 1.06l-7.5-7.5Z"
                                clip-rule="evenodd" />
                        </svg>
                        Kembali
                    </a>
                    <h2 class="text-2xl font-bold text-gray-800">Tambah kategori baru</h2>
                </div>
                <form action="{{ route('managements.categories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-md font-medium text-gray-700 mb-1">Nama Kategori</label>
                        <input type="text" id="name" name="name" placeholder="Masukan nama kategori baru..."
                            value="{{ old('name') }}" 
                            class="bg-gray-100 w-full rounded-lg shadow-lg border border-gray-300 px-4 py-2 outline-none">
                    </div>
                    @error('name')
                        <p class="text-xs text-red-700">{{ $message }}</p>
                    @enderror
                    <div>
                        <label for="description" class="block text-md font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="description" id="description" rows="3" placeholder="Masukan deskripsi untuk kategori ini..."
                            class="bg-gray-100 w-full rounded-lg shadow-lg border border-gray-300 px-4 py-2 outline-none">{{ old('description') }}</textarea>
                    </div>
                    @error('description')
                        <p class="text-xs text-red-700">{{ $message }}</p>
                    @enderror
                    <div class="flex items-center gap-x-2 mt-3">
                        <a href="{{ route('managements.categories.create') }}"
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
