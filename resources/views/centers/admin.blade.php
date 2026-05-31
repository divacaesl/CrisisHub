@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')
@section('role', 'Super Admin')
@section('page_title', 'CrisisHub Command Center')



@section('header_actions')
    <button class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-600 to-red-800 hover:from-red-500 hover:to-red-700 text-white text-sm font-bold rounded-full transition-all shadow-lg animate-pulse" style="box-shadow: 0 0 15px rgba(220, 38, 38, 0.5);">
        <i class="fas fa-broadcast-tower"></i> Emergency Broadcast
    </button>
@endsection

@section('content')
    <!-- Stats Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="glass-panel rounded-2xl p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-red-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Laporan (24J)</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1">{{ $totalReports ?? 24 }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-red-50 dark:bg-red-500/10 flex items-center justify-center text-red-500">
                    <i class="fas fa-exclamation-triangle text-xl"></i>
                </div>
            </div>
            <div class="text-xs text-red-600 dark:text-red-400 font-semibold flex items-center gap-1">
                <i class="fas fa-arrow-up"></i> +12 sejak kemarin
            </div>
        </div>

        <div class="glass-panel rounded-2xl p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-orange-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Korban Terdampak</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1">1.250</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-orange-50 dark:bg-orange-500/10 flex items-center justify-center text-orange-500">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
            <div class="text-xs text-orange-600 dark:text-orange-400 font-semibold flex items-center gap-1">
                <i class="fas fa-chart-area"></i> Berdasarkan Verifikasi
            </div>
        </div>

        <div class="glass-panel rounded-2xl p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Relawan Aktif</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1">45</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center text-blue-500">
                    <i class="fas fa-hard-hat text-xl"></i>
                </div>
            </div>
            <div class="text-xs text-blue-600 dark:text-blue-400 font-semibold flex items-center gap-1">
                <i class="fas fa-map-marker-alt"></i> Tersebar di 8 titik
            </div>
        </div>

        <div class="glass-panel rounded-2xl p-6 relative overflow-hidden border-red-300 dark:border-red-500/30 group bg-red-50/50 dark:bg-red-900/10">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-red-600/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-red-600 dark:text-red-400">Waktu Respon Rata-rata</p>
                    <h3 class="text-3xl font-black text-red-700 dark:text-red-400 mt-1">14m</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-500/20 flex items-center justify-center text-red-600 dark:text-red-400">
                    <i class="fas fa-stopwatch text-xl"></i>
                </div>
            </div>
            <div class="text-xs text-red-700 dark:text-red-400 font-semibold flex items-center gap-1">
                <i class="fas fa-exclamation-circle"></i> +2m dari target
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Left Col: Verification Center -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Application Approvals -->
            <div class="glass-panel rounded-3xl p-6 md:p-8 border border-indigo-500/20 bg-indigo-50/10 dark:bg-indigo-900/10">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6">Persetujuan Kemitraan & Relawan</h3>
                
                <div class="space-y-6">
                    <!-- Vol apps -->
                    <div>
                        <h4 class="text-sm font-bold text-slate-500 dark:text-slate-400 mb-3 uppercase tracking-wider">Pengajuan Relawan Baru</h4>
                        <div class="space-y-3">
                            <!-- Placeholder item -->
                            <div class="p-4 rounded-xl bg-white/60 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 flex justify-between items-center">
                                <div>
                                    <h5 class="font-bold text-slate-900 dark:text-white text-sm">Ahmad Fauzi</h5>
                                    <p class="text-xs text-slate-500">Bandung • Keahlian: Medis, Dapur Umum</p>
                                </div>
                                <div class="flex gap-2">
                                    <button class="w-8 h-8 rounded-lg bg-green-500 text-white flex justify-center items-center hover:bg-green-600 transition-colors" title="Setujui"><i class="fas fa-check"></i></button>
                                    <button class="w-8 h-8 rounded-lg bg-red-500 text-white flex justify-center items-center hover:bg-red-600 transition-colors" title="Tolak"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Org apps -->
                    <div>
                        <h4 class="text-sm font-bold text-slate-500 dark:text-slate-400 mb-3 uppercase tracking-wider">Pengajuan Organisasi</h4>
                        <div class="space-y-3">
                            <!-- Placeholder item -->
                            <div class="p-4 rounded-xl bg-white/60 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 flex justify-between items-center">
                                <div>
                                    <h5 class="font-bold text-slate-900 dark:text-white text-sm">Yayasan Peduli Sesama</h5>
                                    <p class="text-xs text-slate-500">NGO • Kontak: Bpk. Rudi (0812xxx)</p>
                                </div>
                                <div class="flex gap-2">
                                    <button class="w-8 h-8 rounded-lg bg-green-500 text-white flex justify-center items-center hover:bg-green-600 transition-colors" title="Setujui"><i class="fas fa-check"></i></button>
                                    <button class="w-8 h-8 rounded-lg bg-red-500 text-white flex justify-center items-center hover:bg-red-600 transition-colors" title="Tolak"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="glass-panel rounded-3xl p-6 md:p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Pusat Verifikasi Laporan</h3>
                    <div class="flex gap-2">
                        <button class="px-3 py-1.5 text-xs font-bold bg-slate-200 dark:bg-slate-700 rounded-lg">Semua</button>
                        <button class="px-3 py-1.5 text-xs font-bold bg-red-500 text-white rounded-lg">Kritis</button>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- Report Item -->
                    <div class="p-5 rounded-2xl bg-white/60 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 shadow-sm">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden">
                                    <img src="https://i.pravatar.cc/150?img=33" alt="User">
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 dark:text-white text-sm">Budi Santoso</h4>
                                    <p class="text-[10px] text-slate-500">Dilaporkan 10 menit lalu</p>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400 uppercase border border-red-200 dark:border-red-500/30">Gempa Bumi</span>
                        </div>
                        
                        <p class="text-sm text-slate-700 dark:text-slate-300 mb-4 bg-slate-100 dark:bg-slate-900/50 p-3 rounded-xl">Bangunan roboh di Jl. Sudirman No 45. Terdapat korban terjebak di reruntuhan. Mohon bantuan evakuasi segera!</p>
                        
                        <div class="flex items-center justify-between border-t border-slate-200 dark:border-slate-700 pt-4 mt-4">
                            <div class="flex gap-3">
                                <span class="text-xs font-semibold text-slate-500"><i class="fas fa-map-marker-alt"></i> -6.20, 106.82</span>
                                <span class="text-xs font-semibold text-red-500"><i class="fas fa-users"></i> ~5 Korban</span>
                            </div>
                            <div class="flex gap-2">
                                <button class="px-4 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-bold rounded-lg transition-colors">Verifikasi & Teruskan</button>
                                <button class="px-3 py-1.5 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-300 text-xs font-bold rounded-lg transition-colors">Abaikan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="glass-panel rounded-3xl p-6 md:p-8">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6">Distribusi Bantuan Real-time</h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-500 dark:text-slate-400">
                        <thead class="text-xs uppercase bg-slate-100 dark:bg-slate-800/50 text-slate-700 dark:text-slate-300">
                            <tr>
                                <th class="px-4 py-3 rounded-tl-lg rounded-bl-lg">ID</th>
                                <th class="px-4 py-3">Tujuan</th>
                                <th class="px-4 py-3">Logistik</th>
                                <th class="px-4 py-3">Relawan</th>
                                <th class="px-4 py-3 rounded-tr-lg rounded-br-lg">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-slate-200 dark:border-slate-700/50">
                                <td class="px-4 py-3 font-medium text-slate-900 dark:text-white">#DST-001</td>
                                <td class="px-4 py-3">Cimenyan</td>
                                <td class="px-4 py-3">50 Paket Pangan</td>
                                <td class="px-4 py-3">Tim A (3 Org)</td>
                                <td class="px-4 py-3"><span class="px-2 py-1 bg-yellow-100 text-yellow-700 dark:bg-yellow-500/20 dark:text-yellow-400 text-[10px] rounded font-bold">Dalam Perjalanan</span></td>
                            </tr>
                            <tr class="border-b border-slate-200 dark:border-slate-700/50">
                                <td class="px-4 py-3 font-medium text-slate-900 dark:text-white">#DST-002</td>
                                <td class="px-4 py-3">Dayeuhkolot</td>
                                <td class="px-4 py-3">10 Tenda Medis</td>
                                <td class="px-4 py-3">Tim B (5 Org)</td>
                                <td class="px-4 py-3"><span class="px-2 py-1 bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400 text-[10px] rounded font-bold">Tiba di Lokasi</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Col: GIS & Overview -->
        <div class="space-y-8">
            <!-- GIS Map Placeholder -->
            <div class="glass-panel rounded-3xl p-4 h-80 relative overflow-hidden group border border-blue-500/30">
                <div class="absolute top-4 left-4 z-10 px-3 py-1 bg-slate-900/80 backdrop-blur text-white text-xs font-bold rounded-lg flex items-center gap-2">
                    <i class="fas fa-satellite text-blue-400"></i> GIS Monitoring Live
                </div>
                <div class="absolute inset-0 bg-slate-200 dark:bg-slate-800 bg-cover bg-center transition-transform duration-1000 group-hover:scale-105" style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/e/e4/Map_of_Bandung_City.png'); opacity: 0.6;"></div>
                
                <!-- Heatmap clusters -->
                <div class="absolute top-[40%] left-[30%] w-24 h-24 bg-red-500/20 rounded-full blur-xl"></div>
                <div class="absolute top-[45%] left-[35%] w-4 h-4 bg-red-500 rounded-full shadow-[0_0_15px_#ef4444] animate-pulse"></div>
                
                <div class="absolute top-[60%] right-[20%] w-16 h-16 bg-orange-500/20 rounded-full blur-xl"></div>
                <div class="absolute top-[62%] right-[25%] w-3 h-3 bg-orange-500 rounded-full shadow-[0_0_10px_#f97316]"></div>
            </div>

            <!-- Export -->
            <div class="glass-panel rounded-3xl p-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Ekspor Data</h3>
                <div class="space-y-3">
                    <button class="w-full flex justify-between items-center px-4 py-3 bg-white/50 dark:bg-slate-800/50 hover:bg-white dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 rounded-xl transition-colors">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-file-pdf text-red-500 text-lg"></i>
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Laporan Bencana (Harian)</span>
                        </div>
                        <i class="fas fa-download text-slate-400"></i>
                    </button>
                    <button class="w-full flex justify-between items-center px-4 py-3 bg-white/50 dark:bg-slate-800/50 hover:bg-white dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 rounded-xl transition-colors">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-file-excel text-green-500 text-lg"></i>
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Data Donasi & Transparansi</span>
                        </div>
                        <i class="fas fa-download text-slate-400"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
