@extends('layouts.public')

@section('title', 'Riwayat Saya')

@section('head')
<style>
    @keyframes pulse-red-slow {
        0%, 100% { border-color: rgba(239,68,68,0.4); box-shadow: 0 0 15px rgba(239,68,68,0.2); }
        50% { border-color: rgba(239,68,68,0.9); box-shadow: 0 0 30px rgba(239,68,68,0.5); }
    }
    .animate-pulse-slow { animation: pulse-red-slow 2.5s infinite; }

    /* ─── MODAL ANIMATION ─── */
    #report-modal .modal-inner { animation: modalSlide 0.32s cubic-bezier(0.34,1.56,0.64,1); }
    @keyframes modalSlide {
        from { opacity:0; transform:translateY(32px) scale(0.97); }
        to   { opacity:1; transform:translateY(0) scale(1); }
    }

    /* ─── HEADER VARIANTS ─── */
    .modal-header-normal { background:linear-gradient(135deg,#1e293b 0%,#0f172a 100%); border-bottom:1px solid rgba(255,255,255,0.07); }
    .modal-header-sos    { background:linear-gradient(135deg,#450a0a 0%,#991b1b 100%); border-bottom:1px solid rgba(239,68,68,0.35); }

    /* ─── FORM LABELS ─── */
    .form-label {
        display:flex; align-items:center; gap:5px;
        font-size:11px; font-weight:700; letter-spacing:.07em; text-transform:uppercase;
        color:#64748b; margin-bottom:6px;
    }
    .dark .form-label { color:#94a3b8; }

    /* ─── FORM INPUTS ─── */
    .form-input {
        width:100%; padding:10px 14px;
        background:rgba(255,255,255,0.9); border:1.5px solid #e2e8f0; border-radius:12px;
        font-size:13.5px; color:#0f172a; outline:none; transition:all .2s;
    }
    .dark .form-input { background:rgba(15,23,42,0.55); border-color:rgba(255,255,255,0.08); color:#f1f5f9; }
    .form-input:focus { border-color:#ef4444; box-shadow:0 0 0 3px rgba(239,68,68,0.13); background:#fff; }
    .dark .form-input:focus { background:rgba(15,23,42,0.9); box-shadow:0 0 0 3px rgba(239,68,68,0.22); }

    /* ─── FORM SECTIONS ─── */
    .form-section { background:rgba(248,250,252,0.75); border:1.5px solid #e2e8f0; border-radius:16px; padding:16px; }
    .dark .form-section { background:rgba(15,23,42,0.45); border-color:rgba(255,255,255,0.06); }
    .form-section-title { font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:.08em; color:#475569; display:flex; align-items:center; gap:6px; margin-bottom:12px; }
    .dark .form-section-title { color:#94a3b8; }

    /* ─── VULNERABLE COUNTER BOXES ─── */
    .vuln-box { text-align:center; background:rgba(255,255,255,0.9); border:1.5px solid #e2e8f0; border-radius:12px; padding:10px 8px; }
    .dark .vuln-box { background:rgba(15,23,42,0.6); border-color:rgba(255,255,255,0.07); }
    .vuln-box input { width:100%; text-align:center; background:transparent; border:none; outline:none; font-size:20px; font-weight:900; color:#ef4444; }
    .dark .vuln-box input { color:#fca5a5; }
    .vuln-box .vuln-label { font-size:9.5px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.06em; margin-top:2px; }
    .dark .vuln-box .vuln-label { color:#94a3b8; }

    /* ─── GPS BUTTON ─── */
    .gps-btn { display:inline-flex; align-items:center; gap:6px; padding:7px 14px; background:linear-gradient(135deg,#dc2626,#b91c1c); color:#fff; font-size:11px; font-weight:700; border-radius:10px; border:none; cursor:pointer; transition:all .2s; text-transform:uppercase; letter-spacing:.05em; }
    .gps-btn:hover { transform:translateY(-1px); box-shadow:0 4px 14px rgba(220,38,38,0.45); }

    /* ─── SOS MODE OVERRIDES ─── */
    @keyframes sosBlink { 0%,100%{opacity:1;} 50%{opacity:0.45;} }
    .sos-blink { animation:sosBlink 1s infinite; }
    .sos-mode-form .form-input, .sos-mode-form select, .sos-mode-form textarea {
        background:rgba(30,8,8,0.7) !important; border-color:rgba(239,68,68,0.35) !important; color:#fff !important;
    }
    .sos-mode-form .form-input:focus, .sos-mode-form select:focus, .sos-mode-form textarea:focus {
        border-color:#ef4444 !important; box-shadow:0 0 0 3px rgba(239,68,68,0.25) !important;
    }
    .sos-mode-form .form-section { background:rgba(239,68,68,0.04) !important; border-color:rgba(239,68,68,0.22) !important; }
    .sos-mode-form .vuln-box { background:rgba(30,8,8,0.6) !important; border-color:rgba(239,68,68,0.2) !important; }
    .sos-mode-form .form-label { color:#fca5a5 !important; }
    .sos-mode-form .form-section-title { color:#f87171 !important; }
    .sos-mode-form select option { background:#1e0a0a !important; color:#fff !important; }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 min-h-screen" style="padding-top: 7rem;">
    <!-- Page Header -->
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white font-display">Riwayat Aktivitas & Kontribusi</h1>
            <p class="text-slate-500 text-sm mt-1">Selamat datang di panel riwayat Anda.</p>
        </div>
        <div>
            <button onclick="openReportModal(true)" class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-600 to-red-800 hover:from-red-500 hover:to-red-700 text-white text-sm font-bold rounded-full transition-all shadow-lg animate-pulse" style="box-shadow: 0 0 15px rgba(220, 38, 38, 0.5);">
                <i class="fas fa-exclamation-triangle"></i> SOS Darurat
            </button>
        </div>
    </div>

    <!-- Alerts & Toast -->
    @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-green-500/10 border border-green-500/20 text-green-600 dark:text-green-400 flex items-start gap-3 backdrop-blur-md">
            <div class="w-8 h-8 rounded-full bg-green-500 text-white flex justify-center items-center flex-shrink-0">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <h3 class="font-bold">Berhasil!</h3>
                <p class="text-sm mt-0.5">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-600 dark:text-red-400 flex items-start gap-3 backdrop-blur-md">
            <div class="w-8 h-8 rounded-full bg-red-500 text-white flex justify-center items-center flex-shrink-0">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div>
                <h3 class="font-bold">Gagal Mengirim Laporan</h3>
                <p class="text-sm mt-0.5">{{ $errors->first() }}</p>
            </div>
        </div>
    @endif

    <!-- Stats Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="glass-panel rounded-2xl p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-red-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Laporan Aktif Saya</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1">{{ $reportCount }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-red-50 dark:bg-red-500/10 flex items-center justify-center text-red-500">
                    <i class="fas fa-bullhorn text-xl"></i>
                </div>
            </div>
            <div class="text-xs text-red-600 dark:text-red-400 font-semibold flex items-center gap-1">
                <i class="fas fa-clock"></i> Dalam Verifikasi / Tindakan
            </div>
        </div>

        <div class="glass-panel rounded-2xl p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-orange-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Bantuan Berjalan</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1">{{ $needCount }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-orange-50 dark:bg-orange-500/10 flex items-center justify-center text-orange-500">
                    <i class="fas fa-truck-loading text-xl"></i>
                </div>
            </div>
            <div class="text-xs text-orange-600 dark:text-orange-400 font-semibold flex items-center gap-1">
                <i class="fas fa-shipping-fast"></i> Tim Sedang Dikerahkan
            </div>
        </div>

        <div class="glass-panel rounded-2xl p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Laporan Selesai</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1">{{ $resolvedCount }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-green-50 dark:bg-green-500/10 flex items-center justify-center text-green-500">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
            </div>
            <div class="text-xs text-green-600 dark:text-green-400 font-semibold flex items-center gap-1">
                <i class="fas fa-arrow-up"></i> Penanganan Sukses
            </div>
        </div>

        <div class="glass-panel rounded-2xl p-6 relative overflow-hidden border-red-300 dark:border-red-500/30 group bg-red-50/50 dark:bg-red-900/10">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-red-600/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-red-600 dark:text-red-400">Status Peringatan</p>
                    <h3 class="text-3xl font-black text-red-700 dark:text-red-400 mt-1">SIAGA</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-500/20 flex items-center justify-center text-red-600 dark:text-red-400">
                    <i class="fas fa-broadcast-tower text-xl"></i>
                </div>
            </div>
            <div class="text-xs text-red-700 dark:text-red-400 font-semibold flex items-center gap-1">
                <i class="fas fa-exclamation-circle"></i> Tetap Waspada Cuaca Ekstrem
            </div>
        </div>
    </div>

    <!-- Volunteer Progress Tracker (Tahap 4) -->
    @if(isset($volunteerApp) && in_array($volunteerApp->status, ['pending', 'under_review']))
        <div class="mb-8 p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden">
            <!-- Background accent -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/5 rounded-full blur-3xl"></div>
            
            <div class="flex items-center gap-3 mb-6 relative z-10">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center">
                    <i class="fas fa-id-card-alt"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white font-display">Status Pendaftaran Relawan</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Pantau progres pengajuan Anda untuk menjadi bagian dari tim lapangan.</p>
                </div>
            </div>

            @php
                $progress = 25;
                if ($volunteerApp->status == 'under_review') $progress = 50;
            @endphp

            <div class="relative z-10">
                <div class="flex justify-between text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">
                    <span>Progress:</span>
                    <span>{{ $progress }}%</span>
                </div>
                <div class="w-full h-2 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden mb-6">
                    <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-400 rounded-full transition-all duration-1000 ease-out" style="width: {{ $progress }}%"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <!-- Step 1 -->
                    <div class="flex flex-col gap-2 relative">
                        <div class="flex items-center gap-2">
                            <div class="w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[10px]">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-900 dark:text-white">Formulir Dikirim</span>
                        </div>
                    </div>
                    <!-- Step 2 -->
                    <div class="flex flex-col gap-2 relative">
                        <div class="flex items-center gap-2">
                            @if($progress >= 50)
                                <div class="w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[10px]">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span class="text-xs font-bold text-slate-900 dark:text-white">Dokumen Diverifikasi</span>
                            @else
                                <div class="w-5 h-5 rounded-full border-2 border-slate-300 dark:border-slate-700 flex items-center justify-center text-[10px]"></div>
                                <span class="text-xs font-medium text-slate-500">Dokumen Diverifikasi</span>
                            @endif
                        </div>
                    </div>
                    <!-- Step 3 -->
                    <div class="flex flex-col gap-2 relative">
                        <div class="flex items-center gap-2">
                            <div class="w-5 h-5 rounded-full border-2 border-slate-300 dark:border-slate-700 flex items-center justify-center text-[10px]"></div>
                            <span class="text-xs font-medium text-slate-500">Pelatihan Dasar</span>
                        </div>
                    </div>
                    <!-- Step 4 -->
                    <div class="flex flex-col gap-2 relative">
                        <div class="flex items-center gap-2">
                            <div class="w-5 h-5 rounded-full border-2 border-slate-300 dark:border-slate-700 flex items-center justify-center text-[10px]"></div>
                            <span class="text-xs font-medium text-slate-500">Aktivasi Akun</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Grid -->
    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Left Col: Action & Timeline -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Buat Laporan Banner -->
            <div class="glass-panel rounded-3xl p-8 relative overflow-hidden bg-gradient-to-br from-slate-900 to-slate-800 dark:from-slate-800 dark:to-slate-900 text-white shadow-2xl">
                <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 20% 150%, #dc2626 0%, transparent 50%), radial-gradient(circle at 80% -50%, #f97316 0%, transparent 50%);"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div>
                        <h2 class="text-2xl font-bold mb-2 font-display">Perlu Bantuan Darurat?</h2>
                        <p class="text-slate-300 text-sm max-w-md">Laporkan kondisi terkini di wilayah Anda atau ajukan permohonan bantuan logistik, medis, maupun evakuasi.</p>
                    </div>
                    <button onclick="openReportModal(false)" class="flex-shrink-0 px-6 py-3.5 bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white font-bold rounded-xl transition-all shadow-lg flex items-center gap-2 transform hover:scale-[1.03]">
                        <i class="fas fa-plus-circle text-lg"></i> Buat Laporan Baru
                    </button>
                </div>
            </div>

            <!-- Recent Reports / My Reports Toggle -->
            <div class="glass-panel rounded-3xl p-6 md:p-8 shadow-md">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 border-b border-slate-200 dark:border-white/10 pb-4">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white font-display">Laporan & Bantuan</h3>
                    <div class="flex bg-slate-100 dark:bg-white/5 p-1 rounded-xl">
                        <button onclick="switchReportTab('tab-public', this)" class="px-4 py-2 text-xs font-bold uppercase rounded-lg bg-white dark:bg-white/10 shadow text-red-600 dark:text-white transition-all">Laporan Publik</button>
                        <button onclick="switchReportTab('tab-my', this)" class="px-4 py-2 text-xs font-bold uppercase rounded-lg text-slate-500 hover:text-slate-950 dark:hover:text-white transition-all">Laporan Saya</button>
                    </div>
                </div>

                <!-- Tab Public -->
                <div id="tab-public" class="space-y-4 tab-content">
                    @forelse($recentReports as $rep)
                        <div class="p-4 rounded-2xl bg-white/50 dark:bg-white/5 border border-slate-100 dark:border-white/5 flex flex-col sm:flex-row gap-4 sm:items-center hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-all">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0
                                @if($rep->tingkat_kerusakan == 'Hancur Total') bg-red-100 text-red-600 dark:bg-red-950/30 dark:text-red-400
                                @elseif($rep->tingkat_kerusakan == 'Tinggi') bg-orange-100 text-orange-600 dark:bg-orange-950/30 dark:text-orange-400
                                @else bg-blue-100 text-blue-600 dark:bg-blue-950/30 dark:text-blue-400 @endif">
                                <i class="fas fa-house-damage text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-base font-bold text-slate-900 dark:text-white truncate">{{ $rep->jenis_bencana }} di {{ $rep->alamat_lengkap ?? 'Lokasi Terdeteksi' }}</h4>
                                <p class="text-sm text-slate-500 dark:text-slate-400 truncate">{{ $rep->jumlah_korban }} Korban • {{ $rep->tingkat_kerusakan }}</p>
                            </div>
                            <div class="flex flex-col items-end gap-1.5">
                                @if($rep->status == 'Pending')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-yellow-100 text-yellow-700 dark:bg-yellow-500/10 dark:text-yellow-500">Dalam Verifikasi</span>
                                @elseif($rep->status == 'Verified')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-700 dark:bg-green-500/10 dark:text-green-500">Terverifikasi</span>
                                @elseif($rep->status == 'In Progress')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-500">Ditangani</span>
                                @elseif($rep->status == 'Resolved')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-500">Selesai</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-500">Ditolak</span>
                                @endif
                                <span class="text-[10px] text-slate-400">{{ $rep->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 text-slate-500">
                            <i class="fas fa-clipboard-list text-3xl mb-3 block text-slate-300"></i>
                            Belum ada laporan publik masuk saat ini.
                        </div>
                    @endforelse
                </div>

                <!-- Tab My Reports -->
                <div id="tab-my" class="space-y-4 tab-content hidden">
                    @forelse($myReports as $rep)
                        <div class="p-4 rounded-2xl bg-white/50 dark:bg-white/5 border border-slate-100 dark:border-white/5 flex flex-col sm:flex-row gap-4 sm:items-center hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-all">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 bg-red-100 text-red-600 dark:bg-red-950/30 dark:text-red-400">
                                <i class="fas fa-user-shield text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-base font-bold text-slate-900 dark:text-white truncate">{{ $rep->jenis_bencana }} Saya</h4>
                                <p class="text-sm text-slate-500 dark:text-slate-400 truncate">{{ $rep->created_at->format('d M Y, H:i') }} • {{ $rep->alamat_lengkap }}</p>
                            </div>
                            <div class="flex flex-col items-end gap-1.5">
                                @if($rep->status == 'Pending')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-yellow-100 text-yellow-700 dark:bg-yellow-500/10 dark:text-yellow-500">Menunggu Verifikasi</span>
                                @elseif($rep->status == 'Verified')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-700 dark:bg-green-500/10 dark:text-green-500">Disetujui</span>
                                @elseif($rep->status == 'In Progress')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-500">Distribusi Bantuan</span>
                                @elseif($rep->status == 'Resolved')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-500">Kasus Selesai</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-500">Ditolak</span>
                                @endif
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[10px] text-slate-400">{{ $rep->created_at->diffForHumans() }}</span>
                                    @if(in_array($rep->status, ['Verified', 'In Progress', 'Resolved']))
                                        <button onclick="openChatModal({{ $rep->id }}, '{{ $rep->jenis_bencana }}')" class="px-2 py-1 text-[10px] font-bold bg-blue-500/10 text-blue-500 hover:bg-blue-500/20 border border-blue-500/20 rounded-md transition-all flex items-center gap-1">
                                            <i class="fas fa-comment-dots"></i> Chat Admin
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 text-slate-500">
                            <i class="fas fa-folder-open text-3xl mb-3 block text-slate-300"></i>
                            Anda belum pernah mengajukan laporan bencana.
                            <button onclick="openReportModal(false)" class="mt-4 text-xs font-bold text-red-500 hover:text-red-600 block mx-auto underline">Buat Laporan Baru Sekarang</button>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Donation History -->
            <div id="riwayat-donasi" class="glass-panel rounded-3xl p-6 md:p-8 shadow-md">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2 font-display">
                        <i class="fas fa-history text-orange-500"></i> Riwayat Donasi Anda
                    </h3>
                </div>

                @if(isset($donations) && $donations->count() > 0)
                    <div class="space-y-4">
                        @foreach($donations as $don)
                        <div class="p-5 rounded-2xl bg-white/60 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 transition-all hover:scale-[1.01] hover:shadow-sm">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-orange-100 dark:bg-orange-500/10 text-orange-600 flex justify-center items-center flex-shrink-0">
                                    <i class="fas fa-gift text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 dark:text-white">Donasi Kemanusiaan</h4>
                                    <p class="text-xs text-slate-500">{{ $don->created_at->format('d M Y') }} • {{ $don->payment_method }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 w-full sm:w-auto justify-between sm:justify-end">
                                <div class="text-right">
                                    <p class="font-black text-slate-900 dark:text-white text-lg">Rp {{ number_format($don->amount, 0, ',', '.') }}</p>
                                    <p class="text-[10px] font-bold text-green-500 uppercase tracking-wider"><i class="fas fa-check-circle"></i> Berhasil</p>
                                </div>
                                <a href="{{ route('donate.receipt', $don->id) }}" target="_blank" class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200 hover:text-slate-900 flex justify-center items-center transition-colors" title="Lihat E-Kuitansi">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                            <i class="fas fa-box-open text-2xl"></i>
                        </div>
                        <p class="text-slate-500">Belum ada riwayat donasi.</p>
                        <a href="{{ route('donate') }}" class="inline-block mt-3 text-sm font-bold text-orange-500 hover:text-orange-600">Mulai Berdonasi</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Col: Alerts & Tracking -->
        <div class="space-y-8">
            <!-- Status Timeline -->
            <div class="glass-panel rounded-3xl p-6 shadow-md">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 font-display">Status Bantuan Anda</h3>
                
                <div class="relative pl-6 border-l-2 border-slate-200 dark:border-slate-700 space-y-6">
                    <div class="relative">
                        <div class="absolute -left-[31px] w-4 h-4 rounded-full bg-green-500 border-4 border-white dark:border-[#0f172a]"></div>
                        <p class="text-sm font-bold text-slate-900 dark:text-white">Bantuan Diberangkatkan</p>
                        <p class="text-xs text-slate-500 mt-1">Tim relawan (Sdr. Budi) sedang menuju lokasi Anda.</p>
                        <p class="text-xs font-semibold text-green-500 mt-1">Hari ini, 14:30</p>
                    </div>
                    
                    <div class="relative">
                        <div class="absolute -left-[31px] w-4 h-4 rounded-full bg-green-500 border-4 border-white dark:border-[#0f172a]"></div>
                        <p class="text-sm font-bold text-slate-900 dark:text-white">Bantuan Dipersiapkan</p>
                        <p class="text-xs text-slate-500 mt-1">Logistik telah di-packing di Gudang Pusat.</p>
                        <p class="text-xs font-semibold text-slate-400 mt-1">Hari ini, 10:15</p>
                    </div>

                    <div class="relative">
                        <div class="absolute -left-[31px] w-4 h-4 rounded-full bg-green-500 border-4 border-white dark:border-[#0f172a]"></div>
                        <p class="text-sm font-bold text-slate-900 dark:text-white">Laporan Diverifikasi</p>
                        <p class="text-xs text-slate-500 mt-1">Kebutuhan Anda telah divalidasi oleh tim admin.</p>
                        <p class="text-xs font-semibold text-slate-400 mt-1">Kemarin, 21:00</p>
                    </div>
                </div>
            </div>

            <!-- Emergency Announcements -->
            <div class="glass-panel rounded-3xl p-6 bg-red-50/30 dark:bg-red-900/5 border border-red-100 dark:border-red-900/20 shadow-md">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2 font-display">
                    <i class="fas fa-bullhorn text-red-500 animate-bounce"></i> Pengumuman Darurat
                </h3>
                <div class="p-4 rounded-xl bg-white/60 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700">
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5"><i class="fas fa-exclamation-circle text-red-500"></i></div>
                        <div>
                            <p class="text-sm font-bold text-slate-900 dark:text-white">Potensi Banjir Susulan</p>
                            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1 leading-relaxed">Warga di sekitar bantaran sungai Citarum diimbau waspada terhadap kenaikan debit air dalam 12 jam kedepan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modals')
    <!-- REPORT CREATION MODAL (Buat Laporan Baru) -->
    <div id="report-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-md hidden overflow-y-auto py-8">
        <div class="modal-inner w-full max-w-2xl mx-4 my-auto rounded-3xl overflow-hidden shadow-2xl border border-white/10 flex flex-col max-h-[92vh]" style="background:rgba(15,23,42,0.97);">

            <!-- SOS Alert Banner (hidden by default) -->
            <div id="sos-alert-banner" class="hidden px-5 py-2.5 flex items-center gap-2" style="background:linear-gradient(90deg,#7f1d1d,#991b1b,#7f1d1d);">
                <i class="fas fa-exclamation-triangle text-red-300 sos-blink text-sm"></i>
                <span class="text-red-100 text-xs font-bold uppercase tracking-widest sos-blink">Mode SOS Aktif — Prioritas Darurat Tertinggi</span>
                <i class="fas fa-exclamation-triangle text-red-300 sos-blink text-sm ml-auto"></i>
            </div>

            <!-- Modal Header -->
            <div id="report-modal-header" class="modal-header-normal px-6 py-5 flex justify-between items-center flex-shrink-0">
                <div class="flex items-center gap-4">
                    <div id="modal-icon-wrap" class="w-12 h-12 rounded-2xl flex items-center justify-center text-white text-lg shadow-lg" style="background:linear-gradient(135deg,#f97316,#dc2626);">
                        <i id="modal-header-icon" class="fas fa-file-medical-alt"></i>
                    </div>
                    <div>
                        <h3 id="report-modal-title" class="font-black text-white text-lg leading-tight">Buat Laporan Krisis Baru</h3>
                        <p id="report-modal-subtitle" class="text-xs text-slate-400 mt-0.5">Laporkan kejadian bencana untuk penanganan cepat</p>
                    </div>
                </div>
                <button onclick="closeReportModal()" class="w-9 h-9 rounded-xl bg-white/10 hover:bg-white/20 text-slate-400 hover:text-white flex items-center justify-center transition-all">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="report-form" action="{{ route('report.store') }}" method="POST" enctype="multipart/form-data" class="flex-1 overflow-y-auto p-6 space-y-5">
                @csrf

                <!-- Section 1: Jenis & Tingkat -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-bolt text-red-500"></i> Informasi Kejadian
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label"><i class="fas fa-fire-alt text-red-400"></i> Jenis Bencana</label>
                            <select name="jenis_bencana" required class="form-input">
                                <option value="">Pilih Jenis Bencana</option>
                                <option value="Banjir">🌊 Banjir</option>
                                <option value="Tanah Longsor">⛰️ Tanah Longsor</option>
                                <option value="Gempa Bumi">🏔️ Gempa Bumi</option>
                                <option value="Kebakaran Hutan/Pemukiman">🔥 Kebakaran</option>
                                <option value="Angin Puting Beliung/Topan">💨 Angin Puting Beliung</option>
                                <option value="Gunung Meletus">🌋 Gunung Meletus</option>
                                <option value="Tsunami">🌊 Tsunami</option>
                                <option value="Lainnya">⚠️ Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label"><i class="fas fa-tachometer-alt text-orange-400"></i> Tingkat Kerusakan</label>
                            <select name="tingkat_kerusakan" id="tingkat_kerusakan" required class="form-input">
                                <option value="">Pilih Tingkat Kerusakan</option>
                                <option value="Rendah">🟢 Rendah — Kerusakan Minimal</option>
                                <option value="Sedang">🟡 Sedang — Butuh Perbaikan</option>
                                <option value="Tinggi">🟠 Tinggi — Rusak Parah</option>
                                <option value="Hancur Total">🔴 Hancur Total — Rata Tanah</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Korban -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-users text-red-500"></i> Data Korban &amp; Keluarga
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="form-label"><i class="fas fa-user-injured text-red-400"></i> Jumlah Jiwa Terdampak</label>
                            <input type="number" name="jumlah_korban" min="0" value="0" required class="form-input">
                        </div>
                        <div>
                            <label class="form-label"><i class="fas fa-home text-slate-400"></i> Anggota Keluarga Terlibat</label>
                            <input type="number" name="family_members" min="0" value="0" required class="form-input">
                        </div>
                    </div>
                    <!-- Vulnerable groups -->
                    <p class="text-[10.5px] font-bold text-slate-500 uppercase tracking-wider mb-3">Kelompok Rentan (Opsional)</p>
                    <div class="grid grid-cols-3 gap-3">
                        <div class="vuln-box">
                            <div class="text-2xl mb-1">👶</div>
                            <input type="number" name="infants_count" min="0" value="0" required>
                            <div class="vuln-label">Bayi / Balita</div>
                        </div>
                        <div class="vuln-box">
                            <div class="text-2xl mb-1">👴</div>
                            <input type="number" name="elderly_count" min="0" value="0" required>
                            <div class="vuln-label">Lansia 60+</div>
                        </div>
                        <div class="vuln-box">
                            <div class="text-2xl mb-1">♿</div>
                            <input type="number" name="disabled_count" min="0" value="0" required>
                            <div class="vuln-label">Disabilitas</div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Logistik & Kebutuhan -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-boxes text-orange-400"></i> Logistik &amp; Kebutuhan Mendesak
                    </div>
                    <label class="flex items-center gap-3 p-3 rounded-xl border border-red-500/20 bg-red-500/5 cursor-pointer mb-4 hover:bg-red-500/10 transition-all">
                        <input type="checkbox" id="logistic_stock_critical" name="logistic_stock_critical" class="w-4 h-4 accent-red-600 rounded">
                        <span class="text-xs font-bold text-red-400 uppercase tracking-wide flex items-center gap-1.5">
                            <i class="fas fa-exclamation-circle"></i> Stok Logistik Kritis — Tidak ada makanan, air bersih, atau obat-obatan
                        </span>
                    </label>
                    <div>
                        <label class="form-label"><i class="fas fa-list-ul text-slate-400"></i> Kebutuhan Mendesak</label>
                        <input type="text" name="kebutuhan_mendesak" placeholder="Contoh: Selimut hangat, popok bayi, air mineral, dapur umum" class="form-input">
                    </div>
                </div>

                <!-- Section 4: Deskripsi & Foto -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-align-left text-blue-400"></i> Deskripsi &amp; Dokumentasi
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="form-label"><i class="fas fa-comment-alt text-slate-400"></i> Deskripsi Kondisi Lapangan</label>
                            <textarea name="deskripsi_kondisi" required rows="3" placeholder="Ceritakan detail kerusakan, kebutuhan mendesak, atau kondisi akses transportasi saat ini..." class="form-input" style="resize:vertical;"></textarea>
                        </div>
                        <div>
                            <label class="form-label"><i class="fas fa-camera text-slate-400"></i> Foto Kondisi / Kerusakan</label>
                            <input type="file" name="foto" accept="image/*" class="form-input text-sm file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-red-500/15 file:text-red-400 hover:file:bg-red-500/25">
                        </div>
                    </div>
                </div>

                <!-- Section 5: GPS Lokasi -->
                <div class="form-section">
                    <div class="flex items-center justify-between mb-3">
                        <div class="form-section-title" style="margin-bottom:0">
                            <i class="fas fa-map-marked-alt text-green-400"></i> Koordinat Lokasi Kejadian
                        </div>
                        <button type="button" onclick="detectGPSLocation()" class="gps-btn">
                            <i class="fas fa-location-arrow"></i> <span id="gps-btn-text">Deteksi GPS Saya</span>
                        </button>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <label class="form-label">Latitude</label>
                            <input type="text" name="latitude" id="geo-latitude" required placeholder="-6.9147" class="form-input text-center">
                        </div>
                        <div>
                            <label class="form-label">Longitude</label>
                            <input type="text" name="longitude" id="geo-longitude" required placeholder="107.6098" class="form-input text-center">
                        </div>
                    </div>
                    <div id="gps-accuracy-alert" class="hidden mb-3 text-[11px] text-green-400 font-semibold flex items-center gap-1.5 px-3 py-2 rounded-lg bg-green-500/10">
                        <i class="fas fa-satellite-dish"></i> Lokasi berhasil terdeteksi dengan akurasi tinggi!
                    </div>
                    <div>
                        <label class="form-label"><i class="fas fa-map-pin text-red-400"></i> Alamat Lengkap Kejadian</label>
                        <textarea name="alamat_lengkap" id="geo-address" rows="2" placeholder="Nama jalan, RT/RW, nomor rumah, kelurahan, kecamatan, kota..." class="form-input" style="resize:vertical;"></textarea>
                    </div>
                </div>

                <!-- Submit Footer -->
                <div class="flex items-center justify-between gap-3 pt-2 border-t border-white/10">
                    <button type="button" onclick="closeReportModal()" class="px-5 py-2.5 rounded-xl border border-white/15 text-slate-400 hover:text-white hover:border-white/30 text-xs font-bold uppercase tracking-wide transition-all">
                        <i class="fas fa-times mr-1"></i> Batal
                    </button>
                    <button id="submit-btn" type="submit" class="px-7 py-2.5 rounded-xl text-white text-xs font-black uppercase tracking-wide transition-all flex items-center gap-2" style="background:linear-gradient(135deg,#f97316,#dc2626); box-shadow:0 4px 16px rgba(220,38,38,0.4);">
                        <i id="submit-icon" class="fas fa-paper-plane"></i>
                        <span id="submit-text">Kirim Laporan Darurat</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <!-- Scripts for Tab & Modal navigation -->
    <script>
        function switchReportTab(tabId, el) {
            document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
            document.getElementById(tabId).classList.remove('hidden');

            el.parentElement.querySelectorAll('button').forEach(btn => {
                btn.classList.remove('bg-white', 'dark:bg-white/10', 'shadow', 'text-red-600', 'dark:text-white');
                btn.classList.add('text-slate-500');
            });
            el.classList.add('bg-white', 'dark:bg-white/10', 'shadow', 'text-red-600', 'dark:text-white');
            el.classList.remove('text-slate-500');
        }

        function openReportModal(isSos = false) {
            const modal      = document.getElementById('report-modal');
            const title      = document.getElementById('report-modal-title');
            const subtitle   = document.getElementById('report-modal-subtitle');
            const header     = document.getElementById('report-modal-header');
            const iconWrap   = document.getElementById('modal-icon-wrap');
            const icon       = document.getElementById('modal-header-icon');
            const banner     = document.getElementById('sos-alert-banner');
            const damageSelect = document.getElementById('tingkat_kerusakan');
            const logisticChk  = document.getElementById('logistic_stock_critical');
            const submitBtn  = document.getElementById('submit-btn');
            const submitText = document.getElementById('submit-text');
            const submitIcon = document.getElementById('submit-icon');
            const form       = document.getElementById('report-form');

            if (isSos) {
                title.textContent    = '🚨 Laporan SOS Darurat';
                subtitle.textContent = 'Mode darurat — Prioritas tertinggi, bantuan dikirim segera';
                header.className     = 'modal-header-sos px-6 py-5 flex justify-between items-center flex-shrink-0';
                iconWrap.style.background = 'linear-gradient(135deg,#dc2626,#7f1d1d)';
                icon.className       = 'fas fa-sos';
                banner.classList.remove('hidden');
                damageSelect.value   = 'Hancur Total';
                logisticChk.checked  = true;
                submitBtn.style.background = 'linear-gradient(135deg,#dc2626,#7f1d1d)';
                submitBtn.style.boxShadow  = '0 0 20px rgba(220,38,38,0.6)';
                submitText.textContent = '🚨 KIRIM SOS DARURAT';
                form.classList.add('sos-mode-form');
            } else {
                title.textContent    = 'Buat Laporan Krisis Baru';
                subtitle.textContent = 'Laporkan kejadian bencana untuk penanganan cepat';
                header.className     = 'modal-header-normal px-6 py-5 flex justify-between items-center flex-shrink-0';
                iconWrap.style.background = 'linear-gradient(135deg,#f97316,#dc2626)';
                icon.className       = 'fas fa-file-medical-alt';
                banner.classList.add('hidden');
                damageSelect.value   = '';
                logisticChk.checked  = false;
                submitBtn.style.background = 'linear-gradient(135deg,#f97316,#dc2626)';
                submitBtn.style.boxShadow  = '0 4px 16px rgba(220,38,38,0.4)';
                submitText.textContent = 'Kirim Laporan Darurat';
                form.classList.remove('sos-mode-form');
            }

            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeReportModal() {
            const modal = document.getElementById('report-modal');
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // HTML5 Geolocation Auto detection with IP Fallback
        function detectGPSLocation() {
            const btnText = document.getElementById('gps-btn-text');
            const latInput = document.getElementById('geo-latitude');
            const lngInput = document.getElementById('geo-longitude');
            const accuracyAlert = document.getElementById('gps-accuracy-alert');
            const addressInput = document.getElementById('geo-address');

            btnText.textContent = "Mendeteksi Lokasi...";
            
            const handleSuccess = (lat, lng, accuracyText) => {
                latInput.value = parseFloat(lat).toFixed(6);
                lngInput.value = parseFloat(lng).toFixed(6);
                btnText.textContent = "Lokasi Ditemukan ✓";
                accuracyAlert.innerHTML = `<i class="fas fa-satellite"></i> ${accuracyText}`;
                accuracyAlert.classList.remove('hidden');

                // Simple Reverse Geocoding attempt with public osm service
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`)
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.display_name && !addressInput.value) {
                            addressInput.value = data.display_name;
                        }
                    })
                    .catch(err => console.log('Reverse geocoding error:', err));
            };

            const fallbackToIP = () => {
                btnText.textContent = "Mencoba via Jaringan...";
                fetch('https://ipinfo.io/json')
                    .then(res => res.json())
                    .then(data => {
                        if (data.loc) {
                            const [lat, lng] = data.loc.split(',');
                            handleSuccess(lat, lng, "Lokasi perkiraan (Berdasarkan Jaringan IP)");
                            if (!addressInput.value) {
                                addressInput.value = `${data.city}, ${data.region}`;
                            }
                        } else {
                            throw new Error('IP API failed');
                        }
                    })
                    .catch(err => {
                        console.error('IP Fallback Error:', err);
                        btnText.textContent = "Gagal Deteksi Lokasi";
                        alert("Gagal mendeteksi koordinat lokasi secara otomatis. Pastikan Anda memberikan izin akses lokasi pada browser (Location Permission) atau gunakan koneksi internet yang stabil, lalu coba lagi.");
                    });
            };

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        handleSuccess(position.coords.latitude, position.coords.longitude, "Lokasi akurat terdeteksi dari GPS perangkat!");
                    },
                    (error) => {
                        console.warn('GPS Detection Error, falling back to IP:', error.message);
                        fallbackToIP();
                    },
                    { enableHighAccuracy: false, timeout: 8000, maximumAge: 0 }
                );
            } else {
                fallbackToIP();
            }
        }

        // Chat Feature
        let currentReportChatId = null;

        function openChatModal(reportId, title) {
            currentReportChatId = reportId;
            document.getElementById('chat-modal-title').textContent = title;
            document.getElementById('chat-modal').classList.remove('hidden');
            fetchMessages();
        }

        function closeChatModal() {
            document.getElementById('chat-modal').classList.add('hidden');
            currentReportChatId = null;
        }

        function fetchMessages() {
            if (!currentReportChatId) return;
            fetch(`/report/${currentReportChatId}/chat`)
                .then(res => res.json())
                .then(data => {
                    const container = document.getElementById('chat-messages');
                    container.innerHTML = '';
                    data.forEach(msg => {
                        const isSelf = msg.sender_id == {{ auth()->id() }};
                        const align = isSelf ? 'justify-end' : 'justify-start';
                        const bg = isSelf ? 'bg-blue-600 text-white' : 'bg-slate-700 text-white';
                        const name = isSelf ? 'Anda' : (msg.is_admin ? 'Admin CrisisHub' : msg.sender_name);
                        
                        container.innerHTML += `
                            <div class="flex ${align} mb-4">
                                <div class="max-w-[75%]">
                                    <span class="text-[10px] text-slate-400 block mb-1 ${isSelf ? 'text-right' : 'text-left'}">${name} • ${msg.time}</span>
                                    <div class="${bg} px-4 py-2 rounded-2xl ${isSelf ? 'rounded-tr-sm' : 'rounded-tl-sm'} text-sm shadow">
                                        ${msg.content}
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    container.scrollTop = container.scrollHeight;
                })
                .catch(err => console.error(err));
        }

        function sendChatMessage(e) {
            e.preventDefault();
            const input = document.getElementById('chat-input');
            const content = input.value.trim();
            if (!content || !currentReportChatId) return;

            input.disabled = true;
            fetch(`/report/${currentReportChatId}/chat`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ content: content })
            })
            .then(res => res.json())
            .then(data => {
                input.value = '';
                input.disabled = false;
                fetchMessages();
            })
            .catch(err => {
                console.error(err);
                input.disabled = false;
            });
        }
    </script>

    <!-- Chat Modal -->
    <div id="chat-modal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm hidden">
        <div class="glass-panel rounded-2xl w-full max-w-lg mx-4 overflow-hidden shadow-2xl flex flex-col h-[600px] max-h-[80vh] border border-slate-700">
            <!-- Header -->
            <div class="bg-slate-800 px-6 py-4 flex justify-between items-center border-b border-slate-700">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-base leading-tight">Live Chat Bantuan</h3>
                        <p id="chat-modal-title" class="text-xs text-blue-400 font-semibold"></p>
                    </div>
                </div>
                <button onclick="closeChatModal()" class="text-slate-400 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Messages -->
            <div id="chat-messages" class="flex-1 overflow-y-auto p-6 bg-slate-900 custom-scrollbar">
                <!-- AJAX content -->
            </div>

            <!-- Input Box -->
            <div class="p-4 bg-slate-800 border-t border-slate-700">
                <form onsubmit="sendChatMessage(event)" class="flex gap-2">
                    <input type="text" id="chat-input" placeholder="Ketik pesan Anda di sini..." class="flex-1 bg-slate-900 border border-slate-700 text-white text-sm rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all" required autocomplete="off">
                    <button type="submit" class="w-12 flex-shrink-0 bg-blue-600 hover:bg-blue-500 text-white rounded-xl flex items-center justify-center transition-colors">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
