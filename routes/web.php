<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BeritaAcaraController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\LoginConrtroller;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\SignatureController;
use App\Http\Controllers\SubmissionListController;
use Illuminate\Support\Facades\Route;
use App\Models\Jadwal;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Laravel Breeze welcome page
Route::get("/", function () {

    return view('auth.login');
});
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');

// Login manual
// Route::get('/manual-login', [LoginConrtroller::class, 'index'])->name('manual.login');
// Route::post('/login-proses', [LoginConrtroller::class, 'login_proses'])->name('login-proses');
// Route::get('/logout', [LoginConrtroller::class, 'logout'])->name('logout');

// Laravel Breeze Dashboard (hanya untuk user yang login & verifikasi email)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Laravel Breeze Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route custom aplikasi (dibungkus agar hanya untuk user login)
    Route::middleware(['auth', 'verified', 'role:kasi|pelayanan'])->group(function () {
    Route::get('/user', [HomeController::class, 'index'])->name('index');
    Route::get('/create', [HomeController::class, 'create'])->name('user.create');
    Route::post('/store', [HomeController::class, 'store'])->name('user.store');
    Route::get('user/edit/{id}', [HomeController::class, 'edit'])->name('user.edit');
    Route::put('user/update/{id}', [HomeController::class, 'update'])->name('user.update');
    Route::delete('user/delete/{id}', [HomeController::class, 'delete'])->name('user.delete');
    });
    // Jadwal
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
     Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
    Route::get('/jadwal/create/{permohonan_id?}', [JadwalController::class, 'create'])->name('jadwal.create');
    Route::post('/jadwal/store', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::get('/jadwal/edit/{id}', [JadwalController::class, 'edit'])->name('jadwal.edit');
    Route::put('/jadwal/update/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
    Route::put('/jadwal/{id}/status', [JadwalController::class, 'updateStatus'])->name('jadwal.updateStatus');
    Route::delete('/jadwal/delete/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
    Route::get('/report-petugas', [JadwalController::class, 'petugas'])->name('report.petugas');
    Route::get('/report-petugas/{id}/detail', [JadwalController::class, 'reportDetail'])->name('report.petugas.detail');



    // Permohonan
    Route::get('/permohonan', [PermohonanController::class, 'index'])->name('permohonan.index');
    Route::get('/permohonan/create', [PermohonanController::class, 'create'])->name('permohonan.create');
    Route::post('/permohonan/store', [PermohonanController::class, 'store'])->name('permohonan.store');
    Route::get('permohonan/edit/{id}', [PermohonanController::class, 'edit'])->name('permohonan.edit');
    Route::put('/update/{id}', [PermohonanController::class, 'update'])->name('permohonan.update');
    Route::delete('permohonan/delete/{id}', [PermohonanController::class, 'delete'])->name('permohonan.delete');
// Route::get('/permohonan/import', [PermohonanController::class, 'import']);
Route::post('/permohonan/import', [PermohonanController::class, 'import'])->name('permohonan.import');


// Route::post('/permohonan/import-proses', [PermohonanController::class, 'import_proses'])->name('permohonan.import_proses');


    // Signature
    Route::get('/signature', [SignatureController::class, 'index'])->name('signature.index');
    Route::get('/signature/create', [SignatureController::class, 'create'])->name('signature.create');
    Route::post('/signature/store', [SignatureController::class, 'store'])->name('signature.store');
    Route::get('signature/edit/{id}', [SignatureController::class, 'edit'])->name('signature.edit');
Route::put('/signature/update/{id}', [SignatureController::class, 'update']);
    Route::delete('signature/delete/{id}', [SignatureController::class, 'delete'])->name('signature.delete');

    // Berita Acara
    Route::get('/berita-acara', [BeritaAcaraController::class, 'index'])->name('berita-acara.index');
    Route::get('/berita-acara/create', [BeritaAcaraController::class, 'create'])->name('berita-acara.create');
    Route::get('/jadwal/create/{jadwal_id?}', [JadwalController::class, 'create'])->name('jadwal.create');
    Route::post('/berita-acara/store', [BeritaAcaraController::class, 'store'])->name('berita-acara.store');
    Route::get('berita-acara/edit/{id}', [BeritaAcaraController::class, 'edit'])->name('berita-acara.edit');
    Route::put('berita-acara/update/{id}', [BeritaAcaraController::class, 'update'])->name('berita-acara.update');
    Route::delete('berita-acara/delete/{id}', [BeritaAcaraController::class, 'delete'])->name('berita-acara.delete');
    Route::get('berita-acara/{id}', [BeritaAcaraController::class, 'show'])->name('berita-acara.show');
    Route::get('berita-acara/{id}/cetak', [BeritaAcaraController::class, 'cetak'])->name('berita-acara.cetak');
    Route::put('/berita-acara/{id}/validasi-kasi', [BeritaAcaraController::class, 'validasiKasi'])->name('berita-acara.validasi.kasi');
    Route::put('/berita-acara/{id}/validasi-kabid', [BeritaAcaraController::class, 'validasiKabid'])->name('berita-acara.validasi.kabid');
//    Route::post('/signature/upload', [BeritaAcaraController::class, 'uploadSignature'])
//     ->name('signature.upload');



});

// Laravel Breeze auth route (login, register, forgot password)
require __DIR__.'/auth.php';
