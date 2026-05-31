@extends('layouts.dashboard')

@section('title', 'Volunteer Dashboard')
@section('role', 'Relawan')
@section('page_title', 'Dashboard Relawan')



@section('header_actions')
    <!-- Volunteer specific toggle or status -->
    <div class="flex items-center gap-2 px-4 py-1.5 glass-panel rounded-full border border-green-500/30 bg-green-50/50 dark:bg-green-900/20">
        <div class="w-2.5 h-2.5 rounded-full bg-green-500 shadow-[0_0_8px_#22c55e] animate-pulse"></div>
        <span class="text-xs font-bold text-green-600 dark:text-green-400 uppercase tracking-wider">On Duty</span>
    </div>
@endsection

@section('content')
    <!-- Stats Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="glass-panel rounded-2xl p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Misi Aktif</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1">2</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center text-blue-500">
                    <i class="fas fa-running text-xl"></i>
                </div>
            </div>
            <div class="text-xs text-blue-600 dark:text-blue-400 font-semibold flex items-center gap-1">
                <i class="fas fa-map-marker-alt"></i> Sedang Berjalan
            </div>
        </div>

        <div class="glass-panel rounded-2xl p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Misi Selesai</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1">14</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-green-50 dark:bg-green-500/10 flex items-center justify-center text-green-500">
                    <i class="fas fa-check-double text-xl"></i>
                </div>
            </div>
            <div class="text-xs text-green-600 dark:text-green-400 font-semibold flex items-center gap-1">
                <i class="fas fa-star"></i> Kinerja Sangat Baik
            </div>
        </div>

        <div class="glass-panel rounded-2xl p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-purple-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Area Ditugaskan</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1">Kab. Bandung</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-50 dark:bg-purple-500/10 flex items-center justify-center text-purple-500">
                    <i class="fas fa-map text-xl"></i>
                </div>
            </div>
            <div class="text-xs text-purple-600 dark:text-purple-400 font-semibold flex items-center gap-1">
                <i class="fas fa-location-arrow"></i> Radius 10km
            </div>
        </div>

        <div class="glass-panel rounded-2xl p-6 relative overflow-hidden border-red-300 dark:border-red-500/30 group bg-red-50/50 dark:bg-red-900/10">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-red-600/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-red-600 dark:text-red-400">Kasus Kritis Sekitar</p>
                    <h3 class="text-3xl font-black text-red-700 dark:text-red-400 mt-1">3</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-500/20 flex items-center justify-center text-red-600 dark:text-red-400">
                    <i class="fas fa-ambulance text-xl"></i>
                </div>
            </div>
            <div class="text-xs text-red-700 dark:text-red-400 font-semibold flex items-center gap-1">
                <i class="fas fa-exclamation-triangle"></i> Perlu Evakuasi Segera
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Left Col: Tasks -->
        <div class="lg:col-span-2 space-y-8">
            <div class="glass-panel rounded-3xl p-6 md:p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Antrean Penugasan (Mission Queue)</h3>
                    <button class="px-4 py-2 bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-sm font-bold rounded-xl hover:opacity-90 transition-opacity">
                        Refresh
                    </button>
                </div>

                <div class="space-y-4">
                    <!-- Task Item -->
                    <div class="p-5 rounded-2xl bg-white/60 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 shadow-sm relative overflow-hidden">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-red-500"></div>
                        <div class="flex flex-col md:flex-row gap-4 md:items-center justify-between">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400 uppercase">Kritis</span>
                                    <span class="text-xs text-slate-500">#TSK-8921</span>
                                </div>
                                <h4 class="text-base font-bold text-slate-900 dark:text-white">Distribusi Pangan - Dayeuhkolot</h4>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1"><i class="fas fa-map-marker-alt text-slate-400 w-4"></i> Jl. Raya Dayeuhkolot No. 12 (3.2 km)</p>
                            </div>
                            <div class="flex gap-2">
                                <button class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-bold rounded-lg transition-colors">Terima</button>
                                <button class="px-4 py-2 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-300 dark:hover:bg-slate-600 text-sm font-bold rounded-lg transition-colors">Tolak</button>
                            </div>
                        </div>
                    </div>

                    <!-- Task Item -->
                    <div class="p-5 rounded-2xl bg-white/60 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 shadow-sm relative overflow-hidden">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-orange-500"></div>
                        <div class="flex flex-col md:flex-row gap-4 md:items-center justify-between">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-orange-100 text-orange-700 dark:bg-orange-500/20 dark:text-orange-400 uppercase">Tinggi</span>
                                    <span class="text-xs text-slate-500">#TSK-8924</span>
                                </div>
                                <h4 class="text-base font-bold text-slate-900 dark:text-white">Evakuasi Lansia - Baleendah</h4>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1"><i class="fas fa-map-marker-alt text-slate-400 w-4"></i> Perumahan Baleendah Permai (5.1 km)</p>
                            </div>
                            <div class="flex gap-2">
                                <button class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-bold rounded-lg transition-colors">Terima</button>
                                <button class="px-4 py-2 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-300 dark:hover:bg-slate-600 text-sm font-bold rounded-lg transition-colors">Tolak</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Col: Map & Activity -->
        <div class="space-y-8">
            <!-- Mini Map Placeholder -->
            <div class="glass-panel rounded-3xl p-4 h-64 relative overflow-hidden group">
                <div class="absolute inset-0 bg-slate-200 dark:bg-slate-800 bg-cover bg-center" style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/e/e4/Map_of_Bandung_City.png'); opacity: 0.5;"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 to-transparent flex flex-col justify-end p-6">
                    <h4 class="text-white font-bold">Lokasi Anda (GPS Aktif)</h4>
                    <p class="text-slate-300 text-sm text-xs mt-1">Koordinat: -6.985, 107.63</p>
                </div>
                <!-- Pulsing dot -->
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                    <div class="w-4 h-4 bg-blue-500 rounded-full animate-ping absolute"></div>
                    <div class="w-4 h-4 bg-blue-500 rounded-full border-2 border-white relative z-10"></div>
                </div>
            </div>

            <!-- Daily Activities -->
            <div class="glass-panel rounded-3xl p-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Aktivitas Hari Ini</h3>
                <div class="space-y-4">
                    <div class="flex gap-4">
                        <div class="w-2 h-2 mt-2 rounded-full bg-blue-500 flex-shrink-0"></div>
                        <div>
                            <p class="text-sm font-bold text-slate-900 dark:text-white">Status Diperbarui: Tiba di Lokasi</p>
                            <p class="text-xs text-slate-500">TSK-8910 (Bantuan Medis)</p>
                            <span class="text-[10px] text-slate-400">10:45 AM</span>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-2 h-2 mt-2 rounded-full bg-green-500 flex-shrink-0"></div>
                        <div>
                            <p class="text-sm font-bold text-slate-900 dark:text-white">Misi Selesai</p>
                            <p class="text-xs text-slate-500">TSK-8890 (Distribusi Air Bersih)</p>
                            <span class="text-[10px] text-slate-400">09:15 AM</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
