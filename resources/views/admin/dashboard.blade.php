@extends('layouts.admin')

@section('content')
<!-- Header Area -->
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white font-display">Command Center Dashboard</h2>
        <p class="text-xs text-slate-500 dark:text-gray-400 mt-1">Sistem Pemantauan dan Kendali Ekosistem Penanggulangan Bencana CrisisHub.</p>
    </div>
    <div class="flex items-center space-x-2">
        <span class="relative flex h-3.5 w-3.5">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-green-500"></span>
        </span>
        <span class="text-xs font-bold text-green-400 tracking-wide uppercase">Real-Time Core Active</span>
    </div>
</div>

<!-- 8 Core Metrics Grid -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <!-- Stat 1: Total Laporan -->
    <div class="card-glass rounded-2xl p-5 stat-card flex items-center space-x-4">
        <div class="p-3.5 rounded-xl bg-yellow-500/10 text-yellow-650 dark:text-yellow-400 border border-yellow-500/20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        </div>
        <div>
            <div class="text-[10px] text-slate-500 dark:text-gray-500 font-bold uppercase tracking-wider mb-0.5">Total Reports</div>
            <div class="text-2xl font-black text-slate-900 dark:text-white leading-none font-display">{{ number_format($totalLaporan, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Stat 2: Bencana Aktif -->
    <div class="card-glass rounded-2xl p-5 stat-card flex items-center space-x-4">
        <div class="p-3.5 rounded-xl bg-red-500/10 text-red-600 dark:text-red-400 border border-red-500/20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <div>
            <div class="text-[10px] text-slate-500 dark:text-gray-500 font-bold uppercase tracking-wider mb-0.5">Active Disasters</div>
            <div class="text-2xl font-black text-slate-900 dark:text-white leading-none font-display">{{ number_format($activeDisasters, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Stat 3: Korban Terdampak -->
    <div class="card-glass rounded-2xl p-5 stat-card flex items-center space-x-4">
        <div class="p-3.5 rounded-xl bg-orange-500/10 text-orange-655 dark:text-orange-400 border border-orange-500/20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        </div>
        <div>
            <div class="text-[10px] text-slate-500 dark:text-gray-500 font-bold uppercase tracking-wider mb-0.5">Victims Affected</div>
            <div class="text-2xl font-black text-slate-900 dark:text-white leading-none font-display">{{ number_format($totalKorban, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Stat 4: Relawan Aktif -->
    <div class="card-glass rounded-2xl p-5 stat-card flex items-center space-x-4">
        <div class="p-3.5 rounded-xl bg-green-500/10 text-green-600 dark:text-green-400 border border-green-500/20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        </div>
        <div>
            <div class="text-[10px] text-slate-500 dark:text-gray-500 font-bold uppercase tracking-wider mb-0.5">Active Volunteers</div>
            <div class="text-2xl font-black text-slate-900 dark:text-white leading-none font-display">{{ number_format($totalRelawan, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Stat 5: Donasi Diterima -->
    <div class="card-glass rounded-2xl p-5 stat-card flex items-center space-x-4">
        <div class="p-3.5 rounded-xl bg-teal-500/10 text-teal-600 dark:text-teal-400 border border-teal-500/20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <div class="text-[10px] text-slate-500 dark:text-gray-500 font-bold uppercase tracking-wider mb-0.5">Donations Received</div>
            <div class="text-xl font-black text-slate-900 dark:text-white leading-none font-display">Rp {{ number_format($totalDonasi, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Stat 6: Status Distribusi -->
    <div class="card-glass rounded-2xl p-5 stat-card flex items-center space-x-4">
        <div class="p-3.5 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-500/20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
        </div>
        <div>
            <div class="text-[10px] text-slate-500 dark:text-gray-500 font-bold uppercase tracking-wider mb-0.5">Distribution Status</div>
            <div class="text-2xl font-black text-slate-900 dark:text-white leading-none font-display">{{ number_format($totalDistribusi, 0, ',', '.') }} <span class="text-xs text-slate-500 dark:text-gray-400 font-normal">Penyaluran</span></div>
        </div>
    </div>

    <!-- Stat 7: Wilayah Kritis -->
    <div class="card-glass rounded-2xl p-5 stat-card flex items-center space-x-4">
        <div class="p-3.5 rounded-xl bg-purple-500/10 text-purple-600 dark:text-purple-400 border border-purple-500/20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        </div>
        <div>
            <div class="text-[10px] text-slate-500 dark:text-gray-500 font-bold uppercase tracking-wider mb-0.5">Critical Regions</div>
            <div class="text-2xl font-black text-slate-900 dark:text-white leading-none font-display">
                @php $crit = $topPriorities->where('level', 'Kritis')->count(); @endphp
                {{ $crit > 0 ? $crit : 1 }} <span class="text-xs text-red-650 dark:text-red-400 font-normal">Zona Kritis</span>
            </div>
        </div>
    </div>

    <!-- Stat 8: Waktu Respons -->
    <div class="card-glass rounded-2xl p-5 stat-card flex items-center space-x-4">
        <div class="p-3.5 rounded-xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <div class="text-[10px] text-slate-500 dark:text-gray-500 font-bold uppercase tracking-wider mb-0.5">Response Time</div>
            <div class="text-2xl font-black text-slate-900 dark:text-white leading-none font-display">24.5 <span class="text-xs text-indigo-650 dark:text-indigo-400 font-normal">Menit</span></div>
        </div>
    </div>
</div>

<!-- Main Grid Layout -->
<div class="flex flex-col xl:flex-row gap-5 pb-10">
    <!-- Left Column: Map & Chart -->
    <div class="flex flex-col gap-5 w-full xl:w-[45%]">
        <!-- Peta Sebaran Bencana -->
        <div class="card-glass rounded-2xl overflow-hidden flex flex-col min-h-[350px]">
            <div class="p-4 border-b border-slate-200 dark:border-white/5 flex justify-between items-center bg-slate-50 dark:bg-white/[0.02]">
                <div class="flex items-center space-x-3">
                    <h3 class="font-bold text-slate-800 dark:text-white font-display">GIS Bencana Live Map</h3>
                </div>
                <!-- Legend -->
                <div class="bg-slate-100 dark:bg-black/40 border border-slate-200 dark:border-white/10 rounded-lg p-2 text-[9px] flex items-center space-x-3 text-slate-750 dark:text-slate-300">
                    <div class="flex items-center"><div class="w-2 h-2 rounded-full bg-red-500 mr-1.5 shadow-[0_0_5px_rgba(239,68,68,0.8)]"></div>Critical</div>
                    <div class="flex items-center"><div class="w-2 h-2 rounded-full bg-orange-500 mr-1.5"></div>High</div>
                    <div class="flex items-center"><div class="w-2 h-2 rounded-full bg-yellow-400 mr-1.5"></div>Medium</div>
                    <div class="flex items-center"><div class="w-2 h-2 rounded-full bg-green-500 mr-1.5"></div>Low</div>
                </div>
            </div>
            <div id="main-map" class="w-full flex-1 z-0 min-h-[300px]" style="background: #f8fafc;"></div>
        </div>

        <!-- Statistik Laporan -->
        <div class="card-glass rounded-2xl p-5 h-64 flex flex-col justify-between">
            <div class="flex justify-between items-center mb-3">
                <h3 class="font-bold text-slate-800 dark:text-white font-display">Statistik Tren Laporan (7 Hari Terakhir)</h3>
                <span class="text-[9px] uppercase tracking-wider font-bold px-2.5 py-1 bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-full text-slate-500 dark:text-gray-400">7 Hari</span>
            </div>
            <div class="flex-1 relative w-full h-full">
                <canvas id="reportsChart" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>

    <!-- Middle Column: Recent Reports & Urgent Needs -->
    <div class="flex flex-col gap-5 w-full xl:w-[30%]">
        <!-- Laporan Terbaru -->
        <div class="card-glass rounded-2xl p-5 flex flex-col h-[350px]">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-slate-800 dark:text-white font-display">Laporan Terbaru</h3>
                <a href="{{ route('admin.laporan') }}" class="text-xs font-semibold text-red-650 dark:text-yellow-505 hover:text-red-750 dark:hover:text-yellow-400">Lihat Semua</a>
            </div>
            <div class="flex-1 overflow-y-auto pr-2 space-y-4 sidebar-scroll">
                @forelse($latestReports as $report)
                <div class="flex items-start space-x-3 group cursor-pointer pb-3 {{ !$loop->last ? 'border-b border-slate-100 dark:border-white/5' : '' }}">
                    <div class="w-12 h-12 bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-lg overflow-hidden shrink-0 flex items-center justify-center text-slate-500 group-hover:border-red-500/20 dark:group-hover:border-yellow-500/20 group-hover:text-red-600 dark:group-hover:text-yellow-400 transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start">
                            <span class="text-[9px] font-bold text-red-650 dark:text-yellow-400 bg-red-100 dark:bg-yellow-500/10 px-1.5 py-0.5 rounded uppercase tracking-wider">{{ $report->jenis_bencana }}</span>
                            <span class="text-[9px] text-slate-400 dark:text-gray-500">{{ $report->created_at->diffForHumans() }}</span>
                        </div>
                        <h4 class="text-xs font-bold text-slate-800 dark:text-white mt-1.5 truncate group-hover:text-red-600 dark:group-hover:text-yellow-500 transition-colors">{{ Str::limit($report->deskripsi_kondisi, 40) }}</h4>
                        <div class="flex justify-between items-center mt-1">
                            <div class="flex items-center text-[10px] text-slate-400 dark:text-gray-500">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                <span class="truncate w-32">{{ $report->alamat_lengkap ?? 'Lokasi tidak diketahui' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center text-xs text-slate-500 py-10">Belum ada laporan baru.</div>
                @endforelse
            </div>
        </div>

        <!-- Kebutuhan Mendesak -->
        <div class="card-glass rounded-2xl p-5 h-64 flex flex-col">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-slate-800 dark:text-white font-display">Kebutuhan Mendesak Posko</h3>
            </div>
            <div class="flex-1 space-y-4 overflow-y-auto pr-2 sidebar-scroll">
                @forelse($urgentNeeds as $need)
                @php
                    $percent = $need->quantity > 0 ? min(100, round(($need->quantity_fulfilled ?? 0) / $need->quantity * 100)) : 0;
                @endphp
                <div>
                    <div class="flex justify-between items-end mb-1">
                        <div class="flex items-center space-x-2">
                            <div class="bg-orange-500/10 border border-orange-500/20 p-1.5 rounded text-orange-655 dark:text-orange-400"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg></div>
                            <div>
                                <div class="text-xs font-bold text-slate-800 dark:text-white">{{ $need->item_name }}</div>
                                <div class="text-[9px] text-gray-500">Kebutuhan: {{ $need->quantity }} &bull; Terkumpul: {{ $need->quantity_fulfilled ?? 0 }}</div>
                            </div>
                        </div>
                        <div class="text-xs font-bold text-orange-400">{{ $percent }}%</div>
                    </div>
                    <div class="w-full bg-white/5 border border-white/5 rounded-full h-1.5">
                        <div class="bg-orange-500 h-1.5 rounded-full" style="width: {{ $percent }}%"></div>
                    </div>
                </div>
                @empty
                <div class="text-center text-xs text-gray-500 py-6">Kebutuhan terpenuhi.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Right Column: Priority, Volunteers, Notifications -->
    <div class="flex flex-col gap-5 w-full xl:w-[25%]">
        <!-- Prioritas Tertinggi -->
        <div class="card-glass rounded-2xl p-5 h-[200px] flex flex-col">
            <div class="flex justify-between items-center mb-3">
                <h3 class="font-bold text-slate-800 dark:text-white font-display">Prioritas Penanganan</h3>
            </div>
            <div class="flex-1 overflow-y-auto space-y-3 sidebar-scroll pr-1">
                @forelse($topPriorities as $priority)
                <div class="flex items-center justify-between p-2 hover:bg-slate-50 dark:hover:bg-white/5 rounded-lg cursor-pointer transition-colors border border-transparent hover:border-slate-100 dark:hover:border-white/5">
                    <div class="flex items-center space-x-3 min-w-0">
                        <div class="{{ $priority->level == 'Kritis' ? 'bg-red-500/10 text-red-650 dark:text-red-400 border-red-500/20' : 'bg-orange-500/10 text-orange-655 dark:text-orange-400 border-orange-500/20' }} p-1.5 rounded border">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-slate-800 dark:text-white leading-tight truncate w-24">{{ $priority->report->alamat_lengkap ?? 'Lokasi' }}</div>
                            <div class="text-[9px] text-slate-500 dark:text-gray-500 truncate w-24">{{ $priority->report->jenis_bencana }}</div>
                        </div>
                    </div>
                    <div class="text-right shrink-0">
                        <div class="text-[9px] text-slate-500 dark:text-gray-500">Skor <span class="font-bold text-slate-850 dark:text-white">{{ $priority->score }}</span></div>
                        <div class="text-[8px] font-bold {{ $priority->level == 'Kritis' ? 'text-red-600 dark:text-red-400 bg-red-100 dark:bg-red-500/20 border-red-200 dark:border-red-500/20' : 'text-orange-655 dark:text-orange-400 bg-orange-100 dark:bg-orange-500/20 border-orange-200 dark:border-orange-500/20' }} px-1 rounded mt-0.5 inline-block border">{{ $priority->level }}</div>
                    </div>
                </div>
                @empty
                <div class="text-center text-xs text-slate-550 py-6">Tidak ada status prioritas.</div>
                @endforelse
            </div>
        </div>

        <!-- Notifikasi & Donasi (Split half-half) -->
        <div class="flex flex-col gap-5 flex-1 min-h-0">
            <!-- Notifikasi Real-Time -->
            <div class="card-glass rounded-2xl p-4 flex-1 flex flex-col h-[200px]">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-bold text-slate-800 dark:text-white text-xs uppercase tracking-wider font-display">Notifikasi</h3>
                </div>
                <div class="flex-1 overflow-y-auto space-y-3 sidebar-scroll">
                    @foreach($notifications as $notif)
                    <div class="flex items-start space-x-2 pb-2 border-b border-slate-100 dark:border-white/5">
                        <div class="bg-yellow-500/10 border border-yellow-500/20 p-1.5 rounded-full text-yellow-600 dark:text-yellow-400 shrink-0 mt-0.5"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg></div>
                        <div class="flex-1">
                            <div class="text-[10px] font-semibold text-slate-700 dark:text-gray-300 leading-tight">{{ $notif->content }}</div>
                            <div class="text-[8px] text-slate-450 dark:text-gray-500 mt-0.5">{{ $notif->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Donasi Terbaru -->
            <div class="card-glass rounded-2xl p-4 flex-1 flex flex-col h-[200px]">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-bold text-slate-800 dark:text-white text-xs uppercase tracking-wider font-display">Donasi Terbaru</h3>
                </div>
                <div class="flex-1 overflow-y-auto space-y-3 sidebar-scroll">
                    @foreach($latestDonations as $donation)
                    <div class="flex justify-between items-center pb-2 border-b border-slate-100 dark:border-white/5">
                        <div class="flex items-center space-x-2">
                            <img src="https://ui-avatars.com/api/?name={{ $donation->user ? urlencode($donation->user->name) : 'Anonim' }}&background=E8C547&color=000&bold=true" class="w-6 h-6 rounded-full border border-slate-200 dark:border-white/10">
                            <div>
                                <div class="text-[10px] font-bold text-slate-700 dark:text-gray-300">{{ $donation->user->name ?? 'Anonim' }}</div>
                                <div class="text-[8px] text-slate-450 dark:text-gray-500">{{ $donation->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <div class="text-[10px] font-black text-green-600 dark:text-green-400">Rp {{ number_format($donation->amount, 0, ',', '.') }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Map
        const map = L.map('main-map', {
            zoomControl: false,
            attributionControl: false
        }).setView([-6.914744, 107.609810], 9);
        
        L.control.zoom({ position: 'topleft' }).addTo(map);

        // Dynamic light/dark tile layers
        const lightTile = L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            maxZoom: 19
        });
        const darkTile = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            maxZoom: 19
        });

        // Set initial tile layer based on root class state
        const isDark = document.documentElement.classList.contains('dark');
        if (isDark) {
            darkTile.addTo(map);
        } else {
            lightTile.addTo(map);
        }

        // Live watch for theme switching changes to swap tiles reactively
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.attributeName === 'class') {
                    const currentlyDark = document.documentElement.classList.contains('dark');
                    if (currentlyDark) {
                        map.removeLayer(lightTile);
                        darkTile.addTo(map);
                    } else {
                        map.removeLayer(darkTile);
                        lightTile.addTo(map);
                    }
                }
            });
        });
        observer.observe(document.documentElement, { attributes: true });

        // Map Markers Data
        const markers = @json($mapMarkers);

        markers.forEach(m => {
            let color = m.type === 'critical' ? '#EF4444' : 
                        (m.type === 'high' ? '#F97316' : 
                        (m.type === 'medium' ? '#FACC15' : '#22C55E'));
            
            const iconHtml = `
                <div class="relative flex items-center justify-center w-8 h-8">
                    <div class="absolute inset-0 rounded-full opacity-40 animate-ping" style="background-color: ${color}"></div>
                    <div class="relative z-10 w-6 h-6 rounded-full flex items-center justify-center text-white text-[10px] font-bold shadow-lg" style="background-color: ${color}">
                        ${m.count}
                    </div>
                </div>
            `;
            
            const icon = L.divIcon({
                html: iconHtml,
                className: '',
                iconSize: [32, 32],
                iconAnchor: [16, 16]
            });

            L.marker([m.lat, m.lng], {icon: icon})
             .bindTooltip(m.title, {direction: 'top'})
             .addTo(map);
        });

        // Initialize Chart Data
        const chartLabels = @json($chartLabels);
        const chartDataArray = @json($chartData);

        const ctx = document.getElementById('reportsChart').getContext('2d');
        
        let gradient = ctx.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(232, 197, 71, 0.25)');
        gradient.addColorStop(1, 'rgba(232, 197, 71, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Laporan',
                    data: chartDataArray,
                    borderColor: '#E8C547',
                    backgroundColor: gradient,
                    borderWidth: 2,
                    pointBackgroundColor: '#E8C547',
                    pointBorderColor: '#000',
                    pointBorderWidth: 1.5,
                    pointRadius: 3.5,
                    pointHoverRadius: 5.5,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#9CA3AF', font: { size: 9 } },
                        border: { display: false },
                        grid: { color: 'rgba(255,255,255,0.05)', drawBorder: false }
                    },
                    x: {
                        ticks: { color: '#9CA3AF', font: { size: 9 } },
                        border: { display: false },
                        grid: { display: false }
                    }
                },
                interaction: { intersect: false, mode: 'index' }
            }
        });
    });
</script>
@endpush
@endsection
