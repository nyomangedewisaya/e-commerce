@extends('layouts.master')
@section('title', 'Master Data - Kategori')
@section('content')
@include('partial._alert')
    <div x-data="{ loaded: false }" x-init="setTimeout(() => { loaded = true; $dispatch('page-loaded') }, 200)">
        <div x-show="loaded" x-cloak x-transition:enter="transition-all ease-out duration-1000"
            x-transition:enter-start="opacity-0 transform translate-y-8"
            x-transition:enter-end="opacity-100 transform translate-y-0">

            <div class="container mx-auto">
                <div class="rounded-lg border border-gray-300 px-4 py-3 flex flex-col gap-2 sm:flex-row items-start sm:items-center justify-between mb-4">
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
                                class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">No
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
                                <td class="px-6 py-4 whitespace-nowrap text-md text-gray-600 hidden md:table-cell">
                                    {{ $category->description }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    @if ($category->products_count === 0)
                                        <span class="bg-red-100 border border-red-300 text-red-600 rounded-lg px-2 py-1">
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
                                    <div class="flex items-center justify-center">
                                        <a href="{{ route('managements.categories.edit', $category->slug) }}"
                                            class="bg-blue-200 hover:bg-blue-300 border border-blue-400 text-blue-600 rounded-xl shadow-md p-2 transition-all duration-200 hover:-translate-y-1 hover:shadow-xl"
                                            title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                            </svg>

                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
