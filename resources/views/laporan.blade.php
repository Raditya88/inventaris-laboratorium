<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Inventaris</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h1 class="mb-4">Laporan Inventaris</h1>

    <form id="filterForm" method="GET" action="{{ route('laporan.index') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <label class="form-label">Mulai</label>
            <input type="date" name="start_date" id="start_date" class="form-control"
                   value="{{ request('start_date') }}">
        </div>

        <div class="col-md-3">
            <label class="form-label">Sampai</label>
            <input type="date" name="end_date" id="end_date" class="form-control"
                   value="{{ request('end_date') }}">
        </div>

        <div class="col-md-4">
            <label class="form-label">Barang</label>
            <select name="item_id" id="item_id" class="form-select">
                <option value="">Semua</option>
                @foreach($items as $item)
                    <option value="{{ $item->id }}"
                        {{ request('item_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->nama_alat }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2 d-flex align-items-end gap-2">
            <button type="submit" id="applyFilterBtn" class="btn btn-primary w-100">Filter</button>
            <button type="button" id="resetFilterBtn" class="btn btn-outline-secondary w-100">Reset</button>
        </div>
    </form>

    <p class="text-muted mb-3">
        Gunakan filter lalu klik <b>Export PDF</b> untuk mengunduh laporan (hanya baris yang terlihat di tabel saat ini).
    </p>

    @php
        $rows = $peminjamans ?? collect();
        $totalCount = isset($rows) && method_exists($rows, 'total') ? $rows->total() : (is_countable($rows) ? count($rows) : 0);
        use \Carbon\Carbon;
        function formatDateLocal($value) {
            if (empty($value)) return '-';
            try { return Carbon::parse($value)->format('d/m/Y'); } catch (\Exception $e) { return $value; }
        }
    @endphp

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Hasil Laporan <small class="text-muted">({{ $totalCount }} item)</small></h5>

            <div class="table-responsive" id="tableContainer">
                <table class="table table-bordered table-striped align-middle" id="laporanTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width:50px">#</th>
                            <th>Jenis Peminjam</th>
                            <th>Nama Peminjam</th>
                            <th>NIP / NIM</th>
                            <th>Kontak</th>
                            <th>Alat</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rows as $i => $p)
                            <tr>
                                <td>{{ (isset($rows) && method_exists($rows, 'firstItem') ? $rows->firstItem() + $i : $i + 1) }}</td>

                                <td>{{ $p->jenis_peminjam ?? '-' }}</td>
                                <td>{{ $p->nama_peminjam ?? '-' }}</td>
                                <td>{{ $p->nomor_identitas ?? '-' }}</td>
                                <td>{{ $p->kontak ?? '-' }}</td>
                                <td>{{ optional($p->inventaris)->nama_alat ?? '-' }}</td>
                                <td>{{ formatDateLocal($p->tanggal_pinjam) }}</td>
                                <td>{{ formatDateLocal($p->tanggal_kembali) }}</td>
                                <td>{{ $p->status ?? '-' }}</td>
                                <td>{{ $p->keterangan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">Tidak ada data. Silakan gunakan filter lalu klik "Filter".</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($rows) && method_exists($rows, 'links'))
                <div class="mt-3">
                    {{ $rows->appends(request()->query())->links() }}
                </div>
            @endif
        </div>

        <div class="card-footer d-flex justify-content-end">
            <!-- Satu tombol Export PDF yang menggunakan client-side export -->
            <button type="button" id="exportPdfBtn" class="btn btn-danger">Export PDF</button>
        </div>
    </div>
</div>

<!-- html2pdf (bundle includes html2canvas + jsPDF) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const exportBtn = document.getElementById('exportPdfBtn');
    const resetBtn = document.getElementById('resetFilterBtn');
    const filterForm = document.getElementById('filterForm');

    // Client-side export
    exportBtn?.addEventListener('click', function () {
        const btn = this;
        const element = document.getElementById('tableContainer');
        if (!element) {
            alert('Elemen tabel tidak ditemukan.');
            return;
        }

        const opt = {
            margin:       10,
            filename:     `laporan_table_${new Date().toISOString().slice(0,10)}.pdf`,
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2, useCORS: true },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'landscape' }
        };

        btn.disabled = true;
        btn.textContent = 'Membuat PDF...';

        html2pdf().set(opt).from(element).save().finally(() => {
            btn.disabled = false;
            btn.textContent = 'Export PDF';
        });
    });

    // Reset filter: kosongkan input dan redirect ke route laporan tanpa query
    resetBtn?.addEventListener('click', function () {
        // kosongkan form fields
        const sd = document.getElementById('start_date');
        const ed = document.getElementById('end_date');
        const item = document.getElementById('item_id');

        if (sd) sd.value = '';
        if (ed) ed.value = '';
        if (item) item.selectedIndex = 0;

        // Redirect ke base laporan route (menghapus query string)
        window.location.href = '{{ route("laporan.index") }}';
    });
});
</script>

</body>
</html>