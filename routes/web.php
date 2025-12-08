<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\NilaiController;
use App\Http\Controllers\WaliKelas\DashboardController as WaliDashboardController;
use App\Http\Controllers\WaliKelas\RaportController;
use App\Http\Controllers\Kepsek\DashboardController as KepsekDashboardController;
use App\Http\Controllers\Kepsek\MonitoringController;
use App\Http\Controllers\Kepsek\LaporanController;

// Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Protected Routes
Route::middleware('auth')->group(function () {
    // Profile Routes (available for all roles)
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Dashboard redirect based on role
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', UserController::class);
        Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
        Route::get('guru', [GuruController::class, 'index'])->name('guru.index');
        Route::resource('kelas', KelasController::class);
        Route::resource('mapel', MapelController::class);
        Route::post('mapel/{id}/assign-guru', [MapelController::class, 'assignGuru'])->name('mapel.assign-guru');
        Route::delete('mapel/{mapelId}/remove-guru/{mapelGuruId}', [MapelController::class, 'removeGuru'])->name('mapel.remove-guru');
        Route::resource('siswa', SiswaController::class);
    });

    // Guru Routes
    Route::prefix('guru')->name('guru.')->middleware('role:guru')->group(function () {
        Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');
        Route::get('/mapel', [GuruDashboardController::class, 'mapel'])->name('mapel');
        Route::resource('nilai', NilaiController::class);
        Route::get('/rekap', [GuruDashboardController::class, 'rekap'])->name('rekap');
    });

    // Wali Kelas Routes
    Route::prefix('wali')->name('wali.')->middleware('role:wali_kelas')->group(function () {
        Route::get('/dashboard', [WaliDashboardController::class, 'index'])->name('dashboard');
        Route::get('/rekap', [WaliDashboardController::class, 'rekap'])->name('rekap');
        Route::get('/raport', [RaportController::class, 'index'])->name('raport.index');
        Route::get('/raport/{siswa}', [RaportController::class, 'show'])->name('raport.show');
        Route::get('/cetak', [RaportController::class, 'cetak'])->name('cetak');
        Route::get('/cetak/{siswa}', [RaportController::class, 'cetakPdf'])->name('cetak.pdf');
    });

    // Kepala Sekolah Routes
    Route::prefix('kepsek')->name('kepsek.')->middleware('role:kepsek')->group(function () {
        Route::get('/dashboard', [KepsekDashboardController::class, 'index'])->name('dashboard');
        Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring');
        Route::get('/data-guru', [KepsekDashboardController::class, 'dataGuru'])->name('data-guru');
        Route::get('/data-kelas', [KepsekDashboardController::class, 'dataKelas'])->name('data-kelas');
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
        Route::get('/laporan/export-kelas/{kelasId?}', [LaporanController::class, 'exportKelas'])->name('laporan.export-kelas');
        Route::get('/laporan/export-semester', [LaporanController::class, 'exportSemester'])->name('laporan.export-semester');
        Route::get('/laporan/export-pendidikan', [LaporanController::class, 'exportPendidikan'])->name('laporan.export-pendidikan');
    });
});
