@extends('layouts.public')

@section('title', 'Tentang CrisisHub — Platform Manajemen Bencana Indonesia')
@section('description', 'Kenali CrisisHub lebih dalam — visi, misi, solusi, dan dampak nyata dalam penanganan bencana di Indonesia.')

@section('content')
<!-- About Hero -->
<section class="hero-dynamic hero-about relative min-h-[60vh] flex items-center pt-24 pb-16 overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-red-600/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-orange-600/5 rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-red-600/15 border border-red-600/25 rounded-full mb-6">
                    <i class="fas fa-info-circle text-red-400 text-xs"></i>
                    <span class="text-red-400 text-sm font-semibold">Tentang Kami</span>
                </div>
                <h1 class="text-4xl sm:text-5xl font-black text-white mb-6 leading-tight">
                    Apa Itu <span class="gradient-text">CrisisHub</span>?
                </h1>
                <p class="text-slate-300 text-lg leading-relaxed mb-6">
                    CrisisHub adalah platform digital terpadu yang dirancang khusus untuk Indonesia — menghubungkan pelapor bencana, relawan, donatur, dan lembaga pemerintah dalam satu ekosistem yang cepat, transparan, dan efisien.
                </p>
                <p class="text-slate-400 leading-relaxed">
                    Kami percaya bahwa teknologi dapat menyelamatkan nyawa. Dengan sistem real-time berbasis GIS, AI prioritas bantuan, dan jaringan relawan terlatih di 34 provinsi, CrisisHub hadir sebagai solusi nyata bagi kebencanaan Indonesia.
                </p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="premium-sparkle-glass rounded-2xl p-6 border border-red-500/20">
                    <div class="w-12 h-12 bg-red-600/20 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-eye text-red-400 text-xl"></i>
                    </div>
                    <h3 class="text-white font-bold text-lg mb-2">Visi</h3>
                    <p class="text-slate-400 text-sm">Menjadi platform manajemen bencana terdepan di Asia Tenggara yang menyelamatkan jutaan jiwa.</p>
                </div>
                <div class="premium-sparkle-glass rounded-2xl p-6 border border-orange-500/20">
                    <div class="w-12 h-12 bg-orange-600/20 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-rocket text-orange-400 text-xl"></i>
                    </div>
                    <h3 class="text-white font-bold text-lg mb-2">Misi</h3>
                    <p class="text-slate-400 text-sm">Mempercepat respons, meningkatkan koordinasi, dan memastikan transparansi distribusi bantuan.</p>
                </div>
                <div class="premium-sparkle-glass rounded-2xl p-6 border border-blue-500/20 col-span-2">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-blue-600/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-bullseye text-blue-400"></i>
                        </div>
                        <h3 class="text-white font-bold">Tujuan Utama</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-2 text-sm text-slate-400">
                        <div class="flex items-center gap-2"><i class="fas fa-check text-green-400 text-xs"></i>Pelaporan real-time</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check text-green-400 text-xs"></i>Koordinasi relawan</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check text-green-400 text-xs"></i>Distribusi bantuan</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check text-green-400 text-xs"></i>Donasi transparan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Problem Background -->
<section class="py-20 bg-white dark:bg-[#0a0f1e] transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 fade-up">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-yellow-600/15 border border-yellow-600/25 rounded-full mb-4">
                <i class="fas fa-exclamation-circle text-yellow-550 dark:text-yellow-400 text-xs"></i>
                <span class="text-yellow-600 dark:text-yellow-400 text-sm font-semibold">Latar Belakang Masalah</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mb-3">Masalah yang Ingin Kami Selesaikan</h2>
            <p class="text-slate-650 dark:text-slate-400 max-w-xl mx-auto">Indonesia sebagai negara rawan bencana menghadapi berbagai tantangan kritis dalam penanganan darurat.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @php
            $problems = [
                ['icon' => 'fas fa-clock', 'color' => 'red', 'title' => 'Laporan Terlambat', 'desc' => 'Bencana sering kali baru diketahui oleh pihak berwenang berjam-jam setelah kejadian, memperlambat respons penyelamatan yang kritis.', 'stat' => '3-6 jam', 'statLabel' => 'rata-rata keterlambatan laporan'],
                ['icon' => 'fas fa-balance-scale', 'color' => 'orange', 'title' => 'Bantuan Tidak Merata', 'desc' => 'Distribusi bantuan sering tidak merata; sebagian wilayah kelebihan bantuan sementara yang lain terabaikan karena kurangnya koordinasi.', 'stat' => '40%', 'statLabel' => 'wilayah tidak terjangkau optimal'],
                ['icon' => 'fas fa-eye-slash', 'color' => 'yellow', 'title' => 'Kurang Transparansi', 'desc' => 'Donatur tidak dapat melacak ke mana dana mereka pergi, mengurangi kepercayaan publik dan menurunkan motivasi berdonasi.', 'stat' => '68%', 'statLabel' => 'donatur ragukan transparansi'],
                ['icon' => 'fas fa-random', 'color' => 'blue', 'title' => 'Koordinasi Tidak Efektif', 'desc' => 'Ribuan relawan bergerak tanpa sistem yang terkoordinasi, menyebabkan tumpang tindih dan pemborosan sumber daya.', 'stat' => '12.000+', 'statLabel' => 'relawan tanpa koordinasi terpusat'],
            ];
            @endphp
            @foreach($problems as $i => $p)
            <div class="glass rounded-2xl p-8 border border-{{ $p['color'] }}-500/15 premium-card-glow fade-up" style="animation-delay: {{ $i * 0.1 }}s">
                <div class="flex items-start gap-5">
                    <div class="w-14 h-14 bg-{{ $p['color'] }}-600/20 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="{{ $p['icon'] }} text-{{ $p['color'] }}-500 dark:text-{{ $p['color'] }}-400 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-slate-800 dark:text-white font-bold text-xl mb-2">{{ $p['title'] }}</h3>
                        <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed mb-4">{{ $p['desc'] }}</p>
                        <div class="flex items-baseline gap-2">
                            <span class="text-{{ $p['color'] }}-600 dark:text-{{ $p['color'] }}-400 text-3xl font-black">{{ $p['stat'] }}</span>
                            <span class="text-slate-550 dark:text-slate-500 text-xs">{{ $p['statLabel'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Our Solution -->
<section class="py-20 bg-slate-50 dark:bg-[#0f172a] transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 fade-up">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-green-600/15 border border-green-600/25 rounded-full mb-4">
                <i class="fas fa-lightbulb text-green-550 dark:text-green-400 text-xs"></i>
                <span class="text-green-600 dark:text-green-400 text-sm font-semibold">Solusi Kami</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mb-3">Solusi Teknologi CrisisHub</h2>
            <p class="text-slate-650 dark:text-slate-400 max-w-xl mx-auto">Sistem terintegrasi yang menjawab setiap tantangan kebencanaan Indonesia.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $solutions = [
                ['icon' => 'fas fa-bell', 'color' => 'red', 'title' => 'Real-Time Reporting', 'desc' => 'Sistem pelaporan bencana berbasis GPS dengan verifikasi AI dalam hitungan menit. Foto, video, dan data lapangan langsung masuk ke dashboard.'],
                ['icon' => 'fas fa-map', 'color' => 'blue', 'title' => 'GIS Mapping', 'desc' => 'Peta interaktif Indonesia yang menampilkan kondisi bencana real-time dengan heatmap, filter jenis, dan popup informasi lengkap.'],
                ['icon' => 'fas fa-brain', 'color' => 'purple', 'title' => 'Smart Priority Scoring', 'desc' => 'Algoritma AI menghitung skor prioritas berdasarkan jumlah korban, kerusakan, aksesibilitas, dan ketersediaan sumber daya.'],
                ['icon' => 'fas fa-search-dollar', 'color' => 'yellow', 'title' => 'Donation Tracking', 'desc' => 'Sistem pelacakan donasi end-to-end yang memungkinkan donatur memantau setiap rupiah hingga sampai ke tangan penerima.'],
                ['icon' => 'fas fa-users-cog', 'color' => 'green', 'title' => 'Volunteer Coordination', 'desc' => 'Platform manajemen relawan dengan penugasan otomatis berdasarkan keahlian, lokasi, dan ketersediaan, terintegrasi langsung di lapangan.'],
                ['icon' => 'fas fa-satellite', 'color' => 'orange', 'title' => 'Emergency Communication', 'desc' => 'Sistem notifikasi multi-channel (push, SMS, email) dengan peringatan darurat berbasis radius lokasi pengguna.'],
            ];
            @endphp
            @foreach($solutions as $i => $s)
            <div class="glass rounded-2xl p-7 border border-white/7 card-hover premium-card-glow fade-up" style="animation-delay: {{ $i * 0.1 }}s">
                <div class="w-14 h-14 bg-{{ $s['color'] }}-600/20 rounded-2xl flex items-center justify-center mb-5">
                    <i class="{{ $s['icon'] }} text-{{ $s['color'] }}-500 dark:text-{{ $s['color'] }}-400 text-2xl"></i>
                </div>
                <h3 class="text-slate-800 dark:text-white font-bold text-xl mb-3">{{ $s['title'] }}</h3>
                <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">{{ $s['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Ecosystem -->
<section class="py-20 bg-white dark:bg-[#0a0f1e] transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 fade-up">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-blue-600/15 border border-blue-600/25 rounded-full mb-4">
                <i class="fas fa-project-diagram text-blue-555 dark:text-blue-400 text-xs"></i>
                <span class="text-blue-600 dark:text-blue-400 text-sm font-semibold">Ekosistem Platform</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mb-3">Ekosistem CrisisHub</h2>
            <p class="text-slate-650 dark:text-slate-400 max-w-xl mx-auto">Semua pihak terhubung dalam satu platform untuk respons bencana yang efektif.</p>
        </div>

        <div class="relative fade-up">
            <!-- Center Hub -->
            <div class="flex justify-center mb-8">
                <div class="relative">
                    <div class="w-32 h-32 bg-gradient-to-br from-red-600 to-orange-600 rounded-3xl flex items-center justify-center" style="box-shadow: 0 0 60px rgba(220,38,38,0.4);">
                        <div class="text-center">
                            <i class="fas fa-shield-alt text-white text-3xl mb-1"></i>
                            <div class="text-white font-black text-sm">CrisisHub</div>
                        </div>
                    </div>
                    <!-- Lines to hub -->
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <div class="w-64 h-64 rounded-full border-2 border-dashed border-red-500/20 animate-spin" style="animation-duration: 20s;"></div>
                    </div>
                </div>
            </div>

            <!-- Ecosystem roles grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
                @php
                $roles = [
                    ['icon' => 'fas fa-user', 'color' => 'blue', 'title' => 'Warga / Pelapor', 'desc' => 'Melaporkan bencana dengan data real-time, foto, dan GPS location langsung dari smartphone.', 'count' => '500K+ pengguna'],
                    ['icon' => 'fas fa-hard-hat', 'color' => 'green', 'title' => 'Relawan', 'desc' => 'Tim terlatih yang siap dikerahkan berdasarkan keahlian dan lokasi untuk penanganan langsung.', 'count' => '12K+ relawan'],
                    ['icon' => 'fas fa-building', 'color' => 'orange', 'title' => 'Organisasi Bantuan', 'desc' => 'NGO, PMI, dan lembaga kemanusiaan yang mengelola distribusi bantuan secara terkoordinasi.', 'count' => '240+ organisasi'],
                    ['icon' => 'fas fa-heart', 'color' => 'red', 'title' => 'Donatur', 'desc' => 'Individu dan korporasi yang berdonasi dengan jaminan transparansi penuh dan laporan real-time.', 'count' => '28K+ donatur'],
                    ['icon' => 'fas fa-landmark', 'color' => 'purple', 'title' => 'Pemerintah / BNPB', 'desc' => 'Instansi pemerintah yang menggunakan data CrisisHub untuk kebijakan dan koordinasi nasional.', 'count' => '34 provinsi'],
                ];
                @endphp
                @foreach($roles as $i => $r)
                <div class="glass rounded-2xl p-6 border border-{{ $r['color'] }}-500/20 text-center card-hover premium-card-glow fade-up" style="animation-delay: {{ $i * 0.1 }}s">
                    <div class="w-14 h-14 bg-{{ $r['color'] }}-600/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="{{ $r['icon'] }} text-{{ $r['color'] }}-500 dark:text-{{ $r['color'] }}-400 text-2xl"></i>
                    </div>
                    <h3 class="text-slate-800 dark:text-white font-bold mb-2">{{ $r['title'] }}</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed mb-3">{{ $r['desc'] }}</p>
                    <span class="text-{{ $r['color'] }}-600 dark:text-{{ $r['color'] }}-400 text-xs font-bold">{{ $r['count'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Key Features -->
<section class="py-20 bg-slate-50 dark:bg-[#0f172a] transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 fade-up">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-purple-600/15 border border-purple-600/25 rounded-full mb-4">
                <i class="fas fa-star text-purple-550 dark:text-purple-400 text-xs"></i>
                <span class="text-purple-650 dark:text-purple-400 text-sm font-semibold">Fitur Unggulan</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mb-3">Fitur Utama Platform</h2>
            <p class="text-slate-650 dark:text-slate-400 max-w-xl mx-auto">10 fitur inti yang membuat CrisisHub menjadi solusi terlengkap untuk manajemen bencana.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 fade-up">
            @php
            $features = [
                ['icon' => 'fas fa-bell', 'title' => 'Pelaporan Bencana', 'color' => 'red'],
                ['icon' => 'fas fa-map', 'title' => 'GIS Mapping', 'color' => 'blue'],
                ['icon' => 'fas fa-clipboard-list', 'title' => 'Kebutuhan Korban', 'color' => 'orange'],
                ['icon' => 'fas fa-sort-amount-up', 'title' => 'Prioritas Bantuan', 'color' => 'yellow'],
                ['icon' => 'fas fa-donate', 'title' => 'Donasi Online', 'color' => 'green'],
                ['icon' => 'fas fa-truck', 'title' => 'Distribusi Bantuan', 'color' => 'teal'],
                ['icon' => 'fas fa-hard-hat', 'title' => 'Manajemen Relawan', 'color' => 'purple'],
                ['icon' => 'fas fa-bell-slash', 'title' => 'Notifikasi Cerdas', 'color' => 'pink'],
                ['icon' => 'fas fa-satellite', 'title' => 'Komunikasi Darurat', 'color' => 'indigo'],
                ['icon' => 'fas fa-chart-bar', 'title' => 'Analytics & Insight', 'color' => 'cyan'],
            ];
            @endphp
            @foreach($features as $i => $f)
            <div class="glass rounded-xl p-5 border border-slate-200 dark:border-white/7 card-hover premium-card-glow text-center" style="animation-delay: {{ $i * 0.05 }}s">
                <div class="w-12 h-12 bg-{{ $f['color'] }}-600/20 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="{{ $f['icon'] }} text-{{ $f['color'] }}-500 dark:text-{{ $f['color'] }}-400 text-lg"></i>
                </div>
                <div class="text-slate-800 dark:text-white text-xs font-semibold leading-snug">{{ $f['title'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Impact Section -->
<section class="py-20 bg-white dark:bg-[#0a0f1e] transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 fade-up">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-red-600/15 border border-red-600/25 rounded-full mb-4">
                <i class="fas fa-trophy text-red-550 dark:text-red-400 text-xs"></i>
                <span class="text-red-650 dark:text-red-400 text-sm font-semibold">Dampak Nyata</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mb-3">Dampak CrisisHub</h2>
            <p class="text-slate-650 dark:text-slate-400 max-w-xl mx-auto">Pencapaian nyata sejak platform diluncurkan.</p>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            @php
            $impacts = [
                ['icon' => 'fas fa-box-open', 'color' => 'red', 'value' => 54210, 'label' => 'Bantuan Tersalurkan', 'suffix' => '', 'sub' => 'paket bantuan terkirim'],
                ['icon' => 'fas fa-hard-hat', 'color' => 'green', 'value' => 12847, 'label' => 'Total Relawan', 'suffix' => '', 'sub' => 'relawan terdaftar aktif'],
                ['icon' => 'fas fa-heart', 'color' => 'orange', 'value' => 28400, 'label' => 'Total Donatur', 'suffix' => '+', 'sub' => 'donatur aktif berkontribusi'],
                ['icon' => 'fas fa-users', 'color' => 'blue', 'value' => 89432, 'label' => 'Korban Terbantu', 'suffix' => '', 'sub' => 'jiwa menerima bantuan'],
            ];
            @endphp
            @foreach($impacts as $i => $imp)
            <div class="glass rounded-2xl p-8 border border-{{ $imp['color'] }}-500/20 text-center card-hover premium-card-glow fade-up" style="animation-delay: {{ $i * 0.1 }}s">
                <div class="w-16 h-16 bg-{{ $imp['color'] }}-600/20 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <i class="{{ $imp['icon'] }} text-{{ $imp['color'] }}-500 dark:text-{{ $imp['color'] }}-400 text-2xl"></i>
                </div>
                <div class="text-4xl font-black text-slate-900 dark:text-white mb-2" data-target="{{ $imp['value'] }}" data-suffix="{{ $imp['suffix'] }}">{{ number_format($imp['value'], 0, ',', '.') }}{{ $imp['suffix'] }}</div>
                <div class="text-slate-800 dark:text-white font-semibold mb-1">{{ $imp['label'] }}</div>
                <div class="text-slate-500 text-xs">{{ $imp['sub'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
