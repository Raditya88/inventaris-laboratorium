<h2>Laporan Peminjaman</h2>

<table border="1" cellspacing="0" cellpadding="6" width="100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Alat</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Kembali</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @foreach($data as $p)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $p->nama_peminjam }}</td>
            <td>{{ optional($p->inventaris)->nama_alat }}</td>
            <td>{{ $p->tanggal_pinjam }}</td>
            <td>{{ $p->tanggal_kembali }}</td>
            <td>{{ $p->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
