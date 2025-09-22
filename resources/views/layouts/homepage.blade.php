<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/style.css'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: none;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-100 font-poppins @yield('bodyClass', '')" x-data="{ sidebarOpen: false }">
    <div id="sidebar"
        class="sidebar bg-gray-50 rounded-r-xl shadow-xl w-64 fixed top-0 bottom-0 left-0 z-50 flex flex-col transform transition-transform duration-300 ease-in-out -translate-x-full lg:hidden"
        :class="{ 'translate-x-0': sidebarOpen }">
        <div
            class="p-4 font-bold text-2xl text-violet-700 border-b border-gray-100 flex items-center justify-center gap-x-3">
            E-Commerce
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd"
                    d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 0 0 4.25 22.5h15.5a1.875 1.875 0 0 0 1.865-2.071l-1.263-12a1.875 1.875 0 0 0-1.865-1.679H16.5V6a4.5 4.5 0 1 0-9 0ZM12 3a3 3 0 0 0-3 3v.75h6V6a3 3 0 0 0-3-3Zm-3 8.25a3 3 0 1 0 6 0v-.75a.75.75 0 0 1 1.5 0v.75a4.5 4.5 0 1 1-9 0v-.75a.75.75 0 0 1 1.5 0v.75Z"
                    clip-rule="evenodd" />
            </svg>
        </div>
        <nav class="flex-1 overflow-y-auto">
            <ul class="space-y-3 p-4 font-medium">
                <li><a href="/dashboard"
                        class="block px-4 py-2 rounded-lg {{ Request::is('home') ? 'bg-violet-100 border border-violet-300 text-violet-700' : 'text-gray-500' }}">
                        <div class="flex items-center gap-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            Beranda
                        </div>
                    </a></li>
                <li>
                    <a href="{{ route('cart.index') }}"
                        class="block px-4 py-2 rounded-lg {{ Request::is('cart') ? 'bg-violet-100 border border-violet-300 text-violet-700' : 'text-gray-500' }}">
                        <div class="flex items-center gap-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>
                            Keranjang
                        </div>
                    </a>
                </li>
                <li x-data="{ open: $persist(false).as('masterDataOpen') }">
                    <div @click="open = !open"
                        class="flex items-center justify-between px-4 py-2 rounded-lg cursor-pointer {{ Request::is('profile*') ? 'bg-violet-200 border border-violet-400 text-violet-800' : 'text-gray-500 hover:bg-gray-100' }}">
                        <div class="flex items-center gap-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>

                            <span>User Menu</span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="size-5 transition-transform duration-300" :class="{ 'rotate-90': open }">
                            <path fill-rule="evenodd"
                                d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <ul x-show="open" x-transition class="mt-2 space-y-2 pl-5">
                        <li>
                            <a href="{{ route('profile.index') }}"
                                class="block px-4 py-2 rounded-lg pl-10 {{ Request::is('profile*') ? 'bg-violet-100 border border-violet-400 text-violet-700' : 'text-gray-500 hover:bg-gray-100' }}">
                                Profile
                            </a>
                        </li>
                        <li>
                            @if (auth()->user()->role == 'admin')
                                <a href="{{ route('dashboard') }}"
                                    class="block px-4 py-2 rounded-lg text-gray-500 pl-10">
                                    Dashboard
                                </a>
                            @endif
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <button type="button" @click="logoutModal = true"
                                    class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition-colors duration-300 pl-10">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak class="fixed inset-0 bg-black/50 z-40 lg:hidden">
    </div>
    <div x-data="{ productModalOpen: false, selectedProduct: null, quantity: 1, logoutModal: false, filterModalOpen: false, searchQuery: '{{ request('invoice', '') }}', loaded: false }" @keydown.escape.window="productModalOpen = false; filterModalOpen = false"
        x-init="setTimeout(() => {
            loaded = true;
            $dispatch('page-loaded')
        }, 50)"
        @keydown.escape.window="productModalOpen = false; filterModalOpen = false; logoutModal = false">
        @include('partial._alert')

        <div class="min-h-screen flex flex-col overflow-hidden">
            <header class="bg-white/80 backdrop-blur-md shadow-md fixed top-0 left-0 right-0 z-30 flex-shrink-0">
                <div class="w-full px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <div class="flex-shrink-0">
                            <a href="{{ route('home') }}"
                                class="flex items-center gap-x-2 font-bold text-2xl text-violet-700">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-8">
                                    <path fill-rule="evenodd"
                                        d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 0 0 4.25 22.5h15.5a1.875 1.875 0 0 0 1.865-2.071l-1.263-12a1.875 1.875 0 0 0-1.865-1.679H16.5V6a4.5 4.5 0 1 0-9 0ZM12 3a3 3 0 0 0-3 3v.75h6V6a3 3 0 0 0-3-3Zm-3 8.25a3 3 0 1 0 6 0v-.75a.75.75 0 0 1 1.5 0v.75a4.5 4.5 0 1 1-9 0v-.75a.75.75 0 0 1 1.5 0v.75Z"
                                        clip-rule="evenodd" />
                                </svg>
                                E-Commerce
                            </a>
                        </div>
                        <div class="hidden md:flex items-center gap-x-2">
                            <a href="{{ route('home') }}"
                                class="border border-gray-400 text-gray-700 text-sm rounded-3xl px-4 py-2 transition-colors duration-300 {{ Request::is('home') ? 'bg-gray-300' : 'bg-gray-100 hover:bg-gray-200' }}"
                                title="Beranda">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                            </a>

                            <a href="{{ route('cart.index') }}"
                                class="relative border border-violet-400 text-sm rounded-3xl px-4 py-2 transition-colors duration-300 {{ Request::is('cart') ? 'bg-violet-300 text-violet-900' : 'bg-violet-100 text-violet-700 hover:bg-violet-200' }}"
                                title="Keranjang" x-data="{ count: {{ count(session('cart') ?? []) }} }" x-init="window.addEventListener('cart-updated', e => { count = e.detail.count })">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                </svg>
                                <template x-if="count > 0">
                                    <span x-text="count"
                                        class="absolute -top-2 -right-2 bg-red-600 text-white font-medium text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                    </span>
                                </template>
                            </a>

                            @auth
                                <div x-data="{ open: false }" class="relative">
                                    <button @click="open = !open"
                                        class="border border-blue-400 flex items-center justify-between gap-x-2 text-sm rounded-3xl px-4 py-2 transition-colors duration-300 {{ Request::is('profile*') ? 'bg-blue-300 text-blue-900' : 'bg-blue-100 text-blue-700 hover:bg-blue-200' }}"
                                        title="User Menu">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <div x-show="open" @click.away="open = false"
                                        class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg py-2 z-50">
                                        <a href="{{ route('profile.index') }}"
                                            class="block px-4 py-2 text-gray-700 hover:bg-blue-50 transition-colors duration-300">Profile</a>
                                        @if (auth()->user()->role == 'admin')
                                            <a href="{{ route('dashboard') }}"
                                                class="block px-4 py-2 text-gray-700 hover:bg-blue-50 transition-colors duration-300">Dashboard</a>
                                        @endif
                                        <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                            @csrf
                                            <button type="button" @click="logoutModal = true"
                                                class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition-colors duration-300">Logout</button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <!-- Login Button -->
                                <a href="{{ route('login') }}"
                                    class="bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 rounded-3xl flex items-center px-4 py-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    Login
                                </a>
                            @endauth
                        </div>

                        <div class="md:hidden flex items-center">
                            <button @click="sidebarOpen = !sidebarOpen"
                                class="text-gray-700 hover:text-violet-700 focus:outline-none">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </header>
            <main class="w-full flex-grow pt-16 px-4 sm:px-6 lg:px-8 flex flex-col">
                <div x-show="loaded" x-cloak x-transition:enter="transition-all ease-out duration-1000"
                    x-transition:enter-start="opacity-0 transform translate-y-8"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    class="h-full flex flex-col overflow-y-auto">
                    @yield('content')
                </div>
            </main>
            @if (Request::is('home'))
                <footer class="bg-white mt-auto border-t border-gray-200 flex-shrink-0">
                    <div class="w-full px-4 sm:px-6 lg:px-8 py-6 text-center text-violet-700">
                        &copy; {{ date('Y') }} E-Commerce.
                    </div>
                </footer>
            @endif

        </div>
    </div>

    @stack('scripts')
</body>

</html>
