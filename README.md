# 📦 Sistem Inventaris & Peminjaman Laboratorium  
**UAS – Pemrograman Web Lanjut**

**Nama Kelompok:** Kelompok 4  
**Mata Kuliah:** Pemrograman Web Lanjut   

---

## 📝 Deskripsi Project
Aplikasi **Sistem Inventaris dan Peminjaman Laboratorium** berbasis web yang dikembangkan menggunakan **Laravel**.  
Aplikasi ini digunakan untuk mengelola data inventaris alat laboratorium, proses peminjaman alat oleh mahasiswa/dosen/staff, persetujuan oleh admin (asisten lab), serta pembuatan laporan peminjaman.

Project ini dikembangkan sebagai **tugas UTS dan UAS** mata kuliah **Pemrograman Web Lanjut** dan dikerjakan secara **berkelompok** dengan kolaborasi melalui GitHub.

---

## 🎯 Tujuan Pengembangan
- Menerapkan konsep **MVC (Model–View–Controller)**
- Mengimplementasikan **CRUD** pada data inventaris
- Membuat **sistem peminjaman alat laboratorium**
- Mengelola **role Admin (Asisten Lab)**
- Menyediakan **laporan riwayat peminjaman**
- Menerapkan **validasi input dan error handling**
- Menggunakan **GitHub sebagai media kolaborasi**

---

## ⚙️ Teknologi yang Digunakan
- **Framework:** Laravel
- **Bahasa Pemrograman:** PHP
- **Database:** MySQL
- **Frontend:** Blade, Tailwind CSS
- **PDF Generator:** DomPDF
- **Notifikasi:** WhatsApp API (Fonnte)
- **Version Control:** Git & GitHub

---

## 🔐 Role Pengguna
### 1. Admin (Asisten Laboratorium)
- Login ke sistem
- Mengelola data inventaris (CRUD)
- Menyetujui / menolak peminjaman
- Melihat laporan peminjaman
- Mengunduh laporan dalam bentuk PDF

### 2. Peminjam (Mahasiswa / Dosen / Staff)
- Mengisi form peminjaman alat
- Memilih alat & jumlah
- Menentukan tanggal pinjam dan kembali
- Menerima notifikasi WhatsApp status peminjaman

---

##  Fitur Utama (UAS)

###  Manajemen Inventaris
- Tambah data alat
- Ubah data alat
- Hapus data alat
- Lihat daftar alat
- Pencarian berdasarkan kode & nama alat

###  Sistem Peminjaman Alat
- Form peminjaman mahasiswa
- Form peminjaman dosen/staff
- Multi-item peminjaman
- Validasi stok sebelum peminjaman
- Status peminjaman: `pending`, `approved`, `rejected`

###  Approval Admin
- Persetujuan peminjaman
- Penolakan peminjaman
- Otomatis mengurangi stok saat disetujui

###  Laporan Peminjaman
- Riwayat peminjaman (approved)
- Filter berdasarkan:
  - Tanggal
  - Alat
- Export laporan ke **PDF**

###  Fitur Pengayaan
- **Notifikasi WhatsApp otomatis** menggunakan API Fonnte
- **Export PDF laporan**

---

##  Validasi & Keamanan
- Semua input wajib diisi
- Validasi tanggal kembali ≥ tanggal pinjam
- Validasi stok tidak boleh kurang
- Session login admin
- Transaksi database untuk menjaga konsistensi data

---

##  Struktur MVC (Contoh Controller)
- `InventarisController` → CRUD Inventaris
- `PeminjamanController` → Peminjaman & Approval
- `LaporanController` → Laporan & Export PDF
- `AuthController` → Login Admin

