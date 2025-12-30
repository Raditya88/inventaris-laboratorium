<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman; // ganti jika model berbeda
use App\Models\Iventaris;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class LaporanController extends Controller
{
    // Tampilkan halaman laporan (minimal)
    public function index(Request $request)
    {
        $items = class_exists(Barang::class) ? Barang::orderBy('nama_alat')->get() : collect();
        $users = class_exists(User::class) ? User::orderBy('name_peminjam')->get() : collect();

        return view('laporan', compact('items', 'users'));
    }

    // Ekspor PDF berdasarkan filter (minimal)
    public function exportPdf(Request $request)
    {
        $query = Peminjaman::with(['item', 'user']);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_pinjam', [
                $request->input('start_date') . ' 00:00:00',
                $request->input('end_date') . ' 23:59:59',
            ]);
        }

        if ($request->filled('item_id')) {
            $query->where('item_id', $request->input('item_id'));
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        $data = $query->orderBy('tanggal_pinjam', 'desc')->get();

        $from = $request->input('start_date') ?: 'all';
        $to = $request->input('end_date') ?: 'all';
        $filename = "laporan_{$from}_{$to}.pdf";

        $pdf = PDF::loadView('laporan_pdf', [
            'data' => $data,
            'filters' => $request->only(['start_date','end_date','item_id','user_id']),
        ])->setPaper('a4', 'landscape');

        return $pdf->download($filename);
    }
}