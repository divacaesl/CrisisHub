@extends('layouts.public')

@section('title', 'Daftar Relawan')

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
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 min-h-screen" style="padding-top: 7rem;">
    <!-- Page Header -->
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white font-display">Formulir Relawan Kemanusiaan</h1>
            <p class="text-slate-500 text-sm mt-1">Pilih tim yang sesuai dengan keahlian Anda.</p>
        </div>
    </div>
    
    <div class="max-w-3xl mx-auto">
    <!-- Success & Error Alert Toast -->
    @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-green-500/10 border border-green-500/20 text-green-600 dark:text-green-400 flex items-start gap-3 backdrop-blur-md">
            <div class="w-8 h-8 rounded-full bg-green-500 text-white flex justify-center items-center flex-shrink-0">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <h3 class="font-bold">Berhasil!</h3>
                <p class="text-sm mt-0.5">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-600 dark:text-red-400 flex items-start gap-3 backdrop-blur-md">
            <div class="w-8 h-8 rounded-full bg-red-500 text-white flex justify-center items-center flex-shrink-0">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div>
                <h3 class="font-bold">Gagal</h3>
                <p class="text-sm mt-0.5">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    @if($existingApp)
        <!-- VIEW 1: USER ALREADY APPLIED -->
        <div class="glass-panel rounded-3xl p-8 shadow-2xl relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-blue-500/10 rounded-full blur-xl"></div>
            
            @if($existingApp->status == 'pending' || $existingApp->status == 'under_review')
                <!-- Status: PENDING / UNDER REVIEW -->
                <div class="text-center py-6">
                    <div class="relative inline-flex items-center justify-center mb-6">
                        <div class="w-20 h-20 rounded-full bg-blue-500/10 text-blue-500 flex items-center justify-center animate-pulse">
                            <i class="fas fa-user-clock text-4xl"></i>
                        </div>
                        <span class="absolute top-0 right-0 flex h-4 w-4">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-4 w-4 bg-yellow-500"></span>
                        </span>
                    </div>
                    
                    <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white font-display">Pendaftaran Sedang Diproses</h2>
                    <p class="text-slate-500 mt-2 max-w-md mx-auto text-sm leading-relaxed">Terima kasih atas niat mulia Anda! Tim Kurator CrisisHub sedang meninjau kelayakan profil dan keahlian Anda.</p>
                    
                    <!-- Tracking Timeline -->
                    <div class="max-w-md mx-auto mt-10 p-5 rounded-2xl bg-slate-50 dark:bg-white/[0.02] border border-slate-200 dark:border-white/5 text-left space-y-6">
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-6 h-6 rounded-full bg-green-500 text-white flex items-center justify-center text-[10px]"><i class="fas fa-check"></i></div>
                                <div class="w-0.5 h-12 bg-green-500"></div>
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-slate-950 dark:text-white uppercase tracking-wider">Formulir Dikirim</h4>
                                <p class="text-[11px] text-slate-400 mt-0.5">Diserahkan pada {{ $existingApp->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-6 h-6 rounded-full bg-yellow-500 text-white flex items-center justify-center text-[10px] animate-pulse"><i class="fas fa-sync-alt animate-spin"></i></div>
                                <div class="w-0.5 h-12 bg-slate-200 dark:bg-slate-700"></div>
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-slate-950 dark:text-white uppercase tracking-wider">Verifikasi Profil Keahlian</h4>
                                <p class="text-[11px] text-slate-400 mt-0.5">Sedang dalam antrean kurasi tim mitigasi bencana.</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-6 h-6 rounded-full bg-slate-200 dark:bg-slate-800 text-slate-400 flex items-center justify-center text-[10px]"><i class="fas fa-award"></i></div>
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-slate-400 uppercase tracking-wider">Penetapan Relawan Resmi</h4>
                                <p class="text-[11px] text-slate-400 mt-0.5">Penerbitan kartu akses penugasan lapangan.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Application Details summary -->
                    <div class="max-w-md mx-auto mt-6 border-t border-slate-200 dark:border-white/10 pt-6 text-left">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-3">Ringkasan Pendaftaran</h3>
                        <div class="grid grid-cols-2 gap-4 text-xs">
                            <div>
                                <span class="text-slate-400 block">Kota Domisili:</span>
                                <span class="font-bold text-slate-900 dark:text-slate-200">{{ $existingApp->city }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block">Nomor WhatsApp:</span>
                                <span class="font-bold text-slate-900 dark:text-slate-200">{{ $existingApp->phone_number }}</span>
                            </div>
                            <div class="col-span-2">
                                <span class="text-slate-400 block">Keahlian Khusus:</span>
                                <span class="font-bold text-slate-900 dark:text-slate-200">{{ $existingApp->skills ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            @elseif($existingApp->status == 'approved')
                <!-- Status: APPROVED -->
                <div class="text-center py-8">
                    <div class="w-20 h-20 rounded-full bg-green-500/10 text-green-500 flex items-center justify-center mx-auto mb-6 shadow-lg shadow-green-500/20">
                        <i class="fas fa-check-double text-4xl"></i>
                    </div>
                    
                    <h2 class="text-3xl font-black text-slate-900 dark:text-white font-display">Selamat! Anda Adalah Relawan Resmi</h2>
                    <p class="text-slate-500 mt-2 max-w-md mx-auto text-sm leading-relaxed">Akun Anda telah ditingkatkan menjadi **Relawan Resmi CrisisHub**. Sekarang Anda memiliki akses penuh ke pusat penugasan dan kordinasi darurat.</p>
                    
                    <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('center.volunteer') }}" class="px-8 py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-xl transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-hands-helping"></i> Masuk Volunteer Center
                        </a>
                        <a href="{{ route('dashboard') }}" class="px-8 py-3.5 bg-slate-100 hover:bg-slate-200 dark:bg-white/5 dark:hover:bg-white/10 text-slate-700 dark:text-slate-300 font-bold rounded-xl border border-slate-200 dark:border-white/5 transition-all text-center">
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>

            @elseif($existingApp->status == 'rejected')
                <!-- Status: REJECTED -->
                <div class="text-center py-6">
                    <div class="w-20 h-20 rounded-full bg-red-500/10 text-red-500 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-user-times text-4xl"></i>
                    </div>
                    
                    <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white font-display">Pendaftaran Belum Disetujui</h2>
                    <p class="text-slate-500 mt-2 max-w-md mx-auto text-sm leading-relaxed">Terima kasih atas minat Anda, namun pendaftaran Anda sebagai relawan belum memenuhi kriteria kualifikasi saat ini.</p>
                    
                    <!-- Admin Rejection Notes -->
                    <div class="max-w-md mx-auto mt-6 p-4 rounded-xl bg-red-500/5 border border-red-500/20 text-left">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-red-400 block mb-1">Catatan Evaluasi Admin:</span>
                        <p class="text-xs text-red-700 dark:text-red-400 italic">"Pendaftaran belum bisa diterima. Silakan lengkapi bidang keahlian khusus Anda dan sertakan pengalaman relawan sebelumnya jika ada."</p>
                    </div>

                    <!-- Resubmit trigger -->
                    <div class="mt-8">
                        <form action="{{ url('/apply/volunteer') }}" method="POST">
                            @csrf
                            <input type="hidden" name="phone_number" value="clear">
                            <!-- This will trigger resetting application inside controller -->
                            <button type="submit" name="resubmit_clear" value="true" class="px-8 py-3.5 bg-gradient-to-r from-red-600 to-orange-500 hover:from-red-700 hover:to-orange-600 text-white font-bold rounded-xl shadow-lg transition-transform hover:scale-[1.02] flex items-center gap-2 mx-auto">
                                <i class="fas fa-redo"></i> Ajukan Permohonan Ulang
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    @else
        <!-- VIEW 2: TEAM CARDS & MODAL FORM -->
        <div class="text-center mb-10">
            <h2 class="text-3xl font-black text-slate-900 dark:text-white font-display mb-4">Pilih Tim Keahlian Anda</h2>
            <p class="text-slate-500 text-sm max-w-xl mx-auto">Bergabunglah bersama ribuan relawan lainnya di garis depan mitigasi bencana. Pilih tim yang paling sesuai dengan keahlian Anda.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-5 mb-12">
            @foreach($categories as $i => $cat)
            <div onclick="openTeamModal('{{ $cat['id'] }}')" class="glass-panel rounded-2xl p-6 border border-{{ $cat['color'] }}-500/20 shadow-xl hover:shadow-2xl transition-all hover:-translate-y-2 cursor-pointer relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity"><i class="{{ $cat['icon'] }} text-6xl text-{{ $cat['color'] }}-500"></i></div>
                <div class="w-14 h-14 rounded-2xl bg-{{ $cat['color'] }}-500/10 text-{{ $cat['color'] }}-500 flex items-center justify-center mb-6"><i class="{{ $cat['icon'] }} text-2xl"></i></div>
                
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white font-display">{{ $cat['title'] }}</h3>
                    @if($cat['open'])
                    <span class="px-2 py-0.5 bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-400 text-[10px] rounded-full font-bold uppercase">Terbuka</span>
                    @else
                    <span class="px-2 py-0.5 bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-400 text-[10px] rounded-full font-bold uppercase">Penuh</span>
                    @endif
                </div>
                
                <p class="text-slate-650 dark:text-slate-400 text-xs leading-relaxed mb-4 line-clamp-2">{{ $cat['desc'] }}</p>
                <div class="flex flex-wrap gap-1 mb-4">
                    @foreach($cat['skills'] as $skill)
                    <span class="px-2 py-0.5 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-[10px] rounded-full">{{ $skill }}</span>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@section('modals')
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
                    <button onclick="closeTeamModal('{{ $cat['id'] }}'); openApplyModal('{{ $cat['title'] }}')" class="px-6 py-3 bg-{{ $cat['color'] }}-500 hover:bg-{{ $cat['color'] }}-600 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-{{ $cat['color'] }}-500/30">
                        Gabung Tim Ini
                    </button>
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
            <form action="{{ url('/apply/volunteer') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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
                    <button type="submit" class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg transition-transform transform hover:scale-[1.01] flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i> Kirim Pendaftaran Relawan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openTeamModal(id) {
        document.getElementById('team-modal-' + id).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeTeamModal(id) {
        document.getElementById('team-modal-' + id).classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    function openApplyModal(teamName) {
        document.getElementById('modal-title').textContent = 'Formulir Pendaftaran - ' + teamName;
        document.getElementById('preferred_team_input').value = teamName;
        document.getElementById('apply-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeApplyModal() {
        document.getElementById('apply-modal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Auto-open modal if team is passed in URL
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const team = urlParams.get('team');
        if (team) {
            // map short id to full title
            const teamMap = {
                'rescue': 'Rescue Team',
                'medical': 'Medical Team',
                'logistics': 'Logistics Team',
                'assessment': 'Assessment Team'
            };
            if (teamMap[team]) {
                openApplyModal(teamMap[team]);
            }
        }
    });
</script>
    </div>
</div>
@endsection
