<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Literapps - Sistem Peminjaman Buku</title>

        <link rel="icon" href="/logo.svg" type="image/svg+xml">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                font-family: 'Poppins', sans-serif;
            }
            
            .gradient-bg {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            
            .gradient-text {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .hover-lift {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .hover-lift:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3);
            }

            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
            }

            .animate-float {
                animation: float 6s ease-in-out infinite;
            }
        </style>
    </head>
    <body class="bg-linear-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen flex items-center justify-center p-4">
        <!-- Navigation -->
        {{-- @if (Route::has('login'))
            <div class="absolute top-0 right-0 p-6 sm:p-8">
                @auth
                    <a
                        href="{{ url('/dashboard') }}"
                        class="px-6 py-2.5 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 rounded-lg font-medium shadow-lg hover-lift border border-gray-200 dark:border-gray-700"
                    >
                        Dashboard
                    </a>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="px-6 py-2.5 gradient-bg text-white rounded-lg font-semibold shadow-lg hover-lift"
                    >
                        Masuk
                    </a>
                @endauth
            </div>
        @endif --}}

        <!-- Main Content -->
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                
                <!-- Left Content -->
                <div class="text-center md:text-left space-y-6">
                    <!-- Logo and Brand -->
                    <div class="inline-flex items-center gap-4 mb-6">
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-xl hover-lift">
                            <img src="/logo.svg" alt="Logo" class="w-16 h-16">
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold gradient-text">Literapps</h2>
                            <h1 class="text-4xl font-bold text-gray-800 dark:text-white">Peminjaman Buku</h1>
                        </div>
                    </div>

                    <!-- Description -->
                    <p class="text-lg text-gray-600 dark:text-gray-300 leading-relaxed">
                        Kelola peminjaman dan pengembalian buku dengan mudah, cepat, dan efisien. 
                        Sistem modern untuk manajemen inventaris yang lebih baik.
                    </p>

                    <!-- Features -->
                    <div class="grid grid-cols-2 gap-4 pt-6">
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-lg hover-lift border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-3">
                                <div class="bg-purple-100 dark:bg-purple-900/30 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800 dark:text-white">Mudah</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Antarmuka simpel</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-lg hover-lift border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-3">
                                <div class="bg-blue-100 dark:bg-blue-900/30 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800 dark:text-white">Cepat</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Proses instan</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-lg hover-lift border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-3">
                                <div class="bg-green-100 dark:bg-green-900/30 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800 dark:text-white">Aman</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Data terlindungi</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-lg hover-lift border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-3">
                                <div class="bg-orange-100 dark:bg-orange-900/30 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800 dark:text-white">Teratur</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Laporan lengkap</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    @if (Route::has('login'))
                            <div class="pt-6">
                                <div class="flex flex-wrap gap-3 justify-center md:justify-start">
                                    @auth
                                        <a
                                            href="{{ route('dashboard') }}"
                                            class="inline-flex items-center gap-2 px-8 py-4 gradient-bg text-white rounded-xl font-bold text-lg shadow-2xl hover-lift"
                                        >
                                            <span>Masuk Dashboard</span>
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                            </svg>
                                        </a>
                                    @else
                                        <a
                                            href="{{ route('login.siswa') }}"
                                            class="inline-flex items-center gap-2 px-8 py-4 bg-blue-600 text-white rounded-xl font-bold text-lg shadow-2xl hover-lift"
                                        >
                                            <span>Login Siswa</span>
                                        </a>
                                        <a
                                            href="{{ route('login.admin') }}"
                                            class="inline-flex items-center gap-2 px-8 py-4 bg-slate-800 text-white rounded-xl font-bold text-lg shadow-2xl hover-lift"
                                        >
                                            <span>Login Admin</span>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                    @endif
                </div>

                <!-- Right Illustration -->
                <div class="hidden md:block">
                    <div class="relative">
                        <!-- Main Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-8 hover-lift border border-gray-100 dark:border-gray-700">
                            <!-- Logo Large -->
                            <div class="flex justify-center mb-8 animate-float">
                                <div class="bg-linear-to-br from-purple-500 to-blue-600 p-8 rounded-3xl shadow-2xl">
                                    <img src="/logo.svg" alt="Logo" class="w-32 h-32 brightness-0 invert">
                                </div>
                            </div>

                            <!-- Stats -->
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Peminjaman Aktif</span>
                                    </div>
                                    <span class="font-bold text-xl gradient-text">{{ $peminjaman->count() }}</span>
                                </div>

                                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                        </div>
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Total Buku</span>
                                    </div>
                                    <span class="font-bold text-xl gradient-text">{{ $buku }}</span>
                                </div>

                                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                        </div>
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Anggota</span>
                                    </div>
                                    <span class="font-bold text-xl gradient-text">{{ $anggota }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Decorative Elements -->
                        <div class="absolute -top-4 -right-4 w-24 h-24 bg-purple-200 dark:bg-purple-900/30 rounded-full blur-2xl opacity-60"></div>
                        <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-blue-200 dark:bg-blue-900/30 rounded-full blur-2xl opacity-60"></div>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>
