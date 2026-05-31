@extends('layouts.public')

@section('title', 'Donasi — CrisisHub')
@section('description', 'Setiap donasi Anda menyelamatkan kehidupan. Donasikan sekarang untuk korban bencana Indonesia.')

@section('content')
<!-- Donate Hero -->
<section class="hero-dynamic hero-donate relative min-h-[60vh] flex items-center pt-24 pb-16 overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-orange-600/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-red-600/5 rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <div class="max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-orange-600/15 border border-orange-600/25 rounded-full mb-6">
                <i class="fas fa-heart text-orange-400 text-xs"></i>
                <span class="text-orange-400 text-sm font-semibold">Transparansi Terjamin</span>
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white mb-6 leading-tight">
                Setiap Donasi <br><span style="background: linear-gradient(135deg, #f97316, #ef4444, #fbbf24); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Menyelamatkan Kehidupan</span>
            </h1>
            <p class="text-slate-300 text-xl leading-relaxed mb-10">
                Bantuan Anda tersalurkan langsung kepada korban bencana dengan sistem pelacakan transparan dan laporan real-time.
            </p>
            <!-- Donation stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                <div class="glass rounded-2xl p-5 border border-white/10">
                    <div class="text-3xl font-black text-orange-400 mb-1" data-target="42" data-prefix="Rp " data-suffix="M">Rp 42M</div>
                    <div class="text-slate-400 text-xs">Total Donasi</div>
                </div>
                <div class="glass rounded-2xl p-5 border border-white/10">
                    <div class="text-3xl font-black text-green-400 mb-1" data-target="18" data-suffix="">18</div>
                    <div class="text-slate-400 text-xs">Campaign Aktif</div>
                </div>
                <div class="glass rounded-2xl p-5 border border-white/10">
                    <div class="text-3xl font-black text-blue-400 mb-1" data-target="54210" data-suffix="">54.210</div>
                    <div class="text-slate-400 text-xs">Bantuan Tersalurkan</div>
                </div>
                <div class="glass rounded-2xl p-5 border border-white/10">
                    <div class="text-3xl font-black text-red-400 mb-1" data-target="89432" data-suffix="">89.432</div>
                    <div class="text-slate-400 text-xs">Penerima Manfaat</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Campaign List -->
<section class="py-20 bg-white dark:bg-[#0a0f1e] transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-start md:items-end justify-between mb-12 gap-4 fade-up">
            <div>
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-orange-600/15 border border-orange-600/25 rounded-full mb-3">
                    <i class="fas fa-fire text-orange-500 dark:text-orange-400 text-xs"></i>
                    <span class="text-orange-600 dark:text-orange-400 text-sm font-semibold">Campaign Aktif</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mb-2">Campaign Donasi Aktif</h2>
                <p class="text-slate-600 dark:text-slate-400">Pilih campaign dan bantu korban bencana yang membutuhkan.</p>
            </div>
            <!-- Filter -->
            <select class="glass px-4 py-2 rounded-xl text-slate-700 dark:text-slate-300 text-sm border border-slate-200 dark:border-white/10 bg-transparent cursor-pointer outline-none">
                <option class="bg-white text-slate-900 dark:bg-slate-800 dark:text-white">Semua Bencana</option>
                <option class="bg-white text-slate-900 dark:bg-slate-800 dark:text-white">Banjir</option>
                <option class="bg-white text-slate-900 dark:bg-slate-800 dark:text-white">Gempa Bumi</option>
                <option class="bg-white text-slate-900 dark:bg-slate-800 dark:text-white">Longsor</option>
                <option class="bg-white text-slate-900 dark:bg-slate-800 dark:text-white">Erupsi</option>
            </select>
        </div>

        @php
        $campaigns = [
            ['id'=>1,'emoji'=>'🌊','tag'=>'URGENT','tagColor'=>'red','title'=>'Darurat Banjir Jakarta Utara','location'=>'Jakarta Utara, DKI Jakarta','target'=>500000000,'collected'=>387500000,'pct'=>78,'deadline'=>'3 hari lagi','donors'=>2840,'desc'=>'Banjir besar merendam ratusan rumah di Jakarta Utara. Ribuan keluarga butuh bantuan makanan, air bersih, dan tempat pengungsian.'],
            ['id'=>2,'emoji'=>'🏔️','tag'=>'AKTIF','tagColor'=>'blue','title'=>'Rehab Hunian Pasca Gempa Cianjur','location'=>'Cianjur, Jawa Barat','target'=>1000000000,'collected'=>642000000,'pct'=>64,'deadline'=>'12 hari lagi','donors'=>5120,'desc'=>'Ribuan rumah rusak akibat gempa 6.2 SR. Dana digunakan untuk perbaikan hunian sementara and kebutuhan dasar keluarga terdampak.'],
            ['id'=>3,'emoji'=>'🌋','tag'=>'AKTIF','tagColor'=>'orange','title'=>'Pengungsian Erupsi Sinabung','location'=>'Karo, Sumatera Utara','target'=>250000000,'collected'=>185000000,'pct'=>74,'deadline'=>'7 hari lagi','donors'=>1230,'desc'=>'Ratusan keluarga mengungsi akibat erupsi Gunung Sinabung. Bantuan untuk makanan, obat-obatan, dan fasilitas pengungsian sangat dibutuhkan.'],
            ['id'=>4,'emoji'=>'⛰️','tag'=>'AKTIF','tagColor'=>'green','title'=>'Longsor Purworejo — Pemulihan','location'=>'Purworejo, Jawa Tengah','target'=>300000000,'collected'=>198000000,'pct'=>66,'deadline'=>'15 hari lagi','donors'=>892,'desc'=>'Longsor melanda desa Bagelen, Purworejo. Dana dibutuhkan untuk evakuasi, pembersihan material longsor, dan bantuan korban.'],
            ['id'=>5,'emoji'=>'💨','tag'=>'BARU','tagColor'=>'purple','title'=>'Pemulihan Angin Puting Beliung NTB','location'=>'Mataram, Nusa Tenggara Barat','target'=>150000000,'collected'=>42000000,'pct'=>28,'deadline'=>'21 hari lagi','donors'=>345,'desc'=>'Angin puting beliung menghancurkan puluhan rumah di Mataram. Bantuan material bangunan dan logistik sangat mendesak.'],
            ['id'=>6,'emoji'=>'🌊','tag'=>'AKTIF','tagColor'=>'blue','title'=>'Banjir Bandang Kalimantan Selatan','location'=>'Banjarmasin, Kalimantan Selatan','target'=>400000000,'collected'=>287000000,'pct'=>72,'deadline'=>'9 hari lagi','donors'=>2105,'desc'=>'Banjir bandang melanda beberapa kabupaten di Kalimantan Selatan. Ribuan jiwa terdampak dan butuh bantuan segera.'],
        ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-7">
            @foreach($campaigns as $i => $c)
            <div class="campaign-card premium-card-glow fade-up" style="animation-delay: {{ $i * 0.1 }}s">
                <div class="relative h-48 overflow-hidden">
                    @php
                        $img = '/images/cause1.png';
                        if ($c['id'] == 1 || $c['id'] == 6) $img = '/images/flood_case.png';
                        elseif ($c['id'] == 2) $img = '/images/cause1.png';
                        elseif ($c['id'] == 3) $img = '/images/cause3.png';
                        elseif ($c['id'] == 4) $img = '/images/earthquake_case.png';
                        elseif ($c['id'] == 5) $img = '/images/cause2.png';
                    @endphp
                    <img src="{{ $img }}" alt="{{ $c['title'] }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] via-transparent to-transparent"></div>
                    <div class="absolute top-3 left-3">
                        <span class="px-2.5 py-1 bg-{{ $c['tagColor'] }}-600 text-white text-xs font-bold rounded-lg">{{ $c['tag'] }}</span>
                    </div>
                    <div class="absolute bottom-3 left-3 right-3 flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-red-500 dark:text-red-400 text-xs"></i>
                        <span class="text-slate-300 text-xs font-semibold">{{ $c['location'] }}</span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-slate-900 dark:text-white font-bold text-base leading-snug mb-2">{{ $c['title'] }}</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed mb-4">{{ $c['desc'] }}</p>
                    <div class="mb-4">
                        <div class="flex justify-between text-xs mb-2">
                            <span class="text-slate-500 dark:text-slate-400">Terkumpul: <strong class="text-slate-950 dark:text-white">Rp {{ number_format($c['collected'], 0, ',', '.') }}</strong></span>
                            <span class="text-orange-500 dark:text-orange-400 font-bold">{{ $c['pct'] }}%</span>
                        </div>
                        <div class="h-2.5 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                            <div class="progress-bar h-full" style="width: {{ $c['pct'] }}%"></div>
                        </div>
                        <div class="flex justify-between text-xs mt-2 text-slate-500 dark:text-slate-400">
                            <span>Target: Rp {{ number_format($c['target'], 0, ',', '.') }}</span>
                            <span>{{ $c['donors'] }} donatur</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-1 text-orange-600 dark:text-orange-400 text-xs font-semibold mb-5">
                        <i class="fas fa-clock"></i> {{ $c['deadline'] }}
                    </div>
                    @auth
                    <button
                        onclick="openDonasiModal('{{ $c['id'] }}', '{{ addslashes($c['title']) }}', '{{ $c['emoji'] }}')"
                        class="block w-full text-center py-3 bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-500 hover:to-red-500 text-white font-bold rounded-xl transition-all hover:scale-105 hover:shadow-lg hover:shadow-orange-500/30 shimmer-btn">
                        <i class="fas fa-heart mr-2"></i>Donasi Sekarang
                    </button>
                    @else
                    <a href="{{ route('login') }}"
                        class="block w-full text-center py-3 bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-500 hover:to-red-500 text-white font-bold rounded-xl transition-all hover:scale-105 hover:shadow-lg hover:shadow-orange-500/30 flex items-center justify-center shimmer-btn">
                        <i class="fas fa-heart mr-2"></i>Donasi Sekarang
                    </a>
                    @endauth
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ==================== DONATION MODAL ==================== --}}
<div id="donasi-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" onclick="if(event.target===this) closeDonasiModal()">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>

    {{-- Modal Box --}}
    <div class="premium-modal relative w-full max-w-lg max-h-[90vh] overflow-y-auto rounded-3xl shadow-2xl z-10">

        {{-- Header --}}
        <div class="sticky top-0 z-10 px-6 pt-6 pb-4 border-b border-white/10 flex items-center justify-between"
             style="background: inherit; backdrop-filter: blur(20px);">
            <div>
                <p class="text-orange-400 text-xs font-bold uppercase tracking-widest mb-1">Donasi untuk</p>
                <h3 id="modal-title" class="text-white font-black text-xl leading-tight"></h3>
            </div>
            <button onclick="closeDonasiModal()"
                class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-slate-400 hover:text-white transition-all flex-shrink-0 ml-4">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Form Content --}}
        @auth
        <form action="{{ route('donate.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            <input type="hidden" name="campaign_title" id="modal-campaign-input">

            {{-- Step 1 --}}
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">① Pilih Nominal</p>
                <div class="grid grid-cols-3 gap-2 mb-3">
                    @foreach([50000, 100000, 250000, 500000, 1000000, 2500000] as $nom)
                    <button type="button" onclick="selectNominal({{ $nom }}, this)"
                        class="nominal-preset py-2.5 text-xs font-bold rounded-xl border border-white/10 text-slate-400 hover:border-orange-500 hover:text-orange-400 hover:bg-orange-500/5 transition-all">
                        Rp {{ number_format($nom, 0, ',', '.') }}
                    </button>
                    @endforeach
                </div>
                <input type="number" name="amount" id="modal-amount"
                    class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-white font-bold text-sm placeholder-slate-600 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all"
                    placeholder="Nominal lain (min. Rp 10.000)" min="10000" required>
            </div>

            {{-- Step 2 --}}
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">② Metode Pembayaran</p>
                <div class="grid grid-cols-2 gap-2">
                    @foreach([
                        ['value'=>'BCA Virtual Account',   'label'=>'BCA Virtual Account', 'icon'=>'fas fa-university',  'num'=>'8277-0001-2345', 'color'=>'blue'],
                        ['value'=>'Mandiri Virtual Account','label'=>'Mandiri',             'icon'=>'fas fa-credit-card', 'num'=>'9012-3456-7890', 'color'=>'yellow'],
                        ['value'=>'QRIS',                  'label'=>'QRIS / GoPay / OVO',  'icon'=>'fas fa-qrcode',      'num'=>'crisis@qris',    'color'=>'green'],
                        ['value'=>'BNI Virtual Account',   'label'=>'BNI',                 'icon'=>'fas fa-piggy-bank',  'num'=>'8000-9876-5432', 'color'=>'orange'],
                    ] as $m)
                    <label class="payment-method-label flex items-center gap-3 p-3 rounded-xl border border-white/10 cursor-pointer hover:border-{{ $m['color'] }}-500/60 transition-all"
                           data-number="{{ $m['num'] }}" data-name="a.n. Yayasan CrisisHub Indonesia">
                        <input type="radio" name="payment_method" value="{{ $m['value'] }}" class="sr-only" required
                               onchange="onPaymentChange(this)">
                        <div class="w-9 h-9 rounded-xl bg-{{ $m['color'] }}-500/10 flex items-center justify-center text-{{ $m['color'] }}-400 flex-shrink-0">
                            <i class="{{ $m['icon'] }}"></i>
                        </div>
                        <span class="text-slate-300 text-xs font-semibold">{{ $m['label'] }}</span>
                    </label>
                    @endforeach
                </div>

                {{-- Bank detail box --}}
                <div id="modal-bank-box" class="hidden mt-3 p-4 rounded-xl bg-slate-800/70 border border-slate-700">
                    <p class="text-slate-500 text-xs mb-1">Transfer ke:</p>
                    <p id="modal-bank-num" class="text-white font-black text-xl tracking-wider"></p>
                    <p id="modal-bank-name" class="text-slate-400 text-xs mt-0.5"></p>
                    <div class="mt-2 pt-2 border-t border-slate-700 flex items-center gap-2 text-orange-400 text-xs font-semibold">
                        <i class="fas fa-info-circle"></i> Setelah transfer, upload bukti di bawah
                    </div>
                </div>
            </div>

            {{-- Step 3 --}}
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">③ Bukti Transfer</p>
                <label for="modal-proof" id="proof-drop-zone"
                    class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-white/15 hover:border-orange-500/50 rounded-2xl cursor-pointer transition-all group relative overflow-hidden">
                    <div id="proof-placeholder-modal" class="text-center">
                        <i class="fas fa-cloud-upload-alt text-3xl text-slate-600 group-hover:text-orange-400 transition-colors mb-2"></i>
                        <p class="text-slate-500 text-xs group-hover:text-slate-300">Klik atau drag foto bukti transfer</p>
                        <p class="text-slate-600 text-[10px] mt-1">PNG, JPG, JPEG • Maks 4MB</p>
                    </div>
                    <img id="proof-preview-modal" src="#" alt="preview" class="hidden absolute inset-0 w-full h-full object-contain p-2">
                </label>
                <input type="file" name="proof_image" id="modal-proof" class="hidden" accept="image/*"
                       onchange="previewModalProof(this)">
            </div>

            {{-- Pesan --}}
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Pesan / Doa (Opsional)</p>
                <textarea name="notes" rows="2"
                    class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-white text-sm placeholder-slate-600 focus:outline-none focus:border-orange-500 resize-none transition-all"
                    placeholder="Tuliskan doa untuk para korban..."></textarea>
            </div>

            <button type="submit"
                class="w-full py-4 bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white font-black text-base rounded-2xl shadow-xl shadow-orange-500/20 transition-all hover:scale-[1.02] flex items-center justify-center gap-3">
                <i class="fas fa-paper-plane"></i> Kirim Donasi & Bukti Transfer
            </button>
        </form>
        @else
        <div class="p-10 text-center">
            <div class="text-5xl mb-4">🔒</div>
            <h4 class="text-white font-black text-lg mb-2">Login untuk Berdonasi</h4>
            <p class="text-slate-400 text-sm mb-6">Masuk terlebih dahulu untuk melanjutkan proses donasi.</p>
            <a href="{{ route('login') }}"
               class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-orange-600 to-red-600 text-white font-bold rounded-2xl transition-all hover:scale-105">
                <i class="fas fa-sign-in-alt"></i> Masuk Sekarang
            </a>
        </div>
        @endauth
    </div>
</div>




<!-- Donation Form -->
<section id="form-donasi" class="py-20 bg-slate-50 dark:bg-[#0f172a] transition-colors duration-300">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 fade-up">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-orange-600/15 border border-orange-600/25 rounded-full mb-4">
                <i class="fas fa-donate text-orange-550 dark:text-orange-400 text-xs"></i>
                <span class="text-orange-600 dark:text-orange-400 text-sm font-semibold">Form Donasi</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mb-3">Berikan Donasimu</h2>
        </div>

        <div class="glass rounded-3xl border border-slate-200 dark:border-white/10 overflow-hidden fade-up premium-card-glow">
            <!-- Tab Header -->
            <div class="flex border-b border-slate-200 dark:border-white/10">
                <button class="tab-btn active flex-1 py-4 text-sm font-bold transition-all" data-group="donasi" data-tab="tab-uang">
                    💵 Donasi Uang
                </button>
                <button class="tab-btn flex-1 py-4 text-sm font-bold text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all" data-group="donasi" data-tab="tab-barang">
                    📦 Donasi Barang
                </button>
            </div>

            <!-- Tab: Uang -->
            <div id="tab-uang" data-group-content="donasi" class="p-8 md:p-10">
                <form id="donasiUangForm" action="#" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label class="form-label">Pilih Campaign *</label>
                        <select name="campaign" class="form-select" id="d-campaign">
                            <option value="">Pilih Campaign Donasi</option>
                            <option>Darurat Banjir Jakarta Utara</option>
                            <option>Rehab Hunian Pasca Gempa Cianjur</option>
                            <option>Pengungsian Erupsi Sinabung</option>
                            <option>Longsor Purworejo</option>
                            <option>Donasi Umum (CrisisHub menentukan tujuan)</option>
                        </select>
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Jumlah Donasi *</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-3">
                            @foreach(['50.000', '100.000', '250.000', '500.000', '1.000.000', '2.500.000', '5.000.000', 'Lainnya'] as $nominal)
                            <button type="button" class="nominal-btn py-3 glass border border-slate-200 dark:border-white/10 hover:border-orange-500/50 text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white text-sm font-semibold rounded-xl transition-all" data-amount="{{ str_replace('.', '', $nominal) }}">
                                @if($nominal === 'Lainnya') ✏️ Lainnya @else Rp {{ $nominal }} @endif
                            </button>
                            @endforeach
                        </div>
                        <input type="number" name="nominal" id="nominalInput" class="form-input" placeholder="Atau masukkan jumlah lain (Rp)" min="10000">
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Metode Pembayaran *</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            @foreach([['💳', 'Transfer Bank', 'bank'], ['📱', 'QRIS', 'qris'], ['🏪', 'Minimarket', 'minimarket'], ['💰', 'E-Wallet', 'ewallet']] as $method)
                            <label class="flex flex-col items-center gap-2 p-4 glass border border-slate-200 dark:border-white/10 hover:border-orange-500/40 rounded-xl cursor-pointer transition-all text-center">
                                <input type="radio" name="payment" value="{{ $method[2] }}" class="hidden">
                                <span class="text-2xl">{{ $method[0] }}</span>
                                <span class="text-slate-700 dark:text-slate-300 text-xs font-semibold">{{ $method[1] }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Nama Donatur</label>
                        <input type="text" name="nama" class="form-input" placeholder="Nama Anda (kosongkan untuk anonim)" id="d-nama">
                    </div>
                    <div class="mb-8">
                        <label class="form-label">Pesan Dukungan (Opsional)</label>
                        <textarea name="pesan" rows="3" class="form-input resize-none" placeholder="Tulis pesan semangat untuk para korban..." id="d-pesan"></textarea>
                    </div>
                    <button type="submit" class="w-full py-4 bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-500 hover:to-red-500 text-white font-black text-lg rounded-2xl transition-all shimmer-btn" style="box-shadow: 0 0 30px rgba(249,115,22,0.3);">
                        <i class="fas fa-heart mr-2"></i>Lanjutkan Pembayaran
                    </button>
                </form>
            </div>

            <!-- Tab: Barang -->
            <div id="tab-barang" data-group-content="donasi" class="hidden p-8 md:p-10">
                <form id="donasiBarangForm" action="#" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="form-label">Nama Donatur *</label>
                            <input type="text" name="nama" class="form-input" placeholder="Nama Anda" id="db-nama">
                        </div>
                        <div>
                            <label class="form-label">Nomor HP *</label>
                            <input type="tel" name="phone" class="form-input" placeholder="+62 812 xxxx xxxx" id="db-phone">
                        </div>
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Jenis Barang *</label>
                        <select name="jenis" class="form-select" id="db-jenis">
                            <option value="">Pilih Jenis Barang</option>
                            <option>Makanan & Minuman (Sembako)</option>
                            <option>Pakaian & Selimut</option>
                            <option>Obat-obatan & P3K</option>
                            <option>Peralatan Masak</option>
                            <option>Tenda & Terpal</option>
                            <option>Mainan Anak</option>
                            <option>Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Estimasi Jumlah / Berat *</label>
                        <input type="text" name="jumlah" class="form-input" placeholder="Contoh: 50 kg, 100 pcs, 5 karton" id="db-jumlah">
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Untuk Campaign *</label>
                        <select name="campaign" class="form-select" id="db-campaign">
                            <option value="">Pilih Campaign Tujuan</option>
                            <option>Darurat Banjir Jakarta Utara</option>
                            <option>Rehab Hunian Pasca Gempa Cianjur</option>
                            <option>Pengungsian Erupsi Sinabung</option>
                            <option>Donasi Umum</option>
                        </select>
                    </div>
                    <div class="mb-8">
                        <label class="form-label">Lokasi Pengiriman / Antar Jemput</label>
                        <input type="text" name="lokasi" class="form-input" placeholder="Alamat Anda untuk penjemputan barang" id="db-lokasi">
                    </div>
                    <button type="submit" class="w-full py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-black text-lg rounded-2xl transition-all shimmer-btn">
                        <i class="fas fa-box mr-2"></i>Daftarkan Donasi Barang
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Transparency -->
<section id="transparency" class="py-20 bg-white dark:bg-[#0a0f1e] transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 fade-up">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-green-600/15 border border-green-600/25 rounded-full mb-4">
                <i class="fas fa-eye text-green-550 dark:text-green-400 text-xs"></i>
                <span class="text-green-650 dark:text-green-400 text-sm font-semibold">100% Transparan</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mb-3">Transparansi Distribusi</h2>
            <p class="text-slate-650 dark:text-slate-400 max-w-xl mx-auto">Setiap rupiah donasi Anda dapat dilacak secara real-time dari penerimaan hingga penyaluran.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <!-- Timeline -->
            <div class="fade-up">
                <h3 class="text-slate-900 dark:text-white font-bold text-xl mb-6">📋 Timeline Distribusi Terbaru</h3>
                <div class="space-y-4">
                    @php
                    $timeline = [
                        ['time' => '08:30 WIB', 'action' => '500 paket sembako dikirim to posko Jakarta Utara', 'icon' => 'fas fa-truck', 'color' => 'green', 'campaign' => 'Banjir Jakarta'],
                        ['time' => 'Kemarin', 'action' => '200 set pakaian & selimut dibagikan di Cianjur', 'icon' => 'fas fa-tshirt', 'color' => 'blue', 'campaign' => 'Gempa Cianjur'],
                        ['time' => '2 hari lalu', 'action' => 'Rp 50 juta dicairkan untuk perbaikan 25 rumah', 'icon' => 'fas fa-home', 'color' => 'orange', 'campaign' => 'Gempa Cianjur'],
                        ['time' => '3 hari lalu', 'action' => '300 box obat-obatan tiba di camp pengungsi Sinabung', 'icon' => 'fas fa-pills', 'color' => 'red', 'campaign' => 'Erupsi Sinabung'],
                    ];
                    @endphp
                    @foreach($timeline as $t)
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 bg-{{ $t['color'] }}-600/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="{{ $t['icon'] }} text-{{ $t['color'] }}-600 dark:text-{{ $t['color'] }}-400 text-xs"></i>
                            </div>
                            <div class="w-0.5 flex-1 bg-gradient-to-b from-{{ $t['color'] }}-600/20 to-transparent mt-2"></div>
                        </div>
                        <div class="pb-4 flex-1">
                            <p class="text-slate-800 dark:text-white text-sm font-semibold mb-1">{{ $t['action'] }}</p>
                            <div class="flex items-center gap-3">
                                <span class="text-slate-500 text-xs">{{ $t['time'] }}</span>
                                <span class="px-2 py-0.5 bg-{{ $t['color'] }}-100 dark:bg-{{ $t['color'] }}-900/30 text-{{ $t['color'] }}-700 dark:text-{{ $t['color'] }}-400 text-xs rounded-full font-semibold">{{ $t['campaign'] }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Foto Distribusi -->
            <div class="fade-up" style="animation-delay:0.2s">
                <h3 class="text-slate-900 dark:text-white font-bold text-xl mb-6">📸 Foto Distribusi Bantuan</h3>
                <div class="grid grid-cols-2 gap-3">
                    <img src="/images/donation_banner.png" alt="Distribusi bantuan" class="rounded-xl w-full h-36 object-cover col-span-2 shadow-md">
                    <div class="bg-slate-100 dark:bg-slate-800/50 border border-slate-200 dark:border-white/5 rounded-xl h-28 flex items-center justify-center text-3xl">📦</div>
                    <div class="bg-slate-100 dark:bg-slate-800/50 border border-slate-200 dark:border-white/5 rounded-xl h-28 flex items-center justify-center text-3xl">🍱</div>
                </div>
                <div class="mt-4 p-4 glass rounded-xl border border-green-500/20">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas fa-shield-alt text-green-600 dark:text-green-400 text-sm"></i>
                        <span class="text-green-600 dark:text-green-400 text-sm font-bold">Jaminan Transparansi CrisisHub</span>
                    </div>
                    <p class="text-slate-600 dark:text-slate-400 text-xs">Semua distribusi diverifikasi tim lapangan, difoto, dan dilaporkan dalam 24 jam ke platform. Donatur mendapat notifikasi otomatis.</p>
                </div>
            </div>
        </div>

        <!-- Recent Donations Feed -->
        <div class="fade-up">
            <h3 class="text-slate-900 dark:text-white font-bold text-xl mb-6">💝 Donasi Terbaru</h3>
            <div class="space-y-3">
                @php
                $recentDonations = [
                    ['name' => 'Ahmad F.', 'amount' => 500000, 'campaign' => 'Banjir Jakarta Utara', 'time' => '2 menit lalu', 'anon' => false],
                    ['name' => '***anonim***', 'amount' => 1000000, 'campaign' => 'Gempa Cianjur', 'time' => '5 menit lalu', 'anon' => true],
                    ['name' => 'PT Maju Bersama', 'amount' => 25000000, 'campaign' => 'Umum', 'time' => '12 menit lalu', 'anon' => false],
                    ['name' => 'Siti R.', 'amount' => 250000, 'campaign' => 'Erupsi Sinabung', 'time' => '18 menit lalu', 'anon' => false],
                    ['name' => 'Budi S.', 'amount' => 100000, 'campaign' => 'Banjir Jakarta Utara', 'time' => '25 menit lalu', 'anon' => false],
                ];
                @endphp
                @foreach($recentDonations as $d)
                <div class="flex items-center gap-4 glass rounded-xl p-4 border border-slate-200 dark:border-white/7">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-500 to-red-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                        {{ $d['anon'] ? '?' : strtoupper(substr($d['name'], 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <span class="text-slate-800 dark:text-white font-semibold text-sm">{{ $d['name'] }}</span>
                            <span class="text-slate-550 dark:text-slate-500 text-xs">berdonasi untuk</span>
                            <span class="text-orange-655 dark:text-orange-400 text-xs font-bold">{{ $d['campaign'] }}</span>
                        </div>
                        <div class="text-slate-450 dark:text-slate-500 text-xs mt-0.5">{{ $d['time'] }}</div>
                    </div>
                    <div class="text-green-600 dark:text-green-400 font-black text-base">Rp {{ number_format($d['amount'], 0, ',', '.') }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
{{-- Success toast from session --}}
@if(session('donation_success'))
<div id="donation-toast"
    class="dark-content fixed top-6 right-6 z-50 max-w-sm w-full p-5 rounded-2xl shadow-2xl border border-green-500/30 flex items-start gap-4 animate-fade-in"
    style="background: linear-gradient(135deg, #052e16, #14532d); box-shadow: 0 0 40px rgba(34,197,94,0.2);">
    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
        <i class="fas fa-check text-white"></i>
    </div>
    <div class="flex-1">
        <h4 class="text-green-300 font-black mb-1">Donasi Berhasil! 🎉</h4>
        <p class="text-green-400 text-sm leading-snug">{{ session('donation_success') }}</p>
    </div>
    <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-300 mt-1 flex-shrink-0">
        <i class="fas fa-times text-sm"></i>
    </button>
</div>
<script>setTimeout(() => { const t = document.getElementById('donation-toast'); if (t) t.remove(); }, 6000);</script>
@endif

<script>
// ── Modal open/close ──────────────────────────────────────────
function openDonasiModal(id, title, emoji) {
    document.getElementById('modal-title').textContent = emoji + ' ' + title;
    document.getElementById('modal-campaign-input').value = title;

    // Reset form state
    document.getElementById('modal-amount').value = '';
    document.getElementById('modal-bank-box').classList.add('hidden');
    document.getElementById('proof-preview-modal').classList.add('hidden');
    document.getElementById('proof-placeholder-modal').classList.remove('hidden');
    document.getElementById('modal-proof').value = '';
    document.querySelectorAll('.nominal-preset').forEach(b =>
        b.classList.remove('border-orange-500', 'text-orange-400', 'bg-orange-500/10'));
    document.querySelectorAll('.payment-method-label').forEach(l =>
        l.classList.remove('border-orange-500', 'bg-orange-500/10'));

    const modal = document.getElementById('donasi-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeDonasiModal() {
    const modal = document.getElementById('donasi-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
}

// Close on Escape key
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDonasiModal(); });

// ── Nominal preset buttons ────────────────────────────────────
function selectNominal(amount, btn) {
    document.getElementById('modal-amount').value = amount;
    document.querySelectorAll('.nominal-preset').forEach(b =>
        b.classList.remove('border-orange-500', 'text-orange-400', 'bg-orange-500/10'));
    btn.classList.add('border-orange-500', 'text-orange-400', 'bg-orange-500/10');
}

// ── Payment method selection ──────────────────────────────────
function onPaymentChange(radio) {
    const lbl = radio.closest('label');
    const num  = lbl.dataset.number;
    const name = lbl.dataset.name;

    document.querySelectorAll('.payment-method-label').forEach(l =>
        l.classList.remove('border-orange-500', 'bg-orange-500/10'));
    lbl.classList.add('border-orange-500', 'bg-orange-500/10');

    document.getElementById('modal-bank-num').textContent  = num;
    document.getElementById('modal-bank-name').textContent = name;
    document.getElementById('modal-bank-box').classList.remove('hidden');
}

// ── Upload proof preview ──────────────────────────────────────
function previewModalProof(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('proof-preview-modal').src = e.target.result;
            document.getElementById('proof-preview-modal').classList.remove('hidden');
            document.getElementById('proof-placeholder-modal').classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection


