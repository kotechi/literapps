<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';

    protected $fillable = [
        'id_kategori',
        'nama_buku',
        'deskripsi',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    /**
     * Get the kategori that owns the buku.
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    /**
     * Get the peminjaman for the buku.
     */
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_buku');
    }
}