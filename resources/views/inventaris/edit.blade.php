<h3>Edit Inventaris</h3>

<form action="{{ route('admin.inventaris.update', $inventaris->id) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- KODE ALAT --}}
    <div style="margin-bottom:16px; width:260px;">
        <input
            type="text"
            name="kode"

            value="{{ $errors->has('kode') ? '' : old('kode', $inventaris->kode) }}"

            placeholder="{{ $errors->has('kode') ? 'kode alat sudah dipakai' : 'Kode Alat' }}"

            style="
                width:100%;
                padding:6px;
                border:1px solid {{ $errors->has('kode') ? '#d9534f' : '#ccc' }};
                font-style: {{ $errors->has('kode') ? 'italic' : 'normal' }};
                opacity: {{ $errors->has('kode') ? '0.6' : '1' }};
                color:#333;
            "
            required
        >
    </div>

    {{-- NAMA ALAT --}}
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

    {{-- STOK --}}
    <input
        type="number"
        name="stok"
        min="0"
        value="{{ old('stok', $inventaris->stok) }}"
        placeholder="@error('stok') {{ $message }} @else Stok @enderror"
        style="border:1px solid @error('stok') red @else #ccc @enderror; padding:6px; width:250px;"
    ><br><br>

    {{-- KETERANGAN --}}
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

    <button type="submit">Update</button>
</form>
