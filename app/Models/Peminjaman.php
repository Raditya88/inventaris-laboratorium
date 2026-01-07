<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'jenis_peminjam',
        'nama_peminjam',
        'nomor_identitas',
        'kontak',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];

    // Jika masih pakai inventaris_id lama, sementara tetap boleh
    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class, 'inventaris_id');
    }

    // Relasi baru: banyak barang dalam 1 peminjaman
    public function items()
    {
        return $this->hasMany(PeminjamanItem::class, 'peminjaman_id');
    }
}
