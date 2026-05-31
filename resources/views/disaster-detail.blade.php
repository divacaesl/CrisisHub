@extends('layouts.public')

@section('title', 'Detail Bencana — CrisisHub')

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
                <span class="px-3 py-1.5 bg-red-600 text-white text-sm font-bold rounded-xl badge-urgent">🔴 KRITIS</span>
                <span class="px-3 py-1.5 bg-blue-600/40 text-blue-300 text-sm rounded-xl">🌊 Banjir</span>
                <span class="px-3 py-1.5 glass text-slate-400 text-sm rounded-xl">Priority Score: 9.2</span>
            </div>

            <h1 class="text-3xl sm:text-4xl font-black text-white mb-3">Banjir Besar Jakarta Utara</h1>
            <div class="flex flex-wrap items-center gap-4 text-slate-400 text-sm mb-6">
                <span class="flex items-center gap-2"><i class="fas fa-map-marker-alt text-red-400"></i> Jakarta Utara, DKI Jakarta</span>
                <span class="flex items-center gap-2"><i class="fas fa-clock text-orange-400"></i> 30 Mei 2026, 06:15 WIB</span>
                <span class="flex items-center gap-2"><i class="fas fa-eye text-blue-400"></i> 12.450 dilihat</span>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-500/10 rounded-2xl p-4 text-center">
                    <div class="text-3xl font-black text-red-600 dark:text-red-400">2.847</div>
                    <div class="text-slate-600 dark:text-slate-400 text-xs mt-1">Korban Terdampak</div>
                </div>
                <div class="bg-orange-50 dark:bg-orange-900/20 border border-orange-500/10 rounded-2xl p-4 text-center">
                    <div class="text-3xl font-black text-orange-600 dark:text-orange-400">94%</div>
                    <div class="text-slate-600 dark:text-slate-400 text-xs mt-1">Tingkat Kerusakan</div>
                </div>
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-500/10 rounded-2xl p-4 text-center">
                    <div class="text-3xl font-black text-blue-600 dark:text-blue-400">248</div>
                    <div class="text-slate-600 dark:text-slate-400 text-xs mt-1">Relawan Dikerahkan</div>
                </div>
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-500/10 rounded-2xl p-4 text-center">
                    <div class="text-3xl font-black text-green-600 dark:text-green-400">1.200</div>
                    <div class="text-slate-600 dark:text-slate-400 text-xs mt-1">Bantuan Tersalur</div>
                </div>
            </div>
        </div>

        <!-- Main Image -->
        <div class="rounded-2xl overflow-hidden mb-8">
            <img src="/images/flood_case.png" alt="Kondisi Banjir Jakarta Utara" class="w-full h-80 object-cover">
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Detail Info -->
            <div class="lg:col-span-2 space-y-6">
                <div class="glass rounded-2xl p-7 border border-white/7">
                    <h2 class="text-xl font-bold text-white mb-4">Deskripsi Kejadian</h2>
                    <p class="text-slate-400 leading-relaxed mb-4">Banjir besar melanda wilayah Jakarta Utara akibat curah hujan ekstrem yang melanda DKI Jakarta sejak dini hari. Ketinggian air mencapai 1,5–2 meter di beberapa kelurahan, menyebabkan ribuan warga harus mengungsi.</p>
                    <p class="text-slate-400 leading-relaxed">Wilayah yang paling terdampak meliputi Kelurahan Penjaringan, Pluit, Kapuk Muara, dan Muara Baru. Infrastruktur seperti jalan, jembatan, dan fasilitas umum mengalami kerusakan signifikan.</p>
                </div>

                <div class="glass rounded-2xl p-7 border border-white/7">
                    <h2 class="text-xl font-bold text-white mb-4">Kebutuhan Mendesak</h2>
                    <div class="space-y-3">
                        @php
                        $needs = [
                            ['item' => 'Air Minum Bersih', 'pct' => 85, 'color' => 'blue'],
                            ['item' => 'Makanan / Sembako', 'pct' => 72, 'color' => 'orange'],
                            ['item' => 'Obat-obatan', 'pct' => 60, 'color' => 'red'],
                            ['item' => 'Selimut & Pakaian', 'pct' => 45, 'color' => 'purple'],
                            ['item' => 'Relawan Medis', 'pct' => 30, 'color' => 'green'],
                        ];
                        @endphp
                        @foreach($needs as $n)
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
                            <span class="text-slate-400">GOR Jakarta Utara, Jl. Yos Sudarso</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fas fa-phone text-green-400 w-4"></i>
                            <span class="text-slate-400">+62 21-4567-8900</span>
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
