@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto">
    {{-- BREADCRUMB / NAVIGASI KECIL --}}
    <nav class="flex mb-4 text-slate-400 text-xs uppercase tracking-widest font-bold">
        <a href="{{ route('admin.inventaris.index') }}" class="hover:text-blue-600 transition-colors">Inventaris</a>
        <span class="mx-2">/</span>
        <span class="text-slate-700">Tambah Baru</span>
    </nav>

    {{-- CARD FORM --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-50 bg-slate-50/50">
            <h3 class="text-xl font-bold text-slate-800">Tambah Inventaris Baru</h3>
            <p class="text-slate-500 text-sm mt-1">Pastikan kode alat unik dan informasi stok akurat.</p>
        </div>

        <form action="{{ route('admin.inventaris.store') }}" method="POST" class="p-8 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- KODE ALAT --}}
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-slate-700">Kode Alat</label>
                    <input
                        type="text"
                        name="kode"
                        value="{{ old('kode') }}"
                        placeholder="Contoh: PC-001"
                        class="w-full px-4 py-2.5 bg-slate-50 border {{ $errors->has('kode') ? 'border-rose-500 ring-2 ring-rose-500/10' : 'border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10' }} rounded-xl outline-none transition-all text-sm font-mono"
                    >
                    @error('kode')
                        <p class="text-xs text-rose-500 italic mt-1 font-medium"><i class="fas fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                    @enderror
                </div>

                {{-- STOK --}}
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-slate-700">Jumlah Stok</label>
                    <div class="relative">
                        <input
                            type="number"
                            name="stok"
                            min="0"
                            value="{{ old('stok', 0) }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border {{ $errors->has('stok') ? 'border-rose-500 ring-2 ring-rose-500/10' : 'border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10' }} rounded-xl outline-none transition-all text-sm font-bold"
                        >
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs text-slate-400 font-bold uppercase">Unit</span>
                    </div>
                    @error('stok')
                        <p class="text-xs text-rose-500 italic mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- NAMA ALAT --}}
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700">Nama Alat / Barang</label>
                <input
                    type="text"
                    name="nama_alat"
                    value="{{ old('nama_alat') }}"
                    placeholder="Masukkan nama lengkap perangkat"
                    class="w-full px-4 py-2.5 bg-slate-50 border {{ $errors->has('nama_alat') ? 'border-rose-500 ring-2 ring-rose-500/10' : 'border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10' }} rounded-xl outline-none transition-all text-sm"
                >
                @error('nama_alat')
                    <p class="text-xs text-rose-500 italic mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- KETERANGAN --}}
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700">Keterangan / Deskripsi</label>
                <textarea
                    name="keterangan"
                    rows="4"
                    placeholder="Tambahkan catatan mengenai kondisi atau spesifikasi barang..."
                    class="w-full px-4 py-2.5 bg-slate-50 border {{ $errors->has('keterangan') ? 'border-rose-500 ring-2 ring-rose-500/10' : 'border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10' }} rounded-xl outline-none transition-all text-sm resize-none"
                >{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <p class="text-xs text-rose-500 italic mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- TOMBOL AKSI --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-50">
                <a href="{{ route('admin.inventaris.index') }}" class="px-6 py-2.5 text-sm font-bold text-slate-500 hover:text-slate-700 transition-all">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-xl font-bold shadow-lg shadow-blue-200 transition-all active:scale-[0.98]">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
