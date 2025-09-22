@extends('layouts.master')
@section('title', 'Kategori - Edit Kategori')
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
                    <h2 class="text-2xl font-bold text-gray-800">Edit kategori: {{ $category->name }}</h2>
                </div>
                <form action="{{ route('managements.categories.update', $category) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="name" class="block text-md font-medium text-gray-700 mb-1">Nama Kategori</label>
                        <input type="text" id="name" name="name" placeholder="Masukan nama kategori baru..."
                            value="{{ old('name', $category->name) }}" required
                            class="bg-gray-100 w-full rounded-lg shadow-lg border border-gray-300 px-4 py-2 outline-none">
                    </div>
                    <div>
                        <label for="description" class="block text-md font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="description" id="description" rows="3" placeholder="Masukan deskripsi untuk kategori ini..."
                            required class="bg-gray-100 w-full rounded-lg shadow-lg border border-gray-300 px-4 py-2 outline-none">{{ old('description', $category->description) }}</textarea>
                    </div>
                    <button type="submit"
                        class="w-20 bg-violet-100 hover:bg-violet-200 border border-violet-400 text-violet-600 rounded-lg shadow-sm px-4 py-2 text-center font-medium transition-colors duration-200 mt-3">
                        Save
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
