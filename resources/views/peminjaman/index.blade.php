<h3>Data Peminjaman</h3>
<a href="{{ route('inventaris.create') }}">Tambah Alat</a>

{{-- INDIKATOR PEMINJAMAN PENDING --}}
@if(isset($pendingCount) && $pendingCount > 0)
    <div style="
        margin:15px 0;
        padding:10px;
        border:1px solid #d9534f;
        background:#fbeaea;
        color:#a94442;
        font-style: italic;
    ">
        ❗ Ada {{ $pendingCount }} peminjaman menunggu persetujuan admin
    </div>
@endif

@if(session('success'))
    <p style="color:green;">{{ session  ('success') }}</p>
@endif
@if(session('error'))
    <p style="color:red;">{{ session('error') }}</p>
@endif

<table border="1" cellpadding="5">
    <tr>
        <th>Nama</th>
        <th>Jenis</th>
        <th>Identitas</th>
        <th>Alat</th>
        <th>Tanggal</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

@foreach($data as $p)
<tr>
    <td>{{ $p->nama_peminjam }}</td>
    <td>{{ ucfirst($p->jenis_peminjam) }}</td>
    <td>{{ $p->nomor_identitas }}</td>
    <td>{{ $p->inventaris->nama_alat }}</td>
    <td>{{ $p->tanggal_pinjam }} - {{ $p->tanggal_kembali }}</td>
    <td>
    @if($p->status == 'pending')
        Menunggu
    @elseif($p->status == 'approved')
        Disetujui
    @else
        Ditolak
    @endif
    </td>
    <td>
        @if($p->status == 'pending')
            <form action="{{ route('peminjaman.approve', $p->id) }}" method="POST" style="display:inline">
                @csrf
                <button type="submit">Setujui</button>
            </form>
            <form action="{{ route('peminjaman.reject', $p->id) }}" method="POST" style="display:inline">
                @csrf
                <button type="submit">Tolak</button>
            </form>
        @endif
    </td>
</tr>
@endforeach
</table>
