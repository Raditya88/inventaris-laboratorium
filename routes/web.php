<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\PeminjamanController;

/*
|--------------------------------------------------------------------------
| ROUTE UMUM
|--------------------------------------------------------------------------
*/

// landing page
Route::get('/', function () {
    return view('welcome');
});

// login & logout
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| ROUTE USER (PEMINJAMAN)
|--------------------------------------------------------------------------
| User TIDAK perlu login
| Hanya mengisi form peminjaman
*/

Route::get('/peminjaman', [PeminjamanController::class, 'create'])
    ->name('peminjaman.create');

Route::post('/peminjaman', [PeminjamanController::class, 'store'])
    ->name('peminjaman.store');


/*
|--------------------------------------------------------------------------
| ROUTE ADMIN (WAJIB LOGIN + ROLE ADMIN)
|--------------------------------------------------------------------------
| Semua halaman admin ADA DI SINI
| Jika belum login → redirect ke /login
| Jika bukan admin → ditolak
*/

Route::middleware('admin')
    ->prefix('admin')
    ->group(function () {

        // =====================
        // DASHBOARD / INVENTARIS
        // =====================
        Route::get('/inventaris', [InventarisController::class, 'index'])
            ->name('admin.inventaris.index');

        Route::get('/inventaris/create', [InventarisController::class, 'create'])
            ->name('admin.inventaris.create');

        Route::post('/inventaris', [InventarisController::class, 'store'])
            ->name('admin.inventaris.store');

        Route::get('/inventaris/{inventaris}/edit', [InventarisController::class, 'edit'])
            ->name('admin.inventaris.edit');

        Route::put('/inventaris/{inventaris}', [InventarisController::class, 'update'])
            ->name('admin.inventaris.update');

        Route::delete('/inventaris/{inventaris}', [InventarisController::class, 'destroy'])
            ->name('admin.inventaris.destroy');


        // =====================
        // PEMINJAMAN (ADMIN)
        // =====================
        Route::get('/peminjaman', [PeminjamanController::class, 'index'])
            ->name('admin.peminjaman.index');

        Route::post('/peminjaman/{id}/approve', [PeminjamanController::class, 'approve'])
            ->name('admin.peminjaman.approve');

        Route::post('/peminjaman/{id}/reject', [PeminjamanController::class, 'reject'])
            ->name('admin.peminjaman.reject');


        // =====================
        // (OPSIONAL) LAPORAN
        // =====================
        // Route::get('/laporan', [LaporanController::class, 'index'])
        //     ->name('admin.laporan.index');
    });
