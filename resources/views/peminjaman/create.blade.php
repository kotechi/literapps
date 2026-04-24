<x-layouts::app :title="'Tambah Peminjaman'">
    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Back Button & Title -->
        <div class="flex items-center gap-4">
            <a href="{{ route('peminjaman.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Tambah Peminjaman</h1>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-8">
            <form method="POST" action="{{ route('peminjaman.store') }}">
                @csrf

                <div class="space-y-6">
                    <div>
                        @if(auth()->user()->isAdmin())
                        <label for="id_user" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">User</label>
                        <select name="id_user" id="id_user"
                                class="block w-full px-4 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                required>
                            <option value="">Pilih User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('id_user') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_user')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    @endif

                    <div>
                        <label for="id_buku" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">buku</label>
                        <select name="id_buku" id="id_buku"
                                class="block w-full px-4 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                required>
                            <option value="">Pilih buku</option>
                            @foreach($buku as $item)
                                <option value="{{ $item->id }}" {{ old('id_buku') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_buku }} ({{ $item->kategori->nama_kategori }}) - {{ ucfirst($item->status) }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_buku')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tgl_pinjam" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tanggal Pinjam</label>
                        <input type="date" name="tgl_pinjam" id="tgl_pinjam" value="{{ old('tgl_pinjam', date('Y-m-d')) }}"
                               class="block w-full px-4 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               required>
                        @error('tgl_pinjam')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tgl_pengembalian" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tanggal Pengembalian</label>
                        <input type="date" name="tgl_pengembalian" id="tgl_pengembalian" value="{{ old('tgl_pengembalian') }}"
                               class="block w-full px-4 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        @error('tgl_pengembalian')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="deskripsi" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Deskripsi (Opsional)</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4"
                                  class="block w-full px-4 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                  placeholder="Catatan atau keterangan tambahan tentang peminjaman ini...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('peminjaman.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-semibold shadow-sm transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold shadow-md hover:shadow-lg transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>