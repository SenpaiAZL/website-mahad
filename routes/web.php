<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UstadController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PetgsPembayaranControler;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Routes untuk register & login
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Halaman dashboard (hanya bisa diakses jika sudah login dan terverifikasi)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Routes untuk Ustadz (Hanya Admin yang bisa mengakses)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/ustadz', [UstadController::class, 'index'])->name('ustadz.index');
    Route::get('/ustadz/create', [UstadController::class, 'create'])->name('ustadz.create');
    Route::post('/ustadz/store', [UstadController::class, 'store'])->name('ustadz.store');
    Route::get('/ustadz/{id}/edit', [UstadController::class, 'edit'])->name('ustadz.edit');
    Route::put('/ustadz/{id}', [UstadController::class, 'update'])->name('ustadz.update');
    Route::delete('/ustadz/{id}', [UstadController::class, 'destroy'])->name('ustadz.destroy');
});

// Routes untuk Santri (Semua pengguna yang login bisa melihat, tetapi hanya admin yang bisa edit/hapus)
Route::middleware(['auth'])->group(function () {
    Route::get('/santri', [SantriController::class, 'index'])->name('santri.index');
    Route::get('/santri/create', [SantriController::class, 'create'])->name('santri.create');
    Route::post('/santri/store', [SantriController::class, 'store'])->name('santri.store');

    // Hanya admin yang bisa edit/hapus data santri
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/santri/{id}/edit', [SantriController::class, 'edit'])->name('santri.edit');
        Route::put('/santri/{id}', [SantriController::class, 'update'])->name('santri.update');
        Route::delete('/santri/{id}', [SantriController::class, 'destroy'])->name('santri.destroy');
    });
});

// Routes untuk Petugas Pembayaran (Hanya Admin yang bisa mengakses)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/petugas', [PetgsPembayaranControler::class, 'index'])->name('petugas.index');
    Route::get('/petugas/create', [PetgsPembayaranControler::class, 'create'])->name('petugas.create');
    Route::post('/petugas/store', [PetgsPembayaranControler::class, 'store'])->name('petugas.store');
    Route::get('/petugas/{id}/edit', [PetgsPembayaranControler::class, 'edit'])->name('petugas.edit');
    Route::put('/petugas/{id}', [PetgsPembayaranControler::class, 'update'])->name('petugas.update');
    Route::delete('/petugas/{id}', [PetgsPembayaranControler::class, 'destroy'])->name('petugas.destroy');
});

// Routes untuk Pembayaran (Petugas, Admin, dan Santri bisa melihat, tetapi hanya petugas/admin yang bisa edit/hapus)
Route::middleware(['auth', 'role:petugas|admin|santri'])->group(function () {
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::get('/pembayaran/create', [PembayaranController::class, 'create'])->name('pembayaran.create');
    Route::post('/pembayaran/store', [PembayaranController::class, 'store'])->name('pembayaran.store');

    // Hanya petugas/admin yang bisa edit/hapus data pembayaran
    Route::middleware(['role:petugas|admin'])->group(function () {
        Route::get('/pembayaran/{id}/edit', [PembayaranController::class, 'edit'])->name('pembayaran.edit');
        Route::put('/pembayaran/{id}', [PembayaranController::class, 'update'])->name('pembayaran.update');
        Route::delete('/pembayaran/{id}', [PembayaranController::class, 'destroy'])->name('pembayaran.destroy');
    });
});

// Routes untuk Absensi (Hanya Admin dan Ustadz yang bisa mengakses)
Route::middleware(['auth', 'role:admin|ustadz'])->group(function () {
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/absensi/create', [AbsensiController::class, 'create'])->name('absensi.create');
    Route::post('/absensi/store', [AbsensiController::class, 'store'])->name('absensi.store');
    Route::get('/absensi/{id}/edit', [AbsensiController::class, 'edit'])->name('absensi.edit');
    Route::put('/absensi/{id}', [AbsensiController::class, 'update'])->name('absensi.update');
    Route::delete('/absensi/{id}', [AbsensiController::class, 'destroy'])->name('absensi.destroy');
});

// Route untuk menampilkan notifikasi verifikasi email
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

// Route untuk menangani verifikasi email
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Route untuk mengirim ulang email verifikasi
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Link verifikasi telah dikirim ulang!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');