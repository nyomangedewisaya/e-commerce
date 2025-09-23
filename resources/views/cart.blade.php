@extends('layouts.homepage')
@section('title', 'Cart E-Commerce')
@section('bodyClass', 'overflow-hidden h-screen')
@section('content')
    <div x-data='cartManager(@json($cartItems), {{ $total }})'
        class="h-full flex flex-col container mx-auto">
        <div class="flex items-center justify-between gap-4 py-6 flex-shrink-0">
            <h2 class="text-2xl font-bold text-gray-800">Keranjang Belanja</h2>

            @if (!$cartItems->isEmpty())
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="rounded-lg px-3 py-2 text-sm font-semibold bg-red-100 hover:bg-red-200 border border-red-300 text-red-700 flex items-center gap-2 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                        <span>Kosongkan Keranjang</span>
                    </button>
                </form>
            @endif
        </div>
        @if ($cartItems->isEmpty())
            <div class="text-center bg-white p-12 rounded-lg shadow-lg flex flex-col items-center flex-grow justify-center">
                <p class="text-gray-500">Keranjang Anda masih kosong.</p>
                <a href="{{ route('home') }}"
                    class="mt-4 bg-violet-100 hover:bg-violet-200 border border-violet-300 text-violet-700 font-semibold py-2 px-4 rounded-lg flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                    Mulai Belanja
                </a>
            </div>
        @else
            <div class="flex-grow flex flex-col lg:flex-row gap-8 overflow-hidden pb-6">
                <div class="flex flex-col bg-white rounded-lg shadow-md p-4 lg:p-6 flex-1">
                    <div class="h-[430px] overflow-y-auto">
                        <template x-for="(item, index) in items" :key="item.product.id">
                            <div class="flex items-center gap-4 py-4"
                                :class="{ 'border-b border-gray-200': index < items.length - 1 }">
                                <img :src="item.product.image_url" :alt="item.product.name"
                                    class="w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-md flex-shrink-0">
                                <div class="flex-grow min-w-0">
                                    <p class="font-bold text-gray-800 truncate block" x-text="item.product.name"></p>
                                    <p class="text-sm text-gray-500" x-text="formatCurrency(item.product.price)"></p>
                                    <button @click="removeItem(item.product.id)"
                                        class="mt-2 rounded-md px-1 py-0.5 bg-red-100 hover:bg-red-200 border border-red-300 text-red-700 text-xs font-semibold transition-colors duration-300">Hapus</button>
                                </div>
                                <div class="flex items-center gap-2 mr-5">
                                    <button @click="changeQuantity(item, -1)" :disabled="item.quantity <= 1"
                                        class="p-1 border rounded-full disabled:opacity-50"><svg class="size-4"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                        </svg></button>
                                    <span class="font-bold w-8 text-center" x-text="item.quantity"></span>
                                    <button @click="changeQuantity(item, 1)" :disabled="item.quantity >= item.product.stock"
                                        class="p-1 border rounded-full disabled:opacity-50"><svg class="size-4"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="r>ound"
                                                d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg></button>
                                </div>
                                <div class="w-32 text-right hidden sm:block pr-5">
                                    <p class="font-bold text-gray-800" x-text="formatCurrency(item.subtotal)"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="lg:w-96 flex-shrink-0 bg-white rounded-lg shadow-md p-6">
                    <div class="h-[430px] flex flex-col">
                        <h2 class="text-xl font-bold text-gray-800 border-b border-gray-300 pb-4 mb-4 flex-shrink-0">
                            Ringkasan Pesanan</h2>
                        <div class="flex-1 overflow-y-auto">
                            <h3 class="text-md font-semibold text-gray-700 mb-3">Pilih Metode Pembayaran</h3>
                            <div class="space-y-2">
                                <div @click="selectedMethod = 'bank_transfer'"
                                    :class="{ 'bg-violet-100 text-violet-700 border border-violet-300': selectedMethod === 'bank_transfer', 'border-gray-300': selectedMethod !== 'bank_transfer' }"
                                    class="border rounded-lg p-3 flex items-center justify-between cursor-pointer">
                                    <span class="font-medium">Bank Transfer</span>
                                    <div :class="{ 'bg-violet-500': selectedMethod === 'bank_transfer' }"
                                        class="w-4 h-4 border-2 rounded-full"></div>
                                </div>
                                <div @click="selectedMethod = 'e-wallet'"
                                    :class="{ 'bg-violet-100 text-violet-700 border border-violet-300': selectedMethod === 'e-wallet', 'border-gray-300': selectedMethod !== 'e-wallet' }"
                                    class="border rounded-lg p-3 flex items-center justify-between cursor-pointer">
                                    <span class="font-medium">E-Wallet</span>
                                    <div :class="{ 'bg-violet-500': selectedMethod === 'e-wallet' }"
                                        class="w-4 h-4 border-2 rounded-full"></div>
                                </div>
                                <div @click="selectedMethod = 'credit_card'"
                                    :class="{ 'bg-violet-100 text-violet-700 border border-violet-300': selectedMethod === 'credit_card', 'border-gray-300': selectedMethod !== 'credit_card' }"
                                    class="border rounded-lg p-3 flex items-center justify-between cursor-pointer">
                                    <span class="font-medium">Credit Card</span>
                                    <div :class="{ 'bg-violet-500': selectedMethod === 'credit_card' }"
                                        class="w-4 h-4 border-2 rounded-full"></div>
                                </div>
                            </div>

                        </div>
                        <div class="pt-4 border-t border-gray-300 mt-4 flex-shrink-0">
                            <div class="flex justify-between items-center my-2">
                                <span class="text-gray-700 text-lg">Total:</span>
                                <span class="font-bold text-gray-800 text-xl" x-text="formatCurrency(total)"></span>
                            </div>
                            <form action="{{ route('checkout') }}" method="POST">
                                @csrf
                                <input type="hidden" name="payment_method" x-model="selectedMethod">
                                <button type="submit"
                                    class="w-full bg-violet-600 text-white font-bold py-3 rounded-lg hover:bg-violet-700 transition-colors">
                                    Buat Pesanan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
        @endif
    </div>

@endsection
@push('scripts')
    <script>
        function cartManager(initialItems, initialTotal) {
            return {
                items: initialItems,
                total: initialTotal,
                selectedMethod: 'bank_transfer',
                loadingItemId: null,

                formatCurrency(amount) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(amount);
                },

                changeQuantity(item, delta) {
                    let newQuantity = parseInt(item.quantity) + delta;

                    if (newQuantity < 1 || newQuantity > item.product.stock) {
                        return;
                    }
                    this.updateQuantity(item, newQuantity);
                },

                updateQuantity(item, newQuantity) {
                    if (this.loadingItemId) return;
                    this.loadingItemId = item.product.id;

                    fetch(`/cart/update/${item.product.id}`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                quantity: newQuantity
                            })
                        })
                        .then(response => {
                            if (!response.ok) return response.json().then(err => Promise.reject(err));
                            return response.json();
                        })
                        .then(data => {
                            let cartItem = this.items.find(i => i.product.id === item.product.id);
                            if (cartItem) {
                                cartItem.quantity = newQuantity;
                                cartItem.subtotal = data.new_subtotal;
                                this.total = data.new_total;
                            }
                        })
                        .catch(error => {
                            alert(error.message || 'Gagal memperbarui keranjang.');
                        })
                        .finally(() => {
                            this.loadingItemId = null;
                        });
                },

                removeItem(productId) {
                    if (this.loadingItemId) return;
                    this.loadingItemId = productId;

                    fetch(`/cart/remove/${productId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) return Promise.reject('Gagal menghapus item.');
                            return response.json();
                        })
                        .then(data => {
                            this.items = this.items.filter(i => i.product.id !== productId);
                            this.total = data.new_total;

                            window.dispatchEvent(new CustomEvent('cart-updated', {
                                detail: {
                                    count: this.items.length
                                }
                            }));

                            if (this.items.length === 0) {
                                window.location.reload();
                            }
                        })
                        .catch(error => {
                            alert(error.message || 'Gagal menghapus item.');
                        })
                        .finally(() => {
                            this.loadingItemId = null;
                        });
                }
            }
        }
    </script>
@endpush
