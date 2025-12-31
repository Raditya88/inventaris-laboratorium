<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Inventaris;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;

class LaporanController extends Controller
{
    // Tampilkan halaman laporan (hanya yang approved)
    public function index(Request $request)
    {
        // ambil list inventaris untuk dropdown
        $items = Inventaris::orderBy('nama_alat')->get();
        $users = User::orderBy('name')->get();

        // query peminjaman dengan relasi inventaris, hanya yang approved
        $query = Peminjaman::with('inventaris')->where('status', 'approved');

        // filter tanggal (jika diisi)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start = Carbon::parse($request->input('start_date'))->toDateString();
            $end = Carbon::parse($request->input('end_date'))->toDateString();
            $query->whereBetween('tanggal_pinjam', [$start, $end]);
        }

        // filter inventaris
        if ($request->filled('item_id')) {
            $query->where('inventaris_id', $request->input('item_id'));
        }

        // ambil hasil (paginate agar tidak berat)
        $peminjamans = $query->orderBy('tanggal_pinjam', 'desc')->paginate(15)->appends($request->query());

        return view('laporan', compact('items', 'users', 'peminjamans'));
    }

    // Ekspor PDF berdasarkan filter (hanya yang approved)
    public function exportPdf(Request $request)
    {
        $query = Peminjaman::with('inventaris')->where('status', 'approved');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start = Carbon::parse($request->input('start_date'))->toDateString();
            $end = Carbon::parse($request->input('end_date'))->toDateString();
            $query->whereBetween('tanggal_pinjam', [$start, $end]);
        }

        if ($request->filled('item_id')) {
            $query->where('inventaris_id', $request->input('item_id'));
        }

        $data = $query->orderBy('tanggal_pinjam', 'desc')->get();

        $from = $request->input('start_date') ?: 'all';
        $to = $request->input('end_date') ?: 'all';
        $filename = "laporan_{$from}_{$to}.pdf";

        $pdf = PDF::loadView('laporan_pdf', [
            'data' => $data,
            'filters' => $request->only(['start_date','end_date','item_id']),
        ])->setPaper('a4', 'landscape');

        return $pdf->download($filename);
    }
}