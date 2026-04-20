<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalian';

    protected $fillable = [
        'id_peminjaman',
        'tanggal_kembali_realisasi',
        'id_user',
        'status',
        'hari_terlambat',
    ];

    protected $casts = [
        'tanggal_kembali_realisasi' => 'date',
        'status' => 'string',
        'hari_terlambat' => 'integer',
    ];

    /**
     * Get the peminjaman that owns the pengembalian.
     */
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }

    /**
     * Get the user that owns the pengembalian.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Get the denda for the pengembalian.
     */
    public function denda()
    {
        return $this->hasMany(Denda::class, 'id_pengembalian');
    }

    /**
     * Get the bukti pengembalian for the pengembalian.
     */
    public function buktiPengembalian()
    {
        return $this->hasMany(BuktiPengembalian::class, 'id_pengembalian');
    }
}