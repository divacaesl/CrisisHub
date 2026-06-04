@extends('layouts.public')

@section('title', 'Kontak — CrisisHub')
@section('description', 'Hubungi tim CrisisHub untuk informasi, darurat, atau kerjasama. Hotline 24 jam tersedia.')

@section('content')
<!-- Contact Hero -->
<section class="hero-dynamic hero-contact relative min-h-[50vh] flex items-center pt-24 pb-16 overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-purple-600/5 rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <div class="max-w-2xl mx-auto">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-blue-600/15 border border-blue-600/25 rounded-full mb-6">
                <i class="fas fa-headset text-blue-400 text-xs"></i>
                <span class="text-blue-400 text-sm font-semibold">Siap Membantu 24/7</span>
            </div>
            <h1 class="text-4xl sm:text-5xl font-black text-white mb-5">
                Hubungi Tim <span style="background: linear-gradient(135deg, #3b82f6, #8b5cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">CrisisHub</span>
            </h1>
            <p class="text-slate-300 text-lg leading-relaxed">
                Tim kami siap membantu Anda 24 jam sehari, 7 hari seminggu. Hubungi kami untuk informasi, darurat, atau kerjasama.
            </p>
        </div>
    </div>
</section>

<!-- Contact Information -->
<section class="py-20 bg-white dark:bg-[#0a0f1e] transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
            @php
            $contacts = [
                ['icon' => 'fas fa-map-marker-alt', 'color' => 'red', 'title' => 'Alamat Kantor', 'main' => 'Jl. Jend. Sudirman No. 45', 'sub' => 'Jakarta Pusat, DKI Jakarta 10210'],
                ['icon' => 'fas fa-phone-alt', 'color' => 'blue', 'title' => 'Telepon Umum', 'main' => '(021) 5555-1234', 'sub' => 'Senin–Jumat, 08.00–17.00 WIB'],
                ['icon' => 'fas fa-envelope', 'color' => 'purple', 'title' => 'Email', 'main' => 'info@crisishub.id', 'sub' => 'Respons dalam 1x24 jam kerja'],
                ['icon' => 'fab fa-whatsapp', 'color' => 'green', 'title' => 'WhatsApp', 'main' => '+62 812-3456-7890', 'sub' => 'Chat langsung dengan tim kami'],
            ];
            @endphp
            @foreach($contacts as $i => $c)
            <div class="glass rounded-2xl p-7 border border-{{ $c['color'] }}-500/20 card-hover premium-card-glow text-center fade-up" style="animation-delay: {{ $i * 0.1 }}s">
                <div class="w-14 h-14 bg-{{ $c['color'] }}-600/20 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <i class="{{ $c['icon'] }} text-{{ $c['color'] }}-500 dark:text-{{ $c['color'] }}-400 text-2xl"></i>
                </div>
                <h3 class="text-slate-800 dark:text-white font-bold mb-2">{{ $c['title'] }}</h3>
                <p class="text-{{ $c['color'] }}-600 dark:text-{{ $c['color'] }}-300 font-semibold text-sm mb-1">{{ $c['main'] }}</p>
                <p class="text-slate-550 dark:text-slate-500 text-xs">{{ $c['sub'] }}</p>
            </div>
            @endforeach
        </div>

        <!-- Emergency Contact -->
        <div class="dark-content relative overflow-hidden rounded-3xl p-10 fade-up" style="background: linear-gradient(135deg, #1a0000 0%, #7f1d1d 50%, #1a0000 100%); border: 1px solid rgba(220,38,38,0.3); box-shadow: 0 0 60px rgba(220,38,38,0.15);">
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute top-0 left-1/4 w-48 h-48 bg-red-500/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 right-1/4 w-48 h-48 bg-orange-500/10 rounded-full blur-3xl"></div>
            </div>
            <div class="relative z-10 grid lg:grid-cols-2 gap-10 items-center">
                <div>
                    <div class="inline-flex items-center gap-3 px-4 py-2 bg-red-600/30 border border-red-500/40 rounded-full mb-5">
                        <div class="w-3 h-3 rounded-full bg-red-500 badge-urgent"></div>
                        <span class="text-red-300 font-bold text-sm">HOTLINE DARURAT 24 JAM</span>
                    </div>
                    <div class="text-7xl font-black text-white mb-2">119 <span class="text-red-400 text-4xl">ext. 9</span></div>
                    <p class="text-red-200 text-lg font-semibold mb-3">Layanan Tanggap Darurat Bencana Nasional</p>
                    <p class="text-slate-300 leading-relaxed">
                        Hubungi hotline darurat kami untuk situasi bencana yang memerlukan respons segera. Tim kami akan merespons dalam hitungan menit.
                    </p>
                </div>
                <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
                    <a href="tel:119" class="sos-btn text-white font-black text-xl px-10 py-5 rounded-3xl flex items-center gap-3 transition-all hover:scale-105">
                        <i class="fas fa-phone-alt"></i>
                        <div>
                            <div class="text-2xl font-black">119 ext. 9</div>
                            <div class="text-red-200 text-xs font-normal">Telepon Sekarang</div>
                        </div>
                    </a>
                    <a href="https://wa.me/6281234567890" target="_blank" class="flex items-center gap-3 px-8 py-5 bg-green-600 hover:bg-green-500 text-white font-bold rounded-3xl transition-all">
                        <i class="fab fa-whatsapp text-2xl"></i>
                        <div>
                            <div class="font-black">WhatsApp</div>
                            <div class="text-green-200 text-xs font-normal">Chat Darurat</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form & Map -->
<section class="py-20 bg-slate-50 dark:bg-[#0f172a] transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Form -->
            <div class="fade-up">
                <div class="mb-8">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-blue-600/15 border border-blue-600/25 rounded-full mb-4">
                        <i class="fas fa-paper-plane text-blue-550 dark:text-blue-400 text-xs"></i>
                        <span class="text-blue-600 dark:text-blue-400 text-sm font-semibold">Kirim Pesan</span>
                    </div>
                    <h2 class="text-3xl font-black text-slate-900 dark:text-white font-display">Hubungi Kami</h2>
                </div>

                <form id="contactForm" action="#" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">Nama Lengkap *</label>
                            <input type="text" name="nama" class="form-input" placeholder="Nama Anda" required id="c-nama">
                        </div>
                        <div>
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-input" placeholder="email@contoh.com" required id="c-email">
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Subjek *</label>
                        <input type="text" name="subjek" class="form-input" placeholder="Subjek pesan Anda" required id="c-subjek">
                    </div>
                    <div>
                        <label class="form-label">Kategori *</label>
                        <select name="kategori" class="form-select" required id="c-kategori">
                            <option value="">Pilih Kategori</option>
                            <option>Pelaporan Bencana</option>
                            <option>Informasi Relawan</option>
                            <option>Pertanyaan Donasi</option>
                            <option>Kerjasama / Partnership</option>
                            <option>Keluhan / Saran</option>
                            <option>Media & Press</option>
                            <option>Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Pesan *</label>
                        <textarea name="pesan" rows="5" class="form-input resize-none" placeholder="Tulis pesan Anda di sini..." required id="c-pesan"></textarea>
                    </div>
                    <button type="submit" id="submitContact" class="w-full py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-black text-lg rounded-2xl transition-all shimmer-btn">
                        <i class="fas fa-paper-plane mr-2"></i>Kirim Pesan
                    </button>
                </form>
            </div>

            <!-- Map & Office Hours -->
            <div class="fade-up" style="animation-delay:0.2s">
                <div class="mb-8">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-blue-600/15 border border-blue-600/25 rounded-full mb-4">
                        <i class="fas fa-map text-blue-550 dark:text-blue-400 text-xs"></i>
                        <span class="text-blue-600 dark:text-blue-400 text-sm font-semibold">Lokasi Kantor</span>
                    </div>
                    <h2 class="text-3xl font-black text-slate-900 dark:text-white font-display">Temukan Kami</h2>
                </div>
 
                <!-- Google Maps Embed -->
                <div class="rounded-2xl overflow-hidden mb-6 border border-slate-200 dark:border-white/10" style="box-shadow: 0 20px 40px rgba(0,0,0,0.05); dark-box-shadow: 0 20px 40px rgba(0,0,0,0.4);">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322282!2d106.8195613!3d-6.2087634!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e945e34b9d%3A0x5371bf0fdad786a2!2sSudirman%2C%20Kota%20Jakarta%20Pusat%2C%20Daerah%20Khusus%20Ibukota%20Jakarta!5e0!3m2!1sid!2sid!4v1702000000000!5m2!1sid!2sid"
                        width="100%"
                        height="280"
                        style="border:0; filter: invert(90%) hue-rotate(180deg);"
                        allowfullscreen
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
 
                <!-- Office Hours -->
                <div class="glass rounded-2xl p-6 border border-slate-200 dark:border-white/10 premium-card-glow">
                    <h3 class="text-slate-800 dark:text-white font-bold mb-4 flex items-center gap-2">
                        <i class="fas fa-clock text-blue-550 dark:text-blue-400"></i>
                        Jam Operasional
                    </h3>
                    <div class="space-y-3">
                        @php
                        $hours = [
                            ['day' => 'Senin – Jumat', 'time' => '08.00 – 17.00 WIB', 'open' => true],
                            ['day' => 'Sabtu', 'time' => '09.00 – 15.00 WIB', 'open' => true],
                            ['day' => 'Minggu & Hari Libur', 'time' => 'Tutup (Hotline darurat tetap aktif)', 'open' => false],
                        ];
                        @endphp
                        @foreach($hours as $h)
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 text-sm">{{ $h['day'] }}</span>
                            <span class="text-sm {{ $h['open'] ? 'text-green-400 font-semibold' : 'text-slate-500' }}">{{ $h['time'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4 pt-4 border-t border-white/10 flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-red-500 badge-urgent"></div>
                        <span class="text-red-400 text-sm font-bold">Hotline Darurat: 119 ext. 9 — 24 Jam</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="py-20 bg-white dark:bg-[#0a0f1e] transition-colors duration-300">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 fade-up">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-yellow-600/15 border border-yellow-600/25 rounded-full mb-4">
                <i class="fas fa-question-circle text-yellow-600 dark:text-yellow-400 text-xs"></i>
                <span class="text-yellow-600 dark:text-yellow-400 text-sm font-semibold">Pertanyaan Umum</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mb-3">FAQ</h2>
            <p class="text-slate-600 dark:text-slate-400">Pertanyaan yang sering ditanyakan tentang CrisisHub.</p>
        </div>

        <div class="space-y-4 fade-up">
            @php
            $faqs = [
                ['q' => 'Bagaimana cara melapor bencana melalui CrisisHub?', 'a' => 'Anda dapat melapor bencana melalui beberapa cara: (1) Klik tombol "Laporkan Bencana" di navbar, (2) Unduh aplikasi CrisisHub di Play Store/App Store, atau (3) Hubungi hotline 119 ext. 9. Pastikan Anda memiliki data lokasi, foto kejadian, dan informasi korban untuk laporan yang lebih akurat.'],
                ['q' => 'Bagaimana cara mendaftar sebagai relawan?', 'a' => 'Kunjungi halaman Relawan di website ini, isi formulir pendaftaran dengan data diri, keahlian, dan pengalaman Anda. Tim kami akan menghubungi Anda dalam 24 jam untuk proses selanjutnya termasuk orientasi dan pelatihan dasar.'],
                ['q' => 'Bagaimana cara berdonasi dan apakah aman?', 'a' => 'Anda dapat berdonasi melalui halaman Donasi dengan berbagai metode pembayaran (transfer bank, QRIS, e-wallet, minimarket). Sistem pembayaran kami dienkripsi dan tersertifikasi. Seluruh donasi dapat dilacak secara real-time.'],
                ['q' => 'Bagaimana cara melacak distribusi bantuan donasi saya?', 'a' => 'Setelah berdonasi, Anda akan mendapat email konfirmasi dengan kode tracking unik. Gunakan kode tersebut di halaman Transparansi untuk memantau perjalanan donasi Anda dari penerimaan hingga ke tangan penerima manfaat.'],
                ['q' => 'Bagaimana cara menghubungi tim CrisisHub untuk darurat?', 'a' => 'Untuk situasi darurat, hubungi Hotline 119 ext. 9 yang aktif 24 jam. Alternatif lain: WhatsApp +62 812-3456-7890 atau tekan tombol SOS di aplikasi mobile CrisisHub. Jangan gunakan email untuk situasi darurat.'],
            ];
            @endphp

            @foreach($faqs as $i => $faq)
            <div class="faq-item bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden shadow-sm hover:shadow-md transition-all">
                <button class="faq-btn w-full flex items-center justify-between gap-4 p-6 text-left hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                    <span class="text-slate-900 dark:text-white font-semibold text-sm md:text-base">{{ $faq['q'] }}</span>
                    <i class="faq-icon fas fa-plus text-slate-400 dark:text-slate-500 flex-shrink-0 transition-transform duration-300"></i>
                </button>
                <div class="faq-answer px-6 bg-slate-50 dark:bg-slate-800/50">
                    <div class="pb-6 text-slate-600 dark:text-slate-300 text-sm leading-relaxed pt-2">
                        {{ $faq['a'] }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-12 text-center fade-up">
            <p class="text-slate-600 dark:text-slate-400 mb-4">Tidak menemukan jawaban yang Anda cari?</p>
            <a href="#" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold rounded-xl transition-all shimmer-btn">
                <i class="fas fa-headset"></i>Chat dengan Tim Support
            </a>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.getElementById('contactForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('submitContact');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';
        btn.disabled = true;
        setTimeout(() => {
            btn.innerHTML = '<i class="fas fa-check mr-2"></i>Pesan terkirim! Kami akan menghubungi Anda segera.';
            btn.style.background = 'linear-gradient(135deg, #16a34a, #15803d)';
        }, 1500);
    });
</script>
@endsection
