<?php

namespace App\Observers;

use App\Models\Peminjaman;
use App\Models\LogAktivitas;

class PeminjamanObserver
{
    public function created(Peminjaman $peminjaman): void
    {
        LogAktivitas::create([
            'id_user' => auth()->id() ?? $peminjaman->id_user,
            'jenis_aktivitas' => 'peminjaman',
            'deskripsi' => 'Mengajukan peminjaman buku: ' . $peminjaman->buku?->nama_buku ?? 'ID: ' . $peminjaman->id_buku,
            'tanggal_aktivitas' => now(),
        ]);
    }

    public function updated(Peminjaman $peminjaman): void
    {
        $changes = $peminjaman->getChanges();
        
        if (isset($changes['status'])) {
            $statusLama = $peminjaman->getOriginal('status');
            $statusBaru = $changes['status'];
            
            $deskripsi = "Status peminjaman diubah dari '{$statusLama}' menjadi '{$statusBaru}'";
            
            if ($statusBaru === 'approved') {
                $deskripsi = 'Menyetujui peminjaman buku: ' . $peminjaman->buku?->nama_buku ?? 'ID: ' . $peminjaman->id_buku;
            } elseif ($statusBaru === 'rejected') {
                $deskripsi = 'Menolak peminjaman buku: ' . $peminjaman->buku?->nama_buku ?? 'ID: ' . $peminjaman->id_buku;
            }
            
            LogAktivitas::create([
                'id_user' => auth()->id() ?? $peminjaman->id_user,
                'jenis_aktivitas' => 'peminjaman',
                'deskripsi' => $deskripsi,
                'tanggal_aktivitas' => now(),
            ]);
        } else {
            LogAktivitas::create([
                'id_user' => auth()->id() ?? $peminjaman->id_user,
                'jenis_aktivitas' => 'peminjaman',
                'deskripsi' => 'Mengubah data peminjaman ID: ' . $peminjaman->id,
                'tanggal_aktivitas' => now(),
            ]);
        }
    }

    public function deleted(Peminjaman $peminjaman): void
    {
        LogAktivitas::create([
            'id_user' => auth()->id() ?? $peminjaman->id_user,
            'jenis_aktivitas' => 'peminjaman',
            'deskripsi' => 'Menghapus peminjaman buku: ' . $peminjaman->buku?->nama_buku ?? 'ID: ' . $peminjaman->id_buku,
            'tanggal_aktivitas' => now(),
        ]);
    }
}
