@extends('layouts.homepage')
@section('title', 'Profil Saya')
@section('content')
    <div x-data="{
        editProfileModal: false,
        changePasswordModal: false,
        cancelModalOpen: false,
        cancelUrl: ''
    }" class="container mx-auto max-w-5xl py-10">
        <div
            class="bg-white shadow-lg rounded-2xl p-8 border border-gray-200 flex flex-col items-center text-center relative">
            <div class="relative">
                <div
                    class="w-28 h-28 rounded-full bg-gradient-to-br from-violet-400 to-blue-400 flex items-center justify-center shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-14 h-14 text-white drop-shadow-lg"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12 2a7 7 0 0 1 7 7c0 3.866-3.134 7-7 7s-7-3.134-7-7a7 7 0 0 1 7-7Zm-9 18a9 9 0 0 1 18 0H3Z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>

            <h2 class="mt-5 text-2xl font-bold text-gray-800">{{ auth()->user()->name }}</h2>
            <p class="text-gray-600">{{ auth()->user()->email }}</p>
            <p class="text-gray-500 text-sm">Bergabung sejak {{ auth()->user()->created_at->translatedFormat('d M Y') }}
            </p>

            <div class="flex flex-wrap gap-3 mt-6">
                <button @click="editProfileModal = true"
                    class="bg-blue-100 hover:bg-blue-200 border border-blue-300 text-blue-700 rounded-lg px-3 py-2 transition-colors duration-300">
                    Edit Profile
                </button>
                <button @click="changePasswordModal = true"
                    class="bg-yellow-100 hover:bg-yellow-200 border border-yellow-300 text-yellow-700 rounded-lg px-3 py-2 transition-colors duration-300">
                    Ganti Password
                </button>
                @if (auth()->user()->role !== 'admin')
                    <form method="POST" onsubmit="return confirm('Yakin ingin hapus akun?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-100 hover:bg-red-200 border border-red-300 text-red-700 rounded-lg px-3 py-2 transition-colors duration-300">
                            Hapus Akun
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="mt-10">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800">Histori Transaksi</h3>
                <form action="{{ route('profile.index') }}" method="GET" class="relative w-full sm:w-auto">
                    <input type="text" name="invoice" x-model="searchQuery" value="{{ request('invoice') }}"
                        class="w-full bg-gray-100 rounded-3xl border border-gray-300 pl-4 pr-10 py-3 focus:outline-none"
                        placeholder="Cari nomor invoice...">

                    <button type="button" x-show="searchQuery"
                        @click="window.location.href = '{{ route('profile.index') }}'"
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

            <div class="space-y-4">
                @forelse ($orders as $order)
                    <div x-data="{ open: false }"
                        class="bg-white rounded-xl shadow-md border border-gray-200 hover:shadow-lg transition-all duration-300">
                        <div @click="open = !open" class="p-5 flex items-center justify-between cursor-pointer">
                            <div class="flex items-center gap-x-3">
                                <div>
                                    <p class="text-lg font-semibold text-gray-800">
                                        Invoice: {{ $order->payment->invoice }}
                                    </p>
                                    <p class="text-sm font-medium text-gray-500">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-x-4">
                                @php
                                    $statusClasses = [
                                        'success' => 'bg-green-100 text-green-700',
                                        'pending' => 'bg-yellow-100 text-yellow-700',
                                        'cancelled' => 'bg-gray-100 text-gray-700',
                                        'failed' => 'bg-red-100 text-red-700',
                                    ];
                                @endphp
                                <span
                                    class="text-xs font-medium rounded-md px-2 py-1 {{ $statusClasses[$order->status] ?? '' }}">{{ ucwords($order->status) }}</span>
                                <p class="text-sm text-gray-500 hidden md:block">
                                    {{ $order->created_at->translatedFormat('d M Y, H:i') }}
                                </p>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="size-5 text-gray-500 transition-transform duration-300"
                                    :class="{ 'rotate-180': open }">
                                    <path fill-rule="evenodd"
                                        d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div x-show="open" x-transition class="p-6 bg-gray-50 rounded-b-xl border-t border-gray-200">
                            <div class="space-y-3">
                                @forelse ($order->orderItems as $item)
                                    <div
                                        class="flex items-center justify-between bg-white p-2 rounded-md border border-gray-200">
                                        <div class="flex items-center gap-x-3 min-w-0">
                                            <img src="{{ $item->product?->image_url ?? asset('images/placeholder.png') }}"
                                                alt="{{ $item->product?->name ?? 'Produk Dihapus' }}"
                                                class="w-12 h-12 object-cover rounded">
                                            <div class="min-w-0">
                                                <p class="font-semibold text-gray-800 truncate">
                                                    {{ $item->product?->name ?? 'Produk Dihapus' }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    {{ $item->quantity }} item × Rp
                                                    {{ number_format($item->product?->price ?? 0, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-gray-500 text-sm">Subtotal</p>
                                            <p class="font-bold text-gray-800 text-sm">
                                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                    @if ($order->status === 'pending')
                                        <div class="mt-4 pt-4 flex justify-end">
                                            <button
                                                @click="cancelModalOpen = true; cancelUrl = '{{ route('orders.cancelByUser', $order) }}'"
                                                class="bg-red-100 hover:bg-red-200 border border-red-300 text-red-700 text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                                                Batalkan Pesanan
                                            </button>
                                        </div>
                                    @endif
                                @empty
                                    <p class="text-sm text-gray-500 text-center py-4">Item pesanan tidak ditemukan.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @empty
                    @if (request('invoice'))
                        <p class="text-center text-red-500 py-6">
                            Transaksi dengan invoice <span class="font-semibold">{{ request('invoice') }}</span> tidak
                            ditemukan.
                        </p>
                    @else
                        <p class="text-center text-gray-500 py-6">
                            Belum ada transaksi.
                        </p>
                    @endif
                @endforelse
            </div>
        </div>

        <div x-show="cancelModalOpen" x-cloak x-transition.opacity class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50">
        </div>
        <div x-show="cancelModalOpen" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md text-center"
                @click.away="cancelModalOpen = false">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16.01c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h2 class="mt-4 text-xl font-bold text-gray-800">Batalkan Pesanan?</h2>
                <p class="mt-2 text-sm text-gray-500">Stok produk akan dikembalikan dan pesanan ini tidak dapat dipulihkan.
                    Anda yakin?</p>
                <div class="flex justify-center gap-4 mt-6">
                    <button @click="cancelModalOpen = false" class="bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 px-4 py-2 rounded-lg transition-colors duration-300">
                        Tidak
                    </button>
                    <form :action="cancelUrl" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="bg-red-100 hover:bg-red-200 border border-red-300 text-red-700 px-4 py-2 rounded-lg transition-colors duration-300">
                            Ya, Batalkan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div x-show="editProfileModal" x-cloak x-transition.opacity
            class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50">
        </div>
        <div x-show="editProfileModal" x-cloak x-transition
            class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md" @click.away="editProfileModal = false">
                <h2 class="text-xl font-bold mb-4">Edit Profil</h2>
                <form action="{{ route('profile.update') }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-medium">Nama</label>
                        <input type="text" name="name" value="{{ auth()->user()->name }}"
                            class="w-full px-4 py-3 bg-blue-50 rounded-lg border border-blue-200 focus:ring-1 focus:ring-blue-600 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Email</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}"
                            class="w-full px-4 py-3 bg-blue-50 rounded-lg border border-blue-200 focus:ring-1 focus:ring-blue-600 focus:outline-none">
                    </div>
                    <div class="flex justify-end gap-2 pt-4">
                        <button type="button" @click="editProfileModal = false"
                            class="bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 px-4 py-2 rounded-lg transition-colors duration-300">Batal</button>
                        <button type="submit"
                            class="bg-blue-100 hover:bg-blue-200 border border-blue-300 text-blue-700 px-4 py-2 rounded-lg transition-colors duration-300">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <div x-data="changePasswordForm()" x-show="changePasswordModal" x-cloak>
            <div x-show="changePasswordModal" x-transition.opacity
                class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50">
            </div>
            <div x-show="changePasswordModal" x-transition
                class="fixed inset-0 z-50 flex items-center justify-center p-4">
                <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md" @click.away="changePasswordModal = false">
                    <h2 class="text-xl font-bold mb-4">Ganti Password</h2>
                    <form @submit.prevent="validateForm" action="{{ route('profile.password') }}" method="POST"
                        class="space-y-3">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-medium">Password Lama</label>
                            <input type="password" x-model="current_password" name="current_password"
                                class="w-full px-4 py-3 bg-yellow-50 rounded-lg border border-yellow-200 focus:ring-1 focus:ring-yellow-600 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Password Baru</label>
                            <input type="password" x-model="password" name="password"
                                class="w-full px-4 py-3 bg-yellow-50 rounded-lg border border-yellow-200 focus:ring-1 focus:ring-yellow-600 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Konfirmasi Password Baru</label>
                            <input type="password" x-model="password_confirmation" name="password_confirmation"
                                class="w-full px-4 py-3 bg-yellow-50 rounded-lg border border-yellow-200 focus:ring-1 focus:ring-yellow-600 focus:outline-none">
                        </div>
                        <template x-if="errorMessage">
                            <div class="text-red-700 text-sm text-center mb-2">
                                <span x-text="errorMessage"></span>
                            </div>
                        </template>
                        <div class="flex justify-end gap-2 pt-4">
                            <button type="button" @click="changePasswordModal = false"
                                class="bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 px-4 py-2 rounded-lg transition-colors duration-300">Batal</button>
                            <button type="submit"
                                class="bg-yellow-100 hover:bg-yellow-200 border border-yellow-300 text-yellow-700 px-4 py-2 rounded-lg transition-colors duration-300">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function changePasswordForm() {
                return {
                    current_password: '',
                    password: '',
                    password_confirmation: '',
                    errorMessage: '',

                    validateForm() {
                        // Reset pesan error
                        this.errorMessage = '';

                        if (!this.current_password || !this.password || !this.password_confirmation) {
                            this.errorMessage = 'Semua field harus diisi.';
                            return;
                        }

                        if (this.password.length < 8) {
                            this.errorMessage = 'Password baru minimal 8 karakter.';
                            return;
                        }

                        if (this.password !== this.password_confirmation) {
                            this.errorMessage = 'Konfirmasi password tidak cocok.';
                            return;
                        }

                        // Jika valid, submit form
                        $el = event.target.closest("form");
                        $el.submit();
                    }
                }
            }
        </script>
    </div>
@endsection
