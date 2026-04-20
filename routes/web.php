<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'dashboard'])->name('dashboard');
    
    Route::prefix('users')->group(function () {
        Route::get('/', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::get('/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
        Route::post('/', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
        Route::get('/{user}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
        Route::delete('/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    });
    Route::prefix('alat')->group(function () {
        Route::get('/', [\App\Http\Controllers\AlatController::class, 'index'])->name('alat.index');
        Route::get('/create', [\App\Http\Controllers\AlatController::class, 'create'])->name('alat.create');
        Route::post('/', [\App\Http\Controllers\AlatController::class, 'store'])->name('alat.store');
        Route::get('/{alat}/edit', [\App\Http\Controllers\AlatController::class, 'edit'])->name('alat.edit');
        Route::put('/{alat}', [\App\Http\Controllers\AlatController::class, 'update'])->name('alat.update');
        Route::delete('/{alat}', [\App\Http\Controllers\AlatController::class, 'destroy'])->name('alat.destroy');
        Route::get('search', [\App\Http\Controllers\AlatController::class, 'search'])->name('alat.search');
    });
    Route::prefix('kategori')->group(function () {
        Route::get('/', [\App\Http\Controllers\KategoriController::class, 'index'])->name('kategori.index');
        Route::get('/create', [\App\Http\Controllers\KategoriController::class, 'create'])->name('kategori.create');
        Route::post('/', [\App\Http\Controllers\KategoriController::class, 'store'])->name('kategori.store');
        Route::get('/{kategori}/edit', [\App\Http\Controllers\KategoriController::class, 'edit'])->name('kategori.edit');
        Route::put('/{kategori}', [\App\Http\Controllers\KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/{kategori}', [\App\Http\Controllers\KategoriController::class, 'destroy'])->name('kategori.destroy');
    });
    Route::prefix('peminjaman')->group(function () {
        Route::get('/', [\App\Http\Controllers\PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::get('/create', [\App\Http\Controllers\PeminjamanController::class, 'create'])->name('peminjaman.create');
        Route::post('/', [\App\Http\Controllers\PeminjamanController::class, 'store'])->name('peminjaman.store');
        Route::get('/{peminjaman}', [\App\Http\Controllers\PeminjamanController::class, 'show'])->name('peminjaman.show');
        Route::get('/{peminjaman}/edit', [\App\Http\Controllers\PeminjamanController::class, 'edit'])->name('peminjaman.edit');
        Route::put('/{peminjaman}', [\App\Http\Controllers\PeminjamanController::class, 'update'])->name('peminjaman.update');
        Route::put('/{peminjaman}/confirm', [\App\Http\Controllers\PeminjamanController::class, 'confirm'])->name('peminjaman.confirm');
        Route::delete('/{peminjaman}', [\App\Http\Controllers\PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
    });
    Route::prefix('pengembalian')->group(function () {
        Route::get('/', [\App\Http\Controllers\PengembalianController::class, 'index'])->name('pengembalian.index');
        Route::get('/create', [\App\Http\Controllers\PengembalianController::class, 'create'])->name('pengembalian.create');
        Route::post('/', [\App\Http\Controllers\PengembalianController::class, 'store'])->name('pengembalian.store');
        Route::get('/{pengembalian}', [\App\Http\Controllers\PengembalianController::class, 'show'])->name('pengembalian.show');
        Route::get('/{pengembalian}/edit', [\App\Http\Controllers\PengembalianController::class, 'edit'])->name('pengembalian.edit');
        Route::put('/{pengembalian}', [\App\Http\Controllers\PengembalianController::class, 'update'])->name('pengembalian.update');
        Route::put('/{pengembalian}/confirm', [\App\Http\Controllers\PengembalianController::class, 'confirm'])->name('pengembalian.confirm');
    });
    Route::prefix('denda')->group(function () {
        Route::get('/', [\App\Http\Controllers\DendaController::class, 'index'])->name('denda.index');
        Route::get('/create', [\App\Http\Controllers\DendaController::class, 'create'])->name('denda.create');
        Route::post('/', [\App\Http\Controllers\DendaController::class, 'store'])->name('denda.store');
        Route::get('/{denda}/edit', [\App\Http\Controllers\DendaController::class, 'edit'])->name('denda.edit');
        Route::put('/{denda}', [\App\Http\Controllers\DendaController::class, 'update'])->name('denda.update');
        Route::delete('/{denda}', [\App\Http\Controllers\DendaController::class, 'destroy'])->name('denda.destroy');
    });
    Route::prefix('payment')->group(function () {
        Route::get('/', [\App\Http\Controllers\PaymentController::class, 'index'])->name('payment.index');
        Route::get('/create', [\App\Http\Controllers\PaymentController::class, 'create'])->name('payment.create');
        Route::post('/', [\App\Http\Controllers\PaymentController::class, 'store'])->name('payment.store');
        Route::get('/{payment}/edit', [\App\Http\Controllers\PaymentController::class, 'edit'])->name('payment.edit');
        Route::put('/{payment}', [\App\Http\Controllers\PaymentController::class, 'update'])->name('payment.update');
        Route::delete('/{payment}', [\App\Http\Controllers\PaymentController::class, 'destroy'])->name('payment.destroy');
        Route::put('/{payment}/confirm', [\App\Http\Controllers\PaymentController::class, 'confirm'])->name('payment.confirm');

    });
    Route::prefix('log-aktivitas')->group(function () {
        Route::get('/', [\App\Http\Controllers\LogAktivitasController::class, 'index'])->name('log-aktivitas.index');
        Route::get('/{log_aktivitas}/edit', [\App\Http\Controllers\LogAktivitasController::class, 'edit'])->name('log-aktivitas.edit');
        Route::put('/{log_aktivitas}', [\App\Http\Controllers\LogAktivitasController::class, 'update'])->name('log-aktivitas.update');
        Route::delete('/{log_aktivitas}', [\App\Http\Controllers\LogAktivitasController::class, 'destroy'])->name('log-aktivitas.destroy');
    });

    // Routes Laporan (untuk Petugas dan Admin)
    Route::prefix('laporan')->group(function () {
        Route::get('/keseluruhan', [\App\Http\Controllers\LaporanController::class, 'downloadKeseluruhan'])->name('laporan.keseluruhan');
        Route::get('/peminjaman', [\App\Http\Controllers\LaporanController::class, 'downloadPeminjaman'])->name('laporan.peminjaman');
        Route::get('/pengembalian', [\App\Http\Controllers\LaporanController::class, 'downloadPengembalian'])->name('laporan.pengembalian');
        Route::get('/denda', [\App\Http\Controllers\LaporanController::class, 'downloadDenda'])->name('laporan.denda');
        Route::get('/payment', [\App\Http\Controllers\LaporanController::class, 'downloadPayment'])->name('laporan.payment');
    });
});
// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

require __DIR__.'/settings.php';
