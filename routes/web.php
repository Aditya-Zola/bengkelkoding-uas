<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dokter\PeriksaPasienController;
use App\Http\Controllers\Dokter\RiwayatPasienController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\Pasien\PoliController as PasienPoliController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\JadwalPeriksaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');


// --- BAGIAN YANG DIPERBAIKI ---
// Ditambahkan ->name('admin.') agar semua resource di dalamnya memiliki awalan 'admin.'
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function() {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard'); // Diubah: cukup 'dashboard', karena sudah ada prefix 'admin.' dari group

    // Resource ini sekarang otomatis bernama: admin.polis.index, admin.dokter.index, dst.
    Route::resource('polis', PoliController::class);
    Route::resource('dokter', DokterController::class);
    Route::resource('pasien', PasienController::class); // Error 'admin.pasien.index' teratasi di sini
    Route::resource('obat', ObatController::class);
});


Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->group(function(){
    Route::get('/dashboard', function () {
        return view('dokter.dashboard');
    })->name('dokter.dashboard');

    Route::get('/periksa-pasien', [PeriksaPasienController::class, 'index'])->name('periksa-pasien.index');
    Route::get('/periksa-pasien/{id}', [PeriksaPasienController::class, 'create'])->name('periksa-pasien.create')->whereNumber('id');
    Route::post('/periksa-pasien', [PeriksaPasienController::class, 'store'])->name('periksa-pasien.store');

    Route::get('/riwayat-pasien', [RiwayatPasienController::class, 'index'])->name('dokter.riwayat-pasien.index');
    Route::get('/riwayat-pasien/{id}', [RiwayatPasienController::class, 'show'])->name('dokter.riwayat-pasien.show');

    Route::resource('jadwal-periksa', JadwalPeriksaController::class);
});


Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->group(function(){
    Route::get('/dashboard', function () {
        return view('pasien.dashboard');
    })->name('pasien.dashboard');

    Route::get('/daftar', [PasienPoliController::class, 'get'])->name('pasien.daftar');
    Route::post('/daftar', [PasienPoliController::class, 'submit'])->name('pasien.daftar.submit');
});
