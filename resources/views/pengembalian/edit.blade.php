<x-layouts::app :title="'Edit Pengembalian'">
    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Back Button & Title -->
        <div class="flex items-center gap-4">
            <a href="{{ route('pengembalian.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Pengembalian</h1>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-8">
            <form method="POST" action="{{ route('pengembalian.update', $pengembalian) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div>
                        <label for="id_peminjaman" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Peminjaman</label>
                        <select name="id_peminjaman" id="id_peminjaman"
                                class="block w-full px-4 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                required>
                            <option value="">Pilih Peminjaman</option>
                            @foreach($peminjaman as $item)
                                <option value="{{ $item->id }}" {{ old('id_peminjaman', $pengembalian->id_peminjaman) == $item->id ? 'selected' : '' }}>
                                    {{ $item->user->name }} - {{ $item->alat->nama_alat }} ({{ $item->alat->kategori->nama_kategori }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_peminjaman')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tanggal_kembali_realisasi" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tanggal Kembali Realisasi</label>
                        <input type="date" name="tanggal_kembali_realisasi" id="tanggal_kembali_realisasi" value="{{ old('tanggal_kembali_realisasi', $pengembalian->tanggal_kembali_realisasi->format('Y-m-d')) }}"
                               class="block w-full px-4 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               required>
                        @error('tanggal_kembali_realisasi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="id_user" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">User yang Mengembalikan</label>
                        <select name="id_user" id="id_user"
                                class="block w-full px-4 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                required>
                            <option value="">Pilih User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('id_user', $pengembalian->id_user) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_user')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Status</label>
                        <select name="status" id="status"
                                class="block w-full px-4 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                required>
                            <option value="menunggu" {{ old('status', $pengembalian->status) == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="disetujui" {{ old('status', $pengembalian->status) == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="ditolak" {{ old('status', $pengembalian->status) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="selesai" {{ old('status', $pengembalian->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="hari_terlambat" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Hari Terlambat</label>
                        <input type="number" name="hari_terlambat" id="hari_terlambat" value="{{ old('hari_terlambat', $pengembalian->hari_terlambat) }}"
                               class="block w-full px-4 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               required min="0">
                        @error('hari_terlambat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bukti Pengembalian Section -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Bukti Pengembalian</h3>
                        
                        @if($pengembalian->buktiPengembalian->count() > 0)
                        <div class="mb-6">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">File yang sudah diupload:</p>
                            <div class="grid grid-cols-2 gap-3">
                                @foreach($pengembalian->buktiPengembalian as $bukti)
                                <div class="relative rounded-lg border border-gray-200 dark:border-gray-700 p-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ basename($bukti->path_file) }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $bukti->tipe_media }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div class="rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 p-6 text-center hover:border-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all">
                            <div class="flex flex-col items-center gap-3">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Tambah bukti baru atau drag & drop</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">PNG, JPG, PDF hingga 10MB</p>
                                </div>
                                <input type="file" name="bukti_pengembalian[]" id="bukti_pengembalian" multiple
                                       class="hidden"
                                       accept="image/png,image/jpeg,application/pdf">
                                <label for="bukti_pengembalian" class="cursor-pointer text-blue-600 hover:text-blue-700 font-medium text-sm">
                                    Klik untuk pilih file
                                </label>
                            </div>
                        </div>
                        <div id="bukti_preview" class="mt-4 grid grid-cols-2 gap-3"></div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('pengembalian.index') }}" class="inline-flex items-center gap-2 bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg font-medium transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // File preview untuk bukti pengembalian
        const buktiInput = document.getElementById('bukti_pengembalian');
        const buktiPreview = document.getElementById('bukti_preview');

        if (buktiInput) {
            buktiInput.addEventListener('change', function(e) {
                buktiPreview.innerHTML = '';
                Array.from(this.files).forEach(file => {
                    const div = document.createElement('div');
                    div.className = 'relative rounded-lg border border-green-200 bg-green-50 dark:bg-green-900/20 p-3';
                    div.innerHTML = `
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">${file.name}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">${(file.size / 1024).toFixed(2)} KB</p>
                    `;
                    buktiPreview.appendChild(div);
                });
            });
        }
    </script>
</x-layouts::app>