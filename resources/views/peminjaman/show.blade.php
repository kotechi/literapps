<x-layouts::app :title="'Detail Peminjaman'">
    <div class="space-y-6 max-w-5xl mx-auto">
        <div class="flex items-center gap-4">
            <a href="{{ route('peminjaman.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Detail Peminjaman</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Ringkasan informasi peminjaman dan statusnya</p>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 space-y-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                        @php
                            $statusClass = match ($peminjaman->status) {
                                'menunggu' => 'bg-yellow-100 text-yellow-800',
                                'disetujui' => 'bg-green-100 text-green-800',
                                'ditolak' => 'bg-red-100 text-red-800',
                                default => 'bg-blue-100 text-blue-800',
                            };
                        @endphp
                        <span class="mt-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusClass }}">
                            {{ ucfirst($peminjaman->status) }}
                        </span>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal Pengembalian</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $peminjaman->tgl_pengembalian->format('d M Y') }}</p>
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                        <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Peminjam</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $peminjaman->user->name }}</p>
                    </div>
                    <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                        <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">buku</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $peminjaman->buku->nama_buku }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $peminjaman->buku->kategori->nama_kategori }}</p>
                    </div>
                    <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                        <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Dibuat</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $peminjaman->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                        <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Jumlah Pengembalian</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $peminjaman->pengembalian->count() }} data</p>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                    <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2">Deskripsi</p>
                    <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                        {{ $peminjaman->deskripsi ?: 'Tidak ada deskripsi.' }}
                    </p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 space-y-4">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Status Cepat</h2>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Peminjaman</span>
                        <span class="font-semibold text-gray-900 dark:text-white">#{{ $peminjaman->id }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">User</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $peminjaman->user->name }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">buku</span>
                        <span class="font-semibold text-gray-900 dark:text-white text-right">{{ $peminjaman->buku->nama_buku }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Riwayat Pengembalian</h2>
            @if($peminjaman->pengembalian->count() > 0)
                <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    @foreach($peminjaman->pengembalian as $pengembalian)
                        <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $pengembalian->tanggal_kembali_realisasi->format('d M Y') }}</span>
                                @php
                                    $pengembalianStatusClass = match ($pengembalian->status) {
                                        'menunggu' => 'bg-yellow-100 text-yellow-800',
                                        'disetujui' => 'bg-green-100 text-green-800',
                                        'ditolak' => 'bg-red-100 text-red-800',
                                        default => 'bg-blue-100 text-blue-800',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $pengembalianStatusClass }}">
                                    {{ ucfirst($pengembalian->status) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Dikembalikan oleh {{ $pengembalian->user->name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Terlambat {{ $pengembalian->hari_terlambat }} hari</p>
                            <a href="{{ route('pengembalian.show', $pengembalian) }}" class="inline-flex items-center gap-2 text-sm font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">
                                Lihat detail
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="rounded-xl border border-dashed border-gray-300 dark:border-gray-600 p-8 text-center text-gray-500 dark:text-gray-400">
                    Belum ada data pengembalian untuk peminjaman ini.
                </div>
            @endif
        </div>
    </div>
</x-layouts::app>