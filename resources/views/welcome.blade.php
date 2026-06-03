@extends('layouts.public')

@section('title', 'CrisisHub — Bersama Tanggap Bencana Indonesia')
@section('description', 'Platform digital terpadu untuk pelaporan bencana, koordinasi relawan, distribusi bantuan, dan donasi transparan di seluruh Indonesia.')

@section('head')
<style>
    /* Light Mode Default Styling */
    .hero-section {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8fafc 0%, #fff1f2 40%, #f8fafc 70%, #f1f5f9 100%);
        position: relative;
        overflow: hidden;
        transition: background 0.5s ease;
    }
    .dark .hero-section {
        background: linear-gradient(135deg, #0f172a 0%, #1e0000 40%, #0f172a 70%, #0a0f1e 100%);
    }

    .hero-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at 30% 50%, rgba(220, 38, 38, 0.05) 0%, transparent 60%),
                    radial-gradient(ellipse at 80% 20%, rgba(249, 115, 22, 0.04) 0%, transparent 50%),
                    radial-gradient(ellipse at 60% 80%, rgba(59, 130, 246, 0.03) 0%, transparent 50%);
        transition: background 0.5s ease;
    }
    .dark .hero-section::before {
        background: radial-gradient(ellipse at 30% 50%, rgba(220, 38, 38, 0.15) 0%, transparent 60%),
                    radial-gradient(ellipse at 80% 20%, rgba(249, 115, 22, 0.1) 0%, transparent 50%),
                    radial-gradient(ellipse at 60% 80%, rgba(59, 130, 246, 0.08) 0%, transparent 50%);
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.85);
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 20px;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 30px rgba(0,0,0,0.01);
        transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
    }
    .dark .stat-card {
        background: linear-gradient(135deg, rgba(30,41,59,0.8), rgba(15,23,42,0.9));
        border: 1px solid rgba(255,255,255,0.08);
        box-shadow: none;
    }
    .stat-card:hover {
        border-color: rgba(220,38,38,0.4);
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(220, 38, 38, 0.1);
    }

    .step-card {
        position: relative;
        background: rgba(255, 255, 255, 0.85);
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 16px;
        padding: 28px;
        backdrop-filter: blur(10px);
        transition: all 0.3s;
    }
    .dark .step-card {
        background: rgba(30,41,59,0.6);
        border: 1px solid rgba(255,255,255,0.07);
    }
    .step-card:hover { border-color: rgba(249,115,22,0.4); }

    .case-card {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(0, 0, 0, 0.06);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s;
    }
    .dark .case-card {
        background: rgba(15,23,42,0.9);
        border: 1px solid rgba(255,255,255,0.07);
    }
    .case-card:hover { transform: translateY(-8px); box-shadow: 0 30px 60px rgba(0,0,0,0.05); }
    .dark .case-card:hover { transform: translateY(-8px); box-shadow: 0 30px 60px rgba(0,0,0,0.4); }

    .news-card {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s;
    }
    .dark .news-card {
        background: rgba(15,23,42,0.8);
        border: 1px solid rgba(255,255,255,0.07);
    }
    .news-card:hover { border-color: rgba(220,38,38,0.3); }

    .campaign-card {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s;
    }
    .dark .campaign-card {
        background: rgba(15,23,42,0.8);
        border: 1px solid rgba(255,255,255,0.07);
    }
    .campaign-card:hover { transform: translateY(-6px); border-color: rgba(249,115,22,0.3); }

    /* Shimmer Sweep Effect */
    @keyframes shimmerSweep {
        0% { left: -150%; }
        50% { left: -150%; }
        100% { left: 150%; }
    }
    .shimmer-btn {
        position: relative;
        overflow: hidden;
    }
    .shimmer-btn::after {
        content: '';
        position: absolute;
        top: 0;
        left: -150%;
        width: 50%;
        height: 100%;
        background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.45) 50%, rgba(255,255,255,0) 100%);
        transform: skewX(-25deg);
        animation: shimmerSweep 4.5s ease-in-out infinite;
        pointer-events: none;
    }

    /* Premium card glow */
    .premium-card-glow {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0, 0, 0, 0.06) !important;
    }
    .dark .premium-card-glow {
        border: 1px solid rgba(255, 255, 255, 0.07) !important;
    }
    .premium-card-glow:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 45px rgba(220, 38, 38, 0.1), 0 0 30px rgba(249, 115, 22, 0.05) !important;
        border-color: rgba(220, 38, 38, 0.2) !important;
    }
    .dark .premium-card-glow:hover {
        box-shadow: 0 25px 50px rgba(0,0,0,0.55), 0 0 35px rgba(232, 197, 71, 0.18) !important;
        border-color: rgba(232, 197, 71, 0.28) !important;
    }
</style>
@endsection

@section('content')
<!-- HERO SECTION -->
<section class="hero-section flex items-center justify-center relative">
    <!-- Floating particles -->
    <div class="particle w-3 h-3 bg-red-500/30 top-20 left-[10%]" style="animation-delay:0s;animation-duration:7s"></div>
    <div class="particle w-2 h-2 bg-orange-500/30 top-40 left-[25%]" style="animation-delay:1s;animation-duration:5s"></div>
    <div class="particle w-4 h-4 bg-blue-500/20 top-60 right-[15%]" style="animation-delay:2s;animation-duration:9s"></div>
    <div class="particle w-2 h-2 bg-red-400/40 bottom-40 left-[35%]" style="animation-delay:0.5s;animation-duration:6s"></div>
    <div class="particle w-3 h-3 bg-orange-400/20 bottom-60 right-[30%]" style="animation-delay:3s;animation-duration:8s"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-16 relative z-10">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Left: Text Content -->
            <div>
                <!-- Live status badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 glass rounded-full mb-8 border border-red-500/30">
                    <div class="relative w-2.5 h-2.5">
                        <div class="absolute inset-0 rounded-full bg-red-500 pulse-ring opacity-75"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>
                    </div>
                    <span class="text-red-400 text-sm font-semibold">LIVE — Situasi Darurat Aktif</span>
                    <span class="text-slate-400 text-sm">|</span>
                    <span class="text-slate-300 text-sm" id="liveTime"></span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight mb-6">
                    <span class="text-slate-900 dark:text-white">Bersama Tanggap</span><br>
                    <span class="gradient-text">Bencana,</span><br>
                    <span class="text-slate-900 dark:text-white">Bersama </span>
                    <span class="gradient-text">Selamatkan</span><br>
                    <span class="text-slate-900 dark:text-white">Sesama</span>
                </h1>

                <p class="text-slate-600 dark:text-slate-400 text-lg leading-relaxed mb-8 max-w-lg">
                    Platform digital terpadu untuk pelaporan bencana, koordinasi relawan, distribusi bantuan, dan donasi transparan di seluruh Indonesia.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-wrap gap-4 mb-10">
                    <a href="/report" id="btn-laporkan" class="flex items-center gap-3 px-6 py-3.5 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-bold rounded-2xl transition-all duration-200 glow-red shimmer-btn">
                        <i class="fas fa-exclamation-triangle"></i>
                        Laporkan Bencana
                    </a>
                    <a href="/donate" id="btn-donasi" class="flex items-center gap-3 px-6 py-3.5 bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-500 hover:to-amber-500 text-white font-bold rounded-2xl transition-all duration-200 glow-orange shimmer-btn">
                        <i class="fas fa-heart"></i>
                        Donasi Sekarang
                    </a>
                    <a href="/volunteer" id="btn-relawan" class="flex items-center gap-3 px-6 py-3.5 glass hover:bg-slate-200/50 dark:hover:bg-white/15 text-slate-700 dark:text-white font-bold rounded-2xl transition-all duration-200 border border-slate-300 dark:border-white/20 shimmer-btn">
                        <i class="fas fa-hands-helping"></i>
                        Jadi Relawan
                    </a>
                </div>

                <!-- Live stats row -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="glass rounded-xl p-4 text-center">
                        <div class="text-2xl font-black gradient-text" data-target="247" data-suffix="">247</div>
                        <div class="text-xs text-slate-500 mt-1">Laporan Aktif</div>
                    </div>
                    <div class="glass rounded-xl p-4 text-center">
                        <div class="text-2xl font-black text-orange-400" data-target="15890" data-suffix="">15.890</div>
                        <div class="text-xs text-slate-500 mt-1">Korban Terdampak</div>
                    </div>
                    <div class="glass rounded-xl p-4 text-center">
                        <div class="text-2xl font-black text-blue-400" data-target="8432" data-suffix="">8.432</div>
                        <div class="text-xs text-slate-500 mt-1">Bantuan Tersalur</div>
                    </div>
                    <div class="glass rounded-xl p-4 text-center">
                        <div class="text-2xl font-black text-green-400" data-target="3241" data-suffix="">3.241</div>
                        <div class="text-xs text-slate-500 mt-1">Relawan Aktif</div>
                    </div>
                </div>
            </div>

            <!-- Right: Hero Image -->
            <div class="relative">
                <div class="relative rounded-3xl overflow-hidden" style="box-shadow: 0 40px 80px rgba(0,0,0,0.6), 0 0 0 1px rgba(220,38,38,0.2);">
                    <img src="/images/hero_disaster.png" alt="Situasi Bencana Indonesia" class="w-full h-[500px] object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] via-transparent to-transparent"></div>

                    <!-- Overlay info card -->
                    <div class="absolute bottom-6 left-6 right-6 glass rounded-2xl p-4 border border-red-500/20">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-2.5 h-2.5 rounded-full bg-red-500 badge-urgent"></div>
                            <span class="text-red-400 text-xs font-bold uppercase tracking-wider">SIAGA DARURAT — AKTIF</span>
                        </div>
                        <p class="text-white font-semibold text-sm mb-1">Banjir Besar — Jakarta Utara, DKI Jakarta</p>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 text-xs">2.847 jiwa terdampak • Bantuan segera dibutuhkan</span>
                            <span class="px-2 py-0.5 bg-red-600/30 text-red-300 text-xs rounded-full">KRITIS</span>
                        </div>
                    </div>
                </div>

                <!-- Decorative elements -->
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-gradient-to-br from-orange-500/20 to-transparent rounded-full blur-xl"></div>
                <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-gradient-to-tr from-red-500/20 to-transparent rounded-full blur-xl"></div>
            </div>
        </div>
    </div>

    <!-- Scroll indicator -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 animate-bounce">
        <span class="text-slate-500 text-xs">Gulir ke bawah</span>
        <i class="fas fa-chevron-down text-slate-500 text-sm"></i>
    </div>
</section>

<!-- SECTION 2: CRISIS STATISTICS -->
<section class="py-20 bg-slate-50 dark:bg-[#0a0f1e] transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 fade-up">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-red-600/15 border border-red-600/25 rounded-full mb-4">
                <i class="fas fa-chart-line text-red-400 text-xs"></i>
                <span class="text-red-400 text-sm font-semibold">Data Real-Time</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mb-3">Statistik Krisis Nasional</h2>
            <p class="text-slate-600 dark:text-slate-400 max-w-xl mx-auto">Data kebencanaan Indonesia yang diperbarui secara real-time dari seluruh wilayah.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-5">
            <!-- Stat 1 -->
            <div class="stat-card p-6 fade-up">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500/20 to-red-600/10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-400 text-lg"></i>
                    </div>
                    <span class="px-2 py-0.5 bg-red-900/40 text-red-400 text-xs rounded-full font-medium">Live</span>
                </div>
                <div class="text-4xl font-black text-slate-900 dark:text-white mb-1" data-target="1284" data-suffix="">1.284</div>
                <div class="text-slate-500 dark:text-slate-400 text-sm font-medium">Total Laporan Bencana</div>
                <div class="mt-3 text-xs text-green-600 dark:text-green-400 flex items-center gap-1"><i class="fas fa-arrow-up text-xs"></i> +23 hari ini</div>
            </div>

            <!-- Stat 2 -->
            <div class="stat-card p-6 fade-up" style="animation-delay:0.1s">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-orange-500/20 to-orange-600/10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-users text-orange-400 text-lg"></i>
                    </div>
                    <span class="px-2 py-0.5 bg-orange-900/40 text-orange-400 text-xs rounded-full font-medium">Update</span>
                </div>
                <div class="text-4xl font-black text-slate-900 dark:text-white mb-1" data-target="89432" data-suffix="">89.432</div>
                <div class="text-slate-500 dark:text-slate-400 text-sm font-medium">Korban Terdampak</div>
                <div class="mt-3 text-xs text-red-600 dark:text-red-400 flex items-center gap-1"><i class="fas fa-arrow-up text-xs"></i> +1.245 minggu ini</div>
            </div>

            <!-- Stat 3 -->
            <div class="stat-card p-6 fade-up" style="animation-delay:0.2s">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500/20 to-blue-600/10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-box-open text-blue-400 text-lg"></i>
                    </div>
                    <span class="px-2 py-0.5 bg-blue-900/40 text-blue-400 text-xs rounded-full font-medium">Live</span>
                </div>
                <div class="text-4xl font-black text-slate-900 dark:text-white mb-1" data-target="54210" data-suffix="">54.210</div>
                <div class="text-slate-500 dark:text-slate-400 text-sm font-medium">Bantuan Tersalurkan</div>
                <div class="mt-3 text-xs text-green-600 dark:text-green-400 flex items-center gap-1"><i class="fas fa-arrow-up text-xs"></i> +892 hari ini</div>
            </div>

            <!-- Stat 4 -->
            <div class="stat-card p-6 fade-up" style="animation-delay:0.3s">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-500/20 to-yellow-600/10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-donate text-yellow-400 text-lg"></i>
                    </div>
                    <span class="px-2 py-0.5 bg-yellow-900/40 text-yellow-400 text-xs rounded-full font-medium">Live</span>
                </div>
                <div class="text-4xl font-black text-slate-900 dark:text-white mb-1"><span class="grand-total-counter" data-target="{{ 42000000000 + $totalDonationsInDb }}" data-prefix="Rp " data-suffix="">Rp {{ number_format(42000000000 + $totalDonationsInDb, 0, ',', '.') }}</span></div>
                <div class="text-slate-500 dark:text-slate-400 text-sm font-medium">Donasi Terkumpul</div>
                <div class="mt-3 text-xs text-green-600 dark:text-green-400 flex items-center gap-1"><i class="fas fa-arrow-up text-xs"></i> +Rp 850 jt bulan ini</div>
            </div>

            <!-- Stat 5 -->
            <div class="stat-card p-6 fade-up" style="animation-delay:0.4s">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500/20 to-green-600/10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-hard-hat text-green-400 text-lg"></i>
                    </div>
                    <span class="px-2 py-0.5 bg-green-900/40 text-green-400 text-xs rounded-full font-medium">Aktif</span>
                </div>
                <div class="text-4xl font-black text-slate-900 dark:text-white mb-1" data-target="12847" data-suffix="">12.847</div>
                <div class="text-slate-500 dark:text-slate-400 text-sm font-medium">Relawan Aktif</div>
                <div class="mt-3 text-xs text-green-600 dark:text-green-400 flex items-center gap-1"><i class="fas fa-arrow-up text-xs"></i> +156 bergabung</div>
            </div>

            <!-- Stat 6 -->
            <div class="stat-card p-6 fade-up" style="animation-delay:0.5s">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500/20 to-purple-600/10 rounded-xl flex items-center justify-center">
                        <i class="fas fa-map-marked-alt text-purple-400 text-lg"></i>
                    </div>
                    <span class="px-2 py-0.5 bg-purple-900/40 text-purple-400 text-xs rounded-full font-medium">Live</span>
                </div>
                <div class="text-4xl font-black text-slate-900 dark:text-white mb-1" data-target="34" data-suffix=" Prov">34 Prov</div>
                <div class="text-slate-500 dark:text-slate-400 text-sm font-medium">Wilayah Terdampak</div>
                <div class="mt-3 text-xs text-orange-600 dark:text-orange-400 flex items-center gap-1"><i class="fas fa-map-pin text-xs"></i> 198 kabupaten/kota</div>
            </div>
        </div>
    </div>
</section>

<!-- SECTION 3: LIVE DISASTER MAP -->
<section class="py-20 bg-slate-50 dark:bg-[#0f172a] transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 mb-10 fade-up">
            <div>
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-blue-600/15 border border-blue-600/25 rounded-full mb-3">
                    <i class="fas fa-satellite-dish text-blue-500 dark:text-blue-400 text-xs"></i>
                    <span class="text-blue-600 dark:text-blue-400 text-sm font-semibold">Peta Interaktif Real-Time</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mb-2">Peta Bencana Live</h2>
                <p class="text-slate-600 dark:text-slate-400">Lihat kondisi bencana di seluruh Indonesia secara real-time.</p>
            </div>
            <!-- Filters -->
            <div class="flex flex-wrap gap-3">
                <select id="filterType" class="glass px-4 py-2 rounded-xl text-slate-700 dark:text-slate-300 text-sm border border-slate-200 dark:border-white/10 bg-transparent cursor-pointer outline-none">
                    <option value="all" class="bg-white text-slate-950 dark:bg-slate-800 dark:text-white">Semua Jenis</option>
                    <option value="banjir" class="bg-white text-slate-950 dark:bg-slate-800 dark:text-white">🌊 Banjir</option>
                    <option value="gempa" class="bg-white text-slate-950 dark:bg-slate-800 dark:text-white">🏔️ Gempa Bumi</option>
                    <option value="longsor" class="bg-white text-slate-950 dark:bg-slate-800 dark:text-white">⛰️ Longsor</option>
                    <option value="gunung" class="bg-white text-slate-950 dark:bg-slate-800 dark:text-white">🌋 Gunung Api</option>
                    <option value="angin" class="bg-white text-slate-950 dark:bg-slate-800 dark:text-white">💨 Angin Kencang</option>
                </select>
                <select id="filterStatus" class="glass px-4 py-2 rounded-xl text-slate-700 dark:text-slate-300 text-sm border border-slate-200 dark:border-white/10 bg-transparent cursor-pointer outline-none">
                    <option value="all" class="bg-white text-slate-950 dark:bg-slate-800 dark:text-white">Semua Status</option>
                    <option value="kritis" class="bg-white text-slate-950 dark:bg-slate-800 dark:text-white">🔴 Kritis</option>
                    <option value="sedang" class="bg-white text-slate-950 dark:bg-slate-800 dark:text-white">🟠 Sedang</option>
                    <option value="terkendali" class="bg-white text-slate-950 dark:bg-slate-800 dark:text-white">🟡 Terkendali</option>
                </select>
                <a href="/peta-bencana" class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold rounded-xl transition-all">
                    <i class="fas fa-expand"></i> Peta Penuh
                </a>
            </div>
        </div>

        <!-- Map Container -->
        <div class="relative rounded-2xl overflow-hidden border border-slate-200 dark:border-white/10 fade-up" style="box-shadow: 0 20px 60px rgba(0,0,0,0.05), 0 20px 60px rgba(0,0,0,0.25);">
            <div id="disaster-map" style="height: 520px; background: #0f172a;"></div>

            <!-- Map Legend -->
            <div class="absolute bottom-4 left-4 glass rounded-xl p-4 border border-slate-200 dark:border-white/10">
                <p class="text-slate-500 dark:text-slate-400 text-xs font-semibold mb-3 uppercase tracking-wider">Legenda</p>
                <div class="space-y-2">
                    <div class="flex items-center gap-2"><div class="w-3 h-3 rounded-full bg-red-500"></div><span class="text-slate-700 dark:text-slate-300 text-xs">Kritis</span></div>
                    <div class="flex items-center gap-2"><div class="w-3 h-3 rounded-full bg-orange-500"></div><span class="text-slate-700 dark:text-slate-300 text-xs">Sedang</span></div>
                    <div class="flex items-center gap-2"><div class="w-3 h-3 rounded-full bg-yellow-500"></div><span class="text-slate-700 dark:text-slate-300 text-xs">Terkendali</span></div>
                    <div class="flex items-center gap-2"><div class="w-3 h-3 rounded-full bg-blue-500"></div><span class="text-slate-700 dark:text-slate-300 text-xs">Banjir</span></div>
                    <div class="flex items-center gap-2"><div class="w-3 h-3 rounded-full bg-purple-500"></div><span class="text-slate-700 dark:text-slate-300 text-xs">Gempa</span></div>
                </div>
            </div>

            <!-- Live indicator -->
            <div class="absolute top-4 right-4 flex items-center gap-2 glass rounded-full px-3 py-2">
                <div class="w-2 h-2 rounded-full bg-red-500 badge-urgent"></div>
                <span class="text-red-500 dark:text-red-400 text-xs font-bold">LIVE</span>
            </div>
        </div>
    </div>
</section>

<!-- SECTION 4: CURRENT EMERGENCY CASES -->
<section class="py-20 bg-white dark:bg-[#0a0f1e] transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-start md:items-end justify-between mb-12 gap-4 fade-up">
            <div>
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-red-600/15 border border-red-600/25 rounded-full mb-3">
                    <div class="w-2 h-2 rounded-full bg-red-500 badge-urgent"></div>
                    <span class="text-red-500 dark:text-red-400 text-sm font-semibold">Prioritas Tinggi</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mb-2">Kasus Darurat Terkini</h2>
                <p class="text-slate-600 dark:text-slate-400">Bencana yang memerlukan bantuan segera dari seluruh wilayah Indonesia.</p>
            </div>
            <a href="/disasters" class="flex items-center gap-2 px-5 py-2.5 glass border border-slate-200 dark:border-white/10 hover:border-red-500/40 text-slate-700 dark:text-slate-300 hover:text-red-600 dark:hover:text-white rounded-xl text-sm font-medium transition-all">
                Lihat Semua <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
            @php
                // Merge database reports and mock cases
                $dbReports = $reports ?? collect();
                
                // Convert DB reports to the structure used by the card
                $cards = [];
                foreach ($dbReports as $rep) {
                    $priorityRel = \App\Models\PriorityScore::where('report_id', $rep->id)->first();
                    $priorityScore = $priorityRel ? $priorityRel->score : $rep->priority_score;
                    $level = $priorityRel ? $priorityRel->level : 'Sedang';

                    $statusColor = 'orange';
                    if (strtolower($level) === 'kritis') $statusColor = 'red';
                    elseif (strtolower($level) === 'tinggi') $statusColor = 'red';
                    elseif (strtolower($level) === 'terkendali' || strtolower($level) === 'rendah') $statusColor = 'green';
                    
                    $badgeClass = 'bg-red-600';
                    if (strtolower($level) === 'sedang') $badgeClass = 'bg-orange-500';
                    elseif (strtolower($level) === 'rendah') $badgeClass = 'bg-green-500';

                    $typeIcons = [
                        'Banjir' => '🌊 Banjir',
                        'Gempa' => '🏔️ Gempa',
                        'Gempa Bumi' => '🏔️ Gempa',
                        'Gunung Api' => '🌋 Gunung Api',
                        'Gunung' => '🌋 Gunung Api',
                        'Longsor' => '⛰️ Longsor',
                        'Tanah Longsor' => '⛰️ Longsor',
                        'Angin' => '💨 Angin Kencang',
                        'Angin Kencang' => '💨 Angin Kencang',
                        'Angin Topan' => '💨 Angin Kencang',
                    ];
                    
                    $typeStr = '⚠ Bencana';
                    foreach ($typeIcons as $k => $v) {
                        if (stripos($rep->jenis_bencana, $k) !== false) {
                            $typeStr = $v;
                            break;
                        }
                    }

                    // Volunteer availability and resource allocation status
                    $assignedVolunteers = \App\Models\VolunteerTask::where('report_id', $rep->id)->count();
                    if ($assignedVolunteers >= 5) {
                        $resourceStatus = 'Cukup';
                        $resourceClass = 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400';
                    } elseif ($assignedVolunteers >= 2) {
                        $resourceStatus = 'Sedang';
                        $resourceClass = 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400';
                    } else {
                        $resourceStatus = 'Kurang';
                        $resourceClass = 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400';
                    }

                    $cards[] = [
                        'id' => $rep->id,
                        'is_db' => true,
                        'title' => $rep->jenis_bencana . ' - ' . ($rep->alamat_lengkap ? explode(',', $rep->alamat_lengkap)[0] : 'Lokasi Terdampak'),
                        'type_str' => $typeStr,
                        'status' => strtoupper($level),
                        'badge_class' => $badgeClass,
                        'priority_score' => number_format($priorityScore / 10, 1),
                        'location' => $rep->alamat_lengkap ?: 'Tidak Diketahui',
                        'date' => $rep->created_at->diffForHumans(),
                        'korban' => number_format($rep->jumlah_korban),
                        'kerusakan' => $rep->tingkat_kerusakan ?: 'Sedang',
                        'resource_status' => $resourceStatus,
                        'resource_class' => $resourceClass,
                        'image' => $rep->foto_path ? \Illuminate\Support\Facades\Storage::url($rep->foto_path) : '/images/flood_case.png',
                    ];
                }

                // Mock cases fallback
                $mockCases = [
                    [
                        'id' => 1,
                        'is_db' => false,
                        'title' => 'Banjir Jakarta Utara',
                        'type_str' => '🌊 Banjir',
                        'status' => 'KRITIS',
                        'badge_class' => 'bg-red-600',
                        'priority_score' => '9.2',
                        'location' => 'Jakarta Utara, DKI Jakarta',
                        'date' => '6 jam yang lalu',
                        'korban' => '2.847',
                        'kerusakan' => 'Hancur Total',
                        'resource_status' => 'Kurang',
                        'resource_class' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
                        'image' => '/images/flood_case.png',
                    ],
                    [
                        'id' => 2,
                        'is_db' => false,
                        'title' => 'Gempa 6.2 SR Cianjur',
                        'type_str' => '🏔️ Gempa',
                        'status' => 'KRITIS',
                        'badge_class' => 'bg-red-600',
                        'priority_score' => '8.7',
                        'location' => 'Cianjur, Jawa Barat',
                        'date' => '2 jam yang lalu',
                        'korban' => '1.340',
                        'kerusakan' => 'Tinggi',
                        'resource_status' => 'Sangat Kurang',
                        'resource_class' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
                        'image' => '/images/earthquake_case.png',
                    ],
                    [
                        'id' => 3,
                        'is_db' => false,
                        'title' => 'Banjir Banjarmasin',
                        'type_str' => '🌊 Banjir',
                        'status' => 'AKTIF',
                        'badge_class' => 'bg-orange-500',
                        'priority_score' => '7.5',
                        'location' => 'Banjarmasin, Kalimantan Selatan',
                        'date' => '1 hari yang lalu',
                        'korban' => '892',
                        'kerusakan' => 'Sedang',
                        'resource_status' => 'Cukup',
                        'resource_class' => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
                        'image' => '/images/flood_case.png',
                    ],
                    [
                        'id' => 4,
                        'is_db' => false,
                        'title' => 'Gunung Api Sinabung',
                        'type_str' => '🌋 Gunung Api',
                        'status' => 'SIAGA',
                        'badge_class' => 'bg-orange-500',
                        'priority_score' => '6.8',
                        'location' => 'Karo, Sumatera Utara',
                        'date' => '3 hari yang lalu',
                        'korban' => '450',
                        'kerusakan' => 'Sedang',
                        'resource_status' => 'Cukup',
                        'resource_class' => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
                        'image' => '/images/donation_banner.png',
                    ],
                ];

                // Combine them, keeping db reports first, and then filling up to 4 if needed
                $finalCards = array_merge($cards, array_slice($mockCases, count($cards)));
                // Take at most 8 cases to keep layout clean
                $finalCards = array_slice($finalCards, 0, 8);
            @endphp

            @foreach($finalCards as $i => $card)
            <div class="case-card premium-card-glow fade-up" style="animation-delay: {{ $i * 0.1 }}s">
                <div class="relative">
                    <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}" class="w-full h-48 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] via-transparent to-transparent"></div>
                    <div class="absolute top-3 left-3 flex gap-2">
                        <span class="px-2.5 py-1 {{ $card['badge_class'] }} text-white text-xs font-bold rounded-lg badge-urgent">{{ $card['status'] }}</span>
                        <span class="px-2.5 py-1 bg-blue-600/80 text-white text-xs font-medium rounded-lg">{{ $card['type_str'] }}</span>
                    </div>
                    <div class="absolute top-3 right-3 glass rounded-lg px-2 py-1 border-0">
                        <div class="text-white text-xs font-bold">Priority: <span class="text-red-400">{{ $card['priority_score'] }}</span></div>
                    </div>
                </div>
                <div class="p-5 flex flex-col justify-between" style="min-height: 250px;">
                    <div>
                        <h3 class="text-slate-900 dark:text-white font-bold text-base mb-1 line-clamp-1">{{ $card['title'] }}</h3>
                        <p class="text-slate-500 text-xs mb-3 flex items-center gap-1"><i class="fas fa-map-marker-alt text-red-500"></i> {{ $card['location'] }}</p>
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div class="bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-transparent rounded-lg p-2.5 text-center">
                                <div class="text-red-600 dark:text-red-400 font-black text-lg">{{ $card['korban'] }}</div>
                                <div class="text-slate-550 dark:text-slate-400 text-xs">Korban Jiwa</div>
                            </div>
                            <div class="bg-orange-50 dark:bg-orange-900/20 border border-orange-100 dark:border-transparent rounded-lg p-2.5 text-center">
                                <div class="text-orange-600 dark:text-orange-400 font-black text-lg">{{ $card['kerusakan'] }}</div>
                                <div class="text-slate-550 dark:text-slate-400 text-xs">Kerusakan</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-slate-500 dark:text-slate-400 text-xs">Bantuan Aktif</span>
                            <span class="px-2 py-0.5 {{ $card['resource_class'] }} text-xs rounded-full font-semibold">{{ $card['resource_status'] }}</span>
                        </div>
                        <div class="text-xs text-slate-500 mb-4 flex items-center gap-1"><i class="fas fa-clock"></i> {{ $card['date'] }}</div>
                        <a href="/disaster/{{ $card['id'] }}" class="block w-full text-center py-2.5 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-semibold text-sm rounded-xl transition-all">
                            Detail Kasus <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- SECTION 5: HOW CRISISHUB WORKS -->
<section class="py-20 bg-slate-50 dark:bg-[#0f172a] transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 fade-up">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-green-600/15 border border-green-600/25 rounded-full mb-4">
                <i class="fas fa-cogs text-green-500 dark:text-green-400 text-xs"></i>
                <span class="text-green-600 dark:text-green-400 text-sm font-semibold">Sistem Kami</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mb-3">Bagaimana CrisisHub Bekerja?</h2>
            <p class="text-slate-600 dark:text-slate-400 max-w-xl mx-auto">Proses dari laporan masuk hingga bantuan diterima, semua terkoordinasi dalam satu platform.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @php
            $steps = [
                ['icon' => 'fas fa-bell', 'color' => 'red', 'num' => '01', 'title' => 'Laporan Masuk', 'desc' => 'Warga melaporkan bencana melalui aplikasi dengan data lokasi GPS, foto, dan deskripsi kejadian secara real-time.'],
                ['icon' => 'fas fa-check-double', 'color' => 'orange', 'num' => '02', 'title' => 'Verifikasi', 'desc' => 'Tim CrisisHub dan AI memverifikasi laporan dalam hitungan menit untuk memastikan akurasi dan menghindari laporan palsu.'],
                ['icon' => 'fas fa-brain', 'color' => 'yellow', 'num' => '03', 'title' => 'Penilaian Prioritas', 'desc' => 'Sistem AI menghitung priority score berdasarkan jumlah korban, tingkat kerusakan, dan ketersediaan sumber daya.'],
                ['icon' => 'fas fa-truck', 'color' => 'blue', 'num' => '04', 'title' => 'Distribusi Bantuan', 'desc' => 'Bantuan dikoordinasikan dan didistribusikan secara efisien berdasarkan prioritas dan kebutuhan di lapangan.'],
                ['icon' => 'fas fa-user-shield', 'color' => 'green', 'num' => '05', 'title' => 'Penugasan Relawan', 'desc' => 'Relawan ditugaskan berdasarkan keahlian, lokasi, dan kebutuhan spesifik setiap kejadian bencana.'],
                ['icon' => 'fas fa-hands-helping', 'color' => 'purple', 'num' => '06', 'title' => 'Bantuan Diterima', 'desc' => 'Korban menerima bantuan yang terdata dan tercatat, dengan laporan transparansi yang dapat diakses publik.'],
            ];
            @endphp

            @foreach($steps as $i => $step)
            <div class="step-card premium-card-glow fade-up relative overflow-hidden" style="animation-delay: {{ $i * 0.1 }}s">
                <div class="absolute top-0 right-0 text-8xl font-black text-slate-900/[0.03] dark:text-white/5 -mt-3 -mr-3 leading-none select-none">{{ $step['num'] }}</div>
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-{{ $step['color'] }}-600/20 border border-{{ $step['color'] }}-600/30 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="{{ $step['icon'] }} text-{{ $step['color'] }}-600 dark:text-{{ $step['color'] }}-400"></i>
                    </div>
                    <div>
                        <div class="text-{{ $step['color'] }}-600 dark:text-{{ $step['color'] }}-400 text-xs font-bold mb-1">LANGKAH {{ $step['num'] }}</div>
                        <h3 class="text-slate-900 dark:text-white font-bold text-lg mb-2">{{ $step['title'] }}</h3>
                        <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">{{ $step['desc'] }}</p>
                    </div>
                </div>
                @if($i < count($steps) - 1)
                <div class="hidden lg:block absolute bottom-0 right-0 text-slate-700">
                    @if(($i + 1) % 3 !== 0)
                    <div class="w-8 h-full flex items-center justify-center absolute right-0 top-0 -mr-4">
                        <i class="fas fa-arrow-right text-slate-400 dark:text-slate-700/50"></i>
                    </div>
                    @endif
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- SECTION 6: LATEST NEWS -->
<section class="py-20 bg-white dark:bg-[#0a0f1e] transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-start md:items-end justify-between mb-12 gap-4 fade-up">
            <div>
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-purple-600/15 border border-purple-600/25 rounded-full mb-3">
                    <i class="fas fa-newspaper text-purple-600 dark:text-purple-400 text-xs"></i>
                    <span class="text-purple-600 dark:text-purple-400 text-sm font-semibold">Informasi Terkini</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mb-2">Berita & Update</h2>
                <p class="text-slate-600 dark:text-slate-400">Informasi kebencanaan dan distribusi bantuan terbaru.</p>
            </div>
            <a href="/news" class="flex items-center gap-2 px-5 py-2.5 glass border border-slate-200 dark:border-white/10 hover:border-purple-500/40 text-slate-700 dark:text-slate-300 hover:text-purple-600 dark:hover:text-white rounded-xl text-sm font-medium transition-all">
                Semua Berita <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
            $news = array_slice(getMockNews(), 0, 3);
            @endphp

            @foreach($news as $item)
            <div class="news-card news-card-item premium-card-glow group fade-up" style="animation-delay: {{ $loop->index * 0.1 }}s">
                <div class="relative overflow-hidden h-48">
                    <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] via-transparent to-transparent"></div>
                    <div class="absolute top-3 left-3">
                        <span class="px-2.5 py-1 bg-{{ $item['color'] }}-600/80 text-white text-xs font-semibold rounded-lg">{{ $item['tag'] }}</span>
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="text-slate-900 dark:text-white font-bold text-base leading-snug mb-3 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors">{{ $item['title'] }}</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed mb-4 line-clamp-3">{{ $item['summary'] }}</p>
                    <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar-alt"></i>
                            <span>{{ $item['date'] }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-clock"></i>
                            <span>{{ $item['read'] }} baca</span>
                        </div>
                    </div>
                    <a href="{{ $item['url'] }}" target="_blank" rel="noopener noreferrer" class="mt-4 flex items-center gap-2 text-red-600 dark:text-red-400 hover:text-red-500 dark:hover:text-red-300 text-sm font-semibold transition-colors">
                        Baca di {{ $item['author'] }} <i class="fas fa-external-link-alt text-xs"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- SECTION 7: VOLUNTEER RECRUITMENT -->
<section class="py-20 bg-slate-50 dark:bg-[#0f172a] relative overflow-hidden transition-colors duration-300">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-0 w-96 h-96 bg-green-600/5 rounded-full blur-3xl -translate-x-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-600/5 rounded-full blur-3xl translate-x-1/2"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Left -->
            <div class="fade-up">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-green-600/15 border border-green-600/25 rounded-full mb-5">
                    <i class="fas fa-hard-hat text-green-600 dark:text-green-400 text-xs"></i>
                    <span class="text-green-600 dark:text-green-400 text-sm font-semibold">Bergabung Bersama Kami</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mb-5">Menjadi Garda Terdepan <span class="gradient-text">Saat Bencana</span></h2>
                <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-8">Bergabunglah dengan ribuan relawan CrisisHub yang siap membantu sesama di seluruh Indonesia. Tidak perlu pengalaman, hanya butuh tekad dan hati yang ikhlas.</p>

                <!-- Benefits -->
                <div class="space-y-4 mb-8">
                    @php
                    $benefits = [
                        ['icon' => 'fas fa-graduation-cap', 'color' => 'blue', 'title' => 'Pelatihan Resmi BNPB', 'desc' => 'Training penanggulangan bencana bersertifikat nasional'],
                        ['icon' => 'fas fa-certificate', 'color' => 'yellow', 'title' => 'Sertifikat Kompetensi', 'desc' => 'Sertifikat yang diakui pemerintah dan industri'],
                        ['icon' => 'fas fa-users', 'color' => 'green', 'title' => 'Networking Luas', 'desc' => 'Terhubung dengan 12.000+ relawan se-Indonesia'],
                        ['icon' => 'fas fa-medal', 'color' => 'orange', 'title' => 'Pengalaman Nyata', 'desc' => 'Terlibat langsung dalam operasi penyelamatan lapangan'],
                    ];
                    @endphp
                    @foreach($benefits as $b)
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-{{ $b['color'] }}-600/20 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="{{ $b['icon'] }} text-{{ $b['color'] }}-600 dark:text-{{ $b['color'] }}-400 text-sm"></i>
                        </div>
                        <div>
                            <div class="text-slate-900 dark:text-white font-semibold text-sm">{{ $b['title'] }}</div>
                            <div class="text-slate-650 dark:text-slate-400 text-xs mt-0.5">{{ $b['desc'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('apply.volunteer') }}" id="btn-daftar-relawan" class="flex items-center gap-2 px-6 py-3.5 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 text-white font-bold rounded-2xl transition-all glow-blue shimmer-btn">
                        <i class="fas fa-hard-hat"></i>Daftar Jadi Relawan
                    </a>
                    <a href="/volunteer#info" class="flex items-center gap-2 px-6 py-3.5 glass border border-slate-200 dark:border-white/10 hover:border-green-500/30 text-slate-700 dark:text-white font-medium rounded-2xl transition-all shimmer-btn">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>

            <!-- Right: Image + Stats -->
            <div class="fade-up" style="animation-delay:0.2s">
                <div class="relative">
                    <img src="/images/volunteer_team.png" alt="Tim Relawan CrisisHub" class="w-full h-[400px] object-cover rounded-3xl" style="box-shadow: 0 30px 60px rgba(0,0,0,0.05), 0 30px 60px rgba(0,0,0,0.4);">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a]/80 via-transparent to-transparent rounded-3xl"></div>

                    <!-- Floating stats -->
                    <div class="absolute -left-6 top-1/4 glass rounded-2xl p-4 border border-green-500/20">
                        <div class="text-3xl font-black text-green-600 dark:text-green-400">12K+</div>
                        <div class="text-slate-600 dark:text-slate-300 text-xs mt-1 font-semibold">Relawan Aktif</div>
                    </div>
                    <div class="absolute -right-6 top-1/2 glass rounded-2xl p-4 border border-blue-500/20">
                        <div class="text-3xl font-black text-blue-600 dark:text-blue-400">34</div>
                        <div class="text-slate-600 dark:text-slate-300 text-xs mt-1 font-semibold">Provinsi</div>
                    </div>
                    <div class="absolute bottom-8 left-8 right-8 glass rounded-xl p-4 border border-slate-200 dark:border-white/10">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-green-500 badge-urgent"></div>
                            <span class="text-green-600 dark:text-green-400 text-xs font-bold font-display">512 misi aktif sekarang</span>
                        </div>
                        <div class="mt-2 flex -space-x-2">
                            @for($i = 0; $i < 6; $i++)
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-{{ ['red','orange','blue','green','purple','yellow'][$i] }}-500 to-{{ ['red','orange','blue','green','purple','yellow'][$i] }}-700 border-2 border-slate-100 dark:border-[#0f172a] flex items-center justify-center text-xs text-white font-bold">R</div>
                            @endfor
                            <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 border-2 border-slate-100 dark:border-[#0f172a] flex items-center justify-center text-xs text-slate-700 dark:text-slate-300 font-bold">+</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECTION 8: DONATION CTA -->
<section class="py-20 bg-white dark:bg-[#0a0f1e] transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 fade-up">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-orange-600/15 border border-orange-600/25 rounded-full mb-4">
                <i class="fas fa-heart text-orange-500 dark:text-orange-400 text-xs"></i>
                <span class="text-orange-600 dark:text-orange-400 text-sm font-semibold">Campaign Donasi Aktif</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mb-3">Setiap Donasi <span class="gradient-text">Menyelamatkan Kehidupan</span></h2>
            <p class="text-slate-600 dark:text-slate-400 max-w-xl mx-auto">Bantuan Anda akan langsung tersalurkan kepada korban bencana yang membutuhkan, dengan laporan distribusi yang transparan.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            @foreach($campaigns as $i => $c)
            <div class="campaign-card premium-card-glow fade-up" style="animation-delay: {{ $i * 0.1 }}s">
                <div class="h-40 relative overflow-hidden flex items-center justify-center">
                    @if(stripos($c['title'], 'Banjir Jakarta') !== false)
                        <img src="/images/flood_case.png" alt="{{ $c['title'] }}" class="w-full h-40 object-cover">
                    @elseif(stripos($c['title'], 'Cianjur') !== false)
                        <img src="/images/cause1.png" alt="{{ $c['title'] }}" class="w-full h-40 object-cover">
                    @elseif(stripos($c['title'], 'Sinabung') !== false)
                        <img src="/images/cause2.png" alt="{{ $c['title'] }}" class="w-full h-40 object-cover">
                    @else
                        <img src="/images/flood_case.png" alt="{{ $c['title'] }}" class="w-full h-40 object-cover">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] via-transparent to-transparent"></div>
                    @if($c['urgent'])
                    <div class="absolute top-3 right-3 px-2.5 py-1 bg-red-600 text-white text-xs font-bold rounded-lg badge-urgent">URGENT</div>
                    @endif
                    <div class="absolute bottom-3 left-3 px-2 py-0.5 glass rounded-lg text-xs text-slate-700 dark:text-slate-300 border-0">
                        <i class="fas fa-map-marker-alt text-red-500 dark:text-red-400 mr-1"></i>{{ $c['location'] }}
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="text-slate-900 dark:text-white font-bold text-base mb-3">{{ $c['title'] }}</h3>

                    <!-- Progress -->
                    <div class="mb-3">
                        <div class="flex justify-between text-xs mb-2">
                            <span class="text-slate-500 dark:text-slate-400">Terkumpul</span>
                            <span class="text-orange-500 dark:text-orange-400 font-bold">{{ $c['pct'] }}%</span>
                        </div>
                        <div class="h-2 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                            <div class="progress-bar h-full" style="width: {{ $c['pct'] }}%"></div>
                        </div>
                    </div>

                    <div class="flex justify-between text-sm mb-3">
                        <div>
                            <div class="text-slate-950 dark:text-white font-bold">Rp {{ number_format($c['collected'], 0, ',', '.') }}</div>
                            <div class="text-slate-500 text-xs">dari Rp {{ number_format($c['target'], 0, ',', '.') }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-orange-600 dark:text-orange-400 font-semibold text-sm">⏳ {{ $c['deadline'] }}</div>
                            <div class="text-slate-500 text-xs font-medium">sisa waktu</div>
                        </div>
                    </div>

                    @auth
                    <a href="/donate" class="block w-full text-center py-2.5 bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-500 hover:to-amber-500 text-white font-bold text-sm rounded-xl transition-all shimmer-btn">
                        <i class="fas fa-heart mr-2"></i>Donasi Sekarang
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="block w-full text-center py-2.5 bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-500 hover:to-amber-500 text-white font-bold text-sm rounded-xl transition-all shimmer-btn">
                        <i class="fas fa-heart mr-2"></i>Donasi Sekarang
                    </a>
                    @endauth
                </div>
            </div>
            @endforeach
        </div>

        <!-- Big CTA Banner -->
        <div class="relative overflow-hidden rounded-3xl p-10 text-center fade-up" style="background: linear-gradient(135deg, #1a0000 0%, #7f1d1d 50%, #1a0000 100%); border: 1px solid rgba(220,38,38,0.3);">
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute top-0 left-1/4 w-64 h-64 bg-red-500/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 right-1/4 w-64 h-64 bg-orange-500/10 rounded-full blur-3xl"></div>
            </div>
            <div class="relative z-10">
                <div class="text-5xl mb-4">❤️</div>
                <h3 class="text-3xl font-black text-white mb-3">Total Donasi Terkumpul</h3>
                <div class="text-5xl font-black gradient-text mb-2 grand-total-counter" data-target="{{ 42000000000 + $totalDonationsInDb }}" data-prefix="Rp " data-suffix="">Rp {{ number_format(42000000000 + $totalDonationsInDb, 0, ',', '.') }}</div>
                <p class="text-slate-300 mb-8 max-w-lg mx-auto">Dari 28.400+ donatur yang telah membantu sesama. Bergabunglah bersama kami!</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="/donate" class="flex items-center gap-2 px-8 py-4 bg-white text-red-700 hover:bg-red-50 font-black rounded-2xl text-lg transition-all">
                        <i class="fas fa-heart"></i>Donasi Sekarang
                    </a>
                    <a href="/donate#transparency" class="flex items-center gap-2 px-8 py-4 glass border border-white/20 text-white font-bold rounded-2xl text-lg transition-all hover:bg-white/10">
                        <i class="fas fa-chart-bar"></i>Lihat Transparansi
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // Live time update
    function updateTime() {
        const now = new Date();
        const options = { hour: '2-digit', minute: '2-digit', second: '2-digit', timeZone: 'Asia/Jakarta' };
        document.getElementById('liveTime').textContent = now.toLocaleTimeString('id-ID', options) + ' WIB';
    }
    setInterval(updateTime, 1000);
    updateTime();

    // Initialize Leaflet Map
    const map = L.map('disaster-map', {
        center: [-2.5, 118],
        zoom: 5,
        zoomControl: true,
        preferCanvas: true
    });

    // Define light and dark map tile layers
    const lightTile = L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
        attribution: '©OpenStreetMap ©CartoDB',
        subdomains: 'abcd',
        maxZoom: 19
    });
    const darkTile = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '©OpenStreetMap ©CartoDB',
        subdomains: 'abcd',
        maxZoom: 19
    });

    // Load initial map tile based on theme state
    const isInitialDark = document.documentElement.classList.contains('dark') || localStorage.getItem('darkMode') === 'true';
    if (isInitialDark) {
        darkTile.addTo(map);
    } else {
        lightTile.addTo(map);
    }

    // Set up MutationObserver to switch layers in real time when toggled
    const themeObserver = new MutationObserver(() => {
        const isCurrentDark = document.documentElement.classList.contains('dark');
        if (isCurrentDark) {
            map.removeLayer(lightTile);
            darkTile.addTo(map);
        } else {
            map.removeLayer(darkTile);
            lightTile.addTo(map);
        }
    });
    themeObserver.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });

    // Disaster data
    const disasters = [
        { id: 1, lat: -6.1, lng: 106.85, name: 'Banjir Jakarta Utara', type: 'banjir', status: 'kritis', korban: 2847, color: '#ef4444', icon: '🌊', priority: 9.2 },
        { id: 2, lat: -6.82, lng: 107.14, name: 'Gempa Cianjur 6.2 SR', type: 'gempa', status: 'kritis', korban: 1340, color: '#dc2626', icon: '🏔️', priority: 8.7 },
        { id: 3, lat: -3.32, lng: 114.59, name: 'Banjir Banjarmasin', type: 'banjir', status: 'sedang', korban: 4210, color: '#f97316', icon: '🌊', priority: 7.1 },
        { id: 4, lat: 3.18, lng: 98.52, name: 'Erupsi Sinabung', type: 'gunung', status: 'waspada', korban: 892, color: '#eab308', icon: '🌋', priority: 6.4 },
        { id: 5, lat: -8.65, lng: 115.22, name: 'Banjir Denpasar', type: 'banjir', status: 'terkendali', korban: 340, color: '#22c55e', icon: '🌊', priority: 4.2 },
        { id: 6, lat: -7.25, lng: 110.42, name: 'Longsor Purworejo', type: 'longsor', status: 'sedang', korban: 127, color: '#f97316', icon: '⛰️', priority: 6.8 },
        { id: 7, lat: 0.54, lng: 123.06, name: 'Gempa Palu 5.8 SR', type: 'gempa', status: 'kritis', korban: 445, color: '#dc2626', icon: '🏔️', priority: 7.8 },
        { id: 8, lat: -2.12, lng: 106.12, name: 'Banjir Bangka', type: 'banjir', status: 'sedang', korban: 680, color: '#f97316', icon: '🌊', priority: 5.5 },
        { id: 9, lat: -4.0, lng: 122.51, name: 'Angin Kencang Kendari', type: 'angin', status: 'terkendali', korban: 89, color: '#3b82f6', icon: '💨', priority: 3.8 },
        { id: 10, lat: -0.95, lng: 100.35, name: 'Banjir Padang', type: 'banjir', status: 'sedang', korban: 520, color: '#f97316', icon: '🌊', priority: 6.0 },
    ];

    let markers = [];
    function renderMarkers(filterType = 'all', filterStatus = 'all') {
        markers.forEach(m => map.removeLayer(m));
        markers = [];
        disasters.forEach(d => {
            if (filterType !== 'all' && d.type !== filterType) return;
            if (filterStatus !== 'all' && d.status !== filterStatus) return;

            const marker = L.circleMarker([d.lat, d.lng], {
                radius: 12 + d.priority,
                fillColor: d.color,
                color: '#fff',
                weight: 2,
                opacity: 0.9,
                fillOpacity: 0.85
            }).addTo(map);

            marker.bindPopup(`
                <div style="min-width:200px;font-family:'Outfit',sans-serif;">
                    <div style="font-size:20px;margin-bottom:6px">${d.icon}</div>
                    <strong style="font-size:14px;color:#f1f5f9;">${d.name}</strong>
                    <div style="margin-top:8px;display:flex;gap:8px;flex-wrap:wrap;">
                        <span style="padding:2px 8px;background:${d.color}33;color:${d.color};border-radius:99px;font-size:11px;font-weight:600;">${d.status.toUpperCase()}</span>
                        <span style="padding:2px 8px;background:#1e40af33;color:#93c5fd;border-radius:99px;font-size:11px;">Priority: ${d.priority}</span>
                    </div>
                    <div style="margin-top:10px;font-size:12px;color:#94a3b8;">
                        <div>👥 ${d.korban.toLocaleString('id-ID')} korban terdampak</div>
                        <div style="margin-top:4px;">🕐 Diperbarui baru saja</div>
                    </div>
                    <a href="/disaster/${d.id}" style="display:block;margin-top:10px;text-align:center;padding:6px;background:linear-gradient(135deg,#dc2626,#f97316);color:white;border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;">Lihat Detail</a>
                </div>
            `);
            markers.push(marker);
        });
    }
    renderMarkers();

    document.getElementById('filterType')?.addEventListener('change', e => {
        renderMarkers(e.target.value, document.getElementById('filterStatus').value);
    });
    document.getElementById('filterStatus')?.addEventListener('change', e => {
        renderMarkers(document.getElementById('filterType').value, e.target.value);
    });
</script>
@endsection
