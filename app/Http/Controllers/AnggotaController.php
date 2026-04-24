<?php

namespace App\Http\Controllers;

use App\Models\User;

class AnggotaController extends Controller
{
    /**
     * Display daftar anggota (user role siswa + data anggota).
     */
    public function index()
    {
        if (! auth()->user()->isAdmin() && ! auth()->user()->isSiswa()) {
            abort(403);
        }

        $anggota = User::query()
            ->with('anggota')
            ->where('role', 'siswa')
            ->orderBy('name')
            ->paginate(15);

        return view('anggota.index', compact('anggota'));
    }
}
