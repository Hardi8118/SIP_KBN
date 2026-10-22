<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WargaController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\WargaMiddleware;

Route::get('/', [WargaController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin Routes
    Route::middleware(AdminMiddleware::class)->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
                Route::get('/jenis-surat', [AdminController::class, 'jenisSuratIndex'])->name('jenis_surat.index');
        Route::post('/jenis-surat', [AdminController::class, 'jenisSuratStore'])->name('jenis_surat.store');
        Route::post('/jenis-surat/scan', [AdminController::class, 'scanDocx'])->name('jenis_surat.scan');
        Route::put('/jenis-surat/{id}', [AdminController::class, 'jenisSuratUpdate'])->name('jenis_surat.update');
        Route::delete('/jenis-surat/{id}', [AdminController::class, 'jenisSuratDestroy'])->name('jenis_surat.destroy');
        
        Route::get('/penduduk', [AdminController::class, 'pendudukIndex'])->name('penduduk.index');
        Route::post('/penduduk', [AdminController::class, 'pendudukStore'])->name('penduduk.store');
        Route::put('/penduduk/{nik}', [AdminController::class, 'pendudukUpdate'])->name('penduduk.update');
        Route::delete('/penduduk/{nik}', [AdminController::class, 'pendudukDestroy'])->name('penduduk.destroy');
        
        Route::get('/pengajuan', [AdminController::class, 'pengajuanIndex'])->name('pengajuan.index');
        Route::post('/pengajuan/{id}/verifikasi', [AdminController::class, 'pengajuanVerifikasi'])->name('pengajuan.verifikasi');
        
        Route::get('/surat-keluar', [AdminController::class, 'suratKeluarIndex'])->name('surat_keluar.index');
        Route::get('/surat-keluar/{no_surat}/cetak', [AdminController::class, 'suratKeluarCetak'])->name('surat_keluar.cetak');
    });

    // Warga Routes
    Route::middleware(WargaMiddleware::class)->group(function () {
        Route::get('/pengajuan', [WargaController::class, 'pengajuanCreate'])->name('warga.pengajuan.create');
        Route::get('/pengajuan/{id}', [WargaController::class, 'pengajuanForm'])->name('warga.pengajuan.form');
        Route::post('/pengajuan/{id}', [WargaController::class, 'pengajuanStore'])->name('warga.pengajuan.store');
        Route::get('/riwayat', [WargaController::class, 'riwayat'])->name('warga.riwayat');
    });
});
