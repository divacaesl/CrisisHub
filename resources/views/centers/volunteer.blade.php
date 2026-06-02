@extends('layouts.dashboard')

@section('title', 'Volunteer Dashboard')
@section('role', 'Relawan')
@section('page_title', 'Dashboard Relawan')

@section('header_actions')
    <div class="flex items-center gap-2 px-4 py-1.5 glass-panel rounded-full border border-green-500/30 bg-green-50/50 dark:bg-green-900/20">
        <div class="w-2.5 h-2.5 rounded-full bg-green-500 shadow-[0_0_8px_#22c55e] animate-pulse"></div>
        <span class="text-xs font-bold text-green-600 dark:text-green-400 uppercase tracking-wider">On Duty</span>
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
                @if($completedTasks >= 10) Kinerja Luar Biasa
                @elseif($completedTasks >= 5) Kinerja Sangat Baik
                @elseif($completedTasks >= 1) Kinerja Baik
                @else Belum ada misi selesai
                @endif
            </div>
        </div>

        <!-- Total Tugas -->
        <div class="glass-panel rounded-2xl p-6 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-purple-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Penugasan</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white mt-1">{{ $myTasks->count() }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-50 dark:bg-purple-500/10 flex items-center justify-center text-purple-500">
                    <i class="fas fa-clipboard-list text-xl"></i>
                </div>
            </div>
            <div class="text-xs text-purple-600 dark:text-purple-400 font-semibold flex items-center gap-1">
                <i class="fas fa-history"></i> Semua Riwayat Tugas
            </div>
        </div>

        <!-- Laporan Kritis -->
        <div class="glass-panel rounded-2xl p-6 relative overflow-hidden border-red-300 dark:border-red-500/30 group bg-red-50/50 dark:bg-red-900/10">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-red-600/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-red-600 dark:text-red-400">Laporan Kritis</p>
                    <h3 class="text-3xl font-black text-red-700 dark:text-red-400 mt-1">{{ $criticalReports->count() }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-500/20 flex items-center justify-center text-red-600 dark:text-red-400">
                    <i class="fas fa-ambulance text-xl"></i>
                </div>
            </div>
            <div class="text-xs text-red-700 dark:text-red-400 font-semibold flex items-center gap-1">
                <i class="fas fa-exclamation-triangle"></i>
                @if($criticalReports->count() > 0) Perlu Evakuasi Segera @else Tidak Ada Kritis Saat Ini @endif
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Left Col: Task Queue -->
        <div class="lg:col-span-2 space-y-8">
            <div class="glass-panel rounded-3xl p-6 md:p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Antrean Penugasan Saya</h3>
                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-yellow-100 dark:bg-yellow-500/10 text-yellow-700 dark:text-yellow-400">
                        {{ $activeTasks }} Aktif
                    </span>
                </div>

                <div class="space-y-4">
                    @forelse($myTasks->whereIn('status', ['Assigned', 'In Progress'])->take(10) as $task)
                    <div class="p-5 rounded-2xl bg-white/60 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 shadow-sm relative overflow-hidden">
                        {{-- Side indicator --}}
                        <div class="absolute left-0 top-0 bottom-0 w-1
                            @if($task->status === 'Assigned') bg-yellow-500
                            @elseif($task->status === 'In Progress') bg-blue-500
                            @else bg-green-500 @endif">
                        </div>

                        <div class="flex flex-col md:flex-row gap-4 md:items-center justify-between">
                            <div class="flex-1 pl-2">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase
                                        @if($task->status === 'Assigned') bg-yellow-100 text-yellow-700 dark:bg-yellow-500/20 dark:text-yellow-400
                                        @elseif($task->status === 'In Progress') bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400
                                        @else bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400 @endif">
                                        {{ $task->status }}
                                    </span>
                                    <span class="text-xs text-slate-500">#TSK-{{ str_pad($task->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <h4 class="text-base font-bold text-slate-900 dark:text-white">{{ $task->task }}</h4>
                                @if($task->report)
                                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                                    <i class="fas fa-map-marker-alt text-slate-400 w-4"></i>
                                    {{ $task->report->jenis_bencana }} — {{ Str::limit($task->report->alamat_lengkap, 50) }}
                                </p>
                                @endif
                                <p class="text-xs text-slate-400 mt-1">
                                    <i class="fas fa-clock"></i> Ditugaskan {{ $task->created_at->diffForHumans() }}
                                </p>
                            </div>

                            <div class="flex gap-2 flex-shrink-0">
                                @if($task->status === 'Assigned')
                                <form method="POST" action="{{ route('center.volunteer.task.update', $task->id) }}">
                                    @csrf
                                    <input type="hidden" name="status" value="In Progress">
                                    <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-xs font-bold rounded-lg transition-colors">
                                        Mulai Kerjakan
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('center.volunteer.task.update', $task->id) }}" onsubmit="return confirm('Tolak penugasan ini?')">
                                    @csrf
                                    <input type="hidden" name="status" value="Rejected">
                                    <button type="submit" class="px-4 py-2 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-300 dark:hover:bg-slate-600 text-xs font-bold rounded-lg transition-colors">
                                        Tolak
                                    </button>
                                </form>
                                @elseif($task->status === 'In Progress')
                                <form method="POST" action="{{ route('center.volunteer.task.update', $task->id) }}" onsubmit="return confirm('Tandai tugas ini sebagai selesai?')">
                                    @csrf
                                    <input type="hidden" name="status" value="Completed">
                                    <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-xs font-bold rounded-lg transition-colors">
                                        <i class="fas fa-check"></i> Selesai
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12 text-slate-400">
                        <i class="fas fa-inbox text-4xl mb-3 block text-slate-300 dark:text-slate-600"></i>
                        <p class="font-semibold">Belum ada penugasan aktif.</p>
                        <p class="text-sm mt-1 text-slate-400">Tunggu admin menugaskan misi kepada Anda.</p>
                    </div>
                    @endforelse

                    {{-- Riwayat tugas selesai (collapsed) --}}
                    @if($myTasks->where('status', 'Completed')->count() > 0)
                    <details class="mt-2">
                        <summary class="cursor-pointer text-xs font-bold text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 flex items-center gap-2 py-2">
                            <i class="fas fa-history"></i>
                            Lihat Riwayat Tugas Selesai ({{ $myTasks->where('status', 'Completed')->count() }})
                        </summary>
                        <div class="mt-3 space-y-3">
                            @foreach($myTasks->where('status', 'Completed') as $task)
                            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-700/50 relative overflow-hidden opacity-75">
                                <div class="absolute left-0 top-0 bottom-0 w-1 bg-green-500"></div>
                                <div class="pl-2">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400 uppercase">Selesai</span>
                                        <span class="text-xs text-slate-400">#TSK-{{ str_pad($task->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $task->task }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5">{{ $task->updated_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </details>
                    @endif
                </div>
            </div>

            {{-- Laporan Kritis Terdekat --}}
            @if($criticalReports->count() > 0)
            <div class="glass-panel rounded-3xl p-6 md:p-8 border-red-200 dark:border-red-900/30 bg-red-50/20 dark:bg-red-950/10">
                <h3 class="text-lg font-bold text-red-700 dark:text-red-400 mb-4 flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle"></i> Laporan Kritis Aktif — Butuh Bantuan
                </h3>
                <div class="space-y-3">
                    @foreach($criticalReports as $cr)
                    <div class="p-4 rounded-xl bg-white dark:bg-slate-800/60 border border-red-200 dark:border-red-700/30 flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-red-100 dark:bg-red-500/20 flex items-center justify-center text-red-500 flex-shrink-0 mt-0.5">
                            <i class="fas fa-fire text-xs"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $cr->jenis_bencana }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ $cr->alamat_lengkap ?? 'Lokasi tidak tersedia' }}</p>
                            <p class="text-xs text-red-500 font-semibold mt-1">{{ number_format($cr->jumlah_korban) }} Korban • Hancur Total</p>
                        </div>
                        <span class="text-[9px] text-slate-400 flex-shrink-0">{{ $cr->created_at->diffForHumans() }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Right Col: Activity Log -->
        <div class="space-y-8">
            <!-- Daily Activities (Real) -->
            <div class="glass-panel rounded-3xl p-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-stream text-blue-500"></i> Log Aktivitas Terbaru
                </h3>
                @if($recentActivity->count() > 0)
                <div class="space-y-4">
                    @foreach($recentActivity as $act)
                    <div class="flex gap-4">
                        <div class="w-2 h-2 mt-2 rounded-full flex-shrink-0
                            @if($act->status === 'Completed') bg-green-500
                            @elseif($act->status === 'In Progress') bg-blue-500
                            @elseif($act->status === 'Rejected') bg-red-500
                            @else bg-yellow-500 @endif">
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-900 dark:text-white">
                                @if($act->status === 'Completed') ✅ Tugas Selesai
                                @elseif($act->status === 'In Progress') 🔄 Sedang Dikerjakan
                                @elseif($act->status === 'Rejected') ❌ Tugas Ditolak
                                @else 📋 Penugasan Baru
                                @endif
                            </p>
                            <p class="text-xs text-slate-500">{{ Str::limit($act->task, 45) }}</p>
                            @if($act->report)
                            <p class="text-xs text-slate-400">{{ $act->report->jenis_bencana }}</p>
                            @endif
                            <span class="text-[10px] text-slate-400">{{ $act->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-6 text-slate-400">
                    <i class="fas fa-clipboard-list text-2xl mb-2 block text-slate-300 dark:text-slate-600"></i>
                    <p class="text-sm">Belum ada aktivitas tercatat.</p>
                </div>
                @endif
            </div>

            <!-- Quick Info -->
            <div class="glass-panel rounded-3xl p-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Info Akun Relawan</h3>
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-yellow-100 dark:bg-yellow-500/10 flex items-center justify-center text-yellow-600 dark:text-yellow-400 font-black text-sm">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-900 dark:text-white">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <div class="pt-3 border-t border-slate-200 dark:border-slate-700 grid grid-cols-2 gap-3 text-center">
                        <div class="p-2 rounded-xl bg-slate-50 dark:bg-slate-800/50">
                            <p class="text-lg font-black text-blue-600 dark:text-blue-400">{{ $activeTasks }}</p>
                            <p class="text-[10px] text-slate-500 uppercase tracking-wider">Aktif</p>
                        </div>
                        <div class="p-2 rounded-xl bg-slate-50 dark:bg-slate-800/50">
                            <p class="text-lg font-black text-green-600 dark:text-green-400">{{ $completedTasks }}</p>
                            <p class="text-[10px] text-slate-500 uppercase tracking-wider">Selesai</p>
                        </div>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="block w-full text-center py-2 text-xs font-bold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors mt-2">
                        <i class="fas fa-user-edit mr-1"></i> Edit Profil
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
