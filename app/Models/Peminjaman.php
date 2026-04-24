<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'id_user',
        'id_buku',
        'tgl_pinjam',
        'tgl_pengembalian',
        'deskripsi',
        'status',
    ];

    protected $casts = [
        'tgl_pinjam' => 'date',
        'tgl_pengembalian' => 'date',
        'status' => 'string',
    ];

    /**
     * Get the user that owns the peminjaman.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Get the buku that owns the peminjaman.
     */
    public function buku()
    {
        return $this->belongsTo(buku::class, 'id_buku');
    }

    /**
     * Get the pengembalian for the peminjaman.
     */
    public function pengembalian()
    {
        return $this->hasMany(Pengembalian::class, 'id_peminjaman');
    }
}