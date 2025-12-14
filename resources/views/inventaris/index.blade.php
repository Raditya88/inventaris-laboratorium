<h3>Data Inventaris</h3>
<a href="{{ route('inventaris.create') }}">Tambah Alat</a>

<table border="1" cellpadding="5">
    <tr>
        <th>Kode</th>
        <th>Nama Alat</th>
        <th>Stok</th>
        <th>Deskripsi</th>
        <th>Aksi</th>
    </tr>

    @foreach($data as $d)
    <tr>
        <td>{{ $d->kode }}</td>
        <td>{{ $d->nama_alat }}</td>
        <td>{{ $d->stok }}</td>
        <td>{{ Str::limit($d->keterangan, 40) }}</td>
        <td>
            <a href="{{ route('inventaris.edit', $d) }}">Edit</a>
            <form action="{{ route('inventaris.destroy', $d) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
