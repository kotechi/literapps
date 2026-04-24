<?php

namespace App\Http\Controllers;

use App\Exports\LaporanKeseluruhanExport;
use App\Exports\PeminjamanExport;
use App\Exports\PengembalianExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    /**
     * Download laporan keseluruhan
     */
    public function downloadKeseluruhan()
    {
        return Excel::download(new LaporanKeseluruhanExport, 'laporan-keseluruhan-' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Download laporan peminjaman
     */
    public function downloadPeminjaman()
    {
        return Excel::download(new PeminjamanExport, 'laporan-peminjaman-' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Download laporan pengembalian
     */
    public function downloadPengembalian()
    {
        return Excel::download(new PengembalianExport, 'laporan-pengembalian-' . date('Y-m-d') . '.xlsx');
    }
}
