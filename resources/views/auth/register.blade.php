@extends('auth.master')
@section('title', 'Register')
@section('content')
    <div x-data="{ loaded: false }" x-init="setTimeout(() => {
        loaded = true;
        $dispatch('page-loaded')
    }, 200)">
        <div x-show="loaded" x-cloak x-transition:enter="transition-all ease-out duration-1000"
            x-transition:enter-start="opacity-0 transform translate-y-8"
            x-transition:enter-end="opacity-100 transform translate-y-0">
            <div class="sm:mx-auto sm:w-full sm:max-w-md mb-5">
                <h2 class="text-center text-3xl font-extrabold text-white">Buat Akun Baru</h2>
                <p class="mt-2 text-center text-sm text-white">Isi data diri Anda untuk memulai.</p>
            </div>
            <div class="bg-white rounded-xl w-full max-w-lg flex flex-col justify-center items-center shadow-lg border border-gray-100">
                <div class="px-6 py-4">
                    <h2 class="text-center text-xl font-bold text-gray-800">Register Account</h2>
                </div>
                <hr class="border-gray-200">
                <form action="{{ route('register') }}" method="POST"
                    class="flex flex-col justify-center items-center space-y-3 p-4 w-full">
                    @csrf
                    <div class="w-full">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required
                            class="bg-gray-100 rounded-lg text-gray-800 px-3 py-2 w-full outline-none border text-sm @error('name') border-red-500 @else border-gray-300 @enderror"
                            placeholder="Masukkan nama lengkap Anda">
                        @error('name')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="w-full">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required
                            class="bg-gray-100 rounded-lg text-gray-800 px-3 py-2 w-full outline-none border text-sm @error('email') border-red-500 @else border-gray-300 @enderror"
                            placeholder="Masukkan email Anda">
                        @error('email')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="w-full">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input id="password" name="password" type="password" required
                            class="bg-gray-100 rounded-lg text-gray-800 px-3 py-2 w-full outline-none border text-sm @error('password') border-red-500 @else border-gray-300 @enderror"
                            placeholder="Minimal 8 karakter">
                        @error('password')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="w-full">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi
                            Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            class="bg-gray-100 rounded-lg text-gray-800 px-3 py-2 w-full outline-none border text-sm border-gray-300"
                            placeholder="Ulangi password Anda">
                    </div>

                    <button type="submit"
                        class="bg-violet-custom-btn rounded-lg px-5 py-2 mt-2 w-full text-sm font-bold text-white hover-violet-custom-btn">
                        Register
                    </button>
                </form>
                <p class="py-4 text-center text-sm text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-medium text-violet-600 hover:underline">Login di sini</a>
                </p>
            </div>
        </div>
    </div>
@endsection
