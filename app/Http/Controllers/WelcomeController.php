<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;

class WelcomeController extends Controller
{
    public function welcome()
    {
        $peminjaman = Peminjaman::with('buku')->latest()->where('status', 'disetujui')->get();
        $buku = Buku::count();
        $anggota = Anggota::count();
        return view('welcome', compact('peminjaman', 'buku', 'anggota'));
    }
}
