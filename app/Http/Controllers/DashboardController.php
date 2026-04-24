<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $firstSummary = 0;
        $secondSummary = 0;
        $thirdSummary = 0;
        $firstTitle = '';
        $secondTitle = '';
        $thirdTitle = '';
        $chartLabels = [];
        $chartPeminjaman = [];
        $chartPengembalian = [];
        $adminChartSummary = [
            'peminjaman' => 0,
            'pengembalian' => 0,
        ];

        if(auth()->user()->isAdmin()) {
            $firstSummary = \App\Models\User::count();
            $secondSummary = \App\Models\buku::count();
            $thirdSummary = \App\Models\Peminjaman::where('status', 'dipinjam')->count();
            $firstTitle = 'Total Users';
            $secondTitle = 'Total buku';
            $thirdTitle = 'Peminjaman Aktif';
            $latestActivity = \App\Models\LogAktivitas::with('user')
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            $months = collect(range(5, 0))->map(function ($monthOffset) {
                return Carbon::now()->subMonths($monthOffset)->startOfMonth();
            });

            foreach ($months as $month) {
                $startDate = $month->copy()->startOfMonth();
                $endDate = $month->copy()->endOfMonth();

                $chartLabels[] = $month->translatedFormat('M Y');
                $chartPeminjaman[] = \App\Models\Peminjaman::whereBetween('created_at', [$startDate, $endDate])->count();
                $chartPengembalian[] = \App\Models\Pengembalian::whereBetween('created_at', [$startDate, $endDate])->count();
            }

            $adminChartSummary = [
                'peminjaman' => array_sum($chartPeminjaman),
                'pengembalian' => array_sum($chartPengembalian),
            ];
        } elseif(auth()->user()->isSiswa()) {
            $firstSummary = \App\Models\Peminjaman::where('id_user', auth()->id())->count();
            $secondSummary = \App\Models\Pengembalian::where('id_user', auth()->id())->count();
            $thirdSummary = \App\Models\Peminjaman::where('id_user', auth()->id())
                ->where('status', 'menunggu')
                ->count();
            $firstTitle = 'Peminjaman Saya';
            $secondTitle = 'Pengembalian Saya';
            $thirdTitle = 'Peminjaman Menunggu';
            $latestActivity = \App\Models\LogAktivitas::with('user')
                ->where('id_user', auth()->id())
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
        }
        return view('dashboard', compact(
            'firstSummary',
            'secondSummary',
            'thirdSummary',
            'firstTitle',
            'secondTitle',
            'thirdTitle',
            'latestActivity',
            'chartLabels',
            'chartPeminjaman',
            'chartPengembalian',
            'adminChartSummary',
        ));
    }
}
