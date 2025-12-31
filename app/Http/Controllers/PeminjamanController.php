<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Inventaris;

class PeminjamanController extends Controller
{
    // tampilkan form peminjaman
    public function create()
    {
        $inventaris = Inventaris::all();
        return view('peminjaman.create', compact('inventaris'));
    }

    // simpan data peminjaman
    public function store(Request $request)
    {
        $request->validate([
            'jenis_peminjam'   => 'required',
            'nama_peminjam'    => 'required',
            'nomor_identitas'  => 'required',
            'kontak'           => 'required',
            'inventaris_id'    => 'required',
            'tanggal_pinjam'   => 'required|date',
            'tanggal_kembali'  => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        Peminjaman::create([
            'jenis_peminjam'   => $request->jenis_peminjam,
            'nama_peminjam'    => $request->nama_peminjam,
            'nomor_identitas'  => $request->nomor_identitas,
            'kontak'           => $request->kontak,
            'inventaris_id'    => $request->inventaris_id,
            'tanggal_pinjam'   => $request->tanggal_pinjam,
            'tanggal_kembali'  => $request->tanggal_kembali,
            'status'           => 'pending',
        ]);

        return redirect()->back()->with('success', 'Peminjaman berhasil diajukan');
    }

    public function index()
    {
        $data = Peminjaman::with('inventaris')->orderBy('created_at', 'desc')->get();
        return view('peminjaman.index', compact('data'));
    }

    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $inventaris = $peminjaman->inventaris;

        // cek stok
        if ($peminjaman->inventaris->stok <= 0) {
            return back()->with('error', 'Stok alat habis');
        }
        
        // kurangi stok
        $inventaris->stok -= 1;
        $inventaris->save();

        // update status
        $peminjaman->status = 'approved';
        $peminjaman->save();

        return back()->with('success', 'Peminjaman disetujui');
    }

    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status = 'rejected';
        $peminjaman->save();

        return back()->with('success', 'Peminjaman ditolak');
    }

}
