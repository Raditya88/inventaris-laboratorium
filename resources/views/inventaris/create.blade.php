<h3>Tambah Inventaris</h3>

<form action="{{ route('admin.inventaris.store') }}" method="POST">
    @csrf

    <div style="margin-bottom:16px; width:260px;">
    <input
        type="text"
        name="kode"

        {{-- kalau error, kosongkan value biar user ngetik ulang --}}
        value="{{ $errors->has('kode') ? '' : old('kode', $inventaris->kode ?? '') }}"

        {{-- placeholder berubah jadi pesan error --}}
        placeholder="{{ $errors->has('kode') ? 'kode alat sudah dipakai' : 'Kode' }}"

        style="
            width:100%;
            padding:6px;
            border:1px solid {{ $errors->has('kode') ? '#d9534f' : '#ccc' }};
            font-style: {{ $errors->has('kode') ? 'italic' : 'normal' }};
            color:#333;
        "
    ></div>

    <input
    type="text"
    name="nama_alat"
    value="{{ old('nama_alat') }}"
    placeholder="@error('nama_alat') {{ $message }} @else Nama Alat @enderror"
    style="
        border:1px solid @error('nama_alat') red @else #ccc @enderror;
        padding:6px;
        width:250px;
    ">

    <style>
        input::placeholder {
            font-style: italic;
            opacity: 0.6;
        }
    </style>
    <br><br>

    <input
    type="number"
    name="stok"
    min="0"
    value="{{ old('stok', 0) }}"
    placeholder="@error('stok') {{ $message }} @else Stok @enderror"
    style="
        border:1px solid @error('stok') red @else #ccc @enderror;
        padding:6px;
        width:250px;
    "
    ><br><br>

    <textarea
    name="keterangan"
    placeholder="@error('keterangan') {{ $message }} @else Keterangan @enderror"
    style="border:1px solid @error('keterangan') red @else #ccc @enderror; padding:6px; width:250px; height:80px;"
    >{{ old('keterangan') }}</textarea>

    <style>
        textarea::placeholder {
            font-style: italic;
            opacity: 0.6;
        }
    </style>
    <br><br>

    <button type="submit">Simpan</button>
</form>
