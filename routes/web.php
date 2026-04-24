<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\WelcomeController::class, 'welcome'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login/admin', function () {
        return redirect()->route('login', ['role' => 'admin']);
    })->name('login.admin');

    Route::get('/login/siswa', function () {
        return redirect()->route('login', ['role' => 'siswa']);
    })->name('login.siswa');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('anggota', [\App\Http\Controllers\AnggotaController::class, 'index'])->name('anggota.index');
    Route::get('anggota/create', [\App\Http\Controllers\AnggotaController::class, 'create'])->name('anggota.create');
    Route::post('anggota', [\App\Http\Controllers\AnggotaController::class, 'store'])->name('anggota.store');
    Route::get('anggota/{anggota}/edit', [\App\Http\Controllers\AnggotaController::class, 'edit'])->name('anggota.edit');
    Route::put('anggota/{anggota}', [\App\Http\Controllers\AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('anggota/{anggota}', [\App\Http\Controllers\AnggotaController::class, 'destroy'])->name('anggota.destroy');
    
    Route::prefix('users')->group(function () {
        Route::get('/', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::get('/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
        Route::post('/', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
        Route::get('/{user}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
        Route::delete('/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    });
    Route::prefix('buku')->group(function () {
        Route::get('/', [\App\Http\Controllers\bukuController::class, 'index'])->name('buku.index');
        Route::get('/create', [\App\Http\Controllers\bukuController::class, 'create'])->name('buku.create');
        Route::post('/', [\App\Http\Controllers\bukuController::class, 'store'])->name('buku.store');
        Route::get('/{buku}/edit', [\App\Http\Controllers\bukuController::class, 'edit'])->name('buku.edit');
        Route::put('/{buku}', [\App\Http\Controllers\bukuController::class, 'update'])->name('buku.update');
        Route::delete('/{buku}', [\App\Http\Controllers\bukuController::class, 'destroy'])->name('buku.destroy');
        Route::get('search', [\App\Http\Controllers\bukuController::class, 'search'])->name('buku.search');
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
    Route::prefix('log-aktivitas')->group(function () {
        Route::get('/', [\App\Http\Controllers\LogAktivitasController::class, 'index'])->name('log-aktivitas.index');
        Route::get('/{log_aktivitas}/edit', [\App\Http\Controllers\LogAktivitasController::class, 'edit'])->name('log-aktivitas.edit');
        Route::put('/{log_aktivitas}', [\App\Http\Controllers\LogAktivitasController::class, 'update'])->name('log-aktivitas.update');
        Route::delete('/{log_aktivitas}', [\App\Http\Controllers\LogAktivitasController::class, 'destroy'])->name('log-aktivitas.destroy');
    });

    // Routes Laporan
    Route::prefix('laporan')->group(function () {
        Route::get('/keseluruhan', [\App\Http\Controllers\LaporanController::class, 'downloadKeseluruhan'])->name('laporan.keseluruhan');
        Route::get('/peminjaman', [\App\Http\Controllers\LaporanController::class, 'downloadPeminjaman'])->name('laporan.peminjaman');
        Route::get('/pengembalian', [\App\Http\Controllers\LaporanController::class, 'downloadPengembalian'])->name('laporan.pengembalian');
    });
});
// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

require __DIR__.'/settings.php';
