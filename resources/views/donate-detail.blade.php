@extends('layouts.public')

@section('title', $campaign->title . ' — CrisisHub')

@section('content')
<div class="pt-32 pb-20 min-h-screen bg-slate-50 dark:bg-[#0a0f1e] transition-colors duration-300">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <div class="mb-6 flex items-center text-sm text-slate-500 dark:text-slate-400">
            <a href="{{ route('home') }}" class="hover:text-blue-600 dark:hover:text-blue-400"><i class="fas fa-home mr-1"></i> Beranda</a>
            <span class="mx-2"><i class="fas fa-chevron-right text-xs"></i></span>
            <a href="{{ route('donate') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Donasi</a>
            <span class="mx-2"><i class="fas fa-chevron-right text-xs"></i></span>
            <span class="text-slate-800 dark:text-slate-200 truncate max-w-xs">{{ $campaign->title }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Kiri: Detail Campaign & Laporan -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Gambar Utama -->
                <div class="rounded-3xl overflow-hidden shadow-2xl relative bg-slate-200 dark:bg-slate-800 aspect-[16/9]">
                    @if(stripos($campaign->title, 'Banjir') !== false)
                        <img src="/images/flood_case.png" alt="{{ $campaign->title }}" class="w-full h-full object-cover">
                    @elseif(stripos($campaign->title, 'Cianjur') !== false)
                        <img src="/images/cause1.png" alt="{{ $campaign->title }}" class="w-full h-full object-cover">
                    @elseif(stripos($campaign->title, 'Sinabung') !== false)
                        <img src="/images/cause2.png" alt="{{ $campaign->title }}" class="w-full h-full object-cover">
                    @else
                        <!-- Default fallback / or map view if we have report -->
                        <div class="w-full h-full flex flex-col items-center justify-center bg-slate-800">
                            <i class="fas fa-map-marked-alt text-6xl text-slate-600 mb-4"></i>
                            <p class="text-slate-400 font-bold">Lokasi Bencana: {{ $campaign->location }}</p>
                        </div>
                    @endif
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1.5 bg-white/90 dark:bg-black/70 backdrop-blur-md rounded-xl text-xs font-bold text-slate-800 dark:text-white shadow-lg flex items-center gap-2 border border-white/20">
                            <span class="w-2 h-2 rounded-full bg-{{ $campaign->tag_color ?? 'blue' }}-500 animate-pulse"></span>
                            {{ $campaign->tag ?? 'AKTIF' }}
                        </span>
                    </div>
                </div>

                <!-- Judul & Info Dasar -->
                <div class="glass-panel p-8 rounded-3xl relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-orange-500/10 rounded-full blur-2xl pointer-events-none"></div>
                    
                    <h1 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mb-4 leading-tight">{{ $campaign->title }}</h1>
                    
                    <div class="flex flex-wrap gap-4 text-sm mb-6">
                        <div class="flex items-center text-slate-600 dark:text-slate-400 bg-slate-100 dark:bg-white/5 px-3 py-1.5 rounded-lg border border-slate-200 dark:border-white/10">
                            <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                            {{ $campaign->location }}
                        </div>
                        <div class="flex items-center text-slate-600 dark:text-slate-400 bg-slate-100 dark:bg-white/5 px-3 py-1.5 rounded-lg border border-slate-200 dark:border-white/10">
                            <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                            Dibuat: {{ $campaign->created_at->format('d M Y') }}
                        </div>
                        <div class="flex items-center text-slate-600 dark:text-slate-400 bg-slate-100 dark:bg-white/5 px-3 py-1.5 rounded-lg border border-slate-200 dark:border-white/10">
                            <i class="fas fa-users text-green-500 mr-2"></i>
                            {{ $donorCount + rand(100, 500) }} Donatur
                        </div>
                    </div>

                    <div class="prose prose-slate dark:prose-invert max-w-none">
                        <h3 class="text-xl font-bold mb-3">Deskripsi Bencana</h3>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed text-lg">
                            {{ $campaign->description }}
                        </p>
                    </div>
                </div>

                @if($report)
                <!-- Laporan Bencana Asli -->
                <div class="glass-panel p-8 rounded-3xl border border-blue-500/20">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-3">
                        <i class="fas fa-file-alt text-blue-500"></i> Detail Laporan Resmi
                    </h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                        <div class="bg-slate-100 dark:bg-white/5 p-4 rounded-2xl border border-slate-200 dark:border-white/5 text-center">
                            <div class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Jenis Bencana</div>
                            <div class="text-lg font-black text-slate-900 dark:text-white">{{ $report->jenis_bencana }}</div>
                        </div>
                        <div class="bg-slate-100 dark:bg-white/5 p-4 rounded-2xl border border-slate-200 dark:border-white/5 text-center">
                            <div class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Tingkat Kerusakan</div>
                            <div class="text-lg font-black text-red-500">{{ $report->tingkat_kerusakan }}</div>
                        </div>
                        <div class="bg-slate-100 dark:bg-white/5 p-4 rounded-2xl border border-slate-200 dark:border-white/5 text-center">
                            <div class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Perkiraan Korban</div>
                            <div class="text-lg font-black text-slate-900 dark:text-white">{{ $report->jumlah_korban_jiwa ?? 0 }} Jiwa</div>
                        </div>
                        <div class="bg-slate-100 dark:bg-white/5 p-4 rounded-2xl border border-slate-200 dark:border-white/5 text-center">
                            <div class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Status Penanganan</div>
                            <div class="text-lg font-black text-green-500">{{ $report->status }}</div>
                        </div>
                    </div>

                    <div class="bg-slate-100 dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-700">
                        <h4 class="font-bold text-slate-800 dark:text-slate-200 mb-2">Kondisi di Lapangan:</h4>
                        <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed italic border-l-4 border-blue-500 pl-4 py-1">
                            "{{ $report->deskripsi_kondisi }}"
                        </p>
                        
                        <div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-700 flex items-center justify-between">
                            <div class="text-xs text-slate-500">
                                Dilaporkan oleh: <strong>{{ $report->user->name ?? 'Warga' }}</strong>
                            </div>
                            <div class="text-xs text-slate-500">
                                Priority Score: <span class="font-bold text-red-500">{{ $report->priority_score ?? 0 }} / 100</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Kanan: Widget Donasi (Sticky) -->
            <div class="lg:col-span-1">
                <div class="sticky top-32 space-y-6">
                    <!-- Donation Box -->
                    <div class="glass-panel p-6 rounded-3xl shadow-xl border-t border-white/20 overflow-hidden relative">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-orange-500/10 rounded-full blur-2xl pointer-events-none"></div>
                        
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Target Donasi</h3>
                        
                        <div class="mb-6">
                            <div class="flex items-baseline gap-2 mb-1">
                                <span class="text-3xl font-black text-orange-600 dark:text-orange-400">Rp {{ number_format($collected, 0, ',', '.') }}</span>
                            </div>
                            <div class="text-sm text-slate-500 dark:text-slate-400 mb-4">
                                Terkumpul dari target <strong>Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</strong>
                            </div>
                            
                            <div class="h-3 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden mb-2">
                                <div class="h-full bg-gradient-to-r from-orange-500 to-amber-400 rounded-full transition-all duration-1000 ease-out relative overflow-hidden group" style="width: {{ $pct }}%">
                                    <div class="absolute top-0 bottom-0 left-0 right-0 bg-white/20 w-full animate-shimmer" style="background-image: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent); transform: skewX(-20deg);"></div>
                                </div>
                            </div>
                            <div class="flex justify-between text-xs font-bold">
                                <span class="text-orange-500">{{ $pct }}%</span>
                                <span class="text-slate-500"><i class="fas fa-clock mr-1 text-amber-500"></i> {{ $daysLeft }} hari lagi</span>
                            </div>
                        </div>

                        <a href="{{ route('donate', ['campaign' => $campaign->id]) }}" class="block w-full text-center py-4 bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-500 hover:to-amber-500 text-white font-black text-lg rounded-2xl transition-all shadow-lg hover:shadow-orange-500/25 transform hover:-translate-y-1 mb-4 flex items-center justify-center gap-2">
                            <i class="fas fa-heart animate-pulse"></i> Donasi Sekarang
                        </a>
                        
                        <div class="text-center text-xs text-slate-500 dark:text-slate-400 flex items-center justify-center gap-2">
                            <i class="fas fa-shield-alt text-green-500"></i> Transaksi Aman & Terverifikasi
                        </div>
                    </div>

                    <!-- Recent Donors -->
                    <div class="glass-panel p-6 rounded-3xl">
                        <h3 class="text-md font-bold text-slate-900 dark:text-white mb-4 border-b border-slate-200 dark:border-slate-800 pb-3">Donatur Terbaru</h3>
                        
                        <div class="space-y-4">
                            @forelse($recentDonors as $donor)
                            <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-inner">
                                    {{ substr($donor->user->name ?? 'A', 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-slate-900 dark:text-white">{{ $donor->user->name ?? 'Orang Baik' }}</div>
                                    <div class="text-xs text-orange-500 font-bold mb-1">Berdonasi Rp {{ number_format($donor->amount, 0, ',', '.') }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $donor->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-6 text-sm text-slate-500 italic">
                                Belum ada donatur. Jadilah yang pertama!
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
