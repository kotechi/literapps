<x-layouts::app :title="__('Dashboard')">
    <div class="space-y-6">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-purple-700 dark:from-indigo-700 dark:via-purple-700 dark:to-purple-800 rounded-xl shadow-lg p-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Selamat datang, {{ auth()->user()->name }}!</h1>
                    <p class="text-purple-100">Kelola sistem peminjaman buku dengan mudah dan efisien</p>
                </div>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('laporan.keseluruhan') }}" class="bg-white text-purple-600 hover:bg-purple-50 px-6 py-3 rounded-lg font-semibold shadow-md transition-all duration-200 hover:shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Cetak Laporan Keseluruhan
                </a>
                @endif
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid gap-6 md:grid-cols-3">
            <!-- First Summary Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-blue-100 dark:bg-blue-900 rounded-lg p-3">
                            <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-1">{{ $firstTitle }}</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $firstSummary }}</p>
                </div>
            </div>

            <!-- Second Summary Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-green-100 dark:bg-green-900 rounded-lg p-3">
                            <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-1">{{ $secondTitle }}</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $secondSummary }}</p>
                </div>
            </div>

            <!-- Third Summary Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-purple-100 dark:bg-purple-900 rounded-lg p-3">
                            <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-1">{{ $thirdTitle }}</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $thirdSummary }}</p>
                </div>
            </div>
        </div>

        @if(auth()->user()->isAdmin())
        <!-- Admin Chart Stats -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
            <div class="flex flex-col gap-5">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Statistik 6 Bulan Terakhir</h2>
                    <p class="text-sm text-gray-500">Peminjaman dan pengembalian</p>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div class="rounded-lg border border-blue-200 bg-blue-50 p-4">
                        <p class="text-sm font-medium text-blue-700">Total Peminjaman</p>
                        <p class="mt-1 text-2xl font-bold text-blue-900">{{ number_format($adminChartSummary['peminjaman']) }}</p>
                    </div>
                    <div class="rounded-lg border border-green-200 bg-green-50 p-4">
                        <p class="text-sm font-medium text-green-700">Total Pengembalian</p>
                        <p class="mt-1 text-2xl font-bold text-green-900">{{ number_format($adminChartSummary['pengembalian']) }}</p>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">
                    <canvas id="adminStatsChart" height="110"></canvas>
                </div>
            </div>
        </div>
        @endif

        <!-- Main Content Area -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jenis Aktivitas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($latestActivity as $log)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $log->user->name }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                                    {{ $log->deskripsi }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($log->jenis_aktivitas == 'peminjaman') bg-blue-100 text-blue-800
                                        @elseif($log->jenis_aktivitas == 'pengembalian') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($log->jenis_aktivitas) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $log->tanggal_aktivitas->format('d M Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data log aktivitas
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if(auth()->user()->isAdmin())
    <script>
        (() => {
            const labels = @json($chartLabels);
            const dataPeminjaman = @json($chartPeminjaman);
            const dataPengembalian = @json($chartPengembalian);

            const initAdminStatsChart = () => {
                const adminStatsCanvas = document.getElementById('adminStatsChart');

                if (!adminStatsCanvas || !window.Chart) {
                    return false;
                }

                const existingChart = window.Chart.getChart(adminStatsCanvas);
                if (existingChart) {
                    existingChart.destroy();
                }

                new window.Chart(adminStatsCanvas, {
                    type: 'line',
                    data: {
                        labels,
                        datasets: [
                            {
                                label: 'Peminjaman',
                                data: dataPeminjaman,
                                borderColor: '#2563eb',
                                backgroundColor: 'rgba(37, 99, 235, 0.15)',
                                tension: 0.35,
                                fill: true,
                                yAxisID: 'y',
                            },
                            {
                                label: 'Pengembalian',
                                data: dataPengembalian,
                                borderColor: '#059669',
                                backgroundColor: 'rgba(5, 150, 105, 0.15)',
                                tension: 0.35,
                                fill: true,
                                yAxisID: 'y',
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah Data',
                                },
                            },
                        },
                    },
                });

                return true;
            };

            const initWithRetry = (attempt = 0) => {
                if (initAdminStatsChart()) {
                    return;
                }

                if (attempt < 20) {
                    setTimeout(() => initWithRetry(attempt + 1), 100);
                }
            };

            if (!window.__adminStatsChartListenersBound) {
                window.__adminStatsChartListenersBound = true;

                document.addEventListener('DOMContentLoaded', () => initWithRetry());
                document.addEventListener('livewire:navigated', () => initWithRetry());
            }

            initWithRetry();
        })();
    </script>
    @endif
</x-layouts::app>
