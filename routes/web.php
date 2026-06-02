<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// =============================================
// PUBLIC ROUTES — CrisisHub
// =============================================

// Home / Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// About Page
Route::get('/about', function () {
    return view('about');
})->name('about');

// Volunteer Page
Route::get('/volunteer', function () {
    return view('volunteer');
})->name('volunteer');

// Donate Public Page (Campaign List)
Route::get('/donate', function () {
    return view('donate');
})->name('donate');

// Donate Campaign Detail
Route::get('/donate/campaign/{id}', function ($id) {
    return view('donate');
})->name('donate.campaign');

// Donation routes (Protected Action)
Route::middleware(['auth'])->group(function () {
    Route::get('/donate/form', [\App\Http\Controllers\DonationController::class, 'create'])->name('donate.form');
    Route::post('/donate/form', [\App\Http\Controllers\DonationController::class, 'store'])->name('donate.store');
    Route::get('/donate/{id}/receipt', [\App\Http\Controllers\DonationController::class, 'receipt'])->name('donate.receipt');
});

// Contact Page
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Disaster Detail Page
Route::get('/disaster/{id}', function ($id) {
    return view('disaster-detail', ['disasterId' => $id]);
})->name('disaster.detail');

// News Pages — redirect ke halaman utama sambil highlight section berita
Route::get('/news', function () {
    return redirect()->route('home')->with('section', 'news');
})->name('news.index');

Route::get('/news/{id}', function ($id) {
    return redirect()->route('home')->with('section', 'news');
})->name('news.detail');

// Public Map — tampilkan halaman peta bencana aktif dengan marker Leaflet
Route::get('/peta-bencana', function () {
    $reports = \App\Models\Report::whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->whereIn('status', ['Verified', 'Approved', 'In Progress'])
        ->get();
    return view('peta-bencana', compact('reports'));
})->name('peta.bencana');

// Public Analytics — tampilkan halaman analitik publik
Route::get('/analytics', function () {
    $totalLaporan = \App\Models\Report::count();
    $totalDonasi  = \App\Models\Donation::where('status', 'Verified')->sum('amount');
    $totalRelawan = \App\Models\User::whereHas('roles', fn($q) => $q->where('name', 'Relawan'))->count();
    $disasterTypes = \App\Models\Report::select('jenis_bencana', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
        ->groupBy('jenis_bencana')->orderByDesc('total')->take(8)->get();
    return view('analytics-publik', compact('totalLaporan', 'totalDonasi', 'totalRelawan', 'disasterTypes'));
})->name('analytics');


// Terms & Privacy
Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

Route::get('/help', function () {
    return view('contact');
})->name('help');

// Laporkan Bencana (redirect ke dashboard atau halaman report)
Route::get('/report', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('report');

// =============================================
// AUTH DASHBOARD
// =============================================
Route::get('/auth/google', [\App\Http\Controllers\Auth\GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [\App\Http\Controllers\Auth\GoogleAuthController::class, 'callback']);

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // Centers
    Route::get('/volunteer-center', [\App\Http\Controllers\CenterController::class, 'volunteer'])->middleware('role:Relawan')->name('center.volunteer');
    Route::get('/organization-center', [\App\Http\Controllers\CenterController::class, 'organization'])->middleware('role:Organisasi Bantuan')->name('center.organization');
    Route::get('/admin-center', [\App\Http\Controllers\CenterController::class, 'admin'])->middleware('role:Admin')->name('center.admin');

    // Applications
    Route::get('/apply/volunteer', [\App\Http\Controllers\ApplicationController::class, 'createVolunteer'])->name('apply.volunteer');
    Route::post('/apply/volunteer', [\App\Http\Controllers\ApplicationController::class, 'storeVolunteer']);
    
    Route::get('/apply/organization', [\App\Http\Controllers\ApplicationController::class, 'createOrganization'])->name('apply.organization');
    Route::post('/apply/organization', [\App\Http\Controllers\ApplicationController::class, 'storeOrganization']);

    Route::post('/report/store', [\App\Http\Controllers\ReportController::class, 'store'])->name('report.store');
    
    // Report Chat Routes
    Route::get('/report/{id}/chat', [\App\Http\Controllers\ReportChatController::class, 'getMessages'])->name('report.chat.get');
    Route::post('/report/{id}/chat', [\App\Http\Controllers\ReportChatController::class, 'sendMessage'])->name('report.chat.send');
    // Volunteer task status update (relawan update tugas mereka sendiri)
    Route::post('/volunteer/task/{id}/update', [\App\Http\Controllers\CenterController::class, 'updateTaskStatus'])->name('center.volunteer.task.update');
});

// Admin Routes
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    $ctrl = \App\Http\Controllers\AdminDashboardController::class;

    // ── Overview ──────────────────────────────────
    Route::get('/dashboard', [$ctrl, 'index'])->name('dashboard');

    // ── Disaster Reports ──────────────────────────
    Route::get('/laporan', [$ctrl, 'laporan'])->name('laporan');
    Route::post('/laporan/{id}/verify', [$ctrl, 'verifyReport'])->name('laporan.verify');
    Route::get('/laporan/export', [$ctrl, 'exportReports'])->name('laporan.export');

    // ── Verification Center ───────────────────────
    Route::get('/verifikasi', [$ctrl, 'verifikasi'])->name('verifikasi');
    Route::post('/apply/volunteer/{id}/verify', [$ctrl, 'verifyVolunteerApplication'])->name('apply.volunteer.verify');
    Route::post('/apply/organization/{id}/verify', [$ctrl, 'verifyOrganizationApplication'])->name('apply.organization.verify');

    // ── GIS Map ───────────────────────────────────
    Route::get('/peta', [$ctrl, 'peta'])->name('peta');

    // ── Volunteer Management ──────────────────────
    Route::get('/relawan', [$ctrl, 'relawan'])->name('relawan');
    Route::post('/relawan/assign', [$ctrl, 'assignVolunteer'])->name('relawan.assign');
    Route::get('/penugasan', [$ctrl, 'penugasan'])->name('penugasan');

    // ── Donation Management ───────────────────────
    Route::get('/donasi', [$ctrl, 'donasi'])->name('donasi');
    Route::post('/donasi/{id}/verify', [$ctrl, 'verifyDonation'])->name('donasi.verify');
    Route::get('/donasi/export', [$ctrl, 'exportDonations'])->name('donasi.export');

    // ── Campaign Management ───────────────────────
    Route::get('/campaign', [$ctrl, 'campaign'])->name('campaign');
    Route::post('/campaign', [$ctrl, 'campaignStore'])->name('campaign.store');
    Route::patch('/campaign/{id}', [$ctrl, 'campaignUpdate'])->name('campaign.update');
    Route::delete('/campaign/{id}', [$ctrl, 'campaignDestroy'])->name('campaign.destroy');

    // ── Aid Distribution ──────────────────────────
    Route::get('/kebutuhan', [$ctrl, 'kebutuhan'])->name('kebutuhan');
    Route::post('/kebutuhan/{id}/update-status', [$ctrl, 'updateKebutuhanStatus'])->name('kebutuhan.update-status');

    // ── Volunteer Task Status ──────────────────────
    Route::post('/penugasan/{id}/update-status', [$ctrl, 'updateTaskStatus'])->name('penugasan.update-status');

    // ── User Management ───────────────────────────
    Route::get('/pengguna', [$ctrl, 'pengguna'])->name('pengguna');
    Route::patch('/pengguna/{id}', [$ctrl, 'updateUser'])->name('pengguna.update');
    Route::post('/pengguna/{id}/suspend', [$ctrl, 'suspendUser'])->name('pengguna.suspend');
    Route::delete('/pengguna/{id}', [$ctrl, 'destroyUser'])->name('pengguna.destroy');

    // ── Role Management ───────────────────────────
    Route::get('/roles', [$ctrl, 'roleManagement'])->name('roles');

    // ── Analytics ─────────────────────────────────
    Route::get('/analitik', [$ctrl, 'analitik'])->name('analitik');

    // ── Emergency Broadcast ───────────────────────
    Route::get('/notifikasi', [$ctrl, 'notifikasi'])->name('notifikasi');
    Route::post('/notifikasi/broadcast', [$ctrl, 'broadcast'])->name('broadcast');

    // ── System Settings ───────────────────────────
    Route::get('/pengaturan', [$ctrl, 'pengaturan'])->name('pengaturan');
    Route::post('/pengaturan/save', [$ctrl, 'saveSettings'])->name('pengaturan.save');
    Route::post('/pengaturan/defcon', [$ctrl, 'activateDefcon'])->name('pengaturan.defcon');

    // ── Legacy ───────────────────────────────────
    Route::get('/komunikasi', [$ctrl, 'komunikasi'])->name('komunikasi');
    Route::post('/komunikasi/reply', [$ctrl, 'komunikasiReply'])->name('komunikasi.reply');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
