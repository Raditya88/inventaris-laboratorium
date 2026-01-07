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

        {{-- Barang Yang Dipinjam --}}
        <label><b>Pilih Barang yang Dipinjam</b></label>

        <div id="list-barang">

            <div class="row barang-item" style="margin-bottom:10px;">
                <div style="display:inline-block; width:60%;">
                    <select name="items[0][inventaris_id]" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach($inventaris as $i)
                            <option value="{{ $i->id }}">
                                {{ $i->nama_alat }} (Stok: {{ $i->stok }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="display:inline-block; width:20%;">
                    <input type="number" name="items[0][jumlah]" min="1" value="1" required>
                </div>

                <div style="display:inline-block; width:15%;">
                    <button type="button" class="remove-item" style="display:none;">
                        Hapus
                    </button>
                </div>
            </div>

        </div>

        <button type="button" id="tambahBarang">Tambah Barang</button>

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

        <script>
        let index = 1;

        document.getElementById('tambahBarang').addEventListener('click', function () {
            let container = document.getElementById('list-barang');

            let html = `
            <div class="row barang-item" style="margin-bottom:10px;">
                <div style="display:inline-block; width:60%;">
                    <select name="items[${index}][inventaris_id]" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach($inventaris as $i)
                            <option value="{{ $i->id }}">
                                {{ $i->nama_alat }} (Stok: {{ $i->stok }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="display:inline-block; width:20%;">
                    <input type="number" name="items[${index}][jumlah]" min="1" value="1" required>
                </div>

                <div style="display:inline-block; width:15%;">
                    <button type="button" class="remove-item">
                        Hapus
                    </button>
                </div>
            </div>
            `;

            container.insertAdjacentHTML('beforeend', html);
            index++;
        });

        document.addEventListener('click', function(e){
            if(e.target.classList.contains('remove-item')){
                e.target.closest('.barang-item').remove();
            }
        });
        </script>

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
