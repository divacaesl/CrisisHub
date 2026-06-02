@extends('layouts.public')

@section('title', $disaster['title'] . ' — Detail Bencana')

@section('content')
<section class="hero-dynamic hero-about pt-24 pb-16 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="/" class="inline-flex items-center gap-2 text-slate-400 hover:text-white text-sm transition-colors">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>

        <!-- Header -->
        <div class="glass rounded-3xl p-8 border border-red-500/20 mb-8">
            <div class="flex flex-wrap items-start gap-4 mb-6">
                @if(strtolower($disaster['status']) === 'kritis' || strtolower($disaster['status']) === 'tinggi')
                    <span class="px-3 py-1.5 bg-red-600 text-white text-sm font-bold rounded-xl badge-urgent">🔴 {{ $disaster['status'] }}</span>
                @elseif(strtolower($disaster['status']) === 'waspada' || strtolower($disaster['status']) === 'sedang')
                    <span class="px-3 py-1.5 bg-orange-600 text-white text-sm font-bold rounded-xl badge-urgent">🟠 {{ $disaster['status'] }}</span>
                @else
                    <span class="px-3 py-1.5 bg-green-600 text-white text-sm font-bold rounded-xl badge-urgent">🟢 {{ $disaster['status'] }}</span>
                @endif
                <span class="px-3 py-1.5 bg-blue-600/40 text-blue-300 text-sm rounded-xl">{{ $disaster['type_icon'] }} {{ $disaster['type'] }}</span>
                <span class="px-3 py-1.5 glass text-slate-400 text-sm rounded-xl">Priority Score: {{ $disaster['priority_score'] }}</span>
            </div>

            <h1 class="text-3xl sm:text-4xl font-black text-white mb-3">{{ $disaster['title'] }}</h1>
            <div class="flex flex-wrap items-center gap-4 text-slate-400 text-sm mb-6">
                <span class="flex items-center gap-2"><i class="fas fa-map-marker-alt text-red-400"></i> {{ $disaster['location'] }}</span>
                <span class="flex items-center gap-2"><i class="fas fa-clock text-orange-400"></i> {{ $disaster['date'] }}</span>
                <span class="flex items-center gap-2"><i class="fas fa-eye text-blue-400"></i> {{ $disaster['views'] }} dilihat</span>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-500/10 rounded-2xl p-4 text-center">
                    <div class="text-3xl font-black text-red-600 dark:text-red-400">{{ $disaster['korban'] }}</div>
                    <div class="text-slate-600 dark:text-slate-400 text-xs mt-1">Korban Terdampak</div>
                </div>
                <div class="bg-orange-50 dark:bg-orange-900/20 border border-orange-500/10 rounded-2xl p-4 text-center">
                    <div class="text-3xl font-black text-orange-600 dark:text-orange-400">{{ $disaster['kerusakan'] }}</div>
                    <div class="text-slate-600 dark:text-slate-400 text-xs mt-1">Tingkat Kerusakan</div>
                </div>
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-500/10 rounded-2xl p-4 text-center">
                    <div class="text-3xl font-black text-blue-600 dark:text-blue-400">{{ $disaster['relawan'] }}</div>
                    <div class="text-slate-600 dark:text-slate-400 text-xs mt-1">Relawan Dikerahkan</div>
                </div>
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-500/10 rounded-2xl p-4 text-center">
                    <div class="text-3xl font-black text-green-600 dark:text-green-400">{{ $disaster['bantuan'] }}</div>
                    <div class="text-slate-600 dark:text-slate-400 text-xs mt-1">Bantuan Tersalur</div>
                </div>
            </div>
        </div>

        <!-- Main Image -->
        <div class="rounded-2xl overflow-hidden mb-8">
            <img src="{{ $disaster['image'] }}" alt="Kondisi {{ $disaster['title'] }}" class="w-full h-80 object-cover">
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Detail Info -->
            <div class="lg:col-span-2 space-y-6">
                <div class="glass rounded-2xl p-7 border border-white/7">
                    <h2 class="text-xl font-bold text-white mb-4">Deskripsi Kejadian</h2>
                    <p class="text-slate-400 leading-relaxed whitespace-pre-line">{{ $disaster['description'] }}</p>
                </div>

                <div class="glass rounded-2xl p-7 border border-white/7">
                    <h2 class="text-xl font-bold text-white mb-4">Kebutuhan Mendesak</h2>
                    <div class="space-y-3">
                        @foreach($disaster['needs'] as $n)
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-slate-300">{{ $n['item'] }}</span>
                                <span class="text-{{ $n['color'] }}-400 font-bold">{{ $n['pct'] }}% terpenuhi</span>
                            </div>
                            <div class="h-2 bg-slate-800 rounded-full">
                                <div class="h-full bg-{{ $n['color'] }}-500 rounded-full" style="width: {{ $n['pct'] }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sidebar Actions -->
            <div class="space-y-5">
                <div class="glass rounded-2xl p-6 border border-orange-500/20">
                    <h3 class="text-white font-bold mb-4">Bantu Korban Sekarang</h3>
                    <a href="/donate" class="block w-full text-center py-3.5 bg-gradient-to-r from-orange-600 to-red-600 text-white font-bold rounded-xl mb-3 transition-all hover:opacity-90">
                        <i class="fas fa-heart mr-2"></i>Donasi Sekarang
                    </a>
                    <a href="/volunteer" class="block w-full text-center py-3.5 glass border border-white/10 text-white font-medium rounded-xl transition-all hover:bg-white/10">
                        <i class="fas fa-hard-hat mr-2"></i>Jadi Relawan
                    </a>
                </div>

                <div class="glass rounded-2xl p-6 border border-white/7">
                    <h3 class="text-white font-bold mb-4">Informasi Posko</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-map-marker-alt text-red-400 w-4"></i>
                            <span class="text-slate-400">{{ $disaster['posko'] }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fas fa-phone text-green-400 w-4"></i>
                            <span class="text-slate-400">{{ $disaster['phone'] }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fas fa-clock text-blue-400 w-4"></i>
                            <span class="text-slate-400">24 Jam Non-Stop</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
