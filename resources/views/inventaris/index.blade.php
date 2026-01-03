@extends('layouts.admin')

@section('content')
<div class="space-y-6">

    {{-- HEADER & SEARCH SECTION --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Data Inventaris</h2>
            <p class="text-slate-500 text-sm">Kelola aset dan stok alat kantor secara real-time.</p>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-3">
            {{-- SEARCH FORM --}}
            <form method="GET" action="{{ route('inventaris.index') }}" class="flex gap-2">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari kode / nama alat..."
                    class="border border-gray-300 rounded-lg px-4 py-2 w-64 focus:ring focus:ring-blue-200"
                >

                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2"
                >
                    <i class="fas fa-search"></i>
                    Cari
                </button>

                @if(request('search'))
                    <a href="{{ route('inventaris.index') }}"
                    class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-100">
                    Reset
                    </a>
                @endif
            </form>
            {{-- ADD BUTTON --}}
            <a href="{{ route('inventaris.create') }}" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg shadow-blue-200 transition-all flex items-center justify-center gap-2">
                <i class="fas fa-plus"></i>
                <span>Tambah Alat</span>
            </a>
        </div>
    </div>

    {{-- ALERT NOTIFICATION --}}
    @if(isset($pendingCount) && $pendingCount > 0)
        <div class="flex items-center p-4 text-amber-800 border-l-4 border-amber-500 bg-amber-50 rounded-xl shadow-sm animate-pulse">
            <i class="fas fa-exclamation-circle text-xl mr-3 text-amber-500"></i>
            <div class="text-sm font-medium">
                Ada <span class="font-bold underline">{{ $pendingCount }} peminjaman</span> menunggu persetujuan.
            </div>
            <a href="/admin/peminjaman" class="ml-auto text-[10px] bg-white border border-amber-200 hover:bg-amber-100 px-3 py-1.5 rounded-lg transition-all font-bold uppercase tracking-wider">Detail</a>
        </div>
    @endif

    {{-- TABLE SECTION --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 text-slate-400 text-[11px] uppercase tracking-[0.15em]">
                        <th class="px-6 py-4 font-bold">Kode & Nama Alat</th>
                        <th class="px-6 py-4 font-bold text-center">Stok</th>
                        <th class="px-6 py-4 font-bold">Deskripsi</th>
                        <th class="px-6 py-4 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($data as $d)
                    <tr class="hover:bg-blue-50/30 transition-colors group">
                        <td class="px-6 py-4 text-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-slate-100 group-hover:bg-blue-100 text-slate-400 group-hover:text-blue-600 rounded-xl flex items-center justify-center transition-all duration-300">
                                    <i class="fas fa-tools"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-700 group-hover:text-blue-700 transition-colors">{{ $d->nama_alat }}</p>
                                    <p class="text-[11px] text-slate-400 font-mono tracking-tighter">{{ $d->kode }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-3 py-1 {{ $d->stok <= 5 ? 'bg-rose-50 text-rose-600 ring-1 ring-rose-200' : 'bg-emerald-50 text-emerald-600 ring-1 ring-emerald-200' }} rounded-full text-xs font-bold">
                                {{ $d->stok }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-500 line-clamp-1 max-w-[250px]">
                                {{ $d->keterangan ?? '-' }}
                            </p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('inventaris.edit', $d) }}" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('inventaris.destroy', $d) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-20 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-search text-4xl text-slate-200 mb-4"></i>
                                <p class="text-slate-400 font-medium">Tidak ada data yang ditemukan.</p>
                                <a href="{{ route('inventaris.index') }}" class="text-blue-500 text-sm mt-2 hover:underline">Hapus pencarian</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
