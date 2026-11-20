<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisLayananController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\StatusServisController;
use App\Http\Controllers\TransaksiServisController;
use Illuminate\Support\Facades\Route;

// Halaman publik
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Semua halaman di bawah ini wajib login
Route::middleware('auth')->group(function () {

    // [B] Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // [B] Pelanggan
    Route::resource('pelanggan', PelangganController::class)
        ->parameters(['pelanggan' => 'pelanggan'])->except(['show']);

    // [C] Kendaraan
    Route::resource('kendaraan', KendaraanController::class)
        ->parameters(['kendaraan' => 'kendaraan'])->except(['show']);

    // [A] Jenis layanan
    Route::resource('layanan', JenisLayananController::class)
        ->parameters(['layanan' => 'layanan'])->except(['show']);

    // [D] Transaksi servis
    Route::resource('servis', TransaksiServisController::class)
        ->parameters(['servis' => 'servis'])->only(['index', 'create', 'store', 'destroy']);

    // [E] Detail, status, pembayaran, keluhan
    Route::get('servis/{servis}/detail', [StatusServisController::class, 'show'])->name('servis.detail');
    Route::patch('servis/{servis}/status', [StatusServisController::class, 'updateStatus'])
        ->name('servis.status');
    Route::patch('servis/{servis}/pembayaran', [StatusServisController::class, 'updatePembayaran'])
        ->name('servis.pembayaran');
    Route::patch('servis/{servis}/keluhan', [StatusServisController::class, 'updateKeluhan'])
        ->name('servis.keluhan');

    // [C] Laporan
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/pdf', [LaporanController::class, 'pdf'])->name('laporan.pdf');
});
