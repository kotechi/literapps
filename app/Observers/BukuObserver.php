<?php

namespace App\Observers;

use App\Models\Buku;
use App\Models\LogAktivitas;

class BukuObserver
{
    public function created(Buku $buku): void
    {
        if (auth()->check()) {
            LogAktivitas::create([
                'id_user' => auth()->id(),
                'jenis_aktivitas' => 'buku',
                'deskripsi' => 'Menambahkan buku baru: ' . $buku->nama_buku,
                'tanggal_aktivitas' => now(),
            ]);
        }
    }

    public function updated(Buku $buku): void
    {
        if (auth()->check()) {
            LogAktivitas::create([
                'id_user' => auth()->id(),
                'jenis_aktivitas' => 'buku',
                'deskripsi' => 'Mengubah data buku: ' . $buku->nama_buku,
                'tanggal_aktivitas' => now(),
            ]);
        }
    }

    public function deleted(Buku $buku): void
    {
        if (auth()->check()) {
            LogAktivitas::create([
                'id_user' => auth()->id(),
                'jenis_aktivitas' => 'buku',
                'deskripsi' => 'Menghapus buku: ' . $buku->nama_buku,
                'tanggal_aktivitas' => now(),
            ]);
        }
    }
}
