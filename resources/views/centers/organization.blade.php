@extends('layouts.dashboard')

@section('title', 'Organization Dashboard')
@section('role', 'Organisasi Bantuan')
@section('page_title', 'Dashboard Organisasi')



@section('header_actions')
    <button class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-indigo-600 to-indigo-800 hover:from-indigo-500 hover:to-indigo-700 text-white text-sm font-bold rounded-full transition-all shadow-lg">
        <i class="fas fa-plus"></i> Buat Kampanye
    </button>
@endsection

@section('content')
    <!-- Stats Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="glass-panel rounded-2xl p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Kampanye Aktif</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1">4</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center text-indigo-500">
                    <i class="fas fa-bullhorn text-xl"></i>
                </div>
            </div>
            <div class="text-xs text-indigo-600 dark:text-indigo-400 font-semibold flex items-center gap-1">
                <i class="fas fa-users"></i> 1.2k Donatur Berpartisipasi
            </div>
        </div>

        <div class="glass-panel rounded-2xl p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-amber-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Logistik Tersedia</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1">12.4T</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-500/10 flex items-center justify-center text-amber-500">
                    <i class="fas fa-boxes text-xl"></i>
                </div>
            </div>
            <div class="text-xs text-amber-600 dark:text-amber-400 font-semibold flex items-center gap-1">
                <i class="fas fa-warehouse"></i> 3 Gudang Aktif
            </div>
        </div>

        <div class="glass-panel rounded-2xl p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Target Distribusi</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1">85%</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center text-blue-500">
                    <i class="fas fa-truck-loading text-xl"></i>
                </div>
            </div>
            <div class="text-xs text-blue-600 dark:text-blue-400 font-semibold flex items-center gap-1">
                <i class="fas fa-chart-line"></i> On Track bulan ini
            </div>
        </div>

        <div class="glass-panel rounded-2xl p-6 relative overflow-hidden border-red-300 dark:border-red-500/30 group bg-red-50/50 dark:bg-red-900/10">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-red-600/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-red-600 dark:text-red-400">Area Kritis</p>
                    <h3 class="text-3xl font-black text-red-700 dark:text-red-400 mt-1">2</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-500/20 flex items-center justify-center text-red-600 dark:text-red-400">
                    <i class="fas fa-map-marked-alt text-xl"></i>
                </div>
            </div>
            <div class="text-xs text-red-700 dark:text-red-400 font-semibold flex items-center gap-1">
                <i class="fas fa-exclamation-triangle"></i> Defisit Bantuan Medis
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Left Col: Campaigns & Logistics -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Active Campaigns -->
            <div class="glass-panel rounded-3xl p-6 md:p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Kampanye Berjalan</h3>
                    <button class="text-sm font-semibold text-indigo-500 hover:text-indigo-600">Kelola Semua</button>
                </div>

                <div class="space-y-4">
                    <!-- Campaign Item -->
                    <div class="p-5 rounded-2xl bg-white/60 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700">
                        <div class="flex justify-between items-start mb-3">
                            <h4 class="font-bold text-slate-900 dark:text-white">Pemulihan Pasca Gempa Garut</h4>
                            <span class="px-2 py-1 rounded text-[10px] font-bold bg-indigo-100 text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-400 uppercase">Aktif</span>
                        </div>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mb-4 line-clamp-1">Fokus pada pembangunan kembali fasilitas air bersih dan sanitasi di 5 desa terdampak.</p>
                        
                        <div class="flex items-end justify-between">
                            <div class="w-2/3">
                                <div class="flex justify-between text-xs font-semibold mb-1">
                                    <span class="text-slate-900 dark:text-white">Rp 450.000.000 terkumpul</span>
                                    <span class="text-slate-500">75%</span>
                                </div>
                                <div class="w-full h-2 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-indigo-500 to-indigo-600 w-[75%] rounded-full"></div>
                                </div>
                            </div>
                            <button class="px-3 py-1.5 text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 rounded-lg transition-colors">
                                Laporan Transparansi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Logistics -->
            <div class="glass-panel rounded-3xl p-6 md:p-8">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6">Status Logistik & Kebutuhan</h3>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-white/40 dark:bg-slate-800/40">
                        <div class="flex justify-between items-center mb-2">
                            <h5 class="font-bold text-slate-700 dark:text-slate-300">Beras / Pangan Pokok</h5>
                            <i class="fas fa-leaf text-green-500"></i>
                        </div>
                        <div class="text-2xl font-black text-slate-900 dark:text-white mb-1">5.2 Ton</div>
                        <div class="text-xs font-semibold text-green-500">Mencukupi (Stok Aman)</div>
                    </div>
                    <div class="p-4 rounded-xl border border-red-200 dark:border-red-900/30 bg-red-50/40 dark:bg-red-900/10">
                        <div class="flex justify-between items-center mb-2">
                            <h5 class="font-bold text-slate-700 dark:text-slate-300">Obat-obatan Medis</h5>
                            <i class="fas fa-briefcase-medical text-red-500"></i>
                        </div>
                        <div class="text-2xl font-black text-slate-900 dark:text-white mb-1">150 Paket</div>
                        <div class="text-xs font-semibold text-red-500">Defisit di Area Kritis!</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Col: Distribution & Volunteers -->
        <div class="space-y-8">
            <div class="glass-panel rounded-3xl p-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6">Penjadwalan Distribusi</h3>
                
                <div class="space-y-4 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-300 dark:before:via-slate-700 before:to-transparent">
                    
                    <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-slate-300 group-[.is-active]:bg-indigo-500 text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                            <i class="fas fa-truck text-xs"></i>
                        </div>
                        <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-xl bg-white/50 dark:bg-slate-800/50 shadow border border-slate-100 dark:border-slate-700">
                            <div class="flex items-center justify-between mb-1">
                                <h4 class="font-bold text-slate-900 dark:text-white text-sm">Ke Garut</h4>
                                <span class="text-[10px] text-slate-500">Hari ini, 14:00</span>
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Tim Relawan 1 (Budi dkk)</p>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
