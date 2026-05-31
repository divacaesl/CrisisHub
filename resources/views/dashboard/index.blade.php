@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('role', 'Standard User')
@section('page_title', 'Dashboard Utama')

@section('header_actions')
    <button onclick="openReportModal(true)" class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-600 to-red-800 hover:from-red-500 hover:to-red-700 text-white text-sm font-bold rounded-full transition-all shadow-lg animate-pulse" style="box-shadow: 0 0 15px rgba(220, 38, 38, 0.5);">
        <i class="fas fa-exclamation-triangle"></i> SOS Darurat
    </button>
@endsection

@section('content')
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
                                <span class="text-[10px] text-slate-400">{{ $rep->created_at->diffForHumans() }}</span>
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

    <!-- REPORT CREATION MODAL (Buat Laporan Baru) -->
    <div id="report-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/75 backdrop-blur-md hidden overflow-y-auto py-10">
        <div class="glass-panel rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl border border-white/10 mx-4 my-auto flex flex-col max-h-[90vh]">
            <div class="px-6 py-5 border-b border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.02] flex justify-between items-center flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-red-500 text-white flex justify-center items-center font-bold">
                        <i class="fas fa-ambulance"></i>
                    </div>
                    <div>
                        <h3 id="report-modal-title" class="font-bold text-slate-900 dark:text-white font-display text-lg">Buat Laporan Krisis Baru</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Laporkan kejadian krisis/bencana untuk penanganan cepat</p>
                    </div>
                </div>
                <button onclick="closeReportModal()" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-white/10 text-slate-500 hover:text-slate-900 dark:hover:text-white flex justify-center items-center transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('report.store') }}" method="POST" enctype="multipart/form-data" class="flex-1 overflow-y-auto p-6 space-y-6">
                @csrf
                
                <!-- Bencana & Kerusakan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-xs font-bold text-slate-600 dark:text-slate-300 block mb-2 uppercase tracking-wide">Jenis Bencana</label>
                        <select name="jenis_bencana" required class="w-full px-4 py-2.5 bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 transition-all text-sm">
                            <option value="">Pilih Jenis Bencana</option>
                            <option value="Banjir">Banjir</option>
                            <option value="Tanah Longsor">Tanah Longsor</option>
                            <option value="Gempa Bumi">Gempa Bumi</option>
                            <option value="Kebakaran Hutan/Pemukiman">Kebakaran Hutan/Pemukiman</option>
                            <option value="Angin Puting Beliung/Topan">Angin Puting Beliung/Topan</option>
                            <option value="Gunung Meletus">Gunung Meletus</option>
                            <option value="Tsunami">Tsunami</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-600 dark:text-slate-300 block mb-2 uppercase tracking-wide">Tingkat Kerusakan</label>
                        <select name="tingkat_kerusakan" id="tingkat_kerusakan" required class="w-full px-4 py-2.5 bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 transition-all text-sm">
                            <option value="">Pilih Tingkat Kerusakan</option>
                            <option value="Rendah">Rendah (Kerusakan Minimal)</option>
                            <option value="Sedang">Sedang (Bisa dihuni, butuh perbaikan)</option>
                            <option value="Tinggi">Tinggi (Rusak parah, membahayakan)</option>
                            <option value="Hancur Total">Hancur Total (Rata dengan tanah)</option>
                        </select>
                    </div>
                </div>

                <!-- Korban & Keluarga -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-xs font-bold text-slate-600 dark:text-slate-300 block mb-2 uppercase tracking-wide">Jumlah Jiwa Terdampak / Korban</label>
                        <input type="number" name="jumlah_korban" min="0" value="0" required class="w-full px-4 py-2.5 bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 transition-all text-sm">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-600 dark:text-slate-300 block mb-2 uppercase tracking-wide">Total Anggota Keluarga Terlibat</label>
                        <input type="number" name="family_members" min="0" value="0" required class="w-full px-4 py-2.5 bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 transition-all text-sm">
                    </div>
                </div>

                <!-- Vulnerable Metrics -->
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-white/[0.02] border border-slate-200 dark:border-white/5 space-y-4">
                    <h4 class="text-xs font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest flex items-center gap-1.5">
                        <i class="fas fa-users-cog text-red-500"></i> Kelompok Rentan Terdampak (Opsional)
                    </h4>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="text-[10px] font-bold text-slate-500 dark:text-slate-400 block mb-1">Bayi / Balita</label>
                            <input type="number" name="infants_count" min="0" value="0" required class="w-full px-3 py-1.5 bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-center">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-500 dark:text-slate-400 block mb-1">Lansia (60+ th)</label>
                            <input type="number" name="elderly_count" min="0" value="0" required class="w-full px-3 py-1.5 bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-center">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-500 dark:text-slate-400 block mb-1">Disabilitas</label>
                            <input type="number" name="disabled_count" min="0" value="0" required class="w-full px-3 py-1.5 bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-center">
                        </div>
                    </div>
                </div>

                <!-- Logistic Status & Needs -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="logistic_stock_critical" name="logistic_stock_critical" class="w-4.5 h-4.5 text-red-600 border-slate-300 dark:border-slate-700 rounded focus:ring-red-500">
                        <label for="logistic_stock_critical" class="text-xs font-bold text-red-600 dark:text-red-400 uppercase tracking-wide cursor-pointer flex items-center gap-1.5">
                            <i class="fas fa-boxes"></i> Stok Logistik Kritis? (Tidak ada makanan, air bersih, obat-obatan)
                        </label>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-600 dark:text-slate-300 block mb-2 uppercase tracking-wide">Kebutuhan Mendesak (Sembako, tenda, obat dll)</label>
                        <input type="text" name="kebutuhan_mendesak" placeholder="Contoh: Selimut hangat, popok bayi, air mineral, dapur umum" class="w-full px-4 py-2.5 bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 transition-all text-sm">
                    </div>
                </div>

                <!-- Description & Foto -->
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="text-xs font-bold text-slate-600 dark:text-slate-300 block mb-2 uppercase tracking-wide">Deskripsi Kondisi Lapangan</label>
                        <textarea name="deskripsi_kondisi" required rows="3" placeholder="Ceritakan detail kerusakan rumah, kebutuhan mendesak, atau akses transportasi saat ini..." class="w-full px-4 py-2.5 bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 transition-all text-sm"></textarea>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-600 dark:text-slate-300 block mb-2 uppercase tracking-wide">Foto Kondisi / Kerusakan</label>
                        <input type="file" name="foto" accept="image/*" class="w-full px-4 py-2 bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-red-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-500/10 file:text-red-500">
                    </div>
                </div>

                <!-- Geolocation GPS Picker -->
                <div class="p-5 rounded-2xl bg-slate-50 dark:bg-white/[0.02] border border-slate-200 dark:border-white/5 space-y-4">
                    <div class="flex items-center justify-between">
                        <h4 class="text-xs font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest flex items-center gap-1.5">
                            <i class="fas fa-map-marked-alt text-red-500"></i> Koordinat Geografis Kejadian
                        </h4>
                        <button type="button" onclick="detectGPSLocation()" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-[11px] font-bold uppercase rounded-lg shadow transition-colors flex items-center gap-1.5">
                            <i class="fas fa-gps"></i> <span id="gps-btn-text">Deteksi Lokasi GPS Saya</span>
                        </button>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-bold text-slate-500 dark:text-slate-400 block mb-1">Latitude (Garis Lintang)</label>
                            <input type="text" name="latitude" id="geo-latitude" required placeholder="-6.9147" class="w-full px-3 py-2 bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-center">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-500 dark:text-slate-400 block mb-1">Longitude (Garis Bujur)</label>
                            <input type="text" name="longitude" id="geo-longitude" required placeholder="107.6098" class="w-full px-3 py-2 bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-center">
                        </div>
                    </div>
                    <div id="gps-accuracy-alert" class="text-[10px] text-green-500 font-semibold hidden flex items-center gap-1">
                        <i class="fas fa-satellite"></i> Lokasi terdeteksi dengan akurasi tinggi!
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-600 dark:text-slate-300 block mb-2 uppercase tracking-wide">Alamat Lengkap Kejadian</label>
                        <textarea name="alamat_lengkap" id="geo-address" rows="2" placeholder="Tuliskan nama jalan, RT/RW, nomor rumah, kelurahan, kecamatan, dan kota..." class="w-full px-4 py-2.5 bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 transition-all text-sm"></textarea>
                    </div>
                </div>

                <!-- Submit & Cancel -->
                <div class="flex justify-end gap-3 border-t border-slate-200 dark:border-white/10 pt-4 flex-shrink-0">
                    <button type="button" onclick="closeReportModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-white/5 dark:hover:bg-white/10 text-slate-700 dark:text-slate-300 text-xs font-bold uppercase rounded-xl border border-slate-200 dark:border-white/5">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold uppercase rounded-xl shadow-lg transition-transform transform hover:scale-[1.02]">Kirim Laporan Darurat</button>
                </div>
            </form>
        </div>
    </div>

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
            const modal = document.getElementById('report-modal');
            const title = document.getElementById('report-modal-title');
            const damageSelect = document.getElementById('tingkat_kerusakan');
            const isSosAlert = document.getElementById('logistic_stock_critical');

            if (isSos) {
                title.textContent = '🚨 SOS LAPORAN CRITICAL DARURAT';
                damageSelect.value = 'Hancur Total';
                isSosAlert.checked = true;
            } else {
                title.textContent = 'Buat Laporan Krisis Baru';
                damageSelect.value = '';
                isSosAlert.checked = false;
            }

            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeReportModal() {
            const modal = document.getElementById('report-modal');
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // HTML5 Geolocation Auto detection
        function detectGPSLocation() {
            const btnText = document.getElementById('gps-btn-text');
            const latInput = document.getElementById('geo-latitude');
            const lngInput = document.getElementById('geo-longitude');
            const accuracyAlert = document.getElementById('gps-accuracy-alert');

            btnText.textContent = "Mendeteksi Lokasi...";
            
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        latInput.value = lat.toFixed(6);
                        lngInput.value = lng.toFixed(6);
                        btnText.textContent = "GPS Berhasil Terdeteksi ✓";
                        accuracyAlert.classList.remove('hidden');

                        // Simple Reverse Geocoding attempt with public osm service
                        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`)
                            .then(res => res.json())
                            .then(data => {
                                if (data && data.display_name) {
                                    document.getElementById('geo-address').value = data.display_name;
                                }
                            })
                            .catch(err => console.log('Reverse geocoding error:', err));
                    },
                    (error) => {
                        console.error('GPS Detection Error:', error);
                        btnText.textContent = "Gagal Mendeteksi GPS";
                        alert("Gagal mendeteksi koordinat lokasi Anda secara otomatis. Silakan isi kolom secara manual.");
                    },
                    { enableHighAccuracy: true, timeout: 5000, maximumAge: 0 }
                );
            } else {
                alert("Browser Anda tidak mendukung layanan Geolocation GPS.");
                btnText.textContent = "GPS Tidak Didukung";
            }
        }
    </script>
@endsection
