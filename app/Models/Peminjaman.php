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
        'id_alat',
        'tanggal_pengembalian',
        'deskripsi',
        'status',
    ];

    protected $casts = [
        'tanggal_pengembalian' => 'date',
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
     * Get the alat that owns the peminjaman.
     */
    public function alat()
    {
        return $this->belongsTo(Alat::class, 'id_alat');
    }

    /**
     * Get the pengembalian for the peminjaman.
     */
    public function pengembalian()
    {
        return $this->hasMany(Pengembalian::class, 'id_peminjaman');
    }
}