<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama_alat',
        'stok',
        'keterangan'
    ];

    public function peminjamanItems()
    {
        return $this->hasMany(PeminjamanItem::class, 'inventaris_id');
    }
}
