<h3>Edit Inventaris</h3>

<form action="{{ route('inventaris.update', $inventaris) }}" method="POST">
    @csrf
    @method('PUT')

    <input
        type="text"
        name="kode"
        value="@error('kode') @else {{ old('kode', $inventaris->kode) }} @enderror"
        placeholder="@error('kode') {{ $message }} @else Kode @enderror"
        style="border:1px solid @error('kode') red @else #ccc @enderror; padding:6px; width:250px;"
    ><br><br>

    <input
        type="text"
        name="nama_alat"
        value="{{ old('nama_alat', $inventaris->nama_alat) }}"
        placeholder="@error('nama_alat') {{ $message }} @else Nama Alat @enderror"
        style="border:1px solid @error('nama_alat') red @else #ccc @enderror; padding:6px; width:250px;"
    ><br><br>

    <input
        type="number"
        name="stok"
        value="{{ old('stok', $inventaris->stok) }}"
        placeholder="@error('stok') {{ $message }} @else Stok @enderror"
        style="border:1px solid @error('stok') red @else #ccc @enderror; padding:6px; width:250px;"
    ><br><br>

    <textarea
        name="keterangan"
        placeholder="@error('keterangan') {{ $message }} @else Keterangan @enderror"
        style="border:1px solid @error('keterangan') red @else #ccc @enderror; padding:6px; width:250px; height:80px;"
    >{{ old('keterangan', $inventaris->keterangan) }}</textarea><br><br>

    <button type="submit">Update</button>
</form>
