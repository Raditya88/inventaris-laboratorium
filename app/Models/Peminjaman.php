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
        'inventaris_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];

    // Relasi: peminjaman milik satu inventaris
    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class);
    }

    public function index()
    {
        $data = Peminjaman::with('inventaris')->orderBy('created_at', 'desc')->get();
        return view('peminjaman.index', compact('data'));
    }
}
