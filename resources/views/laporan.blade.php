@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Laporan</h1>

    <form id="filterForm" method="GET" action="{{ route('laporan.index') }}" class="row g-3 mb-3">
        <div class="col-auto">
            <label>Mulai</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
        </div>
        <div class="col-auto">
            <label>Sampai</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
        </div>
        <div class="col-auto">
            <label>Barang</label>
            <select name="item_id" id="item_id" class="form-select">
                <option value="">Semua</option>
                @foreach($items as $item)
                    <option value="{{ $item->id }}" {{ request('item_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <label>Peminjam</label>
            <select name="user_id" id="user_id" class="form-select">
                <option value="">Semua</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
                        {{ $u->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-12 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Filter</button>

            <!-- Tombol export di dalam halaman (tidak membuat page baru) -->
            <button type="button" id="exportPdfBtn" class="btn btn-danger">Export PDF</button>
        </div>
    </form>

    <p>Halaman laporan (minimal) siap. Gunakan filter lalu klik "Export PDF" untuk mengunduh tanpa berpindah halaman.</p>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const exportBtn = document.getElementById('exportPdfBtn');
    const filterForm = document.getElementById('filterForm');

    exportBtn.addEventListener('click', async function () {
        // Buat query string dari input form
        const params = new URLSearchParams(new FormData(filterForm)).toString();
        const url = '{{ route("laporan.pdf") }}' + (params ? ('?' + params) : '');

        try {
            exportBtn.disabled = true;
            exportBtn.textContent = 'Membuat PDF...';

            const res = await fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/pdf'
                },
                credentials: 'same-origin'
            });

            if (!res.ok) throw new Error('Gagal mengambil PDF: ' + res.status);

            const blob = await res.blob();

            // Coba ambil filename dari header Content-Disposition, fallback ke nama default
            let filename = 'laporan.pdf';
            const cd = res.headers.get('content-disposition');
            if (cd) {
                const match = cd.match(/filename\*?=(?:UTF-8'')?["']?([^;"']+)["']?/i);
                if (match && match[1]) {
                    filename = decodeURIComponent(match[1].replace(/["']/g, ''));
                }
            } else {
                // Buat nama file berdasarkan tanggal filter kalau tersedia
                const sd = document.getElementById('start_date').value || 'all';
                const ed = document.getElementById('end_date').value || 'all';
                filename = `laporan_${sd}_${ed}.pdf`;
            }

            // Download file
            const link = document.createElement('a');
            const blobUrl = window.URL.createObjectURL(blob);
            link.href = blobUrl;
            link.download = filename;
            document.body.appendChild(link);
            link.click();
            link.remove();
            window.URL.revokeObjectURL(blobUrl);

        } catch (err) {
            console.error(err);
            alert('Terjadi kesalahan saat mengekspor PDF.');
        } finally {
            exportBtn.disabled = false;
            exportBtn.textContent = 'Export PDF';
        }
    });
});
</script>
@endsection