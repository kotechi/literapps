<x-layouts::auth>
    <div class="flex flex-col gap-6">
        <!-- Header dengan styling yang lebih menarik -->
        <div class="text-center mb-2">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                @if(($selectedRole ?? null) === 'admin')
                    {{ __('Login Admin') }}
                @elseif(($selectedRole ?? null) === 'siswa')
                    {{ __('Login Siswa') }}
                @else
                    {{ __('Selamat Datang Kembali') }}
                @endif
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                @if(($selectedRole ?? null) === 'admin')
                    {{ __('Masuk sebagai admin Literapps') }}
                @elseif(($selectedRole ?? null) === 'siswa')
                    {{ __('Masuk sebagai siswa Literapps') }}
                @else
                    {{ __('Masuk ke akun Anda untuk melanjutkan') }}
                @endif
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-5">
            @csrf

            @if(($selectedRole ?? null) === 'admin' || ($selectedRole ?? null) === 'siswa')
                <input type="hidden" name="expected_role" value="{{ $selectedRole }}">
            @endif

            <!-- Username dengan styling lebih baik -->
            <div>
                <flux:input
                    name="username"
                    :label="__('Username')"
                    :value="old('username')"
                    type="text"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Masukkan username"
                    class="w-full"
                />
            </div>

            <!-- Password dengan styling lebih baik -->
            <div class="relative">
                <flux:input
                    name="password"
                    :label="__('Kata Sandi')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('Masukkan kata sandi')"
                    viewable
                    class="w-full"
                />

                {{-- Uncomment jika fitur lupa password diperlukan --}}
                {{-- @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 text-xs end-0 text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300" :href="route('password.request')" wire:navigate>
                        {{ __('Lupa kata sandi?') }}
                    </flux:link>
                @endif --}}
            </div>

            <!-- Remember Me dengan styling lebih baik -->
            <div class="flex items-center">
                <flux:checkbox 
                    name="remember" 
                    :label="__('Ingat saya')" 
                    :checked="old('remember')"
                    class="text-slate-700 focus:ring-slate-500"
                />
            </div>

            <!-- Login Button dengan warna netral -->
            <div class="flex items-center justify-end pt-2">
                <button 
                    type="submit" 
                    class="w-full px-6 py-3.5 text-white font-bold rounded-xl text-sm bg-slate-800 shadow-lg transition-all duration-200 hover:bg-slate-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-500/70"
                    data-test="login-button"
                >
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        {{ __('Masuk') }}
                    </span>
                </button>
            </div>
        </form>
        
        @if (($selectedRole ?? null) === 'siswa' && Route::has('register'))
            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="text-center text-sm">
                    <span class="text-gray-600 dark:text-gray-400">{{ __('Belum terdaftar sebagai anggota?') }}</span>
                    <flux:link 
                        :href="route('register', ['role' => 'siswa'])" 
                        wire:navigate
                        class="ml-1 font-semibold text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition-colors"
                    >
                        {{ __('Daftar Anggota Siswa') }}
                    </flux:link>
                </div>
            </div>
        @endif
        
        <!-- Info tambahan -->
        <div class="mt-4 text-center">
            <p class="text-xs text-gray-500 dark:text-gray-400">
                Dengan masuk, Anda menyetujui syarat dan ketentuan kami
            </p>
        </div>
    </div>
</x-layouts::auth>