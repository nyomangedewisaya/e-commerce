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

<body class="bg-gray-200 font-poppins" x-data="{ sidebarOpen: false, logoutModal: false }">
    <div id="sidebar"
        class="sidebar bg-gray-50 rounded-r-xl shadow-xl w-64 fixed top-0 bottom-0 left-0 z-30 flex flex-col transform transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0"
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
                        class="block px-4 py-2 rounded-lg {{ Request::is('dashboard') ? 'bg-violet-100 border border-violet-400 text-violet-700' : 'text-gray-500 hover:bg-gray-100' }}">
                        <div class="flex items-center gap-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-6">
                                <path fill-rule="evenodd"
                                    d="M1.5 7.125c0-1.036.84-1.875 1.875-1.875h6c1.036 0 1.875.84 1.875 1.875v3.75c0 1.036-.84 1.875-1.875 1.875h-6A1.875 1.875 0 0 1 1.5 10.875v-3.75Zm12 1.5c0-1.036.84-1.875 1.875-1.875h5.25c1.035 0 1.875.84 1.875 1.875v8.25c0 1.035-.84 1.875-1.875 1.875h-5.25a1.875 1.875 0 0 1-1.875-1.875v-8.25ZM3 16.125c0-1.036.84-1.875 1.875-1.875h5.25c1.036 0 1.875.84 1.875 1.875v2.25c0 1.035-.84 1.875-1.875 1.875h-5.25A1.875 1.875 0 0 1 3 18.375v-2.25Z"
                                    clip-rule="evenodd" />
                            </svg>

                            Dashboard
                        </div>
                    </a></li>
                <li x-data="{ open: $persist(false).as('masterDataOpen') }">
                    <div @click="open = !open"
                        class="flex items-center justify-between px-4 py-2 rounded-lg cursor-pointer {{ Request::is('managements/categories*') || Request::is('managements/products*') || Request::is('managements/orders*') ? 'bg-violet-200 border border-violet-400 text-violet-800' : 'text-gray-500 hover:bg-gray-100' }}">
                        <div class="flex items-center gap-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-6">
                                <path
                                    d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a.375.375 0 0 1-.375-.375V3.375A1.875 1.875 0 0 0 12.375 1.5H5.625Z" />
                                <path
                                    d="M12.98 1.5h2.27a.75.75 0 0 1 .75.75v6a.75.75 0 0 1-.75.75h-2.27a.75.75 0 0 1-.75-.75v-6a.75.75 0 0 1 .75-.75Z" />
                            </svg>
                            <span>Master Data</span>
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
                            <a href="{{ route('managements.categories.index') }}"
                                class="block px-4 py-2 rounded-lg {{ Request::is('managements/categories*') ? 'bg-violet-100 border border-violet-400 text-violet-700' : 'text-gray-500 hover:bg-gray-100' }}">
                                <div class="flex items-center gap-x-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                                    </svg>
                                    Kategori
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('managements.products.index') }}"
                                class="block px-4 py-2 rounded-lg {{ Request::is('managements/products*') ? 'bg-violet-100 border border-violet-400 text-violet-700' : 'text-gray-500 hover:bg-gray-100' }}">
                                <div class="flex items-center gap-x-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                                    </svg>

                                    Produk
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('managements.orders.index') }}"
                                class="block px-4 py-2 rounded-lg {{ Request::is('managements/orders*') ? 'bg-violet-100 border border-violet-400 text-violet-700' : 'text-gray-500 hover:bg-gray-100' }}">
                                <div class="flex items-center gap-x-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
                                    </svg>
                                    Pesanan
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('payments') }}"
                        class="block px-4 py-2 rounded-lg {{ Request::is('payments*') ? 'bg-violet-100 border border-violet-400 text-violet-700' : 'text-gray-500 hover:bg-gray-100' }}">
                        <div class="flex items-center gap-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-6">
                                <path d="M4.5 3.75a3 3 0 0 0-3 3v.75h21v-.75a3 3 0 0 0-3-3h-15Z" />
                                <path fill-rule="evenodd"
                                    d="M22.5 9.75h-21v7.5a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3v-7.5Zm-18 3.75a.75.75 0 0 1 .75-.75h6a.75.75 0 0 1 0 1.5h-6a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5h-3Z"
                                    clip-rule="evenodd" />
                            </svg>
                            Pembayaran
                        </div>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="p-4">
            <hr class="mb-4 border-gray-100">
            <ul class="space-y-3 font-medium">
                <li><a href="/home"
                        class="block px-4 py-2 rounded-lg bg-blue-100 hover:bg-blue-200 border border-blue-300 text-blue-700">
                        <div class="flex items-center gap-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>

                            Lihat Situs
                        </div>
                    </a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <button type="button" @click="sidebarOpen = false; setTimeout(() => logoutModal = true, 300)"
                            class="w-full block px-4 py-2 rounded-lg bg-red-100 hover:bg-red-200 border border-red-300 text-red-700">
                            <div class="flex items-center gap-x-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" mobileidebarOpen: false
                                        d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                </svg>
                                Logout
                            </div>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak class="fixed inset-0 bg-black/50 z-20 lg:hidden">
    </div>
    <main class="lg:ml-66 transition-all duration-300 ease-in-out">
        <div class="lg:hidden p-4 bg-gray-50 shadow-md flex items-center justify-between sticky top-0 z-10">
            <button @click.stop="sidebarOpen = !sidebarOpen" class="text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
            <div class="font-bold text-lg text-violet-600">E-Commerce</div>
        </div>

        <div class="h-full overflow-y-auto p-6">
            @yield('content')
        </div>
    </main>

    <div x-show="logoutModal" x-cloak x-transition
        class="fixed inset-0 bg-[rgba(0,0,0,0.5)] flex items-center justify-center bg-opacity-40 backdrop-blur-sm z-50">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-md p-6">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="h-10 w-10 text-red-500 flex-shrink-0">
                    <path fill-rule="evenodd"
                        d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                        clip-rule="evenodd" />
                </svg>
                <h2 class="text-lg font-semibold text-gray-800">Konfirmasi Logout</h2>
            </div>
            <p class="mt-4 text-gray-600">Apakah anda yakin ingin logout?</p>
            <div class="flex justify-end gap-3 mt-6">
                <button @click="logoutModal = false;"
                    class="bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 px-4 py-2 rounded-lg">
                    Batal
                </button>
                <button type="submit" form="logout-form"
                    class="bg-red-100 hover:bg-red-200 border border-red-300 text-red-700 px-4 py-2 rounded-lg">
                    Ya, Logout
                </button>
            </div>
        </div>
    </div>
</body>

</html>
