<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanItem extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_items';

    protected $fillable = [
        'peminjaman_id',
        'inventaris_id',
        'jumlah',
    ];

    /**
     * Relasi ke tabel Peminjaman
     */
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    /**
     * Relasi ke tabel Inventaris
     */
    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class);
    }
}
