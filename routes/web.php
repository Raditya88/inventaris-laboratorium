<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\LaporanController; // ditambahkan

Route::get('/', function () {
    return view('welcome');
});

Route::resource('inventaris', InventarisController::class) ->parameters(['inventaris' => 'inventaris']);;

Route::get('/peminjaman', [PeminjamanController::class, 'create'])->name('peminjaman.create');
Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');

Route::post('/peminjaman/{id}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');

Route::post('/peminjaman/{id}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');

Route::get('/admin/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');

// Routes untuk halaman Laporan dan Export PDF
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/export', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');