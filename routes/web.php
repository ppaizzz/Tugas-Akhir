<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\login;

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
    });

    // Kepala Cabang
    Route::middleware(['role:kepala_cabang'])->group(function () {
        Route::get('/kepala-cabang/dashboard', function () {
            return view('kepalaCabang.dashboardKC');
        })->name('dashboard.kepalaCabang');
    });

    // Kasir
    Route::middleware(['role:kasir'])->group(function () {
        Route::get('/kasir/dashboard', function () {
            return view('kasir.dashboardKSR');
        })->name('dashboard.kasir');
    });

});