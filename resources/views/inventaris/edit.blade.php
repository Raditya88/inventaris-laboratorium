@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto">
    {{-- BREADCRUMB --}}
    <nav class="flex mb-4 text-slate-400 text-xs uppercase tracking-widest font-bold">
        <a href="{{ route('admin.inventaris.index') }}" class="hover:text-blue-600 transition-colors">Inventaris</a>
        <span class="mx-2">/</span>
        <span class="text-slate-700">Edit Data</span>
    </nav>

    {{-- CARD FORM --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-50 bg-blue-50/30">
            <h3 class="text-xl font-bold text-slate-800 flex items-center gap-3">
                <i class="fas fa-edit text-blue-600"></i> Edit Inventaris
            </h3>
            <p class="text-slate-500 text-sm mt-1">Anda sedang merubah rincian alat: <span class="font-bold text-slate-700">{{ $inventaris->nama_alat }}</span></p>
        </div>

        <form action="{{ route('admin.inventaris.update', $inventaris->id) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- KODE ALAT --}}
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-slate-700 uppercase tracking-wider text-[11px]">Kode Alat</label>
                    <input
                        type="text"
                        name="kode"
                        value="{{ $errors->has('kode') ? '' : old('kode', $inventaris->kode) }}"
                        placeholder="{{ $errors->has('kode') ? 'Kode sudah digunakan' : 'Kode unik alat' }}"
                        class="w-full px-4 py-2.5 bg-slate-50 border {{ $errors->has('kode') ? 'border-rose-500 ring-2 ring-rose-500/10 shadow-sm' : 'border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10' }} rounded-xl outline-none transition-all text-sm font-mono {{ $errors->has('kode') ? 'italic placeholder:text-rose-400' : '' }}"
                    >
                    @error('kode')
                        <p class="text-[11px] text-rose-500 mt-1 font-bold italic tracking-wide">{{ $message }}</p>
                    @enderror
                </div>

                {{-- STOK --}}
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-slate-700 uppercase tracking-wider text-[11px]">Stok Saat Ini</label>
                    <div class="relative">
                        <input
                            type="number"
                            name="stok"
                            min="0"
                            value="{{ old('stok', $inventaris->stok) }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border {{ $errors->has('stok') ? 'border-rose-500 ring-2 ring-rose-500/10' : 'border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10' }} rounded-xl outline-none transition-all text-sm font-bold"
                        >
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 font-bold uppercase">Units</span>
                    </div>
                    @error('stok')
                        <p class="text-[11px] text-rose-500 mt-1 font-bold italic tracking-wide">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- NAMA ALAT --}}
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700 uppercase tracking-wider text-[11px]">Nama Alat</label>
                <input
                    type="text"
                    name="nama_alat"
                    value="{{ old('nama_alat', $inventaris->nama_alat) }}"
                    class="w-full px-4 py-2.5 bg-slate-50 border {{ $errors->has('nama_alat') ? 'border-rose-500 ring-2 ring-rose-500/10' : 'border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10' }} rounded-xl outline-none transition-all text-sm shadow-sm"
                >
                @error('nama_alat')
                    <p class="text-[11px] text-rose-500 mt-1 font-bold italic tracking-wide">{{ $message }}</p>
                @enderror
            </div>

            {{-- KETERANGAN --}}
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700 uppercase tracking-wider text-[11px]">Keterangan Tambahan</label>
                <textarea
                    name="keterangan"
                    rows="4"
                    class="w-full px-4 py-2.5 bg-slate-50 border {{ $errors->has('keterangan') ? 'border-rose-500 ring-2 ring-rose-500/10' : 'border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10' }} rounded-xl outline-none transition-all text-sm resize-none"
                >{{ old('keterangan', $inventaris->keterangan) }}</textarea>
                @error('keterangan')
                    <p class="text-[11px] text-rose-500 mt-1 font-bold italic tracking-wide">{{ $message }}</p>
                @enderror
            </div>

            {{-- TOMBOL AKSI --}}
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-50">
                <a href="{{ route('admin.inventaris.index') }}" class="px-6 py-2.5 text-xs font-bold text-slate-400 hover:text-slate-600 transition-all uppercase tracking-widest">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-2.5 rounded-xl font-bold shadow-lg shadow-blue-200 transition-all active:scale-[0.98] uppercase tracking-widest text-xs">
                    Update Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
