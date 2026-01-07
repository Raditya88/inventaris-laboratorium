<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Peminjaman Alat</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: #fdfdfd; }
        .form-card { background: #ffffff; border: 1px solid #f1f5f9; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05); }
    </style>
</head>
<body class="py-12 px-4">

    <div class="max-w-3xl mx-auto">
        {{-- BRANDING USER --}}
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl mb-4">
                <i class="fas fa-clipboard-list text-xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-slate-800">Formulir Peminjaman</h1>
            <p class="text-slate-500 mt-2">Silakan isi detail peminjaman alat di bawah ini.</p>
        </div>

        @if(session('success'))
            <div class="mb-8 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-xl flex items-center gap-3 shadow-sm animate-bounce">
                <i class="fas fa-check-circle"></i>
                <span class="font-medium text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('peminjaman.store') }}" method="POST" class="space-y-8">
            @csrf

            {{-- SECTION 1: IDENTITAS --}}
            <div class="form-card p-8 rounded-3xl">
                <h3 class="text-sm font-bold text-blue-600 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <span class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-[10px]">1</span>
                    Identitas Peminjam
                </h3>

                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Saya adalah seorang...</label>
                        <select name="jenis_peminjam" id="jenis_peminjam" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all text-slate-600">
                            <option value="">Pilih Status</option>
                            <option value="dosen">Dosen / Staff Pengajar</option>
                            <option value="mahasiswa">Mahasiswa Aktif</option>
                        </select>
                        @error('jenis_peminjam') <p class="text-xs text-rose-500 mt-2">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="nama_peminjam" placeholder="Sesuai kartu identitas" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                        </div>
                        <div>
                            <label id="label_identitas" class="block text-sm font-medium text-slate-700 mb-2">NIP / NIM</label>
                            <input type="text" name="nomor_identitas" id="nomor_identitas" placeholder="..." class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Nomor WhatsApp (Aktif)</label>
                        <input type="text" name="kontak" placeholder="0812xxxx" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                    </div>
                </div>
            </div>

            {{-- SECTION 2: BARANG --}}
            <div class="form-card p-8 rounded-3xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-sm font-bold text-blue-600 uppercase tracking-widest flex items-center gap-2">
                        <span class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-[10px]">2</span>
                        Pilih Alat / Barang
                    </h3>
                    <button type="button" id="tambahBarang" class="text-xs font-bold text-blue-600 hover:bg-blue-50 px-3 py-2 rounded-lg transition-all">
                        + Tambah Barang Lain
                    </button>
                </div>

                <div id="list-barang" class="space-y-4">
                    <div class="barang-item flex gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100 relative group">
                        <div class="flex-1">
                            <select name="items[0][inventaris_id]" required class="w-full bg-transparent border-none focus:ring-0 text-sm font-medium text-slate-700">
                                <option value="">Pilih barang yang tersedia...</option>
                                @foreach($inventaris as $i)
                                    <option value="{{ $i->id }}">{{ $i->nama_alat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-20 border-l border-slate-200 pl-3">
                            <input type="number" name="items[0][jumlah]" min="1" value="1" class="w-full bg-transparent border-none focus:ring-0 text-sm text-center font-bold">
                        </div>
                        <button type="button" class="remove-item text-rose-400 hover:text-rose-600 hidden"><i class="fas fa-times-circle"></i></button>
                    </div>
                </div>
            </div>

            {{-- SECTION 3: WAKTU --}}
            <div class="form-card p-8 rounded-3xl">
                <h3 class="text-sm font-bold text-blue-600 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <span class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-[10px]">3</span>
                    Waktu Peminjaman
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2 text-center md:text-left">Rencana Pinjam</label>
                        <input type="date" name="tanggal_pinjam" class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2 text-center md:text-left">Rencana Kembali</label>
                        <input type="date" name="tanggal_kembali" class="w-full px-4 py-3 border border-slate-200 rounded-xl outline-none focus:border-blue-500">
                    </div>
                </div>
            </div>

            {{-- SUBMIT --}}
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl shadow-xl shadow-blue-100 transition-all hover:-translate-y-1">
                Kirim Permohonan Pinjam
            </button>
        </form>

        <p class="text-center text-slate-400 text-xs mt-8">
            Harap pastikan data sudah benar sebelum mengirim. <br>Persetujuan akan dikirimkan melalui sistem admin.
        </p>
    </div>

    <script>
        // Logika Identitas (NIP/NIM)
        document.getElementById('jenis_peminjam').addEventListener('change', function () {
            const label = document.getElementById('label_identitas');
            const input = document.getElementById('nomor_identitas');
            if (this.value === 'dosen') {
                label.innerText = 'Nomor Induk Pegawai (NIP)';
                input.placeholder = 'Masukkan NIP Anda';
            } else if (this.value === 'mahasiswa') {
                label.innerText = 'Nomor Induk Mahasiswa (NIM)';
                input.placeholder = 'Masukkan NIM Anda';
            }
        });

        // Logika Tambah Barang
        let index = 1;
        document.getElementById('tambahBarang').addEventListener('click', function () {
            let container = document.getElementById('list-barang');
            let html = `
            <div class="barang-item flex gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100 animate-fade-in">
                <div class="flex-1">
                    <select name="items[${index}][inventaris_id]" required class="w-full bg-transparent border-none focus:ring-0 text-sm font-medium text-slate-700">
                        <option value="">Pilih barang...</option>
                        @foreach($inventaris as $i)
                            <option value="{{ $i->id }}">{{ $i->nama_alat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-20 border-l border-slate-200 pl-3">
                    <input type="number" name="items[${index}][jumlah]" min="1" value="1" class="w-full bg-transparent border-none focus:ring-0 text-sm text-center font-bold">
                </div>
                <button type="button" class="remove-item text-rose-400 hover:text-rose-600"><i class="fas fa-times-circle"></i></button>
            </div>`;
            container.insertAdjacentHTML('beforeend', html);
            index++;
        });

        document.addEventListener('click', function(e){
            if(e.target.closest('.remove-item')){
                e.target.closest('.barang-item').remove();
            }
        });
    </script>
</body>
</html>
