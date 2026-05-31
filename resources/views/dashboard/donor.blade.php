@extends('layouts.dashboard')

@section('title', 'Donor Dashboard')
@section('role', 'Donatur')
@section('page_title', 'Dashboard Donatur')

@section('sidebar')
    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-yellow-600 dark:text-yellow-400 bg-yellow-50 dark:bg-yellow-500/10 font-semibold transition-colors">
        <i class="fas fa-home w-5 text-center"></i> Beranda
    </a>
    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/5 font-medium transition-colors">
        <i class="fas fa-heart w-5 text-center"></i> Kampanye Aktif
    </a>
    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/5 font-medium transition-colors">
        <i class="fas fa-history w-5 text-center"></i> Riwayat Donasi
    </a>
    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/5 font-medium transition-colors">
        <i class="fas fa-truck-loading w-5 text-center"></i> Lacak Penyaluran
    </a>
    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/5 font-medium transition-colors">
        <i class="fas fa-chart-pie w-5 text-center"></i> Laporan Transparansi
    </a>
@endsection

@section('header_actions')
    <a href="/donate" class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-400 hover:to-yellow-500 text-white text-sm font-bold rounded-full transition-all shadow-lg">
        <i class="fas fa-hand-holding-usd"></i> Donasi Baru
    </a>
@endsection

@section('content')
    <!-- Stats Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="glass-panel rounded-2xl p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-yellow-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Donasi</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1">Rp 12.5M</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-yellow-50 dark:bg-yellow-500/10 flex items-center justify-center text-yellow-500">
                    <i class="fas fa-wallet text-xl"></i>
                </div>
            </div>
            <div class="text-xs text-yellow-600 dark:text-yellow-400 font-semibold flex items-center gap-1">
                <i class="fas fa-arrow-up"></i> +Rp 500rb bulan ini
            </div>
        </div>

        <div class="glass-panel rounded-2xl p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-rose-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Kampanye Didukung</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1">8</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-rose-50 dark:bg-rose-500/10 flex items-center justify-center text-rose-500">
                    <i class="fas fa-heart text-xl"></i>
                </div>
            </div>
            <div class="text-xs text-rose-600 dark:text-rose-400 font-semibold flex items-center gap-1">
                <i class="fas fa-fire"></i> 2 Aktif
            </div>
        </div>

        <div class="glass-panel rounded-2xl p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Penerima Manfaat</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1">452</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center text-blue-500">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
            <div class="text-xs text-blue-600 dark:text-blue-400 font-semibold flex items-center gap-1">
                <i class="fas fa-chart-line"></i> Estimasi Berdasarkan Donasi
            </div>
        </div>

        <div class="glass-panel rounded-2xl p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Bantuan Tersalur</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1">100%</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-green-50 dark:bg-green-500/10 flex items-center justify-center text-green-500">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
            </div>
            <div class="text-xs text-green-600 dark:text-green-400 font-semibold flex items-center gap-1">
                <i class="fas fa-shield-alt"></i> Terverifikasi Transparan
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Left Col: Impact & Campaigns -->
        <div class="lg:col-span-2 space-y-8">
            <div class="glass-panel rounded-3xl p-6 md:p-8">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6">Dampak Donasi Anda</h3>
                
                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="p-4 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white relative overflow-hidden">
                        <i class="fas fa-utensils absolute right-4 bottom-4 text-5xl opacity-20"></i>
                        <p class="text-sm opacity-80 mb-1">Paket Sembako Disalurkan</p>
                        <h4 class="text-2xl font-black">120 Paket</h4>
                    </div>
                    <div class="p-4 rounded-2xl bg-gradient-to-br from-teal-500 to-emerald-600 text-white relative overflow-hidden">
                        <i class="fas fa-briefcase-medical absolute right-4 bottom-4 text-5xl opacity-20"></i>
                        <p class="text-sm opacity-80 mb-1">Keluarga Mendapat Bantuan Medis</p>
                        <h4 class="text-2xl font-black">45 Keluarga</h4>
                    </div>
                </div>
            </div>

            <!-- Campaign Recommendations -->
            <div class="glass-panel rounded-3xl p-6 md:p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Rekomendasi Kampanye</h3>
                    <a href="#" class="text-sm font-semibold text-yellow-500 hover:text-yellow-600">Lihat Semua</a>
                </div>

                <div class="space-y-6">
                    <!-- Campaign Item -->
                    <div class="flex flex-col sm:flex-row gap-4 group">
                        <div class="w-full sm:w-48 h-32 rounded-xl bg-slate-200 dark:bg-slate-700 overflow-hidden flex-shrink-0 relative">
                            <img src="/images/flood_case.png" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="Banjir">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 to-transparent"></div>
                            <span class="absolute bottom-2 left-2 text-[10px] font-bold px-2 py-0.5 bg-red-500 text-white rounded uppercase">Mendesak</span>
                        </div>
                        <div class="flex-1 min-w-0 flex flex-col justify-center">
                            <h4 class="text-lg font-bold text-slate-900 dark:text-white group-hover:text-yellow-500 transition-colors">Bantuan Darurat Banjir Bandang Demak</h4>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 line-clamp-2">Ribuan warga terpaksa mengungsi akibat tanggul jebol. Kebutuhan mendesak: makanan, selimut, obat-obatan.</p>
                            
                            <div class="mt-3">
                                <div class="flex justify-between text-xs font-semibold mb-1">
                                    <span class="text-yellow-600 dark:text-yellow-400">Terkumpul 65%</span>
                                    <span class="text-slate-500">Target Rp 500 Juta</span>
                                </div>
                                <div class="w-full h-2 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-yellow-400 to-yellow-500 w-[65%] rounded-full"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Col: History -->
        <div class="space-y-8">
            <div class="glass-panel rounded-3xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Kontribusi Terakhir</h3>
                </div>
                
                <div class="space-y-4">
                    <div class="p-4 rounded-xl bg-white/50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-slate-400">12 Mei 2026</span>
                            <span class="px-2 py-0.5 bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400 text-[10px] font-bold rounded uppercase">Tersalurkan</span>
                        </div>
                        <h4 class="font-bold text-slate-900 dark:text-white mb-1">Rp 500.000</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Bantuan Darurat Erupsi Gunung Ruang</p>
                        <a href="#" class="text-[10px] font-bold text-blue-500 mt-2 inline-block"><i class="fas fa-file-invoice"></i> Unduh Tanda Terima</a>
                    </div>

                    <div class="p-4 rounded-xl bg-white/50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-slate-400">01 Apr 2026</span>
                            <span class="px-2 py-0.5 bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400 text-[10px] font-bold rounded uppercase">Tersalurkan</span>
                        </div>
                        <h4 class="font-bold text-slate-900 dark:text-white mb-1">Barang: 5 Kardus Pakaian</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Bantuan Banjir Pesisir Pantai Utara</p>
                        <a href="#" class="text-[10px] font-bold text-yellow-500 mt-2 inline-block"><i class="fas fa-camera"></i> Lihat Bukti Penyaluran</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
