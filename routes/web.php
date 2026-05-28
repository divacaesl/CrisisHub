<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    // Jika user yang login adalah Admin, arahkan langsung ke Admin Dashboard
    if (auth()->check() && auth()->user()->hasRole('Admin')) {
        return redirect()->route('admin.dashboard');
    }
    
    return view('dashboard');
})->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/peta', [\App\Http\Controllers\AdminDashboardController::class, 'peta'])->name('admin.peta');
    Route::get('/admin/laporan', [\App\Http\Controllers\AdminDashboardController::class, 'laporan'])->name('admin.laporan');
    Route::get('/admin/kebutuhan', [\App\Http\Controllers\AdminDashboardController::class, 'kebutuhan'])->name('admin.kebutuhan');
    Route::get('/admin/donasi', [\App\Http\Controllers\AdminDashboardController::class, 'donasi'])->name('admin.donasi');
    Route::get('/admin/relawan', [\App\Http\Controllers\AdminDashboardController::class, 'relawan'])->name('admin.relawan');
    Route::get('/admin/penugasan', [\App\Http\Controllers\AdminDashboardController::class, 'penugasan'])->name('admin.penugasan');
    Route::get('/admin/notifikasi', [\App\Http\Controllers\AdminDashboardController::class, 'notifikasi'])->name('admin.notifikasi');
    
    // Menu Lainnya
    Route::get('/admin/komunikasi', [\App\Http\Controllers\AdminDashboardController::class, 'komunikasi'])->name('admin.komunikasi');
    Route::get('/admin/verifikasi', [\App\Http\Controllers\AdminDashboardController::class, 'verifikasi'])->name('admin.verifikasi');
    Route::get('/admin/analitik', [\App\Http\Controllers\AdminDashboardController::class, 'analitik'])->name('admin.analitik');
    Route::get('/admin/pengguna', [\App\Http\Controllers\AdminDashboardController::class, 'pengguna'])->name('admin.pengguna');
    Route::get('/admin/pengaturan', [\App\Http\Controllers\AdminDashboardController::class, 'pengaturan'])->name('admin.pengaturan');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
