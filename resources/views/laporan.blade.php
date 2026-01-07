@extends('layouts.admin')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Laporan Peminjaman</h2>
            <p class="text-slate-500 text-sm">Filter, lihat riwayat, dan ekspor data ke PDF.</p>
        </div>

        <button id="exportPdfBtn"
            class="bg-rose-600 hover:bg-rose-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow-md shadow-rose-200 transition-all flex items-center gap-2">
            <i class="fas fa-file-pdf"></i> Export PDF
        </button>
    </div>


    {{-- FILTER --}}
    <form method="GET" action="{{ route('admin.laporan.index') }}"
        class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm grid grid-cols-1 md:grid-cols-4 gap-4">

        <div>
            <label class="text-sm font-semibold text-slate-600">Mulai</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}"
                class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2 focus:ring-blue-200 focus:ring outline-none">
        </div>

        <div>
            <label class="text-sm font-semibold text-slate-600">Sampai</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}"
                class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2 focus:ring-blue-200 focus:ring outline-none">
        </div>

        <div>
            <label class="text-sm font-semibold text-slate-600">Barang</label>
            <select name="item_id"
                class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2 focus:ring-blue-200 focus:ring outline-none">
                <option value="">Semua</option>
                @foreach($items as $item)
                    <option value="{{ $item->id }}" {{ request('item_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->nama_alat }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-end gap-2">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg shadow-blue-200 transition-all">
                Filter
            </button>

            <a href="{{ route('admin.laporan.index') }}"
                class="px-5 py-2.5 border rounded-xl text-slate-600 hover:bg-slate-100">
                Reset
            </a>
        </div>
    </form>


    {{-- TABEL --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div id="tableContainer" class="overflow-x-auto">

            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 text-[11px] uppercase tracking-widest">
                        <th class="px-6 py-4 font-bold">#</th>
                        <th class="px-6 py-4 font-bold">Jenis</th>
                        <th class="px-6 py-4 font-bold">Nama</th>
                        <th class="px-6 py-4 font-bold">NIP / NIM</th>
                        <th class="px-6 py-4 font-bold">Kontak</th>
                        <th class="px-6 py-4 font-bold">Alat</th>
                        <th class="px-6 py-4 font-bold">Pinjam</th>
                        <th class="px-6 py-4 font-bold">Kembali</th>
                        <th class="px-6 py-4 font-bold text-center">Status</th>
                        <th class="px-6 py-4 font-bold">Keterangan</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($peminjamans as $i => $p)
                    <tr class="hover:bg-blue-50/30 transition">

                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $p->jenis_peminjam }}</td>
                        <td class="px-6 py-4 font-semibold text-slate-700">{{ $p->nama_peminjam }}</td>
                        <td class="px-6 py-4">{{ $p->nomor_identitas }}</td>
                        <td class="px-6 py-4">{{ $p->kontak }}</td>
                        <td class="px-6 py-4 text-blue-600 font-medium">
                            {{ optional($p->inventaris)->nama_alat ?? '-' }}
                        </td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d/m/Y') }}</td>

                        <td class="px-6 py-4 text-center">
                            @if($p->status == 'approved')
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs rounded-full font-bold">Disetujui</span>
                            @elseif($p->status == 'pending')
                                <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs rounded-full font-bold">Menunggu</span>
                            @else
                                <span class="px-3 py-1 bg-rose-100 text-rose-700 text-xs rounded-full font-bold">Ditolak</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-slate-500">
                            {{ $p->keterangan ?? '-' }}
                        </td>

                    </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="p-10 text-center text-slate-400">
                                Tidak ada data laporan ditemukan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>


{{-- PDF SCRIPT --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

<script>
document.getElementById("exportPdfBtn")?.addEventListener("click", function () {
    const el = document.getElementById("tableContainer");
    const opt = {
        margin: 10,
        filename: "laporan-peminjaman.pdf",
        image: { type: "jpeg", quality: 1 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: "mm", format: "a4", orientation: "landscape" }
    };

    html2pdf().set(opt).from(el).save();
});
</script>

@endsection
