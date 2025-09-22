@extends('auth.master')
@section('title', 'Login')
@section('content')
    <div x-data="{ loaded: false }" x-init="setTimeout(() => { loaded = true;
        $dispatch('page-loaded') }, 200)">
        <div x-show="loaded" x-cloak x-transition:enter="transition-all ease-out duration-1000"
            x-transition:enter-start="opacity-0 transform translate-y-8"
            x-transition:enter-end="opacity-100 transform translate-y-0">
            <div class="sm:mx-auto sm:w-full sm:max-w-md mb-5">
                <h2 class="text-center text-3xl font-extrabold text-white">
                    Login to Your Account
                </h2>
                <p class="mt-2 text-center text-sm text-white">
                    Welcome back! Please enter your details.
                </p>
            </div>
            <div
                class="bg-white rounded-xl w-[80vw] lg:w-[30vw] flex flex-col justify-center items-center shadow-lg border border-gray-100">
                <div class="headers px-5 p-4 flex flex-col items-center w-full">
                    <h2 class="text-lg font-semibold text-gray-700">Login Account</h2>
                </div>
                <hr class="border- border-gray-300 w-full">
                <form action="{{ route('login_action') }}" method="POST"
                    class="flex flex-col justify-center items-center space-y-3 p-4 w-full">
                    @csrf
                    <div class="w-full">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <div class="relative w-full">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </span>
                            <input id="email" name="email" type="email" value="{{ old('email') }}"
                                class="bg-gray-100 rounded-lg text-gray-800 pl-10 pr-3 py-2 w-full outline-none border text-sm
                                @error('email')
                                    border-red-500 focus:border-red-500 focus:ring-red-500
                                @else
                                    border-gray-300
                                @enderror"
                                placeholder="Enter your email" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                                @error('email') aria-describedby="email-error" @enderror>
                        </div>
                    </div>
                    @error('email')
                        <p id="email-error" class="text-xs text-red-600 animate-fade-in">{{ $message }}</p>
                    @enderror
                    <div class="w-full">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative w-full">
                            <span class="absolute inset-y-0 left-0 flex items-center p-3 text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                </svg>
                            </span>
                            <input id="password" name="password" type="password" value="{{ old('password') }}"
                                class="bg-gray-100 rounded-lg text-gray-800 pl-10 pr-10 px-4 py-2 w-full outline-none border text-sm
                                @error('password')
                                    border-red-500 focus:border-red-500 focus:ring-red-500
                                @else
                                    border-gray-300
                                @enderror
                                "
                                placeholder="Enter your password"
                                aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                                @error('password') aria-describedby="password-error" @enderror>
                        </div>
                    </div>
                    @error('password')
                        <p id="password-error" class="text-xs text-red-600 animate-fade-in">{{ $message }}</p>
                    @enderror
                    @if ($errors->has('login'))
                        <p class="text-xs text-red-600 animate-fade-in">{{ $errors->first('login') }}</p>
                    @endif
                    <button type="submit"
                        class="bg-violet-custom-btn rounded-lg px-5 py-2 mt-2 w-full text-sm font-bold text-white hover-violet-custom-btn">
                        Login
                    </button>
                </form>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const firstInvalidInput = document.querySelector('[aria-invalid="true"]');
            if (firstInvalidInput) firstInvalidInput.focus();
        });
    </script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-5px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .animate-fade-in {
            transition: fadeIn 0.3s ease-out forwards
        }
    </style>
@endsection
