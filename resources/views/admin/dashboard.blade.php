@extends('layouts.admin')

@section('content')
<!-- Top Summary Cards & Action -->
<div class="flex flex-col lg:flex-row justify-between items-start mb-6 gap-6">
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 flex-1 w-full">
        <!-- Card 1 -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] flex items-center space-x-4">
            <div class="bg-green-100 p-3 rounded-xl text-green-700">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <div class="text-[11px] text-gray-500 font-semibold uppercase tracking-wider mb-0.5">Laporan Bencana</div>
                <div class="text-2xl font-bold text-gray-900 leading-none">{{ number_format($totalLaporan, 0, ',', '.') }}</div>
            </div>
        </div>
        <!-- Card 2 -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] flex items-center space-x-4">
            <div class="bg-emerald-50 p-3 rounded-xl text-emerald-600">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div>
                <div class="text-[11px] text-gray-500 font-semibold uppercase tracking-wider mb-0.5">Korban Terdampak</div>
                <div class="text-2xl font-bold text-gray-900 leading-none">{{ number_format($totalKorban, 0, ',', '.') }}</div>
            </div>
        </div>
        <!-- Card 3 -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] flex items-center space-x-4">
            <div class="bg-teal-50 p-3 rounded-xl text-teal-600">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
            <div>
                <div class="text-[11px] text-gray-500 font-semibold uppercase tracking-wider mb-0.5">Bantuan Disalurkan</div>
                <div class="text-2xl font-bold text-gray-900 leading-none">{{ number_format($totalDistribusi, 0, ',', '.') }}</div>
            </div>
        </div>
        <!-- Card 4 -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] flex items-center space-x-4">
            <div class="bg-green-50 p-3 rounded-xl text-green-600">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <div class="text-[11px] text-gray-500 font-semibold uppercase tracking-wider mb-0.5">Relawan Aktif</div>
                <div class="text-2xl font-bold text-gray-900 leading-none">{{ number_format($totalRelawan, 0, ',', '.') }}</div>
            </div>
        </div>
        <!-- Card 5 -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] flex items-center space-x-4">
            <div class="bg-red-50 p-3 rounded-xl text-red-500">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path></svg>
            </div>
            <div>
                <div class="text-[11px] text-gray-500 font-semibold uppercase tracking-wider mb-0.5">Donasi Terkumpul</div>
                <div class="text-xl font-bold text-gray-900 leading-none">Rp {{ number_format($totalDonasi, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Main Grid Layout -->
<div class="flex flex-col xl:flex-row gap-5 h-auto xl:h-[calc(100vh-230px)] pb-10">
    <!-- Left Column: Map & Chart -->
    <div class="flex flex-col gap-5 w-full xl:w-[45%] h-full">
        <!-- Peta Sebaran Bencana -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] overflow-hidden flex-1 relative flex flex-col min-h-[350px]">
            <div class="p-4 border-b border-gray-50 flex justify-between items-center z-10 bg-white">
                <div class="flex items-center space-x-3">
                    <h3 class="font-bold text-gray-800">Peta Sebaran Bencana</h3>
                    <div class="flex items-center space-x-1.5 bg-green-50 px-2 py-0.5 rounded-full border border-green-100">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        <span class="text-[10px] font-bold text-green-600">Live</span>
                    </div>
                </div>
                <!-- Legend -->
                <div class="bg-white border border-gray-100 rounded-lg p-2 text-[10px] flex items-center space-x-3">
                    <div class="flex items-center"><div class="w-2 h-2 rounded-full bg-red-500 mr-1.5 shadow-[0_0_5px_rgba(239,68,68,0.8)]"></div>Critical</div>
                    <div class="flex items-center"><div class="w-2 h-2 rounded-full bg-orange-500 mr-1.5"></div>High</div>
                    <div class="flex items-center"><div class="w-2 h-2 rounded-full bg-yellow-400 mr-1.5"></div>Medium</div>
                    <div class="flex items-center"><div class="w-2 h-2 rounded-full bg-green-500 mr-1.5"></div>Low</div>
                </div>
            </div>
            <div id="main-map" class="w-full flex-1 z-0 min-h-[300px]"></div>
        </div>

        <!-- Statistik Laporan -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] p-5 h-64 flex flex-col flex-shrink-0">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-gray-800">Statistik Laporan</h3>
                <select class="text-xs border border-gray-200 rounded-lg text-gray-500 bg-gray-50 py-1 pl-2 pr-6 focus:outline-none">
                    <option>7 Hari Terakhir</option>
                </select>
            </div>
            <div class="flex-1 relative w-full flex items-end">
                <canvas id="reportsChart" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>

    <!-- Middle Column: Recent Reports & Urgent Needs -->
    <div class="flex flex-col gap-5 w-full xl:w-[30%] h-full">
        <!-- Laporan Terbaru -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] p-5 flex-1 flex flex-col overflow-hidden min-h-[300px]">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-gray-800">Laporan Terbaru</h3>
                <a href="#" class="text-xs font-semibold text-green-600 hover:text-green-700">Lihat Semua</a>
            </div>
            <div class="flex-1 overflow-y-auto pr-2 space-y-4 sidebar-scroll">
                @forelse($latestReports as $report)
                <div class="flex items-start space-x-3 group cursor-pointer pb-3 {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg overflow-hidden shrink-0 flex items-center justify-center text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start">
                            <span class="text-[9px] font-bold text-blue-600 bg-blue-50 px-1.5 py-0.5 rounded text-uppercase tracking-wider">{{ $report->jenis_bencana }}</span>
                            <span class="text-[9px] text-gray-400">{{ $report->created_at->diffForHumans() }}</span>
                        </div>
                        <h4 class="text-sm font-bold text-gray-900 mt-1 truncate group-hover:text-green-700 transition-colors">{{ Str::limit($report->deskripsi_kondisi, 40) }}</h4>
                        <div class="flex justify-between items-center mt-1">
                            <div class="flex items-center text-[10px] text-gray-500">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                <span class="truncate w-32">{{ $report->alamat_lengkap ?? 'Lokasi tidak diketahui' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center text-sm text-gray-400 py-10">Belum ada laporan baru.</div>
                @endforelse
            </div>
        </div>

        <!-- Kebutuhan Mendesak -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] p-5 h-64 flex flex-col flex-shrink-0">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-gray-800">Kebutuhan Mendesak</h3>
            </div>
            <div class="flex-1 space-y-4 overflow-y-auto pr-2 sidebar-scroll">
                @forelse($urgentNeeds as $need)
                @php
                    $percent = $need->quantity > 0 ? min(100, round(($need->quantity_fulfilled ?? 0) / $need->quantity * 100)) : 0;
                @endphp
                <div>
                    <div class="flex justify-between items-end mb-1">
                        <div class="flex items-center space-x-2">
                            <div class="bg-orange-100 p-1.5 rounded text-orange-600"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg></div>
                            <div>
                                <div class="text-xs font-bold text-gray-900">{{ $need->item_name }}</div>
                                <div class="text-[9px] text-gray-500">Kebutuhan: {{ $need->quantity }} &bull; Terkumpul: {{ $need->quantity_fulfilled ?? 0 }}</div>
                            </div>
                        </div>
                        <div class="text-xs font-bold text-gray-800">{{ $percent }}%</div>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ $percent }}%"></div>
                    </div>
                </div>
                @empty
                <div class="text-center text-sm text-gray-400 py-6">Kebutuhan terpenuhi.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Right Column: Priority, Volunteers, Notifications -->
    <div class="flex flex-col gap-5 w-full xl:w-[25%] h-full">
        <!-- Prioritas Tertinggi -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] p-5 flex-1 overflow-hidden flex flex-col min-h-[250px]">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-gray-800">Prioritas Tertinggi</h3>
            </div>
            <div class="flex-1 overflow-y-auto space-y-3 sidebar-scroll pr-1">
                @forelse($topPriorities as $priority)
                <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg cursor-pointer transition-colors border border-transparent hover:border-gray-100">
                    <div class="flex items-center space-x-3">
                        <div class="{{ $priority->level == 'Kritis' ? 'bg-red-100 text-red-600' : 'bg-orange-100 text-orange-600' }} p-2 rounded-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-gray-900 leading-tight truncate w-24">{{ $priority->report->alamat_lengkap ?? 'Lokasi' }}</div>
                            <div class="text-[10px] text-gray-500 truncate w-24">{{ $priority->report->jenis_bencana }}</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-[10px] text-gray-500">Skor <span class="font-bold text-gray-900">{{ $priority->score }}</span></div>
                        <div class="text-[9px] font-bold {{ $priority->level == 'Kritis' ? 'text-red-500 bg-red-50' : 'text-orange-500 bg-orange-50' }} px-1.5 py-0.5 rounded mt-0.5 inline-block">{{ $priority->level }}</div>
                    </div>
                </div>
                @empty
                <div class="text-center text-sm text-gray-400 py-6">Tidak ada status prioritas.</div>
                @endforelse
            </div>
        </div>

        <!-- Notifikasi & Donasi (Split half-half) -->
        <div class="flex flex-col gap-5 flex-1 min-h-0">
            <!-- Notifikasi Real-Time -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] p-4 flex-1 flex flex-col overflow-hidden">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-bold text-gray-800 text-sm">Notifikasi</h3>
                </div>
                <div class="flex-1 overflow-y-auto space-y-3 sidebar-scroll">
                    @foreach($notifications as $notif)
                    <div class="flex items-start space-x-2">
                        <div class="bg-green-50 p-1.5 rounded-full text-green-500 shrink-0 mt-0.5"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg></div>
                        <div class="flex-1">
                            <div class="text-[10px] font-semibold text-gray-800 leading-tight">{{ $notif->content }}</div>
                            <div class="text-[9px] text-gray-400 mt-0.5">{{ $notif->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Donasi Terbaru -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] p-4 flex-1 flex flex-col overflow-hidden">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-bold text-gray-800 text-sm">Donasi Terbaru</h3>
                </div>
                <div class="flex-1 overflow-y-auto space-y-3 sidebar-scroll">
                    @foreach($latestDonations as $donation)
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-2">
                            <img src="https://ui-avatars.com/api/?name={{ $donation->user ? urlencode($donation->user->name) : 'Anonim' }}&background=f3f4f6" class="w-6 h-6 rounded-full">
                            <div>
                                <div class="text-[10px] font-bold text-gray-800">{{ $donation->user->name ?? 'Anonim' }}</div>
                                <div class="text-[8px] text-gray-400">{{ $donation->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <div class="text-[10px] font-bold text-gray-900">Rp {{ number_format($donation->amount, 0, ',', '.') }}</div>
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

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            maxZoom: 19
        }).addTo(map);

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
        
        let gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(34, 197, 94, 0.2)');
        gradient.addColorStop(1, 'rgba(34, 197, 94, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Laporan',
                    data: chartDataArray,
                    borderColor: '#22C55E',
                    backgroundColor: gradient,
                    borderWidth: 2,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#22C55E',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
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
                        ticks: { color: '#9CA3AF', font: { size: 10 } },
                        border: { display: false },
                        grid: { color: '#F3F4F6', drawBorder: false }
                    },
                    x: {
                        ticks: { color: '#9CA3AF', font: { size: 10 } },
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
