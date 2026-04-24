<x-layouts::app :title="'Detail Pengembalian'">
    <div class="space-y-6 max-w-5xl mx-auto">
        <div class="flex items-center gap-4">
            <a href="{{ route('pengembalian.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Detail Pengembalian</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Detail pengembalian, status, dan bukti file</p>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 space-y-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                        @php
                            $statusClass = match ($pengembalian->status) {
                                'menunggu' => 'bg-yellow-100 text-yellow-800',
                                'disetujui' => 'bg-green-100 text-green-800',
                                'ditolak' => 'bg-red-100 text-red-800',
                                default => 'bg-blue-100 text-blue-800',
                            };
                        @endphp
                        <span class="mt-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusClass }}">
                            {{ ucfirst($pengembalian->status) }}
                        </span>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal Kembali Realisasi</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $pengembalian->tanggal_kembali_realisasi->format('d M Y') }}</p>
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                        <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Peminjaman</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $pengembalian->peminjaman->user->name }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $pengembalian->peminjaman->buku->nama_buku }}</p>
                    </div>
                    <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                        <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Dikembalikan Oleh</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $pengembalian->user->name }}</p>
                    </div>
                    <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                        <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Terlambat</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $pengembalian->hari_terlambat }} hari</p>
                    </div>
                    <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                        <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Jumlah Bukti</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $pengembalian->buktiPengembalian->count() }} file</p>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                    <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2">Detail Peminjaman</p>
                    <div class="text-sm text-gray-700 dark:text-gray-300 space-y-1">
                        <p><span class="font-medium">Kategori:</span> {{ $pengembalian->peminjaman->buku->kategori->nama_kategori }}</p>
                        <p><span class="font-medium">Tanggal Pengembalian:</span> {{ $pengembalian->peminjaman->tgl_pengembalian->format('d M Y') }}</p>
                        <p><span class="font-medium">Deskripsi:</span> {{ $pengembalian->peminjaman->deskripsi ?: '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 space-y-4">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Ringkasan</h2>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">ID</span>
                        <span class="font-semibold text-gray-900 dark:text-white">#{{ $pengembalian->id }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Pengembalian Oleh</span>
                        <span class="font-semibold text-gray-900 dark:text-white text-right">{{ $pengembalian->user->name }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Status</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ ucfirst($pengembalian->status) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Bukti Pengembalian</h2>
            @if($pengembalian->buktiPengembalian->count() > 0)
                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach($pengembalian->buktiPengembalian as $bukti)
                        <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4 space-y-2">
                            <div class="flex items-center justify-between gap-2">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ basename($bukti->path_file) }}</p>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-200">{{ $bukti->tipe_media }}</span>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $bukti->keterangan ?: 'Tidak ada keterangan.' }}</p>
                            <a href="{{ asset('storage/' . $bukti->path_file) }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">
                                Buka file
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5h7m0 0v7m0-7L10 16"></path>
                                </svg>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="rounded-xl border border-dashed border-gray-300 dark:border-gray-600 p-8 text-center text-gray-500 dark:text-gray-400">
                    Belum ada bukti pengembalian.
                </div>
            @endif
        </div>
    </div>
</x-layouts::app>