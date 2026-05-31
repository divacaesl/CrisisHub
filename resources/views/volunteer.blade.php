@extends('layouts.public')

@section('title', 'Daftar Relawan — CrisisHub')
@section('description', 'Bergabunglah sebagai relawan CrisisHub dan menjadi garda terdepan penanganan bencana di Indonesia.')

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
                    Bergabunglah dengan lebih dari 12.000 relawan CrisisHub yang tersebar di 34 provinsi Indonesia. Bersama kita lebih kuat dalam menghadapi setiap bencana.
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
                        <div><div class="text-2xl font-black text-blue-400">34</div><div class="text-xs text-slate-400">Provinsi</div></div>
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
            @php
            $categories = [
                ['icon' => 'fas fa-life-ring', 'color' => 'red', 'emoji' => '🆘', 'title' => 'Rescue Team', 'desc' => 'Tim penyelamatan & evakuasi korban bencana langsung di lapangan.', 'members' => '2.840', 'skills' => ['SAR', 'Evakuasi', 'Selam'], 'open' => true],
                ['icon' => 'fas fa-stethoscope', 'color' => 'blue', 'emoji' => '🏥', 'title' => 'Medical Team', 'desc' => 'Tim medis untuk pertolongan pertama dan pelayanan kesehatan darurat.', 'members' => '1.920', 'skills' => ['P3K', 'Gawat Darurat', 'Psikologi'], 'open' => true],
                ['icon' => 'fas fa-box', 'color' => 'orange', 'emoji' => '📦', 'title' => 'Logistics Team', 'desc' => 'Pengelolaan dan distribusi bantuan logistik ke wilayah terdampak.', 'members' => '3.210', 'skills' => ['Gudang', 'Distribusi', 'Inventaris'], 'open' => true],
                ['icon' => 'fas fa-satellite-dish', 'color' => 'purple', 'emoji' => '📡', 'title' => 'Communication Team', 'desc' => 'Koordinasi komunikasi dan informasi antar tim di lapangan.', 'members' => '1.450', 'skills' => ['Radio', 'IT', 'Media Sosial'], 'open' => false],
                ['icon' => 'fas fa-clipboard-check', 'color' => 'yellow', 'emoji' => '📋', 'title' => 'Assessment Team', 'desc' => 'Tim penilaian kerusakan dan kebutuhan korban secara komprehensif.', 'members' => '1.120', 'skills' => ['Survey', 'Data', 'Analisis'], 'open' => true],
            ];
            @endphp
            @foreach($categories as $i => $cat)
            <div class="glass rounded-2xl p-6 border border-{{ $cat['color'] }}-500/20 card-hover premium-card-glow fade-up" style="animation-delay: {{ $i * 0.1 }}s">
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

<!-- Registration Form -->
<section id="form-relawan" class="py-20 bg-white dark:bg-[#0a0f1e] transition-colors duration-300">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 fade-up">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-green-600/15 border border-green-600/25 rounded-full mb-4">
                <i class="fas fa-file-alt text-green-600 dark:text-green-400 text-xs"></i>
                <span class="text-green-600 dark:text-green-400 text-sm font-semibold">Formulir Pendaftaran</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mb-3">Daftar Sebagai Relawan</h2>
            <p class="text-slate-650 dark:text-slate-400">Isi formulir di bawah ini dan tim kami akan menghubungi Anda dalam 24 jam.</p>
        </div>

        <div class="glass rounded-3xl p-8 md:p-10 border border-slate-200 dark:border-white/10 fade-up premium-card-glow">
            <form action="#" method="POST" class="space-y-6" id="volunteerForm">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="form-label">Nama Lengkap *</label>
                        <input type="text" name="nama" class="form-input" placeholder="Masukkan nama lengkap" required id="v-nama">
                    </div>
                    <div>
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-input" placeholder="email@contoh.com" required id="v-email">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="form-label">Nomor HP/WhatsApp *</label>
                        <input type="tel" name="phone" class="form-input" placeholder="+62 812 xxxx xxxx" required id="v-phone">
                    </div>
                    <div>
                        <label class="form-label">Kota Domisili *</label>
                        <input type="text" name="kota" class="form-input" placeholder="Contoh: Bandung, Jawa Barat" required id="v-kota">
                    </div>
                </div>
                <div>
                    <label class="form-label">Kategori Relawan *</label>
                    <select name="kategori" class="form-select" required id="v-kategori">
                        <option value="">Pilih Kategori</option>
                        <option value="rescue">🆘 Rescue Team</option>
                        <option value="medical">🏥 Medical Team</option>
                        <option value="logistics">📦 Logistics Team</option>
                        <option value="communication">📡 Communication Team</option>
                        <option value="assessment">📋 Assessment Team</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Keahlian Khusus</label>
                    <input type="text" name="keahlian" class="form-input" placeholder="Contoh: SAR, Pertolongan Pertama, IT, Mengemudi" id="v-keahlian">
                </div>
                <div>
                    <label class="form-label">Pengalaman Kerelawanan</label>
                    <select name="pengalaman" class="form-select" id="v-pengalaman">
                        <option value="">Pilih Pengalaman</option>
                        <option value="0">Belum pernah (Pemula)</option>
                        <option value="1">1-2 tahun</option>
                        <option value="3">3-5 tahun</option>
                        <option value="5">Lebih dari 5 tahun</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Sertifikasi yang Dimiliki</label>
                    <input type="text" name="sertifikasi" class="form-input" placeholder="Contoh: SAR Dasar, PPGD, ISO 22320" id="v-sertifikasi">
                </div>
                <div>
                    <label class="form-label">Upload CV/Resume (PDF, max 2MB)</label>
                    <div class="border-2 border-dashed border-slate-300 dark:border-slate-700 hover:border-green-550/50 rounded-xl p-8 text-center cursor-pointer transition-all group bg-slate-50/50 dark:bg-slate-900/20" onclick="document.getElementById('cvUpload').click()">
                        <i class="fas fa-cloud-upload-alt text-slate-400 group-hover:text-green-500 text-3xl mb-3 transition-colors"></i>
                        <p class="text-slate-600 dark:text-slate-400 text-sm mb-1">Klik atau drag & drop file CV Anda</p>
                        <p class="text-slate-500 dark:text-slate-600 text-xs">PDF, DOC, DOCX — Max 2MB</p>
                        <input type="file" id="cvUpload" name="cv" accept=".pdf,.doc,.docx" class="hidden">
                    </div>
                </div>
                <div>
                    <label class="form-label">Motivasi Bergabung</label>
                    <textarea name="motivasi" rows="4" class="form-input resize-none" placeholder="Ceritakan mengapa Anda ingin menjadi relawan CrisisHub..." id="v-motivasi"></textarea>
                </div>
                <div class="flex items-start gap-3">
                    <input type="checkbox" id="agree" name="agree" class="mt-1 custom-radio" required>
                    <label for="agree" class="text-slate-650 dark:text-slate-400 text-sm">Saya menyetujui <a href="/terms" class="text-green-600 dark:text-green-400 hover:underline font-semibold">Syarat & Ketentuan</a> dan bersedia mengikuti pelatihan serta misi yang ditugaskan oleh CrisisHub.</label>
                </div>
                <button type="submit" id="submitVolunteer" class="w-full py-4 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 text-white font-black text-lg rounded-2xl transition-all shimmer-btn" style="box-shadow: 0 0 20px rgba(34,197,94,0.3);">
                    <i class="fas fa-hard-hat mr-2"></i>Kirim Pendaftaran Relawan
                </button>
            </form>
        </div>
    </div>
</section>

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

    // Form submit
    document.getElementById('volunteerForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('submitVolunteer');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';
        btn.disabled = true;
        setTimeout(() => {
            btn.innerHTML = '<i class="fas fa-check mr-2"></i>Pendaftaran Terkirim! Tim kami akan menghubungi Anda';
            btn.style.background = 'linear-gradient(135deg, #16a34a, #15803d)';
        }, 2000);
    });
</script>
@endsection
