<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\login;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\PermintaanController as AdminPermintaan;
use App\Http\Controllers\Cabang\StokController;
use App\Http\Controllers\Cabang\PermintaanController as CabangPermintaan;
use App\Http\Controllers\Kasir\KeepBarangController;
use App\Http\Controllers\Kasir\PosController;

Route::get('/', function () {
    return view('login');
});

// Route Login
Route::get('/login', [login::class, 'index'])->name('login');
Route::post('/login', [login::class, 'proses'])->name('login.proses');
Route::post('/logout', [login::class, 'logout'])->name('logout');

// Route Dashboard — dilindungi middleware auth
Route::middleware(['auth'])->group(function () {

    // Admin Pusat
    Route::middleware(['role:admin_pusat'])->group(function () {
        Route::get('/admin-pusat/dashboard', function () {
            return view('adminPusat.dashboardAP');
        })->name('dashboard.adminPusat');

        Route::get('/admin-pusat/barang', [BarangController::class, 'index'])->name('adminPusat.barang.index');
        Route::post('/admin-pusat/barang', [BarangController::class, 'store'])->name('adminPusat.barang.store');
        
        Route::get('/admin-pusat/permintaan', [AdminPermintaan::class, 'index'])->name('adminPusat.permintaan.index');
        Route::get('/admin-pusat/permintaan/{id}', [AdminPermintaan::class, 'detail'])->name('adminPusat.permintaan.detail');
        Route::post('/admin-pusat/permintaan/{id}/proses', [AdminPermintaan::class, 'proses'])->name('adminPusat.permintaan.proses');
    });

    // Kepala Cabang
    Route::middleware(['role:kepala_cabang'])->group(function () {
        Route::get('/kepala-cabang/dashboard', function () {
            return view('kepalaCabang.dashboardKC');
        })->name('dashboard.kepalaCabang');

        Route::get('/kepala-cabang/stok', [StokController::class, 'index'])->name('kepalaCabang.stok.index');
        Route::put('/kepala-cabang/stok/{id}', [StokController::class, 'update'])->name('kepalaCabang.stok.update');

        Route::get('/kepala-cabang/permintaan', [CabangPermintaan::class, 'index'])->name('kepalaCabang.permintaan.index');
        Route::get('/kepala-cabang/permintaan/create', [CabangPermintaan::class, 'create'])->name('kepalaCabang.permintaan.create');
        Route::post('/kepala-cabang/permintaan', [CabangPermintaan::class, 'store'])->name('kepalaCabang.permintaan.store');
        Route::post('/kepala-cabang/permintaan/{id}/terima', [CabangPermintaan::class, 'terima'])->name('kepalaCabang.permintaan.terima');
    });

    // Kasir
    Route::middleware(['role:kasir'])->group(function () {
        Route::get('/kasir/dashboard', function () {
            return view('kasir.dashboardKSR');
        })->name('dashboard.kasir');

        Route::get('/kasir/keep', [KeepBarangController::class, 'index'])->name('kasir.keep.index');
        Route::get('/kasir/keep/create', [KeepBarangController::class, 'create'])->name('kasir.keep.create');
        Route::post('/kasir/keep', [KeepBarangController::class, 'store'])->name('kasir.keep.store');

        Route::get('/kasir/pos', [PosController::class, 'index'])->name('kasir.pos.index');
        Route::post('/kasir/pos/direct', [PosController::class, 'processDirect'])->name('kasir.pos.process');
        Route::get('/kasir/pos/checkout/{id}', [PosController::class, 'checkoutKeep'])->name('kasir.pos.checkoutKeep');
        Route::post('/kasir/pos/checkout/{id}', [PosController::class, 'processKeep'])->name('kasir.pos.processKeep');
        Route::post('/kasir/pos/konfirmasi/{id}', [PosController::class, 'konfirmasiTransfer'])->name('kasir.pos.konfirmasi');
    });

    // Manager
    Route::middleware(['role:manager'])->group(function () {
        Route::get('/manager/dashboard', function () {
            return view('manager.dashboardMNG');
        })->name('dashboard.manager');
    });

});