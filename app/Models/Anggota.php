<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggota';

    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'angkatan',
        'kelas',
        'nis',
        'nisn',
    ];

    /**
     * Get user for this anggota profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
