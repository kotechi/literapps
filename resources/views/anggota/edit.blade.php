<x-layouts::app :title="'Edit Anggota'">
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('anggota.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Anggota</h1>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-8">
            <form method="POST" action="{{ route('anggota.update', $anggota) }}">
                @csrf
                @method('PUT')

                <div class="space-y-8">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Data Akun</h2>
                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $anggota->name) }}"
                                       class="block w-full px-4 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-colors"
                                       required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="username" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Username</label>
                                <input type="text" name="username" id="username" value="{{ old('username', $anggota->username) }}"
                                       class="block w-full px-4 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-colors"
                                       required>
                                @error('username')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Password Baru (Opsional)</label>
                                <input type="password" name="password" id="password"
                                       class="block w-full px-4 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-colors">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="block w-full px-4 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-colors">
                            </div>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Data Anggota</h2>
                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label for="angkatan" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Angkatan</label>
                                <input type="number" name="angkatan" id="angkatan" value="{{ old('angkatan', $anggota->anggota?->angkatan) }}"
                                       class="block w-full px-4 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-colors"
                                       required>
                                @error('angkatan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="kelas" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Kelas</label>
                                <input type="text" name="kelas" id="kelas" value="{{ old('kelas', $anggota->anggota?->kelas) }}"
                                       class="block w-full px-4 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-colors"
                                       required>
                                @error('kelas')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nis" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">NIS</label>
                                <input type="text" name="nis" id="nis" value="{{ old('nis', $anggota->anggota?->nis) }}"
                                       class="block w-full px-4 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-colors"
                                       required>
                                @error('nis')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nisn" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">NISN</label>
                                <input type="text" name="nisn" id="nisn" value="{{ old('nisn', $anggota->anggota?->nisn) }}"
                                       class="block w-full px-4 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-colors"
                                       required>
                                @error('nisn')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('anggota.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-semibold shadow-sm transition-all">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-cyan-600 hover:bg-cyan-700 text-white rounded-lg font-semibold shadow-md hover:shadow-lg transition-all">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>
