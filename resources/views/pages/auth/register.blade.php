<x-layouts::auth>
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Daftar Anggota Siswa')" :description="__('Lengkapi data akun dan profil anggota')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6 ">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4 space-y-4">
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">
                        Informasi Akun
                    </h3>

                    <!-- Name -->
                    <flux:input
                        name="name"
                        :label="__('Nama')"
                        :value="old('name')"
                        type="text"
                        required
                        autofocus
                        autocomplete="name"
                        :placeholder="__('Masukkan nama lengkap')"
                    />

                    <!-- Username -->
                    <flux:input
                        name="username"
                        :label="__('Username')"
                        :value="old('username')"
                        type="text"
                        required
                        autocomplete="username"
                        :placeholder="__('Masukkan username')"
                    />

                    <!-- Password -->
                    <flux:input
                        name="password"
                        :label="__('Kata Sandi')"
                        type="password"
                        required
                        autocomplete="new-password"
                        :placeholder="__('Masukkan kata sandi')"
                        viewable
                    />

                    <!-- Confirm Password -->
                    <flux:input
                        name="password_confirmation"
                        :label="__('Konfirmasi Kata Sandi')"
                        type="password"
                        required
                        autocomplete="new-password"
                        :placeholder="__('Ulangi kata sandi')"
                        viewable
                    />
                </div>

                <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4 space-y-4">
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">
                        Informasi Keanggotaan
                    </h3>

                    <flux:input
                        name="angkatan"
                        :label="__('Angkatan')"
                        :value="old('angkatan')"
                        type="number"
                        required
                        min="2000"
                        max="2100"
                        :placeholder="__('Contoh: 2026')"
                    />

                    <flux:input
                        name="kelas"
                        :label="__('Kelas')"
                        :value="old('kelas')"
                        type="text"
                        required
                        :placeholder="__('Contoh: XI IPA 1')"
                    />

                    <flux:input
                        name="nis"
                        :label="__('NIS')"
                        :value="old('nis')"
                        type="text"
                        required
                        :placeholder="__('Masukkan NIS')"
                    />
                </div>
            </div>

            <div class="flex items-center justify-end">
                <flux:button
                    type="submit"
                    variant="primary"
                    class="w-full bg-slate-800! hover:bg-slate-900! focus-visible:ring-slate-500/70!"
                    data-test="register-user-button"
                >
                    Daftar Anggota
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>Sudah punya akun?</span>
            <flux:link
                :href="route('login', ['role' => 'siswa'])"
                wire:navigate
                class="font-medium text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition-colors"
            >
                Masuk sebagai siswa
            </flux:link>
        </div>
    </div>
</x-layouts::auth>
