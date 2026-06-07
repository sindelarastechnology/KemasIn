<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\KemasanController;
use App\Http\Controllers\PengemasanController;
use App\Http\Controllers\KelolaPenggunaController;
use App\Http\Controllers\StokProdukController;
use App\Http\Controllers\LaporanController;

use App\Http\Controllers\ProdukController;
use App\Http\Controllers\HistoryController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/stok', [StokProdukController::class, 'index'])->name('stok.index');
    Route::get('/stok/bahan-baku', [StokProdukController::class, 'bahanBaku'])->name('stok.bahanBaku');

    // ===== PENGEMASAN =====
    Route::middleware('role:admin')->group(function () {
        Route::get('/pengemasan/create', [PengemasanController::class, 'create'])->name('pengemasan.create');
        Route::post('/pengemasan', [PengemasanController::class, 'store'])->name('pengemasan.store');
        Route::get('/pengemasan/{id}/edit', [PengemasanController::class, 'edit'])->name('pengemasan.edit');
        Route::put('/pengemasan/{id}', [PengemasanController::class, 'update'])->name('pengemasan.update');
        Route::delete('/pengemasan/{id}', [PengemasanController::class, 'destroy'])->name('pengemasan.destroy');
        Route::post('/pengemasan/{id}/batalkan', [PengemasanController::class, 'batalkan'])->name('pengemasan.batalkan');
    });

    Route::get('/pengemasan', [PengemasanController::class, 'index'])->name('pengemasan.index');
    Route::get('/pengemasan/{id}', [PengemasanController::class, 'show'])->name('pengemasan.show');
    Route::get('/pengemasan/{id}/riwayat-progres', [PengemasanController::class, 'riwayatProgres'])->name('pengemasan.riwayatProgres');
    Route::post('/pengemasan/{id}/tambah-progres', [PengemasanController::class, 'tambahProgres'])->name('pengemasan.tambahProgres');

    // ===== HISTORY =====
    Route::get('/history/pengemasan', [HistoryController::class, 'pengemasan'])->name('history.pengemasan');
    Route::get('/history/bahan-baku', [HistoryController::class, 'bahanBaku'])->name('history.bahanBaku');

    // AJAX
    Route::get('/ajax/cek-stok-bahan/{id}', [BahanBakuController::class, 'cekStok'])->name('ajax.cekStokBahan');
    Route::get('/ajax/kemasan-bahan/{id}', [KemasanController::class, 'getBahan'])->name('ajax.kemasanBahan');
});

Route::middleware(['auth', 'role:admin,pemilik'])->group(function () {
    Route::resource('/produk', ProdukController::class);
    Route::resource('/bahan-baku', BahanBakuController::class);
    Route::get('/bahan-baku/{id}/tambah-stok', [BahanBakuController::class, 'tambahStok'])->name('bahan-baku.tambahStok');
    Route::post('/bahan-baku/{id}/tambah-stok', [BahanBakuController::class, 'simpanTambahStok'])->name('bahan-baku.simpanTambahStok');
    Route::resource('/kemasan', KemasanController::class);
    Route::resource('/pengguna', KelolaPenggunaController::class);

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/pengemasan', [LaporanController::class, 'pengemasan'])->name('laporan.pengemasan');
    Route::get('/laporan/export-pengemasan', [LaporanController::class, 'exportPengemasan'])->name('laporan.exportPengemasan');
    Route::get('/laporan/pdf-pengemasan', [LaporanController::class, 'exportPengemasanPdf'])->name('laporan.pdfPengemasan');
    Route::get('/laporan/bahan-baku', [LaporanController::class, 'bahanBaku'])->name('laporan.bahanBaku');
    Route::get('/laporan/export-bahan-baku', [LaporanController::class, 'exportBahanBaku'])->name('laporan.exportBahanBaku');
});


