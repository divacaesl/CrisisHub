@extends('layouts.public')

@section('title', 'Daftar Relawan — CrisisHub')
@section('description', 'Bergabunglah sebagai relawan CrisisHub dan menjadi garda terdepan penanganan bencana di Indonesia.')

@php
$categories = [
    ['id' => 'rescue', 'icon' => 'fas fa-life-ring', 'color' => 'red', 'emoji' => '🆘', 'title' => 'Rescue Team', 'desc' => 'Tim penyelamatan & evakuasi korban bencana langsung di lapangan.', 'members' => '2.840', 'skills' => ['SAR', 'Evakuasi', 'Selam'], 'open' => true,
     'details' => 'Tim Rescue bertugas di garis depan saat bencana terjadi. Anda akan dilatih untuk melakukan pencarian dan penyelamatan di berbagai medan ekstrem.',
     'tasks' => ['Evakuasi korban', 'Pencarian orang hilang', 'Pemetaan area berbahaya'],
     'training' => 'Setiap akhir pekan (Sabtu & Minggu)',
     'benefit' => 'Sertifikat SAR Dasar Nasional',
     'urgency' => 'Sangat Tinggi'],
    ['id' => 'medical', 'icon' => 'fas fa-stethoscope', 'color' => 'blue', 'emoji' => '🏥', 'title' => 'Medical Team', 'desc' => 'Tim medis untuk pertolongan pertama dan pelayanan kesehatan darurat.', 'members' => '1.920', 'skills' => ['P3K', 'Gawat Darurat', 'Psikologi'], 'open' => true,
     'details' => 'Tim Medis memberikan layanan kesehatan darurat bagi korban bencana. Tenaga kesehatan sangat dibutuhkan untuk penanganan trauma fisik dan psikologis.',
     'tasks' => ['Pertolongan pertama (P3K)', 'Triage pasien', 'Trauma healing'],
     'training' => '2 kali sebulan (Jumat sore)',
     'benefit' => 'Sertifikat BLS (Basic Life Support)',
     'urgency' => 'Tinggi'],
    ['id' => 'logistics', 'icon' => 'fas fa-box', 'color' => 'orange', 'emoji' => '📦', 'title' => 'Logistics Team', 'desc' => 'Pengelolaan dan distribusi bantuan logistik ke wilayah terdampak.', 'members' => '3.210', 'skills' => ['Gudang', 'Distribusi', 'Inventaris'], 'open' => true,
     'details' => 'Tim Logistik mengatur alur barang masuk dan keluar, pendirian tenda, hingga manajemen dapur umum untuk penyintas.',
     'tasks' => ['Manajemen gudang', 'Distribusi bantuan pangan', 'Pendirian tenda darurat'],
     'training' => '1 kali sebulan (Fleksibel)',
     'benefit' => 'Sertifikat Manajemen Bencana',
     'urgency' => 'Sedang'],
    ['id' => 'communication', 'icon' => 'fas fa-satellite-dish', 'color' => 'purple', 'emoji' => '📡', 'title' => 'Communication Team', 'desc' => 'Koordinasi komunikasi dan informasi antar tim di lapangan.', 'members' => '1.450', 'skills' => ['Radio', 'IT', 'Media Sosial'], 'open' => false,
     'details' => 'Tim Komunikasi memastikan arus informasi tetap berjalan meskipun jaringan publik terputus.',
     'tasks' => ['Instalasi radio komunikasi', 'Broadcast informasi darurat', 'Update media sosial'],
     'training' => 'Setiap Rabu malam (Online)',
     'benefit' => 'Sertifikat Komunikasi Krisis',
     'urgency' => 'Rendah (Penuh)'],
    ['id' => 'assessment', 'icon' => 'fas fa-clipboard-check', 'color' => 'yellow', 'emoji' => '📋', 'title' => 'Assessment Team', 'desc' => 'Tim penilaian kerusakan dan kebutuhan korban secara komprehensif.', 'members' => '1.120', 'skills' => ['Survey', 'Data', 'Analisis'], 'open' => true,
     'details' => 'Tim Assessment adalah tim perintis yang datang pertama untuk menilai seberapa parah kerusakan dan apa saja yang dibutuhkan korban.',
     'tasks' => ['Pemetaan wilayah terdampak', 'Pengumpulan data korban', 'Analisis kebutuhan mendesak'],
     'training' => 'Insidental sebelum misi',
     'benefit' => 'Sertifikat Asesor Bencana',
     'urgency' => 'Tinggi'],
];
@endphp

@section('content')
<!-- Volunteer Hero -->
<section class="hero-dynamic hero-volunteer relative min-h-[65vh] flex items-center pt-24 pb-16 overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-green-600/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-emerald-600/5 rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-green-600/15 border border-green-600/25 rounded-full mb-6">
                    <div class="w-2 h-2 rounded-full bg-green-500 badge-urgent"></div>
                    <span class="text-green-400 text-sm font-semibold">Rekrutmen Terbuka</span>
                </div>
                <h1 class="text-4xl sm:text-5xl font-black text-white mb-6 leading-tight">
                    Menjadi Garda Terdepan <span style="background: linear-gradient(135deg, #22c55e, #10b981); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Saat Bencana</span>
                </h1>
                <p class="text-slate-300 text-lg leading-relaxed mb-8">
                    Bergabunglah dengan lebih dari 12.000 relawan CrisisHub yang tersebar di 38 provinsi Indonesia. Bersama kita lebih kuat dalam menghadapi setiap bencana.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('apply.volunteer') }}" id="btn-daftar" class="flex items-center gap-2 px-6 py-3.5 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 text-white font-bold rounded-2xl transition-all" style="box-shadow: 0 0 20px rgba(34,197,94,0.4);">
                        <i class="fas fa-hard-hat"></i>Daftar Sekarang
                    </a>
                    <a href="#why" class="flex items-center gap-2 px-6 py-3.5 glass border border-white/10 hover:bg-white/10 text-white font-medium rounded-2xl transition-all">
                        Pelajari Lebih
                    </a>
                </div>
            </div>
            <div class="relative">
                <img src="/images/volunteer_team.png" alt="Tim Relawan CrisisHub" class="w-full h-[450px] object-cover rounded-3xl" style="box-shadow: 0 40px 80px rgba(0,0,0,0.6);">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a]/60 via-transparent to-transparent rounded-3xl"></div>
                <div class="absolute bottom-6 left-6 right-6 glass rounded-2xl p-4 border border-green-500/20">
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div><div class="text-2xl font-black text-green-400">12K+</div><div class="text-xs text-slate-400">Relawan Aktif</div></div>
                        <div><div class="text-2xl font-black text-blue-400">38</div><div class="text-xs text-slate-400">Provinsi</div></div>
                        <div><div class="text-2xl font-black text-orange-400">512</div><div class="text-xs text-slate-400">Misi Aktif</div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Volunteer -->
<section id="why" class="py-20 bg-white dark:bg-[#0a0f1e] transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 fade-up">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-green-600/15 border border-green-600/25 rounded-full mb-4">
                <i class="fas fa-question-circle text-green-550 dark:text-green-400 text-xs"></i>
                <span class="text-green-600 dark:text-green-400 text-sm font-semibold">Mengapa Bergabung?</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mb-3">Manfaat Menjadi Relawan CrisisHub</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
            $benefits = [
                ['icon' => 'fas fa-graduation-cap', 'color' => 'blue', 'title' => 'Pelatihan Resmi', 'desc' => 'Program pelatihan intensif penanggulangan bencana yang diakui BNPB dan Basarnas, gratis untuk semua relawan.'],
                ['icon' => 'fas fa-certificate', 'color' => 'yellow', 'title' => 'Sertifikat Nasional', 'desc' => 'Sertifikat kompetensi kebencanaan yang diakui pemerintah, berguna untuk karier di bidang kemanusiaan.'],
                ['icon' => 'fas fa-users', 'color' => 'green', 'title' => 'Jaringan Luas', 'desc' => 'Terhubung dengan ribuan relawan, profesional, dan organisasi kemanusiaan dari seluruh Indonesia.'],
                ['icon' => 'fas fa-medal', 'color' => 'orange', 'title' => 'Pengalaman Nyata', 'desc' => 'Terlibat langsung dalam operasi penyelamatan dan distribusi bantuan di lapangan yang berdampak nyata.'],
            ];
            @endphp
            @foreach($benefits as $i => $b)
            <div class="glass rounded-2xl p-7 border border-{{ $b['color'] }}-500/20 premium-card-glow fade-up text-center" style="animation-delay: {{ $i * 0.1 }}s">
                <div class="w-16 h-16 bg-{{ $b['color'] }}-600/20 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <i class="{{ $b['icon'] }} text-{{ $b['color'] }}-500 dark:text-{{ $b['color'] }}-400 text-2xl"></i>
                </div>
                <h3 class="text-slate-900 dark:text-white font-bold text-lg mb-3">{{ $b['title'] }}</h3>
                <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">{{ $b['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Volunteer Categories -->
<section class="py-20 bg-slate-50 dark:bg-[#0f172a] transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 fade-up">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-blue-600/15 border border-blue-600/25 rounded-full mb-4">
                <i class="fas fa-layer-group text-blue-550 dark:text-blue-400 text-xs"></i>
                <span class="text-blue-600 dark:text-blue-400 text-sm font-semibold">Kategori Relawan</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mb-3">Pilih Peranmu</h2>
            <p class="text-slate-650 dark:text-slate-400 max-w-xl mx-auto">Berbagai kategori relawan dengan tugas dan tanggung jawab yang berbeda sesuai keahlianmu.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-5">
            @foreach($categories as $i => $cat)
            <div onclick="openTeamModal('{{ $cat['id'] }}')" class="glass rounded-2xl p-6 border border-{{ $cat['color'] }}-500/20 card-hover premium-card-glow fade-up cursor-pointer" style="animation-delay: {{ $i * 0.1 }}s">
                <div class="text-4xl mb-4">{{ $cat['emoji'] }}</div>
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-slate-800 dark:text-white font-bold">{{ $cat['title'] }}</h3>
                    @if($cat['open'])
                    <span class="px-2 py-0.5 bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-400 text-xs rounded-full font-semibold">Terbuka</span>
                    @else
                    <span class="px-2 py-0.5 bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-400 text-xs rounded-full font-semibold">Penuh</span>
                    @endif
                </div>
                <p class="text-slate-650 dark:text-slate-400 text-xs leading-relaxed mb-4">{{ $cat['desc'] }}</p>
                <div class="flex flex-wrap gap-1 mb-4">
                    @foreach($cat['skills'] as $skill)
                    <span class="px-2 py-0.5 bg-{{ $cat['color'] }}-900/30 text-{{ $cat['color'] }}-400 text-xs rounded-full">{{ $skill }}</span>
                    @endforeach
                </div>
                <div class="flex items-center justify-between">
                    <div class="text-{{ $cat['color'] }}-400 font-bold">{{ $cat['members'] }}</div>
                    <div class="text-slate-500 text-xs">anggota</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<script>
    function openTeamModal(id) {
        document.getElementById('team-modal-' + id).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeTeamModal(id) {
        document.getElementById('team-modal-' + id).classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>

<!-- Success Stories -->
<section class="py-20 bg-slate-50 dark:bg-[#0f172a] transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 fade-up">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-orange-600/15 border border-orange-600/25 rounded-full mb-4">
                <i class="fas fa-star text-orange-550 dark:text-orange-400 text-xs"></i>
                <span class="text-orange-600 dark:text-orange-400 text-sm font-semibold">Kisah Inspiratif</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mb-3">Suara Para Relawan</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
            $stories = [
                ['name' => 'Ahmad Fauzi', 'role' => 'Rescue Team — Jakarta', 'year' => '3 tahun', 'quote' => '"Bergabung dengan CrisisHub mengubah hidup saya. Saya bisa langsung menyentuh kehidupan orang banyak. Sistem koordinasinya luar biasa efisien — tidak ada waktu yang terbuang."', 'missions' => 24, 'saved' => 142],
                ['name' => 'dr. Siti Rahayu', 'role' => 'Medical Team — Surabaya', 'year' => '2 tahun', 'quote' => '"Sebagai dokter, CrisisHub memberikan saya akses ke lapangan yang sebelumnya tidak mungkin. Platform ini membantu saya melayani ratusan korban bencana dengan lebih terorganisir."', 'missions' => 18, 'saved' => 89],
                ['name' => 'Bagas Pratama', 'role' => 'Logistics Team — Bandung', 'year' => '1 tahun', 'quote' => '"Awalnya saya bingung mau mulai dari mana. Tapi CrisisHub memberikan pelatihan yang komprehensif. Dalam 6 bulan saya sudah terlibat dalam 5 misi distribusi bantuan besar."', 'missions' => 11, 'saved' => 320],
            ];
            @endphp
            @foreach($stories as $i => $s)
            <div class="glass rounded-2xl p-7 border border-white/7 card-hover fade-up" style="animation-delay: {{ $i * 0.1 }}s">
                <div class="flex items-center gap-1 mb-4">
                    @for($j = 0; $j < 5; $j++)
                    <i class="fas fa-star text-yellow-400 text-sm"></i>
                    @endfor
                </div>
                <p class="text-slate-650 dark:text-slate-300 text-sm leading-relaxed mb-6 italic">{{ $s['quote'] }}</p>
                <div class="flex items-center gap-4 pt-4 border-t border-slate-200 dark:border-white/10">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-500 to-emerald-700 flex items-center justify-center text-white font-black text-lg">
                        {{ substr($s['name'], 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <div class="text-slate-800 dark:text-white font-bold text-sm">{{ $s['name'] }}</div>
                        <div class="text-slate-550 dark:text-slate-500 text-xs">{{ $s['role'] }}</div>
                        <div class="text-green-600 dark:text-green-400 text-xs mt-0.5 font-semibold">{{ $s['year'] }} bergabung</div>
                    </div>
                    <div class="text-right">
                        <div class="text-slate-800 dark:text-white font-bold text-sm">{{ $s['missions'] }} misi</div>
                        <div class="text-slate-550 dark:text-slate-500 text-xs">{{ $s['saved'] }} jiwa terbantu</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@foreach($categories as $cat)
<!-- Modal for Team Details -->
<div id="team-modal-{{ $cat['id'] }}" class="fixed inset-0 flex items-center justify-center bg-slate-900/80 backdrop-blur-sm hidden p-4" style="z-index: 99999;">
    <div class="bg-white dark:bg-slate-900 rounded-3xl w-full max-w-2xl shadow-2xl relative flex flex-col max-h-[90vh]">
        <!-- Modal Header -->
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center bg-{{ $cat['color'] }}-500/10 rounded-t-3xl shrink-0">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-{{ $cat['color'] }}-500/20 text-{{ $cat['color'] }}-500 flex items-center justify-center text-2xl">
                    <i class="{{ $cat['icon'] }}"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-slate-900 dark:text-white">{{ $cat['title'] }}</h2>
                    <p class="text-sm text-{{ $cat['color'] }}-600 dark:text-{{ $cat['color'] }}-400 font-bold">Tingkat Kebutuhan: {{ $cat['urgency'] }}</p>
                </div>
            </div>
            <button onclick="closeTeamModal('{{ $cat['id'] }}')" class="w-10 h-10 rounded-full bg-white dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:bg-red-100 hover:text-red-500 transition-colors shadow-sm">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6 md:p-8 space-y-6 overflow-y-auto flex-1">
            <div>
                <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-2 uppercase tracking-wider text-slate-500">Deskripsi Tim</h4>
                <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">{{ $cat['details'] }}</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-2 uppercase tracking-wider text-slate-500"><i class="fas fa-tasks mr-2"></i>Tugas Volunteer</h4>
                    <ul class="list-disc list-inside text-sm text-slate-600 dark:text-slate-400 space-y-1">
                        @foreach($cat['tasks'] as $task)
                        <li>{{ $task }}</li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-2 uppercase tracking-wider text-slate-500"><i class="fas fa-tools mr-2"></i>Skill Dibutuhkan</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($cat['skills'] as $skill)
                        <span class="px-3 py-1 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs rounded-lg border border-slate-200 dark:border-slate-700">{{ $skill }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700">
                <div>
                    <h4 class="text-xs font-bold text-slate-500 mb-1 uppercase">Jadwal Pelatihan</h4>
                    <p class="text-sm font-semibold text-slate-900 dark:text-white"><i class="far fa-calendar-alt text-blue-500 mr-2"></i>{{ $cat['training'] }}</p>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-500 mb-1 uppercase">Benefit Sertifikat</h4>
                    <p class="text-sm font-semibold text-slate-900 dark:text-white"><i class="fas fa-certificate text-amber-500 mr-2"></i>{{ $cat['benefit'] }}</p>
                </div>
            </div>
            
            <div class="flex items-center justify-between pt-4 border-t border-slate-200 dark:border-slate-800">
                <div class="text-sm">
                    <span class="text-slate-500">Anggota Aktif:</span>
                    <span class="font-bold text-slate-900 dark:text-white ml-1">{{ $cat['members'] }} Relawan</span>
                </div>
                
                @if($cat['open'])
                    @auth
                        <button onclick="closeTeamModal('{{ $cat['id'] }}'); openApplyModal('{{ $cat['title'] }}')" class="px-6 py-3 bg-{{ $cat['color'] }}-500 hover:bg-{{ $cat['color'] }}-600 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-{{ $cat['color'] }}-500/30">
                            Gabung Tim Ini
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-3 bg-{{ $cat['color'] }}-500 hover:bg-{{ $cat['color'] }}-600 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-{{ $cat['color'] }}-500/30">
                            Gabung Tim Ini
                        </a>
                    @endauth
                @else
                    <button disabled class="px-6 py-3 bg-slate-300 dark:bg-slate-700 text-slate-500 font-bold rounded-xl cursor-not-allowed">
                        Kuota Penuh
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- MODAL FORM PENDAFTARAN -->
@auth
<div id="apply-modal" class="fixed inset-0 flex items-center justify-center bg-slate-900/80 backdrop-blur-sm hidden p-4" style="z-index: 99999;">
    <div class="bg-white dark:bg-slate-900 rounded-3xl w-full max-w-3xl shadow-2xl relative flex flex-col max-h-[90vh]">
        <!-- Modal Header -->
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center bg-white dark:bg-slate-900 rounded-t-3xl shrink-0">
            <div>
                <h2 class="text-2xl font-black text-slate-900 dark:text-white font-display" id="modal-title">Formulir Pendaftaran Relawan</h2>
                <p class="text-sm text-slate-500">Isi data diri dengan lengkap sesuai dengan identitas asli Anda.</p>
            </div>
            <button onclick="closeApplyModal()" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:bg-red-100 hover:text-red-500 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6 md:p-8 overflow-y-auto flex-1">
            <form id="volunteerForm" action="{{ url('/apply/volunteer') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <input type="hidden" name="preferred_team" id="preferred_team_input">

                <!-- Data Diri (Readonly) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Nama Lengkap *</label>
                        <input type="text" name="full_name" value="{{ auth()->user()->name ?? '' }}" required class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Email *</label>
                        <input type="email" value="{{ auth()->user()->email ?? '' }}" disabled class="w-full px-4 py-2.5 bg-slate-100 dark:bg-slate-800 border-none rounded-xl text-sm text-slate-500 cursor-not-allowed">
                    </div>
                </div>

                <!-- Kontak & Lokasi -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Nomor HP/WhatsApp *</label>
                        <input type="text" name="phone_number" required placeholder="+62 812 xxxx xxxx" class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Kota Domisili *</label>
                        <input type="text" name="city" required placeholder="Contoh: Bandung, Jawa Barat" class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                </div>

                <!-- Keahlian & Kategori -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Kategori Relawan *</label>
                        <select name="category" required class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="Profesional">Profesional (Dokter, Insinyur, dll)</option>
                            <option value="Mahasiswa">Mahasiswa</option>
                            <option value="Masyarakat Umum">Masyarakat Umum</option>
                            <option value="Pensiunan">Pensiunan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Keahlian Khusus</label>
                        <input type="text" name="skills" placeholder="Contoh: SAR, Pertolongan Pertama, IT, Mengemudi" class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                </div>

                <!-- Waktu & Area Penugasan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Ketersediaan Waktu *</label>
                        <select name="availability" required class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            <option value="" disabled selected>Pilih Waktu</option>
                            <option value="Full Time">Siap Panggilan (Full Time)</option>
                            <option value="Weekend">Akhir Pekan Saja (Weekend)</option>
                            <option value="Weekday">Hari Kerja (Weekday)</option>
                            <option value="Remote">Hanya Remote / Online</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Area Penugasan *</label>
                        <select name="assignment_area" required class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            <option value="" disabled selected>Pilih Area</option>
                            <option value="Dalam Kota">Hanya Dalam Kota Domisili</option>
                            <option value="Dalam Provinsi">Dalam Satu Provinsi</option>
                            <option value="Seluruh Indonesia">Siap ke Seluruh Indonesia</option>
                        </select>
                    </div>
                </div>

                <!-- Pengalaman & Sertifikasi -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Pengalaman Kerelawanan</label>
                    <textarea name="experience" rows="2" placeholder="Ceritakan pengalaman Anda sebelumnya di bidang kebencanaan/kemanusiaan..." class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Sertifikasi yang Dimiliki</label>
                    <input type="text" name="certification" placeholder="Contoh: SAR Dasar, PPGD, ISO 22320" class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>

                <!-- Upload CV -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Upload CV/Resume (PDF/DOC, maks 2MB)</label>
                    <div class="border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-2xl p-6 text-center hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        <i class="fas fa-cloud-upload-alt text-3xl text-slate-400 mb-2"></i>
                        <input type="file" name="cv_file" accept=".pdf,.doc,.docx" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                    </div>
                </div>

                <!-- Kontak Darurat -->
                <div class="bg-slate-50 dark:bg-white/[0.02] border border-slate-200 dark:border-white/5 rounded-2xl p-6">
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-4"><i class="fas fa-heartbeat text-red-500 mr-2"></i>Kontak Darurat (Wajib)</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Nama Lengkap</label>
                            <input type="text" name="emergency_contact_name" required placeholder="Nama Kerabat" class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Hubungan</label>
                            <input type="text" name="emergency_contact_relation" required placeholder="Ayah/Ibu/Suami/Istri" class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Nomor HP</label>
                            <input type="text" name="emergency_contact_phone" required placeholder="08xxx" class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 text-sm">
                        </div>
                    </div>
                </div>

                <!-- Motivasi -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Motivasi Bergabung</label>
                    <textarea name="motivation" rows="3" placeholder="Ceritakan mengapa Anda ingin menjadi relawan CrisisHub..." class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"></textarea>
                </div>

                <!-- Persetujuan -->
                <div class="flex items-start gap-3">
                    <input type="checkbox" required id="agree" class="mt-1 w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                    <label for="agree" class="text-xs text-slate-500 dark:text-slate-400 cursor-pointer">
                        Saya menyetujui <a href="#" class="text-blue-500 font-bold hover:underline">Syarat & Ketentuan</a> dan bersedia mengikuti pelatihan serta misi yang ditugaskan oleh CrisisHub. Seluruh data yang saya isi adalah benar.
                    </label>
                </div>

                <div class="pt-4 border-t border-slate-200 dark:border-slate-800">
                    <button type="submit" id="submitVolunteer" class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg transition-transform transform hover:scale-[1.01] flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i> Kirim Pendaftaran Relawan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endauth

<!-- Alerts & Notifications -->
@if(session('success'))
<div id="success-modal" class="fixed inset-0 flex items-center justify-center bg-slate-900/80 backdrop-blur-sm p-4" style="z-index: 999999;">
    <div class="bg-white dark:bg-slate-900 rounded-3xl w-full max-w-md shadow-2xl relative flex flex-col items-center text-center p-8 transform transition-all">
        <div class="w-24 h-24 rounded-full bg-green-500/10 text-green-500 flex justify-center items-center mb-6">
            <i class="fas fa-check-circle text-6xl"></i>
        </div>
        <h2 class="text-3xl font-black text-slate-900 dark:text-white mb-2">Berhasil!</h2>
        <p class="text-slate-500 dark:text-slate-400 mb-8">{{ session('success') }}</p>
        <button onclick="document.getElementById('success-modal').style.display='none'" class="w-full py-3.5 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold rounded-xl shadow-lg transition-transform hover:scale-[1.02]">
            Tutup
        </button>
    </div>
</div>
@endif

@if(session('error') || $errors->any())
<div id="error-modal" class="fixed inset-0 flex items-center justify-center bg-slate-900/80 backdrop-blur-sm p-4" style="z-index: 999999;">
    <div class="bg-white dark:bg-slate-900 rounded-3xl w-full max-w-md shadow-2xl relative flex flex-col items-center text-center p-8 transform transition-all">
        <div class="w-24 h-24 rounded-full bg-red-500/10 text-red-500 flex justify-center items-center mb-6">
            <i class="fas fa-exclamation-triangle text-6xl"></i>
        </div>
        <h2 class="text-3xl font-black text-slate-900 dark:text-white mb-2">Perhatian!</h2>
        <div class="text-slate-500 dark:text-slate-400 mb-8 text-sm">
            @if(session('error'))
                <p>{{ session('error') }}</p>
            @endif
            @if($errors->any())
                <ul class="list-disc list-inside text-left mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
        <button onclick="document.getElementById('error-modal').style.display='none'" class="w-full py-3.5 bg-gradient-to-r from-slate-200 to-slate-300 hover:from-slate-300 hover:to-slate-400 text-slate-800 font-bold rounded-xl shadow-lg transition-transform hover:scale-[1.02]">
            Mengerti
        </button>
    </div>
</div>
@endif

@endsection

@section('scripts')
<script>
    // CV upload preview
    document.getElementById('cvUpload')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const container = this.parentElement;
            container.querySelector('p').textContent = '✅ ' + file.name + ' (' + (file.size/1024).toFixed(1) + ' KB)';
        }
    });

    // Form submit with AJAX and Desktop Notifications
    document.getElementById('volunteerForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Remove previous errors
        document.querySelectorAll('.error-text').forEach(el => el.remove());
        document.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500', 'focus:ring-red-500'));
        
        const btn = document.getElementById('submitVolunteer');
        const originalBtnText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';
        btn.disabled = true;

        const formData = new FormData(this);
        
        try {
            const response = await fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (!response.ok) {
                if (response.status === 422) {
                    // Validation errors
                    const errors = data.errors;
                    for (const [field, messages] of Object.entries(errors)) {
                        const input = document.querySelector(`[name="${field}"]`);
                        if (input) {
                            input.classList.add('border-red-500', 'focus:ring-red-500');
                            const errorMsg = document.createElement('p');
                            errorMsg.className = 'text-red-500 text-xs mt-1 error-text font-bold';
                            errorMsg.innerHTML = `<i class="fas fa-exclamation-triangle"></i> ${messages[0]}`;
                            input.parentNode.appendChild(errorMsg);
                        }
                    }
                } else {
                    // Other error (e.g., already applied)
                    const errorModal = document.getElementById('error-modal');
                    if (errorModal) {
                        errorModal.querySelector('.text-slate-500').innerHTML = `<p>${data.message || 'Terjadi kesalahan teknis.'}</p>`;
                        errorModal.style.display = 'flex';
                    }
                    
                    if (Notification.permission === 'granted') {
                        new Notification('Gagal mendaftar', { body: data.message || 'Terjadi kesalahan teknis.', icon: '/favicon.ico' });
                    }
                }
            } else {
                // Success
                document.getElementById('apply-modal').classList.add('hidden');
                document.body.style.overflow = 'auto';
                
                // Show success modal
                const successModal = document.getElementById('success-modal');
                if(successModal) {
                    successModal.querySelector('p').innerText = data.message || 'Berhasil terkirim!';
                    successModal.style.display = 'flex';
                }
                
                // OS Notification
                if (Notification.permission === 'granted') {
                    new Notification('Pendaftaran Berhasil!', { body: data.message || 'Pengajuan relawan Anda berhasil dikirim.', icon: '/favicon.ico' });
                } else if (Notification.permission !== 'denied') {
                    Notification.requestPermission().then(permission => {
                        if (permission === 'granted') {
                            new Notification('Pendaftaran Berhasil!', { body: data.message || 'Pengajuan relawan Anda berhasil dikirim.', icon: '/favicon.ico' });
                        }
                    });
                }
                
                this.reset();
            }
        } catch (error) {
            const errorModal = document.getElementById('error-modal');
            if (errorModal) {
                errorModal.querySelector('.text-slate-500').innerHTML = `<p>Gagal menghubungi server. Silakan coba lagi nanti.</p>`;
                errorModal.style.display = 'flex';
            }
            if (Notification.permission === 'granted') {
                new Notification('Kesalahan Koneksi', { body: 'Gagal menghubungi server CrisisHub.', icon: '/favicon.ico' });
            }
        } finally {
            btn.innerHTML = originalBtnText;
            btn.disabled = false;
        }
    });

    // Request Notification permission early when opening modal
    function openApplyModal(teamName) {
        if (Notification.permission !== 'granted' && Notification.permission !== 'denied') {
            Notification.requestPermission();
        }
        document.getElementById('modal-title').textContent = 'Formulir Pendaftaran - ' + teamName;
        document.getElementById('preferred_team_input').value = teamName;
        document.getElementById('apply-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeApplyModal() {
        document.getElementById('apply-modal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>
@endsection
