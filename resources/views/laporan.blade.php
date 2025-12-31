<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Inventaris</title>

    <!-- optional: bootstrap kalau mau rapi -->
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

        <div class="col-md-12 d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                Filter
            </button>

            <button type="button" id="exportPdfBtn" class="btn btn-danger">
                Export PDF
            </button>
        </div>
    </form>

    <p class="text-muted">
        Gunakan filter lalu klik <b>Export PDF</b> untuk mengunduh laporan tanpa pindah halaman.
    </p>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const exportBtn = document.getElementById('exportPdfBtn');
    const filterForm = document.getElementById('filterForm');

    exportBtn.addEventListener('click', async function () {
        const params = new URLSearchParams(new FormData(filterForm)).toString();
        const url = '{{ route("laporan.pdf") }}' + (params ? '?' + params : '');

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

            if (!res.ok) {
                throw new Error('Gagal mengambil PDF');
            }

            const blob = await res.blob();

            let filename = 'laporan.pdf';
            const cd = res.headers.get('content-disposition');
            if (cd) {
                const match = cd.match(/filename\*?=(?:UTF-8'')?["']?([^;"']+)["']?/i);
                if (match && match[1]) {
                    filename = decodeURIComponent(match[1].replace(/["']/g, ''));
                }
            } else {
                const sd = document.getElementById('start_date').value || 'all';
                const ed = document.getElementById('end_date').value || 'all';
                filename = `laporan_${sd}_${ed}.pdf`;
            }

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
            alert('Terjadi kesalahan saat export PDF');
        } finally {
            exportBtn.disabled = false;
            exportBtn.textContent = 'Export PDF';
        }
    });
});
</script>

</body>
</html>
