<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800&display=swap" rel="stylesheet" />
        
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

            .auth-card {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
            }

            .dark .auth-card {
                background: rgba(31, 41, 55, 0.95);
            }
        </style>
    </head>
    <body class="min-h-screen antialiased bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
        <div class="flex min-h-screen flex-col items-center justify-center gap-6 p-6 md:p-10 relative">
            <!-- Decorative Elements -->
            <div class="absolute top-10 left-10 w-32 h-32 bg-purple-200 dark:bg-purple-900/30 rounded-full blur-3xl opacity-60"></div>
            <div class="absolute bottom-10 right-10 w-40 h-40 bg-blue-200 dark:bg-blue-900/30 rounded-full blur-3xl opacity-60"></div>
            
            <div class="flex w-full max-w-md flex-col gap-6 relative z-10">
                <!-- Logo and Brand -->
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-3 mb-2" wire:navigate>
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-xl hover-lift border border-gray-200 dark:border-gray-700">
                        <img src="/logo.svg" alt="{{ config('app.name', 'Laravel') }}" class="w-16 h-16">
                    </div>
                    <div class="text-center">
                        <h1 class="text-2xl font-bold gradient-text">Sistem</h1>
                        <p class="text-xl font-bold text-gray-800 dark:text-white">Peminjaman Alat</p>
                    </div>
                </a>
                
                <!-- Auth Card -->
                <div class="auth-card rounded-2xl shadow-2xl p-8 border border-gray-200 dark:border-gray-700">
                    {{ $slot }}
                </div>
                
                <!-- Back to Home -->
                <div class="text-center">
                    <a href="{{ route('home') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-purple-600 dark:hover:text-purple-400 transition-colors inline-flex items-center gap-2" wire:navigate>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
