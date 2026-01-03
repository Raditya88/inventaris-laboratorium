<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Inventaris;

class InventarisController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventaris::query();

        // kalau search TIDAK kosong → filter
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                ->orWhere('nama_alat', 'like', "%{$search}%");
            });
        }

        $data = $query->orderBy('nama_alat')->get();
        $pendingCount = Peminjaman::where('status', 'pending')->count();

        return view('inventaris.index', compact('data', 'pendingCount'));
    }

    public function create()
    {
        return view('inventaris.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'kode' => 'required|unique:inventaris,kode',
                'nama_alat' => 'required',
                'stok' => 'required|integer|min:0',
                'keterangan' => 'nullable|string',
            ],
            [
                'kode.required' => 'Kode alat wajib diisi',
                'kode.unique' => 'Kode alat sudah digunakan',
                'nama_alat.required' => 'Nama alat jangan kosong',
                'stok.required' => 'Stok harus diisi',
                'stok.integer' => 'Stok harus berupa angka',
                'stok.min' => 'Stok tidak boleh minus',
            ]
        );

        Inventaris::create($request->all());

        return redirect()->route('admin.inventaris.index')->with('success', 'Data inventaris berhasil ditambahkan');
    }

    public function show(Inventaris $inventaris)
    {
        //
    }

    public function edit(Inventaris $inventaris)
    {
        return view('inventaris.edit', compact('inventaris'));
    }

    public function update(Request $request, Inventaris $inventaris)
    {
        $request->validate(
            [
                'kode' => 'required|unique:inventaris,kode,' . $inventaris->id,
                'nama_alat' => 'required',
                'stok' => 'required|integer|min:0',
                'keterangan' => 'nullable|string',
            ],
            [
                'kode.required' => 'Kode alat wajib diisi',
                'kode.unique' => 'Kode alat sudah digunakan',
                'nama_alat.required' => 'Nama alat jangan kosong',
                'stok.required' => 'Stok harus diisi',
                'stok.integer' => 'Stok harus berupa angka',
                'stok.min' => 'Stok tidak boleh minus',
            ]
        );

        $inventaris->update($request->all());
        return redirect()->route('admin.inventaris.index')->with('success', 'Data inventaris berhasil diperbarui');
    }

    public function destroy(Inventaris $inventaris)
    {
        $inventaris->delete();
        return redirect()->route('admin.inventaris.index')->with('success', 'Data inventaris berhasil dihapus');;
    }
}
