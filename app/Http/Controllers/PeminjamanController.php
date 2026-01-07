<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Peminjaman;
use App\Models\Inventaris;
use App\Models\PeminjamanItem;
use App\Helpers\WhatsAppHelper;

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

            'items'                 => 'required|array|min:1',
            'items.*.inventaris_id' => 'required|exists:inventaris,id',
            'items.*.jumlah'        => 'required|integer|min:1',
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
                'kontak'           => $request->kontak, // format 62xxxx
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

        if ($peminjaman->status !== 'pending') {
            return back()->with('error', 'Peminjaman sudah diproses');
        }

        // ============================
        // CEK STOK
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
        // APPROVE + POTONG STOK
        // ============================
        DB::transaction(function () use ($peminjaman) {

            foreach ($peminjaman->items as $item) {
                $item->inventaris->decrement('stok', $item->jumlah);
            }

            $peminjaman->update([
                'status' => 'approved'
            ]);
        });

        // ============================
        // KIRIM WHATSAPP (FONNTE)
        // ============================
        $pesan = $this->formatPesanWA($peminjaman, 'DISETUJUI');
        WhatsAppHelper::send($peminjaman->kontak, $pesan);

        return back()->with('success', 'Peminjaman disetujui & WhatsApp terkirim');
    }

    // ============================
    // REJECT PEMINJAMAN
    // ============================
    public function reject($id)
    {
        $peminjaman = Peminjaman::with('items.inventaris')->findOrFail($id);

        if ($peminjaman->status !== 'pending') {
            return back()->with('error', 'Peminjaman sudah diproses');
        }

        $peminjaman->update([
            'status' => 'rejected'
        ]);

        // ============================
        // KIRIM WHATSAPP (FONNTE)
        // ============================
        $pesan = $this->formatPesanWA($peminjaman, 'DITOLAK');
        WhatsAppHelper::send($peminjaman->kontak, $pesan);

        return back()->with('success', 'Peminjaman ditolak & WhatsApp terkirim');
    }

    // ============================
    // FORMAT PESAN WHATSAPP
    // ============================
    private function formatPesanWA($peminjaman, $status)
    {
        $items = "";
        foreach ($peminjaman->items as $item) {
            if ($item->inventaris) {
                $items .= "- {$item->inventaris->nama_alat} ({$item->jumlah})\n";
            }
        }

        return
"📌 *INFORMASI PEMINJAMAN*
-------------------------
Nama    : {$peminjaman->nama_peminjam}
Status  : *{$status}*
Pinjam  : {$peminjaman->tanggal_pinjam}
Kembali : {$peminjaman->tanggal_kembali}

📦 *Daftar Barang*
{$items}

Terima kasih 🙏";
    }
}
