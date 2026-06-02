@extends('layouts.dashboard')

@section('title', 'Volunteer Dashboard')
@section('role', 'Relawan')
@section('page_title', 'Dashboard Relawan')

@section('head')
    <!-- Leaflet Maps CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        .map-container {
            height: 250px;
            border-radius: 1rem;
            z-index: 10;
        }
    </style>
@endsection

@section('header_actions')
    <div class="flex items-center gap-2 px-4 py-1.5 glass-panel rounded-full border border-green-500/30 bg-green-50/50 dark:bg-green-900/20">
        <div class="w-2.5 h-2.5 rounded-full bg-green-500 shadow-[0_0_8px_#22c55e] animate-pulse"></div>
        <span class="text-xs font-bold text-green-600 dark:text-green-400 uppercase tracking-wider">
            {{ ($volApp && $volApp->availability_status === 'Siap Bertugas') ? 'Siap Bertugas' : 'Tidak Tersedia' }}
        </span>
    </div>
@endsection

@section('content')

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="mb-5 p-4 rounded-2xl bg-green-500/10 border border-green-500/20 text-green-600 dark:text-green-400 flex items-center gap-3">
        <i class="fas fa-check-circle text-lg"></i>
        <span class="text-sm font-semibold">{{ session('success') }}</span>
    </div>
    @endif
    @if(session('error'))
    <div class="mb-5 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-600 dark:text-red-400 flex items-center gap-3">
        <i class="fas fa-exclamation-circle text-lg"></i>
        <span class="text-sm font-semibold">{{ session('error') }}</span>
    </div>
    @endif

    {{-- 1. Direct Messages / Notifications --}}
    @if($myNotifications->isNotEmpty())
    <div class="mb-6 space-y-3">
        @foreach($myNotifications->take(3) as $noti)
        <div class="p-4 rounded-2xl bg-blue-500/10 border border-blue-500/20 text-slate-900 dark:text-white flex items-center justify-between gap-4 shadow-sm animate-fade-in">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-500">
                    <i class="fas fa-bell"></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $noti->content }}</p>
                    <p class="text-[10px] text-slate-500 dark:text-slate-400">{{ $noti->created_at->diffForHumans() }}</p>
                </div>
            </div>
            <button onclick="this.parentElement.remove()" class="text-slate-400 hover:text-slate-600 dark:hover:text-white"><i class="fas fa-times"></i></button>
        </div>
        @endforeach
    </div>
    @endif

    {{-- 2. Profile Incomplete Alert --}}
    @if($profileIncomplete)
    <div class="mb-8 p-6 rounded-3xl bg-amber-500/10 border border-amber-500/20 text-slate-900 dark:text-white relative overflow-hidden shadow-lg animate-pulse">
        <div class="absolute -right-10 -top-10 w-32 h-32 bg-amber-500/5 rounded-full blur-2xl"></div>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-500/20 flex items-center justify-center text-amber-500 flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-black font-display text-amber-600 dark:text-amber-400">Profil Belum Lengkap!</h4>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                        Sebelum dapat menerima tugas bantuan, silakan isi nomor telepon, domisili, dan wilayah operasi Anda terlebih dahulu.
                    </p>
                </div>
            </div>
            <button onclick="document.getElementById('profile-modal').classList.remove('hidden')" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-slate-950 text-sm font-bold rounded-xl shadow-lg transition-all flex-shrink-0">
                <i class="fas fa-edit mr-1"></i> Lengkapi Profil
            </button>
        </div>
    </div>
    @endif

    <!-- Profile Overview Card -->
    @php
        $team = $volApp ? $volApp->preferred_team : 'Relawan Umum';
        $level = 'Pemula';
        
        if ($completedTasks >= 10) $level = 'Koordinator';
        elseif ($completedTasks >= 5) $level = 'Senior';
        elseif ($completedTasks >= 2) $level = 'Aktif';

        // Contribution Stats Calculations
        $sumVictims = $myTasks->where('status', 'Completed')->sum('victims_helped');
        $sumAid = $myTasks->where('status', 'Completed')->sum('aid_delivered_qty');
        $sumHours = 0;
        foreach($myTasks->where('status', 'Completed') as $t) {
            if ($t->started_at && $t->completed_at) {
                $diff = \Carbon\Carbon::parse($t->started_at)->diffInHours(\Carbon\Carbon::parse($t->completed_at));
                $sumHours += max(1, round($diff));
            } else {
                $sumHours += 8;
            }
        }
    @endphp

    <div class="glass-panel rounded-3xl p-6 md:p-8 mb-8 relative overflow-hidden flex flex-col md:flex-row items-center gap-6 shadow-lg border border-slate-200 dark:border-slate-800">
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-blue-500/5 rounded-full blur-3xl"></div>
        
        <div class="w-24 h-24 rounded-full bg-slate-200 dark:bg-slate-800 flex items-center justify-center flex-shrink-0 border-4 border-white dark:border-slate-900 shadow-xl overflow-hidden relative z-10">
            <span class="text-3xl font-black text-slate-400 dark:text-slate-600">{{ substr(auth()->user()->name, 0, 1) }}</span>
        </div>
        
        <div class="flex-1 text-center md:text-left relative z-10">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-black text-slate-900 dark:text-white font-display">{{ auth()->user()->name }}</h2>
                    <p class="text-slate-500 text-sm mb-4">{{ auth()->user()->email }}</p>
                </div>
                <!-- Availability Status Selector -->
                <div class="flex items-center gap-2 justify-center md:justify-end">
                    <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Status:</span>
                    <form method="POST" action="{{ route('center.volunteer.availability.toggle') }}">
                        @csrf
                        <select name="availability_status" onchange="this.form.submit()" class="px-3 py-1.5 rounded-xl text-xs font-bold bg-white/50 dark:bg-white/5 border border-slate-200 dark:border-white/10 text-slate-800 dark:text-slate-200 focus:outline-none cursor-pointer">
                            <option value="Siap Bertugas" {{ ($volApp && $volApp->availability_status === 'Siap Bertugas') ? 'selected' : '' }}>🟢 Siap Bertugas</option>
                            <option value="Tidak Tersedia" {{ ($volApp && $volApp->availability_status === 'Tidak Tersedia') ? 'selected' : '' }}>🔴 Tidak Tersedia</option>
                        </select>
                    </form>
                </div>
            </div>
            
            <div class="flex flex-wrap items-center justify-center md:justify-start gap-4">
                <div class="px-4 py-2 rounded-xl bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/50 flex items-center gap-2">
                    <i class="fas fa-users text-blue-500"></i>
                    <span class="text-xs font-bold text-blue-700 dark:text-blue-400">Tim: {{ $team ?? 'Umum' }}</span>
                </div>
                <div class="px-4 py-2 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800/50 flex items-center gap-2">
                    <i class="fas fa-medal text-amber-500"></i>
                    <span class="text-xs font-bold text-amber-700 dark:text-amber-400">Level: {{ $level }}</span>
                </div>
                <div class="px-4 py-2 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800/50 flex items-center gap-2">
                    <i class="fas fa-clock text-emerald-500"></i>
                    <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400">Total Kontribusi: {{ $sumHours }} Jam</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Misi Aktif -->
        <div class="glass-panel rounded-2xl p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Misi Aktif</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1">{{ $activeTasks }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center text-blue-500">
                    <i class="fas fa-running text-xl"></i>
                </div>
            </div>
            <div class="text-xs text-blue-600 dark:text-blue-400 font-semibold flex items-center gap-1">
                <i class="fas fa-map-marker-alt"></i> Sedang Berjalan
            </div>
        </div>

        <!-- Misi Selesai -->
        <div class="glass-panel rounded-2xl p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Misi Selesai</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1">{{ $completedTasks }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-green-50 dark:bg-green-500/10 flex items-center justify-center text-green-500">
                    <i class="fas fa-check-double text-xl"></i>
                </div>
            </div>
            <div class="text-xs text-green-600 dark:text-green-400 font-semibold flex items-center gap-1">
                <i class="fas fa-star"></i>
                {{ $level }} Relawan
            </div>
        </div>

        <!-- Bantuan Tersalurkan -->
        <div class="glass-panel rounded-2xl p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Bantuan Tersalurkan</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1">{{ number_format($sumAid) }} Paket</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center text-indigo-500">
                    <i class="fas fa-box text-xl"></i>
                </div>
            </div>
            <div class="text-xs text-indigo-600 dark:text-indigo-400 font-semibold flex items-center gap-1">
                <i class="fas fa-hand-holding-heart"></i> Total Logistik Didistribusikan
            </div>
        </div>

        <!-- Korban Terbantu -->
        <div class="glass-panel rounded-2xl p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Korban Terbantu</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1">{{ number_format($sumVictims) }} Jiwa</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                    <i class="fas fa-heart text-xl"></i>
                </div>
            </div>
            <div class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold flex items-center gap-1">
                <i class="fas fa-smile"></i> Warga Terdampak Terbantu
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Tasks Queue & Available Missions -->
        <div class="lg:col-span-2 space-y-8">
            
            {{-- Antrean Penugasan Relawan --}}
            <div class="glass-panel rounded-3xl p-6 md:p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Penugasan Aktif Saya</h3>
                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-blue-100 dark:bg-blue-500/10 text-blue-700 dark:text-blue-400">
                        {{ $activeTasks }} Tugas
                    </span>
                </div>

                <div class="space-y-6">
                    @forelse($myTasks->whereIn('status', ['Requested', 'Assigned', 'On The Way', 'On Site']) as $task)
                    <div class="p-6 rounded-2xl bg-white/60 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 shadow-sm relative overflow-hidden">
                        {{-- Side Indicator Color --}}
                        <div class="absolute left-0 top-0 bottom-0 w-1.5
                            @if($task->status === 'Requested') bg-orange-400
                            @elseif($task->status === 'Assigned') bg-yellow-500
                            @elseif($task->status === 'On The Way') bg-blue-500
                            @elseif($task->status === 'On Site') bg-indigo-500
                            @else bg-green-500 @endif">
                        </div>

                        <div class="pl-2">
                            {{-- Header metadata --}}
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-extrabold uppercase tracking-wider
                                        @if($task->status === 'Requested') bg-orange-100 text-orange-700 dark:bg-orange-500/20 dark:text-orange-400
                                        @elseif($task->status === 'Assigned') bg-yellow-100 text-yellow-700 dark:bg-yellow-500/20 dark:text-yellow-400
                                        @elseif($task->status === 'On The Way') bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400
                                        @elseif($task->status === 'On Site') bg-indigo-100 text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-400
                                        @else bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400 @endif">
                                        @if($task->status === 'On The Way') On The Way @elseif($task->status === 'On Site') On Site @else {{ $task->status }} @endif
                                    </span>
                                    <span class="text-xs text-slate-400">#TSK-{{ str_pad($task->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <span class="text-xs text-slate-400"><i class="fas fa-clock"></i> {{ $task->created_at->diffForHumans() }}</span>
                            </div>

                            <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-2">{{ $task->task }}</h4>
                            
                            @if($task->report)
                            <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200/50 dark:border-white/5 mb-4">
                                <p class="text-sm font-bold text-slate-700 dark:text-slate-300">{{ $task->report->jenis_bencana }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1"><i class="fas fa-map-marker-alt text-red-500 mr-1"></i> {{ $task->report->alamat_lengkap }}</p>
                                @if($task->report->deskripsi_kondisi)
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 bg-white/40 dark:bg-black/20 p-2 rounded border border-slate-100 dark:border-slate-800">{{ $task->report->deskripsi_kondisi }}</p>
                                @endif
                            </div>
                            @endif

                            {{-- STATE MACHINE FLOWS --}}
                            
                            @if($task->status === 'Requested')
                                <div class="p-4 rounded-xl bg-orange-500/10 border border-orange-500/20 text-orange-600 dark:text-orange-400 text-xs font-semibold">
                                    <i class="fas fa-hourglass-half mr-1.5 animate-spin"></i> Menunggu persetujuan admin untuk tugas ini.
                                </div>
                            @endif

                            @if($task->status === 'Assigned')
                                <div class="mt-4 flex gap-2">
                                    <form method="POST" action="{{ route('center.volunteer.task.update', $task->id) }}">
                                        @csrf
                                        <input type="hidden" name="status" value="On The Way">
                                        <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold uppercase rounded-xl transition-all shadow-lg shadow-blue-500/20">
                                            <i class="fas fa-route mr-1.5"></i> Mulai Perjalanan (On The Way)
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('center.volunteer.task.update', $task->id) }}" onsubmit="return confirm('Tolak penugasan ini?')">
                                        @csrf
                                        <input type="hidden" name="status" value="Rejected">
                                        <button type="submit" class="px-5 py-2.5 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-300 dark:hover:bg-slate-600 text-xs font-bold uppercase rounded-xl transition-all">
                                            Tolak Misi
                                        </button>
                                    </form>
                                </div>
                            @endif

                            @if($task->status === 'On The Way')
                                <!-- Interactive Navigation Map & ETA -->
                                <div class="mt-4 space-y-4">
                                    <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400 font-bold bg-blue-500/5 p-3 rounded-xl border border-blue-500/10">
                                        <span><i class="fas fa-shipping-fast text-blue-500 mr-1.5"></i> Estimasi Waktu Tempuh:</span>
                                        <span class="text-blue-600 dark:text-blue-400 font-extrabold uppercase tracking-wide">~24 Menit (ETA)</span>
                                    </div>
                                    
                                    {{-- Map Box --}}
                                    <div class="map-container border border-slate-200 dark:border-slate-700 shadow-inner" id="map-{{ $task->id }}"></div>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            var map = L.map('map-{{ $task->id }}').setView([{{ $task->report->latitude ?? -6.2088 }}, {{ $task->report->longitude ?? 106.8456 }}], 13);
                                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                                attribution: '© OpenStreetMap'
                                            }).addTo(map);

                                            var disasterIcon = L.icon({
                                                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
                                                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                                                iconSize: [25, 41],
                                                iconAnchor: [12, 41],
                                                popupAnchor: [1, -34],
                                                shadowSize: [41, 41]
                                            });
                                            L.marker([{{ $task->report->latitude ?? -6.2088 }}, {{ $task->report->longitude ?? 106.8456 }}], {icon: disasterIcon})
                                                .addTo(map)
                                                .bindPopup("<b>Posko Bencana</b><br>{{ $task->report->jenis_bencana }}")
                                                .openPopup();

                                            var volunteerIcon = L.icon({
                                                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png',
                                                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                                                iconSize: [25, 41],
                                                iconAnchor: [12, 41],
                                                popupAnchor: [1, -34],
                                                shadowSize: [41, 41]
                                            });
                                            var volLat = {{ $task->report->latitude ?? -6.2088 }} + 0.012;
                                            var volLng = {{ $task->report->longitude ?? 106.8456 }} - 0.014;
                                            L.marker([volLat, volLng], {icon: volunteerIcon})
                                                .addTo(map)
                                                .bindPopup("<b>Posisi Anda (ETA)</b>");

                                            L.polyline([[volLat, volLng], [{{ $task->report->latitude ?? -6.2088 }}, {{ $task->report->longitude ?? 106.8456 }}]], {
                                                color: '#3b82f6',
                                                weight: 4,
                                                dashArray: '5, 10'
                                            }).addTo(map);
                                        });
                                    </script>

                                    <!-- Geolocation Checkin button -->
                                    <form id="form-checkin-{{ $task->id }}" method="POST" action="{{ route('center.volunteer.task.update', $task->id) }}">
                                        @csrf
                                        <input type="hidden" name="status" value="On Site">
                                        <input type="hidden" name="checkin_lat" id="lat-{{ $task->id }}" value="">
                                        <input type="hidden" name="checkin_lng" id="lng-{{ $task->id }}" value="">
                                        <button type="button" onclick="requestCheckin({{ $task->id }})" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold uppercase rounded-xl transition-all shadow-lg shadow-indigo-500/20 w-full md:w-auto">
                                            <i class="fas fa-map-pin mr-1.5"></i> Saya Sudah Tiba (Check-In GPS)
                                        </button>
                                    </form>
                                </div>
                            @endif

                            @if($task->status === 'On Site')
                                <div class="mt-4 p-4 rounded-2xl bg-indigo-500/5 border border-indigo-500/10 space-y-6">
                                    <p class="text-xs text-indigo-600 dark:text-indigo-400 font-bold uppercase tracking-wider flex items-center gap-1.5">
                                        <i class="fas fa-check-circle"></i> Sudah Tiba di Lokasi (Check-in: {{ $task->checkin_at ? \Carbon\Carbon::parse($task->checkin_at)->format('H:i') : now()->format('H:i') }} WIB)
                                    </p>

                                    {{-- Progressive updates / completion details --}}
                                    <form method="POST" action="{{ route('center.volunteer.task.update', $task->id) }}" enctype="multipart/form-data" class="space-y-4">
                                        @csrf
                                        <input type="hidden" name="status" id="status-field-{{ $task->id }}" value="On Site">

                                        <!-- Progress Updates -->
                                        <div>
                                            <label class="text-[10px] uppercase font-bold text-slate-500 dark:text-slate-400 block mb-1">Status Progres Tugas</label>
                                            <div class="grid grid-cols-4 gap-2">
                                                @foreach([25, 50, 75, 100] as $pct)
                                                <button type="button" onclick="setProgress({{ $task->id }}, {{ $pct }})" id="btn-{{ $task->id }}-{{ $pct }}" class="py-2 text-xs font-black rounded-lg border transition-all text-center {{ ($task->progress_percent == $pct) ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white/5 border-slate-200 dark:border-white/10 text-slate-500 hover:bg-slate-100 dark:hover:bg-white/5' }}">
                                                    {{ $pct }}%
                                                </button>
                                                @endforeach
                                            </div>
                                            <input type="hidden" name="progress_percent" id="pct-input-{{ $task->id }}" value="{{ $task->progress_percent ?? 25 }}">
                                        </div>

                                        <div>
                                            <label class="text-[10px] uppercase font-bold text-slate-500 dark:text-slate-400 block mb-1">Laporan Aktivitas / Kebutuhan</label>
                                            <textarea name="progress_notes" rows="2" placeholder="Tulis catatan, misal: menyalurkan 50 paket air bersih, air surut..." class="w-full px-3 py-2 text-xs bg-white/5 border border-slate-200 dark:border-white/10 rounded-lg text-slate-800 dark:text-white focus:outline-none">{{ $task->progress_notes }}</textarea>
                                        </div>

                                        <div class="flex gap-2">
                                            <button type="submit" class="px-4 py-2 bg-indigo-600/20 text-indigo-600 dark:text-indigo-400 border border-indigo-600/30 text-xs font-bold uppercase rounded-lg hover:bg-indigo-600/30 transition-all">
                                                Simpan Progres Terkini
                                            </button>
                                        </div>

                                        <hr class="border-slate-200 dark:border-slate-800 my-4" />

                                        <h5 class="text-xs font-bold text-slate-800 dark:text-slate-300 uppercase tracking-wide mb-3"><i class="fas fa-handshake text-indigo-500 mr-1"></i> Verifikasi Penyaluran & Korban</h5>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <!-- QR Verification simulation -->
                                            <div>
                                                <label class="text-[10px] uppercase font-bold text-slate-500 dark:text-slate-400 block mb-1">Verifikasi QR Bantuan</label>
                                                <button type="button" onclick="simulateQRScan({{ $task->id }})" class="w-full py-2 bg-white/5 border border-dashed border-slate-300 dark:border-white/20 hover:border-indigo-500/50 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:text-indigo-500 dark:hover:text-indigo-400 flex items-center justify-center gap-2 transition-all">
                                                    <i class="fas fa-qrcode text-base"></i> Pindai / Scan QR Bantuan
                                                </button>
                                                <input type="hidden" name="qr_code" id="qr-input-{{ $task->id }}" value="">
                                                <p id="qr-status-{{ $task->id }}" class="text-[10px] text-slate-400 mt-1">QR belum discan</p>
                                            </div>

                                            <!-- Image upload -->
                                            <div>
                                                <label class="text-[10px] uppercase font-bold text-slate-500 dark:text-slate-400 block mb-1">Foto Bukti Penyerahan</label>
                                                <input type="file" name="verification_photo" class="w-full text-xs text-slate-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4 mt-3">
                                            <div>
                                                <label class="text-[10px] uppercase font-bold text-slate-500 dark:text-slate-400 block mb-1">Bantuan Tersalurkan (Paket)</label>
                                                <input type="number" name="aid_delivered_qty" min="0" placeholder="Contoh: 100" class="w-full px-3 py-2 text-xs bg-white/5 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-800 dark:text-white focus:outline-none">
                                            </div>
                                            <div>
                                                <label class="text-[10px] uppercase font-bold text-slate-500 dark:text-slate-400 block mb-1">Korban Terbantu (Jiwa)</label>
                                                <input type="number" name="victims_helped" min="0" placeholder="Contoh: 45" class="w-full px-3 py-2 text-xs bg-white/5 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-800 dark:text-white focus:outline-none">
                                            </div>
                                        </div>

                                        <!-- Selesaikan Tugas button -->
                                        <div class="pt-4 flex justify-end">
                                            <button type="button" onclick="submitCompleteTask({{ $task->id }})" class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-xs font-bold uppercase rounded-xl transition-all shadow-lg shadow-green-500/20">
                                                <i class="fas fa-check-double mr-1.5"></i> Selesaikan Seluruh Misi
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @endif

                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12 text-slate-400">
                        <i class="fas fa-inbox text-4xl mb-3 block text-slate-300 dark:text-slate-600"></i>
                        <p class="font-semibold">Belum ada penugasan aktif.</p>
                        <p class="text-sm mt-1 text-slate-400">Tunggu admin menugaskan misi atau silakan pilih misi di bawah ini.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- 3. Daftar Tugas Bencana Bantuan (Available Missions Queue) --}}
            <div class="glass-panel rounded-3xl p-6 md:p-8">
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Daftar Misi Kemanusiaan Terbuka</h3>
                    <p class="text-xs text-slate-500 mt-1">Daftar laporan bencana terverifikasi yang membutuhkan kontribusi relawan di lapangan.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-slate-800 text-[10px] uppercase tracking-wider text-slate-400 font-bold">
                                <th class="pb-3 pr-4">Lokasi / Wilayah</th>
                                <th class="pb-3 px-4">Jenis Bencana</th>
                                <th class="pb-3 px-4 text-center">Prioritas</th>
                                <th class="pb-3 px-4 text-center">Status</th>
                                <th class="pb-3 pl-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-800 dark:text-slate-300">
                            @forelse($availableReports as $rep)
                            @php
                                $loc = $rep->alamat_lengkap ? explode(',', $rep->alamat_lengkap)[0] : 'Lokasi Umum';
                                $prio = 'Sedang';
                                $prioColor = 'bg-yellow-500/10 border-yellow-500/20 text-yellow-500';
                                
                                if ($rep->tingkat_kerusakan === 'Hancur Total' || $rep->jumlah_korban > 100) {
                                    $prio = 'Kritis';
                                    $prioColor = 'bg-red-500/10 border-red-500/20 text-red-500';
                                } elseif ($rep->tingkat_kerusakan === 'Tinggi' || $rep->jumlah_korban > 20) {
                                    $prio = 'Tinggi';
                                    $prioColor = 'bg-orange-500/10 border-orange-500/20 text-orange-500';
                                } elseif ($rep->tingkat_kerusakan === 'Rendah') {
                                    $prio = 'Rendah';
                                    $prioColor = 'bg-blue-500/10 border-blue-500/20 text-blue-500';
                                }
                            @endphp
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-white/[0.01] transition-colors">
                                <td class="py-4 pr-4 font-semibold text-xs text-slate-900 dark:text-white max-w-[150px] truncate" title="{{ $rep->alamat_lengkap }}">
                                    {{ $loc }}
                                </td>
                                <td class="py-4 px-4 text-xs font-bold">{{ $rep->jenis_bencana }}</td>
                                <td class="py-4 px-4 text-center">
                                    <span class="text-[9px] font-extrabold uppercase tracking-widest px-2 py-0.5 rounded border {{ $prioColor }}">
                                        {{ $prio }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span class="text-[9px] font-extrabold uppercase tracking-widest px-2 py-0.5 rounded border bg-slate-500/10 border-slate-500/20 text-slate-400">
                                        Belum Diambil
                                    </span>
                                </td>
                                <td class="py-4 pl-4 text-right">
                                    <form method="POST" action="{{ route('center.volunteer.task.claim') }}">
                                        @csrf
                                        <input type="hidden" name="report_id" value="{{ $rep->id }}">
                                        <button type="submit" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-[10px] font-bold uppercase rounded-lg shadow-sm transition-all">
                                            Ambil Tugas
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-500 text-xs">
                                    Tidak ada misi terbuka saat ini. Semua laporan bencana telah tertangani.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Right Column: Info & Smart Recommendations -->
        <div class="space-y-8">
            
            {{-- Smart Recommendation Card --}}
            @if($recommendedReport)
            <div class="glass-panel rounded-3xl p-6 relative overflow-hidden border border-red-500/30 bg-red-500/5 shadow-md">
                <div class="absolute -right-10 -top-10 w-24 h-24 bg-red-500/10 rounded-full blur-xl"></div>
                <div class="flex items-center gap-2 mb-4">
                    <span class="w-2.5 h-2.5 rounded-full bg-red-500 animate-ping"></span>
                    <span class="text-[10px] font-extrabold text-red-500 uppercase tracking-widest">Rekomendasi Pintar</span>
                </div>
                <h4 class="text-base font-bold text-slate-900 dark:text-white mb-2">{{ $recommendedReport->jenis_bencana }}</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-3"><i class="fas fa-map-marker-alt text-red-500"></i> {{ $recommendedReport->alamat_lengkap }}</p>
                
                <p class="text-xs text-slate-700 dark:text-slate-300 leading-relaxed mb-4 bg-white/40 dark:bg-black/20 p-2.5 rounded-xl border border-slate-200/50 dark:border-white/5">
                    "{{ $recommendationReason }}"
                </p>

                <form method="POST" action="{{ route('center.volunteer.task.claim') }}">
                    @csrf
                    <input type="hidden" name="report_id" value="{{ $recommendedReport->id }}">
                    <button type="submit" class="w-full py-2.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold uppercase rounded-xl transition-all shadow-md shadow-red-600/20">
                        Terima & Ajukan Misi ini
                    </button>
                </form>
            </div>
            @endif

            <!-- Quick Profile Details -->
            <div class="glass-panel rounded-3xl p-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Info Kontak & Wilayah</h3>
                <div class="space-y-3 text-xs text-slate-600 dark:text-slate-400">
                    <div>
                        <span class="font-bold block text-[10px] text-slate-400 uppercase">Nomor Telepon</span>
                        <p class="text-slate-900 dark:text-white mt-0.5">{{ $volApp->phone_number ?? 'Belum diisi' }}</p>
                    </div>
                    <div>
                        <span class="font-bold block text-[10px] text-slate-400 uppercase">Alamat Domisili</span>
                        <p class="text-slate-900 dark:text-white mt-0.5">{{ $volApp->city ?? 'Belum diisi' }}</p>
                    </div>
                    <div>
                        <span class="font-bold block text-[10px] text-slate-400 uppercase">Keahlian</span>
                        <p class="text-slate-900 dark:text-white mt-0.5">{{ $volApp->skills ?? 'Umum / Belum diisi' }}</p>
                    </div>
                    <div>
                        <span class="font-bold block text-[10px] text-slate-400 uppercase">Wilayah Operasi</span>
                        <p class="text-slate-900 dark:text-white mt-0.5">{{ $volApp->assignment_area ?? 'Belum diisi' }}</p>
                    </div>
                    <button onclick="document.getElementById('profile-modal').classList.remove('hidden')" class="w-full mt-4 py-2 border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-800 dark:text-white text-xs font-bold uppercase rounded-xl transition-all text-center">
                        <i class="fas fa-user-edit mr-1"></i> Perbarui Detail Profil
                    </button>
                </div>
            </div>

            <!-- Activity Log -->
            <div class="glass-panel rounded-3xl p-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Aktivitas Terakhir</h3>
                <div class="space-y-4">
                    @forelse($recentActivity as $act)
                    <div class="flex gap-3">
                        <div class="w-1.5 h-1.5 rounded-full bg-slate-300 dark:bg-slate-700 mt-2"></div>
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-slate-800 dark:text-white truncate">{{ $act->task }}</p>
                            <p class="text-[10px] text-slate-500 mt-0.5">{{ $act->status }} — {{ $act->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-slate-500 text-center py-2">Belum ada riwayat aktivitas.</p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

    {{-- MODAL LENGKAPI PROFIL --}}
    <div id="profile-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm hidden">
        <div class="glass-panel rounded-3xl w-full max-w-md overflow-hidden shadow-2xl border border-white/10 mx-4">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-white/5 bg-slate-100 dark:bg-white/[0.02] flex justify-between items-center">
                <h3 class="font-bold text-slate-900 dark:text-white font-display text-base">Lengkapi Profil Relawan</h3>
                <button onclick="document.getElementById('profile-modal').classList.add('hidden')" class="text-slate-500 hover:text-slate-900 dark:text-gray-400 dark:hover:text-white text-xl font-bold">&times;</button>
            </div>
            <form method="POST" action="{{ route('center.volunteer.profile.update') }}" class="p-6 space-y-4 text-slate-800 dark:text-slate-300">
                @csrf
                <div>
                    <label class="text-[10px] uppercase font-bold text-slate-500 dark:text-slate-400 block mb-1">Nomor Telepon</label>
                    <input type="text" name="phone_number" required value="{{ $volApp->phone_number ?? '' }}" placeholder="Contoh: 08123456789" class="w-full px-3 py-2 text-xs bg-white/5 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-800 dark:text-white focus:outline-none">
                </div>

                <div>
                    <label class="text-[10px] uppercase font-bold text-slate-500 dark:text-slate-400 block mb-1">Alamat Domisili</label>
                    <input type="text" name="city" required value="{{ $volApp->city ?? '' }}" placeholder="Contoh: Jakarta Utara, DKI Jakarta" class="w-full px-3 py-2 text-xs bg-white/5 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-800 dark:text-white focus:outline-none">
                </div>

                <div>
                    <label class="text-[10px] uppercase font-bold text-slate-500 dark:text-slate-400 block mb-1">Keahlian (Pilih satu atau lebih)</label>
                    @php
                        $userSkills = $volApp ? array_map('trim', explode(',', strtolower($volApp->skills ?? ''))) : [];
                    @endphp
                    <div class="grid grid-cols-2 gap-2 mt-1">
                        @foreach(['Medis', 'Logistik', 'Evakuasi', 'Distribusi Bantuan', 'Dapur Umum'] as $skill)
                        <label class="flex items-center gap-2 text-xs cursor-pointer bg-white/10 dark:bg-black/10 border border-slate-200 dark:border-slate-800 p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-white/5">
                            <input type="checkbox" name="skills[]" value="{{ $skill }}" {{ in_array(strtolower($skill), $userSkills) ? 'checked' : '' }} class="rounded text-red-600 focus:ring-red-500">
                            <span>{{ $skill }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="text-[10px] uppercase font-bold text-slate-500 dark:text-slate-400 block mb-1">Wilayah Operasi Jangkauan</label>
                    <input type="text" name="assignment_area" required value="{{ $volApp->assignment_area ?? '' }}" placeholder="Contoh: Jabodetabek, Jawa Barat" class="w-full px-3 py-2 text-xs bg-white/5 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-800 dark:text-white focus:outline-none">
                </div>

                <div class="flex justify-end gap-2 border-t border-slate-200 dark:border-slate-800 pt-4 mt-2">
                    <button type="button" onclick="document.getElementById('profile-modal').classList.add('hidden')" class="px-4 py-2 bg-slate-100 dark:bg-white/5 hover:bg-slate-200 dark:hover:bg-white/10 text-slate-600 dark:text-gray-300 text-xs font-bold uppercase rounded-lg border border-slate-200 dark:border-slate-700">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold uppercase rounded-lg shadow-md shadow-red-600/20">Simpan Profil</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function requestCheckin(taskId) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    document.getElementById('lat-' + taskId).value = position.coords.latitude;
                    document.getElementById('lng-' + taskId).value = position.coords.longitude;
                    document.getElementById('form-checkin-' + taskId).submit();
                },
                function(error) {
                    console.warn('Geolocation error: ' + error.message + '. Submitting with default coordinates.');
                    // Fallback to default checkin values (using report defaults)
                    document.getElementById('lat-' + taskId).value = 0;
                    document.getElementById('lng-' + taskId).value = 0;
                    document.getElementById('form-checkin-' + taskId).submit();
                }
            );
        } else {
            document.getElementById('form-checkin-' + taskId).submit();
        }
    }

    function setProgress(taskId, pct) {
        document.getElementById('pct-input-' + taskId).value = pct;
        
        // Reset styles for all percentages
        [25, 50, 75, 100].forEach(p => {
            const btn = document.getElementById('btn-' + taskId + '-' + p);
            if (btn) {
                btn.className = "py-2 text-xs font-black rounded-lg border transition-all text-center bg-white/5 border-slate-200 dark:border-white/10 text-slate-500 hover:bg-slate-100 dark:hover:bg-white/5";
            }
        });

        // Select the active one
        const activeBtn = document.getElementById('btn-' + taskId + '-' + pct);
        if (activeBtn) {
            activeBtn.className = "py-2 text-xs font-black rounded-lg border transition-all text-center bg-indigo-600 text-white border-indigo-600";
        }
    }

    function simulateQRScan(taskId) {
        const statusText = document.getElementById('qr-status-' + taskId);
        const inputVal = document.getElementById('qr-input-' + taskId);
        statusText.innerText = "⏳ Membuka kamera scanner...";
        statusText.className = "text-[10px] font-bold text-amber-500 mt-1";
        
        setTimeout(() => {
            statusText.innerText = "🔍 Mendeteksi barcode bantuan...";
            setTimeout(() => {
                const randomId = "AID-CRISISHUB-" + Math.floor(1000 + Math.random() * 9000);
                statusText.innerText = "✅ QR Terverifikasi: " + randomId;
                statusText.className = "text-[10px] font-bold text-green-500 mt-1";
                inputVal.value = randomId;
            }, 1000);
        }, 800);
    }

    function submitCompleteTask(taskId) {
        // Change status to Completed in the form status field and submit
        document.getElementById('status-field-' + taskId).value = 'Completed';
        
        // Find the form wrapping the checkin inputs & submit
        document.getElementById('status-field-' + taskId).form.submit();
    }
</script>
@endsection
