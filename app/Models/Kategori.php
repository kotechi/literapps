<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = [
        'nama_kategori',
    ];

    /**
     * Get the buku for the kategori.
     */
    public function buku()
    {
        return $this->hasMany(buku::class, 'id_kategori');
    }
}