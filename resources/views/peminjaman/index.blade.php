<x-layouts::app :title="'Daftar Peminjaman'">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="bg-linear-to-r from-indigo-600 via-purple-600 to-purple-700 dark:from-indigo-700 dark:via-purple-700 dark:to-purple-800 rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center">
                <div class="text-white">
                    <h1 class="text-3xl font-bold mb-1">Daftar Peminjaman</h1>
                    @if(auth()->user()->isAdmin())
                        <p class="text-purple-100">Kelola peminjaman buku</p>
                    @else
                        <p class="text-purple-100">Lihat riwayat peminjaman Anda</p>
                    @endif

                </div>
                <div class="flex gap-3">
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('laporan.peminjaman') }}" class="bg-white text-purple-600 hover:bg-purple-50 px-6 py-3 rounded-lg font-semibold shadow-md transition-all duration-200 hover:shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Cetak Laporan
                    </a>
                    @endif
                    <a href="{{ route('peminjaman.create') }}" class="bg-white text-purple-600 hover:bg-purple-50 px-6 py-3 rounded-lg font-semibold shadow-md transition-all duration-200 hover:shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        @if(auth()->user()->isAdmin())
                        Tambah Peminjaman
                        @else
                        Ajukan Peminjaman
                        @endif
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-800 px-6 py-4 rounded-lg shadow-md">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <!-- Summary Cards -->
        <div class="grid gap-6 md:grid-cols-3">
            <!-- Total Peminjaman -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-indigo-100 dark:bg-indigo-900 rounded-lg p-3">
                            <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-1">Total Peminjaman</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalPeminjaman }}</p>
                </div>
            </div>

            <!-- Peminjaman Disetujui -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-green-100 dark:bg-green-900 rounded-lg p-3">
                            <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-1">Disetujui</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $peminjamanDisetujui }}</p>
                </div>
            </div>

            <!-- Peminjaman Menunggu -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-yellow-100 dark:bg-yellow-900 rounded-lg p-3">
                            <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-1">Menunggu</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $peminjamanMenunggu }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <form method="GET" action="{{ route('peminjaman.index') }}" class="flex gap-3 flex-wrap">
                <div>
                    <select name="status" class="w-full px-4 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        <option value="">Semua Status</option>
                        <option value="menunggu" @selected(($status ?? '') === 'menunggu')>Menunggu</option>
                        <option value="disetujui" @selected(($status ?? '') === 'disetujui')>Disetujui</option>
                        <option value="ditolak" @selected(($status ?? '') === 'ditolak')>Ditolak</option>
                        <option value="dikembalikan" @selected(($status ?? '') === 'dikembalikan')>Dikembalikan</option>
                    </select>
                </div>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold shadow-md transition-all duration-200 hover:shadow-lg">
                    Filter
                </button>
                @if(!empty($status ?? null))
                    <a href="{{ route('peminjaman.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold shadow-md transition-all duration-200 hover:shadow-lg">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Data Table -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">buku</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal Pengembalian</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($peminjaman as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $item->user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $item->buku->nama_buku }} ({{ $item->buku->kategori->nama_kategori }})
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $item->tgl_pengembalian->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClass = match ($item->status) {
                                            'menunggu' => 'bg-yellow-100 text-yellow-800',
                                            'disetujui' => 'bg-green-100 text-green-800',
                                            'ditolak' => 'bg-red-100 text-red-800',
                                            default => 'bg-blue-100 text-blue-800',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <a href="{{ route('peminjaman.show', $item) }}" class="inline-flex items-center px-3 py-1.5 bg-slate-100 text-slate-700 hover:bg-slate-200 dark:bg-slate-700 dark:text-slate-200 dark:hover:bg-slate-600 rounded-md transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Detail
                                        </a>
                                        @if(auth()->user()->isAdmin())
                                        <a href="{{ route('peminjaman.edit', $item) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-100 text-indigo-700 hover:bg-indigo-200 dark:bg-indigo-900 dark:text-indigo-300 dark:hover:bg-indigo-800 rounded-md transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                        @endif
                                            @if(auth()->user()->isAdmin())
                                            @if($item->status == 'menunggu')
                                                <form method="POST" action="{{ route('peminjaman.confirm', $item) }}" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="disetujui">
                                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 hover:bg-green-200 dark:bg-green-900 dark:text-green-300 dark:hover:bg-green-800 rounded-md transition-colors">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                        Setujui
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('peminjaman.confirm', $item) }}" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="ditolak">
                                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 dark:bg-red-900 dark:text-red-300 dark:hover:bg-red-800 rounded-md transition-colors">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                        Tolak
                                                    </button>
                                                </form>
                                            @endif
                                            @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data peminjaman
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                {{ $peminjaman->links() }}
            </div>
        </div>
    </div>
</x-layouts::app>