<h3>Form Peminjaman Alat</h3>

@if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
@endif

<form action="{{ route('peminjaman.store') }}" method="POST">
    @csrf

    {{-- Jenis Peminjam --}}
    <label>Jenis Peminjam</label><br>
    <select name="jenis_peminjam" id="jenis_peminjam">
        <option value="">-- Pilih Jenis --</option>
        <option value="dosen" {{ old('jenis_peminjam')=='dosen'?'selected':'' }}>Dosen / Staff</option>
        <option value="mahasiswa" {{ old('jenis_peminjam')=='mahasiswa'?'selected':'' }}>Mahasiswa</option>
    </select>
    @error('jenis_peminjam')
        <br><i style="color:red;">{{ $message }}</i>
    @enderror
    <br><br>

    {{-- Nama --}}
    <label>Nama Peminjam</label><br>
    <input type="text" name="nama_peminjam" value="{{ old('nama_peminjam') }}">
    @error('nama_peminjam')
        <br><i style="color:red;">{{ $message }}</i>
    @enderror
    <br><br>

    {{-- Nomor Identitas --}}
    <label id="label_identitas">NIP / NIM</label><br>
    <input type="text" name="nomor_identitas" id="nomor_identitas"
           placeholder="Masukkan NIP / NIM"
           value="{{ old('nomor_identitas') }}">
    @error('nomor_identitas')
        <br><i style="color:red;">{{ $message }}</i>
    @enderror
    <br><br>

    {{-- Kontak --}}
    <label>Kontak</label><br>
    <input type="text" name="kontak" value="{{ old('kontak') }}">
    @error('kontak')
        <br><i style="color:red;">{{ $message }}</i>
    @enderror
    <br><br>

    {{-- Alat --}}
    <label>Alat</label><br>
    <select name="inventaris_id">
        <option value="">-- Pilih Alat --</option>
        @foreach($inventaris as $i)
            <option value="{{ $i->id }}" {{ old('inventaris_id')==$i->id?'selected':'' }}>
                {{ $i->nama_alat }} (Stok: {{ $i->stok }})
            </option>
        @endforeach
    </select>
    @error('inventaris_id')
        <br><i style="color:red;">{{ $message }}</i>
    @enderror
    <br><br>

    {{-- Tanggal --}}
    <label>Tanggal Pinjam</label><br>
    <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}">
    @error('tanggal_pinjam')
        <br><i style="color:red;">{{ $message }}</i>
    @enderror
    <br><br>

    <label>Tanggal Kembali</label><br>
    <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali') }}">
    @error('tanggal_kembali')
        <br><i style="color:red;">{{ $message }}</i>
    @enderror
    <br><br>

    <button type="submit">Ajukan Peminjaman</button>
</form>

<script>
document.getElementById('jenis_peminjam').addEventListener('change', function () {
    const label = document.getElementById('label_identitas');
    const input = document.getElementById('nomor_identitas');

    if (this.value === 'dosen') {
        label.innerText = 'NIP';
        input.placeholder = 'Masukkan NIP';
    } else if (this.value === 'mahasiswa') {
        label.innerText = 'NIM';
        input.placeholder = 'Masukkan NIM';
    } else {
        label.innerText = 'NIP / NIM';
        input.placeholder = 'Masukkan NIP / NIM';
    }
});
</script>
