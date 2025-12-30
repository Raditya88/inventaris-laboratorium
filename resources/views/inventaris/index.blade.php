@extends('layouts.admin')

@section('content')
<div class="space-y-6">

    {{-- HEADER SECTION --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Data Inventaris</h2>
            <p class="text-slate-500 text-sm">Kelola aset dan stok alat kantor secara real-time.</p>
        </div>

        <a href="{{ route('inventaris.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg shadow-blue-200 transition-all flex items-center gap-2 w-fit">
            <i class="fas fa-plus"></i> Tambah Alat
        </a>
    </div>

    {{-- ALERT NOTIFICATION (Jika ada pending) --}}
    @if(isset($pendingCount) && $pendingCount > 0)
        <div class="flex items-center p-4 mb-4 text-amber-800 border-t-4 border-amber-500 bg-amber-50 rounded-xl shadow-sm animate-pulse">
            <i class="fas fa-exclamation-circle text-xl mr-3"></i>
            <div class="text-sm font-medium">
                Pemberitahuan: <span class="font-bold underline">Ada {{ $pendingCount }} peminjaman</span> yang sedang menunggu persetujuan Anda.
            </div>
            <a href="/admin/peminjaman" class="ml-auto text-xs bg-amber-200 hover:bg-amber-300 px-3 py-1 rounded-lg transition-all font-bold uppercase">Cek Sekarang</a>
        </div>
    @endif

    {{-- TABLE SECTION --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 text-slate-500 text-xs uppercase tracking-widest">
                        <th class="px-6 py-4 font-semibold">Kode & Nama Alat</th>
                        <th class="px-6 py-4 font-semibold text-center">Stok</th>
                        <th class="px-6 py-4 font-semibold text-center">Deskripsi</th>
                        <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($data as $d)
                    <tr class="hover:bg-blue-50/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-slate-100 group-hover:bg-blue-100 text-slate-500 group-hover:text-blue-600 rounded-lg flex items-center justify-center transition-colors">
                                    <i class="fas fa-tools"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-700">{{ $d->nama_alat }}</p>
                                    <p class="text-xs text-slate-400 font-mono">{{ $d->kode }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-block px-3 py-1 {{ $d->stok <= 5 ? 'bg-rose-100 text-rose-700' : 'bg-blue-100 text-blue-700' }} rounded-full text-sm font-bold">
                                {{ $d->stok }} <span class="text-[10px] font-normal italic">Unit</span>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-500 italic leading-relaxed">
                                "{{ Str::limit($d->keterangan, 40) }}"
                            </p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-2">
                                {{-- Edit Button --}}
                                <a href="{{ route('inventaris.edit', $d) }}" class="w-9 h-9 flex items-center justify-center text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white rounded-lg transition-all" title="Edit Data">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>

                                {{-- Delete Button --}}
                                <form action="{{ route('inventaris.destroy', $d) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus alat ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-9 h-9 flex items-center justify-center text-rose-600 bg-rose-50 hover:bg-rose-600 hover:text-white rounded-lg transition-all" title="Hapus Data">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Jika data kosong --}}
        @if($data->isEmpty())
            <div class="p-20 text-center">
                <i class="fas fa-folder-open text-5xl text-slate-200 mb-4"></i>
                <p class="text-slate-400">Belum ada data inventaris.</p>
            </div>
        @endif
    </div>
</div>
@endsection
