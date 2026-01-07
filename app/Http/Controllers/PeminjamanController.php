<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Peminjaman;
use App\Models\Inventaris;
use App\Models\PeminjamanItem;

class PeminjamanController extends Controller
{
    // ============================
    // FORM PEMINJAMAN
    // ============================
    public function create()
    {
        $inventaris = Inventaris::all();
        return view('peminjaman.create', compact('inventaris'));
    }

    // ============================
    // SIMPAN PEMINJAMAN
    // ============================
    public function store(Request $request)
    {
        $request->validate([
            'jenis_peminjam'   => 'required',
            'nama_peminjam'    => 'required',
            'nomor_identitas'  => 'required',
            'kontak'           => 'required',
            'tanggal_pinjam'   => 'required|date',
            'tanggal_kembali'  => 'required|date|after_or_equal:tanggal_pinjam',

            'items'                    => 'required|array|min:1',
            'items.*.inventaris_id'    => 'required|exists:inventaris,id',
            'items.*.jumlah'           => 'required|integer|min:1',
        ]);

        // ============================
        // CEK STOK SEBELUM SIMPAN
        // ============================
        foreach ($request->items as $item) {
            $barang = Inventaris::find($item['inventaris_id']);

            if (!$barang) {
                return back()->with('error', 'Barang tidak ditemukan');
            }

            if ($item['jumlah'] > $barang->stok) {
                return back()
                    ->with(
                        'error',
                        "Stok {$barang->nama_alat} tidak cukup! Tersedia: {$barang->stok}"
                    )
                    ->withInput();
            }
        }

        DB::transaction(function () use ($request) {

            // ============================
            // SIMPAN HEADER
            // ============================
            $peminjaman = Peminjaman::create([
                'jenis_peminjam'   => $request->jenis_peminjam,
                'nama_peminjam'    => $request->nama_peminjam,
                'nomor_identitas'  => $request->nomor_identitas,
                'kontak'           => $request->kontak,
                'tanggal_pinjam'   => $request->tanggal_pinjam,
                'tanggal_kembali'  => $request->tanggal_kembali,
                'status'           => 'pending',
            ]);

            // ============================
            // SIMPAN DETAIL BARANG
            // ============================
            foreach ($request->items as $item) {
                PeminjamanItem::create([
                    'peminjaman_id' => $peminjaman->id,
                    'inventaris_id' => $item['inventaris_id'],
                    'jumlah'        => $item['jumlah'],
                ]);
            }
        });

        return back()->with(
            'success',
            'Peminjaman berhasil diajukan dan menunggu persetujuan Admin.'
        );
    }

    // ============================
    // LIST PEMINJAMAN
    // ============================
    public function index()
    {
        $data = Peminjaman::with('items.inventaris')->get();
        return view('peminjaman.index', compact('data'));
    }

    // ============================
    // APPROVE PEMINJAMAN
    // ============================
    public function approve($id)
    {
        $peminjaman = Peminjaman::with('items.inventaris')->findOrFail($id);

        // cegah approve ulang
        if ($peminjaman->status === 'approved') {
            return back()->with('error', 'Peminjaman sudah disetujui');
        }

        // ============================
        // CEK STOK SEMUA BARANG
        // ============================
        foreach ($peminjaman->items as $item) {

            if (!$item->inventaris) {
                return back()->with('error', 'Data inventaris tidak valid');
            }

            if ($item->jumlah > $item->inventaris->stok) {
                return back()->with(
                    'error',
                    "Stok {$item->inventaris->nama_alat} tidak mencukupi"
                );
            }
        }

        // ============================
        // PROSES APPROVE (TRANSACTION)
        // ============================
        DB::transaction(function () use ($peminjaman) {

            foreach ($peminjaman->items as $item) {
                $item->inventaris->decrement('stok', $item->jumlah);
            }

            $peminjaman->update([
                'status' => 'approved'
            ]);
        });

        return back()->with('success', 'Peminjaman disetujui');
    }

    // ============================
    // REJECT PEMINJAMAN
    // ============================
    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'pending') {
            return back()->with('error', 'Peminjaman tidak dapat ditolak');
        }

        $peminjaman->update([
            'status' => 'rejected'
        ]);

        return back()->with('success', 'Peminjaman ditolak');
    }
}
