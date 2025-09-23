@extends('layouts.master')
@section('title', 'Master Data - Kategori')
@section('content')
    @include('partial._alert')
    <div x-data="{ deleteModalOpen: false, deleteCategoryName: '', deleteCategoryUrl: '' }">
        <div x-data="{ loaded: false }" x-init="setTimeout(() => {
            loaded = true;
            $dispatch('page-loaded')
        }, 200)">
            <div x-show="loaded" x-cloak x-transition:enter="transition-all ease-out duration-1000"
                x-transition:enter-start="opacity-0 transform translate-y-8"
                x-transition:enter-end="opacity-100 transform translate-y-0">

                <div class="container mx-auto">
                    <div
                        class="rounded-lg border border-gray-300 px-4 py-3 flex flex-col gap-2 sm:flex-row items-start sm:items-center justify-between mb-4">
                        <h2 class="text-2xl font-bold text-gray-800">Data Kategori</h2>
                        <a href="{{ route('managements.categories.create') }}"
                            class="bg-violet-100 hover:bg-violet-200 border border-violet-400 text-violet-600 font-bold rounded-lg shadow-md px-4 py-2 flex items-center gap-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                <path
                                    d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                            </svg>
                            Tambah Kategori
                        </a>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md border border-gray-300 overflow-x-auto md:overflow-hidden">
                    <table class="min-w-full divide divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    No
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Kategori</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                    Deskripsi
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Jumlah</th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($categories as $category)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-md font-medium text-gray-900">
                                        {{ $category->name }}</td>
                                    <td class="px-6 py-4 text-md text-gray-600 hidden md:table-cell">
                                        {{ $category->description }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        @if ($category->products_count === 0)
                                            <span
                                                class="bg-red-100 border border-red-300 text-red-600 rounded-lg px-2 py-1">
                                                Kosong
                                            </span>
                                        @else
                                            <span
                                                class="bg-violet-100 border border-violet-300 text-violet-600 rounded-lg px-2 py-1">
                                                {{ $category->products_count }} Produk
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('managements.categories.edit', $category->slug) }}"
                                                class="bg-blue-200 hover:bg-blue-300 border border-blue-400 text-blue-600 rounded-xl shadow-md p-2 transition-all duration-200 hover:-translate-y-1 hover:shadow-xl"
                                                title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                                </svg>
                                            </a>
                                            @if ($category->products_count == 0)
                                                <button type="button"
                                                    @click="deleteModalOpen = true; deleteCategoryName = '{{ addslashes($category->name) }}'; deleteCategoryUrl = '{{ route('managements.categories.destroy', $category->slug) }}'"
                                                    class="bg-red-200 hover:bg-red-300 border border-red-400 text-red-600 rounded-xl shadow-md p-2 transition-all duration-200 hover:-translate-y-1 hover:shadow-xl"
                                                    title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div x-show="deleteModalOpen" x-cloak x-transition.opacity class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50">
        </div>
        <div x-show="deleteModalOpen" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div @click.outside="deleteModalOpen = false" class="bg-white rounded-lg shadow-2xl w-full max-w-md p-6">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="h-10 w-10 text-red-500 flex-shrink-0">
                        <path fill-rule="evenodd"
                            d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                            clip-rule="evenodd" />
                    </svg>
                    <h2 class="text-lg font-semibold text-gray-800">Konfirmasi Hapus</h2>
                </div>
                <p class="mt-4 text-gray-600">Apakah anda yakin ingin menghapus <span class="font-semibold text-red-600"
                        x-text="deleteCategoryName"></span>? Tindakan ini tidak bisa
                    dibatalkan.</p>

                <div class="flex justify-end gap-3 mt-6">
                    <button @click="deleteModalOpen = false; deleteCategoryName = ''"
                        class="bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 px-4 py-2 rounded-lg">
                        Batal
                    </button>

                    <form method="POST" :action="deleteCategoryUrl">
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
    </div>
@endsection
