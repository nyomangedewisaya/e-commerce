@extends('layouts.master')
@section('title', 'Transaksi - Pembayaran')
@section('content')
@include('partial._alert')
    <div x-data="{ loaded: false }" x-init="setTimeout(() => { loaded = true; $dispatch('page-loaded') }, 200)">
        <div x-show="loaded" x-cloak x-transition:enter="transition-all ease-out duration-1000"
            x-transition:enter-start="opacity-0 transform translate-y-8"
            x-transition:enter-end="opacity-100 transform translate-y-0">

            <div class="container mx-auto" x-data="{
                isStatusModalOpen: false,
                modalInvoice: '',
                modalOrderCode: '',
                modalAmount: '',
                modalUpdateUrl: '',
                isFilterModalOpen: false
            }">
                <div class="rounded-lg border border-gray-300 px-4 py-3 flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 gap-2">
                    <h2 class="text-2xl font-bold text-gray-800">Pembayaran</h2>
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
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                            </form>
                            <button @click="isFilterModalOpen = true"
                                class="px-4 py-2 rounded-lg shadow-md flex items-center gap-2 {{ $isFilterActive
                                    ? 'bg-green-100 border border-green-300 text-green-700 font-medium hover:bg-green-200'
                                    : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-100' }}">
                                <span class="font-bold text-gray-700">Filter</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h18M6 9.75h12M9 15h6" />
                                </svg>
                            </button>
                        </div>
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
                                    class="px-5 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Invoice
                                </th>
                                <th scope="col"
                                    class="px-5 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Order Id
                                </th>
                                <th scope="col"
                                    class="whitespace-nowrap px-5 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Jumlah
                                </th>
                                <th scope="col"
                                    class="whitespace-nowrap px-5 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Metode
                                </th>
                                <th scope="col"
                                    class="px-5 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-5 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal
                                    Dibuat</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($payments as $payment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-3 text-sm font-medium">{{ $payment->invoice }}</td>
                                    <td class="px-5 py-3 text-gray-700 text-sm font-medium">
                                        {{ $payment->order->order_code }}</td>
                                    <td class="whitespace-nowrap px-5 py-3 text-md font-medium text-gray-700">Rp
                                        {{ number_format($payment->amount, '0', ',', '.') }}</td>
                                    <td class="whitespace-nowrap px-5 py-3">
                                        @if ($payment->method == 'bank_transfer')
                                            <span class="rounded-lg border px-2 py-0.5 text-xs"
                                                style="background-color: rgba(255, 163, 5, 0.1); border-color: rgba(255, 163, 5, 0.3); color: rgb(255, 163, 5)">{{ ucwords(str_replace('_', ' ', $payment->method)) }}</span>
                                        @elseif($payment->method == 'credit_card')
                                            <span class="rounded-lg border px-2 py-0.5 text-xs"
                                                style="background-color: rgba(17, 199, 141, 0.1); border-color: rgba(17, 199, 141, 0.3); color: rgb(17, 199, 141)">{{ ucwords(str_replace('_', ' ', $payment->method)) }}</span>
                                        @elseif($payment->method == 'e-wallet')
                                            <span class="rounded-lg border px-2 py-0.5 text-xs"
                                                style="background-color: rgba(78, 33, 240, 0.1); border-color: rgba(78, 33, 240, 0.3); color: rgb(78, 33, 240)">{{ ucwords(str_replace('_', ' ', $payment->method)) }}</span>
                                        @else
                                            <span class="bg-[rgb(255, 163, 5)] text-sm">Unknown</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3">
                                        @php
                                            $statusClasses = [
                                                'success' =>
                                                    'bg-green-100 hover:bg-green-200 border border-green-300 text-green-700',
                                                'pending' =>
                                                    'bg-yellow-100 hover:bg-yellow-200 border border-yellow-300 text-yellow-700',
                                                'cancelled' =>
                                                    'bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700',
                                                'failed' =>
                                                    'bg-red-100 hover:bg-red-200 border border-red-300 text-red-700',
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
                                            $status = $payment->order->status;
                                        @endphp

                                        @if (isset($statusClasses[$status]))
                                            <button
                                                @click="
                                                    isStatusModalOpen = true;
                                                    modalInvoice = '{{ $payment->invoice }}';
                                                    modalOrderCode = '{{ $payment->order->order_code }}';
                                                    modalAmount = 'Rp {{ number_format($payment->amount, '0', ',', '.') }}';
                                                    modalUpdateUrl = '{{ route('managements.orders.updateStatus', $payment->order->id) }}';
                                                "
                                                class="w-full rounded-xl px-2 py-0.5 text-sm flex items-center gap-2 cursor-pointer transition-all hover:-translate-y-0.5 hover:shadow-xl {{ $statusClasses[$status] }}">
                                                {!! $statusIcons[$status] !!}
                                                {{ ucwords(str_replace('_', ' ', $status)) }}
                                            </button>
                                        @else
                                            <span class="text-sm">Unknown</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3">
                                        {{ \Carbon\Carbon::parse($payment->created_at)->translatedFormat('d M Y, H:i') }}
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div x-show="isStatusModalOpen" x-cloak x-transition
                    class="fixed inset-0 bg-[rgba(0,0,0,0.5)] flex items-center justify-center bg-opacity-40 backdrop-blur-sm z-40 p-4">
                    <div class="bg-white rounded-lg shadow-2xl w-full max-w-lg p-6">
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="h-10 w-10 text-blue-600 flex-shrink-0">
                                <path
                                    d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                <path
                                    d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                            </svg>
                            <h2 class="text-lg font-semibold text-gray-800">Edit Status Pembayaran</h2>
                        </div>
                        <div class="space-y-2 mt-6">
                            <div class="flex items-center justify-between text-gray-600">
                                Invoice:
                                <span class="font-semibold text-gray-800" x-text="modalInvoice"></span>
                            </div>
                            <div class="flex items-center justify-between text-gray-600">
                                Order ID:
                                <span class="font-semibold text-gray-800" x-text="modalOrderCode"></span>
                            </div>
                            <div class="flex items-center justify-between text-gray-600">
                                Total:
                                <span class="font-semibold text-gray-800" x-text="modalAmount"></span>
                            </div>
                        </div>
                        <div class="flex flex-col gap-y-4 mt-4">
                            @foreach (['success', 'pending', 'cancelled', 'failed'] as $newStatus)
                                <form :action="modalUpdateUrl" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="{{ $newStatus }}">
                                    <button type="submit"
                                        class="w-full justify-center rounded-lg px-4 py-3 text-md flex items-center gap-2 cursor-pointer transition-colors {{ $statusClasses[$newStatus] }}">
                                        {!! $statusIcons[$newStatus] !!}
                                        {{ ucwords($newStatus) }}
                                    </button>
                                </form>
                            @endforeach
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="button" @click="isStatusModalOpen = false"
                                class="bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 px-4 py-2 rounded-lg transition">
                                Batal
                            </button>
                        </div>
                    </div>
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
                                    <label for="search" class="block text-sm font-medium text-gray-700">Invoice</label>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        class="mt-1 w-full rounded-lg shadow-md px-4 py-3 border border-gray-300 focus:outline-none focus:border-violet-500 focus:ring-violet-500"
                                        placeholder="Cari nomor invoice...">
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

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection
