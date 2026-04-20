<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuktiPengembalian extends Model
{
    use HasFactory;

    protected $table = 'bukti_pengembalian';

    protected $fillable = [
        'id_pengembalian',
        'tipe_media',
        'path_file',
        'keterangan',
    ];

    /**
     * Get the pengembalian that owns the bukti pengembalian.
     */
    public function pengembalian()
    {
        return $this->belongsTo(Pengembalian::class, 'id_pengembalian');
    }
}
