<?php

namespace App\Observers;

use App\Models\Pengembalian;
use App\Models\LogAktivitas;

class PengembalianObserver
{
    public function created(Pengembalian $pengembalian): void
    {
        LogAktivitas::create([
            'id_user' => auth()->id() ?? $pengembalian->id_user,
            'jenis_aktivitas' => 'pengembalian',
            'deskripsi' => 'Mengembalikan buku dari peminjaman ID: ' . $pengembalian->id_peminjaman,
            'tanggal_aktivitas' => now(),
        ]);
    }

    public function updated(Pengembalian $pengembalian): void
    {
        LogAktivitas::create([
            'id_user' => auth()->id() ?? $pengembalian->id_user,
            'jenis_aktivitas' => 'pengembalian',
            'deskripsi' => 'Mengubah data pengembalian ID: ' . $pengembalian->id,
            'tanggal_aktivitas' => now(),
        ]);
    }

    public function deleted(Pengembalian $pengembalian): void
    {
        LogAktivitas::create([
            'id_user' => auth()->id() ?? $pengembalian->id_user,
            'jenis_aktivitas' => 'pengembalian',
            'deskripsi' => 'Menghapus data pengembalian ID: ' . $pengembalian->id,
            'tanggal_aktivitas' => now(),
        ]);
    }
}
