@extends('layouts.admin')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Log Peminjaman</h2>
            <p class="text-slate-500 text-sm">Pantau dan kelola persetujuan peminjaman alat.</p>
        </div>
        <a href="{{ route('inventaris.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg shadow-blue-200 transition-all flex items-center gap-2 w-fit">
            <i class="fas fa-plus text-sm"></i> Tambah Pinjaman
        </a>
    </div>

    {{-- NOTIFIKASI SUKSES/ERROR --}}
    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-lg flex items-center gap-3 animate-fade-in-down">
            <i class="fas fa-check-circle text-emerald-500 text-lg"></i>
            <p class="text-emerald-700 text-sm font-medium">{{ session('success') }}</p>
        </div>
    @endif

    {{-- INDIKATOR PEMINJAMAN PENDING --}}
    @if(isset($pendingCount) && $pendingCount > 0)
        <div class="bg-amber-50 border border-amber-200 p-4 rounded-2xl flex items-center justify-between shadow-sm border-l-4 border-l-amber-500">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock animate-spin-slow"></i>
                </div>
                <div>
                    <p class="text-amber-800 font-bold text-sm">Perlu Tindakan!</p>
                    <p class="text-amber-700 text-xs">Ada {{ $pendingCount }} permintaan peminjaman yang menunggu keputusan Anda.</p>
                </div>
            </div>
        </div>
    @endif

    {{-- TABEL PEMINJAMAN --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-widest">
                        <th class="px-6 py-4 font-semibold">Peminjam</th>
                        <th class="px-6 py-4 font-semibold">Informasi Alat</th>
                        <th class="px-6 py-4 font-semibold">Durasi Sewa</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                        <th class="px-6 py-4 font-semibold text-center">Keputusan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($data as $p)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-700">{{ $p->nama_peminjam }}</p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-[10px] bg-slate-100 text-slate-500 px-2 py-0.5 rounded font-bold uppercase">{{ $p->jenis_peminjam }}</span>
                                <span class="text-xs text-slate-400 italic">{{ $p->nomor_identitas }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2 text-blue-600 font-medium">
                                <i class="fas fa-laptop text-xs"></i>
                                <span>{{ $p->inventaris->nama_alat }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-xs text-slate-600">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-calendar-check text-emerald-500 w-3"></i>
                                    <span>{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</span>
                                </div>
                                <div class="flex items-center gap-2 mt-1">
                                    <i class="fas fa-calendar-times text-rose-500 w-3"></i>
                                    <span>{{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d M Y') }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center text-xs">
                            @if($p->status == 'pending')
                                <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full font-bold uppercase tracking-tighter">Menunggu</span>
                            @elseif($p->status == 'approved')
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full font-bold uppercase tracking-tighter">Disetujui</span>
                            @else
                                <span class="px-3 py-1 bg-rose-100 text-rose-700 rounded-full font-bold uppercase tracking-tighter">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-2">

                                @if($p->status === 'pending')

                                    {{-- APPROVE --}}
                                    @if($p->inventaris->stok > 0)
                                        <form action="{{ route('peminjaman.approve', $p->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="bg-emerald-500 hover:bg-emerald-600 text-white text-[11px] font-bold py-1.5 px-3 rounded-lg">
                                                TERIMA
                                            </button>
                                        </form>
                                    @else
                                        <button type="button" disabled
                                            class="bg-slate-200 text-slate-400 text-[11px] font-bold py-1.5 px-3 rounded-lg cursor-not-allowed">
                                            STOK HABIS
                                        </button>
                                    @endif

                                    {{-- TOLAK --}}
                                    <form action="{{ route('peminjaman.reject', $p->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="border border-rose-300 text-rose-600 text-[11px] font-bold py-1.5 px-3 rounded-lg">
                                            TOLAK
                                        </button>
                                    </form>

                                @else
                                    <span class="text-slate-300 text-xs italic">Selesai</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin-slow {
        animation: spin-slow 8s linear infinite;
    }
</style>
@endsection
