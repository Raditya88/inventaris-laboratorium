<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Peminjaman Alat Kampus</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #1e293b; }
        .campus-card { background: white; border-radius: 24px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
        .input-style { width: 100%; padding: 0.75rem 1rem; background-color: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 0.875rem; transition: all 0.2s; }
        .input-style:focus { outline: none; border-color: #2563eb; background-color: #ffffff; ring: 4px; ring-color: rgba(37, 99, 235, 0.1); }
    </style>
</head>
<body class="py-10 px-4">

    <div class="max-w-4xl mx-auto">

        <div class="flex flex-col items-center text-center mb-10">
            <div class="w-16 h-16 bg-blue-900 text-white rounded-2xl flex items-center justify-center shadow-lg mb-4">
                <i class="fas fa-university text-2xl"></i>
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Form Peminjaman Sarana</h1>
            <p class="text-slate-500 mt-2 max-w-md italic">Gunakan layanan ini untuk peminjaman alat inventaris dalam menunjang kegiatan akademik.</p>
        </div>

        @if(session('success'))
            <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center gap-3 animate-pulse">
                <i class="fas fa-check-circle"></i>
                <span class="font-semibold text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('peminjaman.store') }}" method="POST" class="space-y-8">
            @csrf

            <div class="campus-card p-6 md:p-8">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-50 pb-4">
                    <span class="text-blue-600"><i class="fas fa-id-card"></i></span>
                    <h3 class="font-bold text-slate-800">Identitas Peminjam</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Status Anda</label>
                        <select name="jenis_peminjam" id="jenis_peminjam" class="input-style">
                            <option value="">-- Pilih Status --</option>
                            <option value="dosen">Dosen / Staff Pengajar</option>
                            <option value="mahasiswa">Mahasiswa Aktif</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Nama Lengkap</label>
                        <input type="text" name="nama_peminjam" placeholder="Sesuai kartu identitas" class="input-style">
                    </div>

                    <div>
                        <label id="label_identitas" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">NIP / NIM</label>
                        <input type="text" name="nomor_identitas" id="nomor_identitas" placeholder="NIP / NIM" class="input-style font-mono">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Kontak WhatsApp</label>
                        <input type="text" name="kontak" placeholder="Contoh: 08123456789" class="input-style">
                    </div>
                </div>
            </div>

            <div class="campus-card p-6 md:p-8">
                <div class="flex items-center justify-between mb-6 border-b border-slate-50 pb-4">
                    <div class="flex items-center gap-3">
                        <span class="text-blue-600"><i class="fas fa-boxes-stacked"></i></span>
                        <h3 class="font-bold text-slate-800">Daftar Alat</h3>
                    </div>
                    <button type="button" id="tambahBarang" class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-2 rounded-lg hover:bg-blue-100 transition-all">
                        <i class="fas fa-plus mr-1"></i> Tambah Baris
                    </button>
                </div>

                <div id="list-barang" class="space-y-4">
                    {{-- Row Barang --}}
                    <div class="barang-item flex flex-col md:flex-row gap-4 p-5 bg-slate-50 rounded-2xl border border-slate-100 relative group">
                        <div class="flex-1">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Pilih Alat & Stok Tersedia</label>
                            <select name="items[0][inventaris_id]" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-medium focus:ring-2 focus:ring-blue-500/10">
                                <option value="">-- Cari Alat --</option>
                                @foreach($inventaris as $i)
                                    <option value="{{ $i->id }}" {{ $i->stok <= 0 ? 'disabled' : '' }}>
                                        {{ $i->nama_alat }} — (Tersedia: {{ $i->stok }} unit)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full md:w-32">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Jumlah</label>
                            <input type="number" name="items[0][jumlah]" min="1" value="1" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-bold text-center">
                        </div>
                        <button type="button" class="remove-item absolute -top-2 -right-2 bg-white text-rose-500 w-8 h-8 rounded-full shadow-md hover:bg-rose-500 hover:text-white transition-all hidden">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="campus-card p-6 md:p-8">
                <div class="flex items-center gap-3 mb-6 border-b border-slate-50 pb-4">
                    <span class="text-blue-600"><i class="fas fa-calendar-alt"></i></span>
                    <h3 class="font-bold text-slate-800">Durasi Peminjaman</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Rencana Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" class="input-style">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Rencana Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali" class="input-style">
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-900 hover:bg-blue-800 text-white font-bold py-4 rounded-[18px] shadow-xl shadow-blue-900/10 transition-all hover:scale-[1.01] active:scale-[0.99] flex items-center justify-center gap-3 tracking-wide">
                AJUKAN PEMINJAMAN SEKARANG <i class="fas fa-chevron-right text-xs"></i>
            </button>
        </form>

        <p class="text-center text-slate-400 text-xs mt-10">
            &copy; 2026 Sarana & Prasarana Kampus. Pastikan alat dijaga dengan baik.
        </p>
    </div>

    <script>
        // Ganti Placeholder Identitas
        document.getElementById('jenis_peminjam').addEventListener('change', function () {
            const label = document.getElementById('label_identitas');
            const input = document.getElementById('nomor_identitas');
            if (this.value === 'dosen') {
                label.innerText = 'Nomor Induk Pegawai (NIP)';
                input.placeholder = 'Masukkan NIP Anda';
            } else if (this.value === 'mahasiswa') {
                label.innerText = 'Nomor Induk Mahasiswa (NIM)';
                input.placeholder = 'Masukkan NIM Anda';
            } else {
                label.innerText = 'NIP / NIM';
                input.placeholder = 'Masukkan Identitas';
            }
        });

        // Tambah Baris Barang
        let index = 1;
        document.getElementById('tambahBarang').addEventListener('click', function () {
            let container = document.getElementById('list-barang');
            let html = `
            <div class="barang-item flex flex-col md:flex-row gap-4 p-5 bg-slate-50 rounded-2xl border border-slate-100 relative animate-slide-up">
                <div class="flex-1">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Pilih Alat & Stok Tersedia</label>
                    <select name="items[${index}][inventaris_id]" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-medium">
                        <option value="">-- Cari Alat --</option>
                        @foreach($inventaris as $i)
                            <option value="{{ $i->id }}" {{ $i->stok <= 0 ? 'disabled' : '' }}>
                                ${"{{ $i->nama_alat }}"} — (Tersedia: ${"{{ $i->stok }}"} unit)
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full md:w-32">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Jumlah</label>
                    <input type="number" name="items[${index}][jumlah]" min="1" value="1" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-bold text-center">
                </div>
                <button type="button" class="remove-item absolute -top-2 -right-2 bg-white text-rose-500 w-8 h-8 rounded-full shadow-md hover:bg-rose-500 hover:text-white transition-all flex items-center justify-center border border-slate-100">
                    <i class="fas fa-times text-xs"></i>
                </button>
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

    <style>
        @keyframes slideUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-slide-up { animation: slideUp 0.3s ease-out; }
    </style>
</body>
</html>
