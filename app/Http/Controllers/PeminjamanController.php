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
            'jenis_peminjam' => 'required',
            'nama_peminjam' => 'required',
            'nomor_identitas' => 'required',
            'kontak' => 'required',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',

            // VALIDASI BARANG
            'items' => 'required|array|min:1',
            'items.*.inventaris_id' => 'required|exists:inventaris,id',
            'items.*.jumlah' => 'required|integer|min:1'
        ]);

        // ===========================
        //  CEK STOK TERLEBIH DULU
        // ===========================
        foreach ($request->items as $item) {
            $barang = Inventaris::find($item['inventaris_id']);

            if (!$barang) {
                return back()->with('error', 'Barang tidak ditemukan');
            }

            if ($item['jumlah'] > $barang->stok) {
                return back()
                ->with('error', "Stok {$barang->nama_alat} tidak cukup! Tersedia: {$barang->stok}")
                ->withInput();
            }
        }

        // ===========================
        //  SIMPAN KE TABEL PEMINJAMAN (HEADER)
        // ===========================
        $peminjaman = Peminjaman::create([
            'jenis_peminjam'   => $request->jenis_peminjam,
            'nama_peminjam'    => $request->nama_peminjam,
            'nomor_identitas'  => $request->nomor_identitas,
            'kontak'           => $request->kontak,
            'tanggal_pinjam'   => $request->tanggal_pinjam,
            'tanggal_kembali'  => $request->tanggal_kembali,
            'status'           => 'pending',
        ]);

        // ===========================
        //  SIMPAN DETAIL BARANG
        // ===========================
        foreach ($request->items as $item) {
            \App\Models\PeminjamanItem::create([
                'peminjaman_id' => $peminjaman->id,
                'inventaris_id' => $item['inventaris_id'],
                'jumlah'        => $item['jumlah']
            ]);
        }

        return redirect()->back()->with('success', 'Peminjaman berhasil diajukan dan menunggu persetujuan Admin.');
    }

    public function index()
    {
        $data = Peminjaman::with('items.inventaris')->get();
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
