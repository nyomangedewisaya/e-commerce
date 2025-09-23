<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di E-Commerce</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-100 font-poppins bg-gradient-to-br from-violet-500 via-blue-500 to-pink-500 overflow-hidden">
    <div x-data="{ loaded: false }" x-init="setTimeout(() => {
        loaded = true;
        $dispatch('page-loaded')
    }, 300)">
        <div x-show="loaded" x-cloak x-transition:enter="transition-all ease-out duration-1000"
            x-transition:enter-start="opacity-0 transform translate-y-8"
            x-transition:enter-end="opacity-100 transform translate-y-0">
            <div class="min-h-screen flex items-center justify-center p-4">
                <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-12 text-center max-w-4xl border border-gray-200">
                    <div class="flex justify-center items-center gap-x-2 font-bold text-3xl text-violet-700 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-9">
                            <path fill-rule="evenodd"
                                d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 0 0 4.25 22.5h15.5a1.875 1.875 0 0 0 1.865-2.071l-1.263-12a1.875 1.875 0 0 0-1.865-1.679H16.5V6a4.5 4.5 0 1 0-9 0ZM12 3a3 3 0 0 0-3 3v.75h6V6a3 3 0 0 0-3-3Zm-3 8.25a3 3 0 1 0 6 0v-.75a.75.75 0 0 1 1.5 0v.75a4.5 4.5 0 1 1-9 0v-.75a.75.75 0 0 1 1.5 0v.75Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>E-Commerce</span>
                    </div>

                    <h1 class="text-4xl font-extrabold text-gray-800 mt-6">Destinasi Belanja Online Terbaik Anda</h1>
                    <p class="mt-4 text-gray-600 leading-relaxed">
                        Temukan ribuan produk berkualitas mulai dari fashion, elektronik, hingga kebutuhan rumah tangga
                        dengan penawaran terbaik. Nikmati pengalaman belanja yang aman, cepat, dan menyenangkan.
                    </p>
                    <div class="mt-8">
                        @guest
                            <a href="{{ route('login') }}"
                                class="inline-block bg-violet-600 hover:bg-violet-700 text-white font-bold py-3 px-8 rounded-full text-lg transition-transform duration-300 hover:scale-105">
                                Mulai Belanja
                            </a>
                        @endguest
                        @auth
                            @if (auth()->user()->role == 'admin')
                                <a href="{{ route('managements.dashboard') }}"
                                    class="inline-block bg-violet-600 hover:bg-violet-700 text-white font-bold py-3 px-8 rounded-full text-lg transition-transform duration-300 hover:scale-105">
                                    Lanjutkan ke Dashboard
                                </a>
                            @else
                                <a href="{{ route('home') }}"
                                    class="inline-block bg-violet-600 hover:bg-violet-700 text-white font-bold py-3 px-8 rounded-full text-lg transition-transform duration-300 hover:scale-105">
                                    Lanjutkan Belanja
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>
