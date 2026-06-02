@extends('layouts.public')

@section('title', 'Donasi — CrisisHub')
@section('description', 'Setiap donasi Anda menyelamatkan kehidupan. Donasikan sekarang untuk korban bencana Indonesia.')

@section('head')
<style>
    /* Prevent the bank detail card from rendering as stark white in dark mode */
    #modal-bank-box {
        background: rgba(241, 245, 249, 0.95) !important;
        border: 1px solid rgba(226, 232, 240, 1) !important;
    }
    .dark #modal-bank-box {
        background: rgba(30, 41, 59, 0.75) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
    }
</style>
@endsection

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
                    <div class="text-3xl font-black text-orange-400 mb-1 grand-total-counter" data-target="{{ 42000000000 + $totalDonationsInDb }}" data-prefix="Rp " data-suffix="">Rp {{ number_format(42000000000 + $totalDonationsInDb, 0, ',', '.') }}</div>
                    <div class="text-slate-400 text-xs">Total Donasi</div>
                </div>
                <div class="glass rounded-2xl p-5 border border-white/10">
                    <div class="text-3xl font-black text-green-400 mb-1" data-target="{{ count($campaigns) }}" data-suffix="">{{ count($campaigns) }}</div>
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

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-7">
            @foreach($campaigns as $i => $c)
            <div class="campaign-card premium-card-glow fade-up" data-campaign-title="{{ $c['title'] }}" style="animation-delay: {{ $i * 0.1 }}s">
                <div class="relative h-48 overflow-hidden">
                    @php
                        $img = '/images/cause1.png';
                        if (stripos($c['title'], 'Banjir Jakarta') !== false || stripos($c['title'], 'Kalimantan') !== false) $img = '/images/flood_case.png';
                        elseif (stripos($c['title'], 'Cianjur') !== false) $img = '/images/cause1.png';
                        elseif (stripos($c['title'], 'Sinabung') !== false) $img = '/images/cause3.png';
                        elseif (stripos($c['title'], 'Purworejo') !== false) $img = '/images/earthquake_case.png';
                        elseif (stripos($c['title'], 'NTB') !== false) $img = '/images/cause2.png';
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
                            <span class="text-slate-500 dark:text-slate-400">Terkumpul: <strong class="text-slate-950 dark:text-white card-collected">Rp {{ number_format($c['collected'], 0, ',', '.') }}</strong></span>
                            <span class="text-orange-500 dark:text-orange-400 font-bold card-pct">{{ $c['pct'] }}%</span>
                        </div>
                        <div class="h-2.5 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                            <div class="progress-bar h-full card-progress" style="width: {{ $c['pct'] }}%"></div>
                        </div>
                        <div class="flex justify-between text-xs mt-2 text-slate-500 dark:text-slate-400">
                            <span class="card-target" data-target-raw="{{ $c['target'] }}">Target: Rp {{ number_format($c['target'], 0, ',', '.') }}</span>
                            <span class="card-donors" data-donors-raw="{{ $c['donors'] }}">{{ number_format($c['donors'], 0, ',', '.') }} donatur</span>
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
<div id="donasi-modal" class="fixed inset-0 z-50 hidden overflow-y-auto p-4 md:p-6 justify-center items-start" onclick="if(event.target===this) closeDonasiModal()">
    {{-- Backdrop --}}
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm pointer-events-none"></div>

    {{-- Modal Box --}}
    <div class="premium-modal relative w-full max-w-lg my-auto rounded-3xl shadow-2xl z-10">

        {{-- Header --}}
        <div class="sticky top-0 z-10 px-6 pt-6 pb-4 border-b border-slate-200 dark:border-white/10 flex items-center justify-between"
             style="background: inherit; backdrop-filter: blur(20px);">
            <div>
                <p class="text-orange-500 dark:text-orange-400 text-xs font-bold uppercase tracking-widest mb-1">Donasi untuk</p>
                <h3 id="modal-title" class="text-slate-900 dark:text-white font-black text-xl leading-tight"></h3>
            </div>
            <button onclick="closeDonasiModal()"
                class="w-9 h-9 rounded-full bg-slate-100 dark:bg-white/10 hover:bg-slate-200 dark:hover:bg-white/20 flex items-center justify-center text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white transition-all flex-shrink-0 ml-4">
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
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-3">① Pilih Nominal</p>
                <div class="grid grid-cols-3 gap-2 mb-3">
                    @foreach([50000, 100000, 250000, 500000, 1000000, 2500000] as $nom)
                    <button type="button" onclick="selectNominal({{ $nom }}, this)"
                        class="nominal-preset py-2.5 text-xs font-bold rounded-xl border border-slate-200 dark:border-white/10 text-slate-600 dark:text-slate-400 hover:border-orange-500 hover:text-orange-500 dark:hover:text-orange-400 hover:bg-orange-500/5 dark:hover:bg-orange-500/5 transition-all">
                        Rp {{ number_format($nom, 0, ',', '.') }}
                    </button>
                    @endforeach
                </div>
                <input type="number" name="amount" id="modal-amount"
                    class="w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/10 rounded-xl py-3 px-4 text-slate-900 dark:text-white font-bold text-sm placeholder-slate-400 dark:placeholder-slate-600 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all"
                    placeholder="Nominal lain (min. Rp 10.000)" min="10000" required>
            </div>

            {{-- Step 2 --}}
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-3">② Metode Pembayaran</p>
                <div class="grid grid-cols-2 gap-2">
                    @foreach([
                        ['value'=>'BCA Virtual Account',   'label'=>'BCA Virtual Account', 'icon'=>'fas fa-university',  'num'=>'8277-0001-2345', 'color'=>'blue'],
                        ['value'=>'Mandiri Virtual Account','label'=>'Mandiri',             'icon'=>'fas fa-credit-card', 'num'=>'9012-3456-7890', 'color'=>'yellow'],
                        ['value'=>'QRIS',                  'label'=>'QRIS / GoPay / OVO',  'icon'=>'fas fa-qrcode',      'num'=>'crisis@qris',    'color'=>'green'],
                        ['value'=>'BNI Virtual Account',   'label'=>'BNI',                 'icon'=>'fas fa-piggy-bank',  'num'=>'8000-9876-5432', 'color'=>'orange'],
                    ] as $m)
                    <label class="payment-method-label flex items-center gap-3 p-3 rounded-xl border border-slate-200 dark:border-white/10 cursor-pointer hover:border-orange-500 dark:hover:border-orange-500/60 transition-all"
                           data-number="{{ $m['num'] }}" data-name="a.n. Yayasan CrisisHub Indonesia">
                        <input type="radio" name="payment_method" value="{{ $m['value'] }}" class="sr-only" required
                               onchange="onPaymentChange(this)">
                        <div class="w-9 h-9 rounded-xl bg-orange-500/10 flex items-center justify-center text-orange-500 dark:text-orange-400 flex-shrink-0">
                            <i class="{{ $m['icon'] }}"></i>
                        </div>
                        <span class="text-slate-700 dark:text-slate-300 text-xs font-semibold">{{ $m['label'] }}</span>
                    </label>
                    @endforeach
                </div>

                {{-- Bank detail box --}}
                <div id="modal-bank-box" class="hidden mt-3 p-4 rounded-xl border">
                    <p id="modal-bank-label" class="text-slate-500 dark:text-slate-400 text-xs mb-1">Transfer ke:</p>
                    <p id="modal-bank-num" class="text-slate-900 dark:text-white font-black text-xl tracking-wider"></p>
                    <p id="modal-bank-name" class="text-slate-500 dark:text-slate-400 text-xs mt-0.5"></p>
                    
                    {{-- QR Code Image for QRIS --}}
                    <div id="modal-qr-box" class="hidden flex flex-col items-center justify-center my-4 p-3 bg-white rounded-2xl border border-slate-200 w-48 h-48 mx-auto shadow-md">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=crisis@qris" alt="QRIS Code" class="w-full h-full object-contain">
                    </div>

                    <div class="mt-2 pt-2 border-t border-slate-200 dark:border-slate-700 flex items-center gap-2 text-orange-500 dark:text-orange-400 text-xs font-semibold">
                        <i class="fas fa-info-circle"></i> Setelah transfer, upload bukti di bawah
                    </div>
                </div>
            </div>

            {{-- Step 3 --}}
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-3">③ Bukti Transfer</p>
                <label for="modal-proof" id="proof-drop-zone"
                    class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-slate-300 dark:border-white/15 hover:border-orange-500 dark:hover:border-orange-500/50 rounded-2xl cursor-pointer transition-all group relative overflow-hidden">
                    <div id="proof-placeholder-modal" class="text-center">
                        <i class="fas fa-cloud-upload-alt text-3xl text-slate-400 dark:text-slate-650 group-hover:text-orange-500 dark:group-hover:text-orange-400 transition-colors mb-2"></i>
                        <p class="text-slate-500 dark:text-slate-400 text-xs group-hover:text-slate-700 dark:group-hover:text-slate-300">Klik atau drag foto bukti transfer</p>
                        <p class="text-slate-400 dark:text-slate-600 text-[10px] mt-1">PNG, JPG, JPEG • Maks 4MB</p>
                    </div>
                    <img id="proof-preview-modal" src="#" alt="preview" class="hidden absolute inset-0 w-full h-full object-contain p-2">
                </label>
                <input type="file" name="proof_image" id="modal-proof" class="hidden" accept="image/*"
                       onchange="previewModalProof(this)">
            </div>

            {{-- Pesan --}}
            <div>
                <p class="text-xs font-bold text-slate-550 dark:text-slate-455 uppercase tracking-widest mb-2">Pesan / Doa (Opsional)</p>
                <textarea name="notes" rows="2"
                    class="w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/10 rounded-xl py-3 px-4 text-slate-900 dark:text-white text-sm placeholder-slate-400 dark:placeholder-slate-600 focus:outline-none focus:border-orange-500 resize-none transition-all"
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
            <h4 class="text-slate-900 dark:text-white font-black text-lg mb-2">Login untuk Berdonasi</h4>
            <p class="text-slate-500 dark:text-slate-400 text-sm mb-6">Masuk terlebih dahulu untuk melanjutkan proses donasi.</p>
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
                            @foreach($campaigns as $c)
                            <option value="{{ $c['title'] }}">{{ $c['title'] }}</option>
                            @endforeach
                            <option value="Donasi Umum">Donasi Umum (CrisisHub menentukan tujuan)</option>
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
                            @foreach($campaigns as $c)
                            <option value="{{ $c['title'] }}">{{ $c['title'] }}</option>
                            @endforeach
                            <option value="Donasi Umum">Donasi Umum</option>
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
            <div id="recent-donations-feed" class="space-y-3">
                @forelse($recentDonations as $d)
                @php
                    $notes = $d->notes;
                    if ($notes && preg_match('/^Dari:\s*([^.]+)\./i', $notes, $matches)) {
                        $donorName = trim($matches[1]);
                    } else {
                        $donorName = $d->user ? $d->user->name : '***anonim***';
                    }
                    $isAnon = (stripos($donorName, 'anonim') !== false || $donorName === '***anonim***');
                    $avatar = $isAnon ? '?' : strtoupper(substr($donorName, 0, 1));
                    $campaignName = $d->campaign_title ?: 'Donasi Umum';
                    $timeAgo = $d->created_at ? $d->created_at->diffForHumans() : 'Baru saja';
                @endphp
                <div class="flex items-center gap-4 glass rounded-xl p-4 border border-slate-200 dark:border-white/7">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-500 to-red-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                        {{ $avatar }}
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <span class="text-slate-800 dark:text-white font-semibold text-sm">{{ $donorName }}</span>
                            <span class="text-slate-550 dark:text-slate-500 text-xs">berdonasi untuk</span>
                            <span class="text-orange-655 dark:text-orange-400 text-xs font-bold">{{ $campaignName }}</span>
                        </div>
                        <div class="text-slate-450 dark:text-slate-500 text-xs mt-0.5">{{ $timeAgo }}</div>
                    </div>
                    <div class="text-green-600 dark:text-green-400 font-black text-base">Rp {{ number_format($d->amount, 0, ',', '.') }}</div>
                </div>
                @empty
                <div class="text-center py-8 text-slate-500 dark:text-slate-400 text-sm">
                    Belum ada donasi terbaru. Jadilah yang pertama!
                </div>
                @endforelse
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
        b.classList.remove('border-orange-500', 'text-orange-500', 'text-orange-400', 'bg-orange-500/10'));
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
        b.classList.remove('border-orange-500', 'text-orange-500', 'text-orange-400', 'bg-orange-500/10'));
    btn.classList.add('border-orange-500', 'text-orange-500', 'dark:text-orange-400', 'bg-orange-500/10');
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

    const qrBox = document.getElementById('modal-qr-box');
    const labelEl = document.getElementById('modal-bank-label');
    
    if (radio.value === 'QRIS') {
        qrBox.classList.remove('hidden');
        labelEl.textContent = 'Scan QRIS di bawah ini:';
    } else {
        qrBox.classList.add('hidden');
        labelEl.textContent = 'Transfer ke:';
    }

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

// ── Toast notifications ───────────────────────────────────────
function showDonationToast(message) {
    // Remove existing toast if any
    const existingToast = document.getElementById('donation-toast');
    if (existingToast) existingToast.remove();
    
    const toastHtml = `
    <div id="donation-toast"
        class="dark-content fixed top-6 right-6 z-50 max-w-sm w-full p-5 rounded-2xl shadow-2xl border border-green-500/30 flex items-start gap-4 animate-fade-in"
        style="background: linear-gradient(135deg, #052e16, #14532d); box-shadow: 0 0 40px rgba(34,197,94,0.2);">
        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
            <i class="fas fa-check text-white"></i>
        </div>
        <div class="flex-1">
            <h4 class="text-green-300 font-black mb-1">Donasi Berhasil! 🎉</h4>
            <p class="text-green-400 text-sm leading-snug">${message}</p>
        </div>
        <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-300 mt-1 flex-shrink-0">
            <i class="fas fa-times text-sm"></i>
        </button>
    </div>
    `;
    document.body.insertAdjacentHTML('beforeend', toastHtml);
    setTimeout(() => {
        const t = document.getElementById('donation-toast');
        if (t) t.remove();
    }, 8000);
}

// ── Update Card donation total dynamically ───────────────────
function updateCardDonation(title, amount) {
    const card = document.querySelector(`.campaign-card[data-campaign-title="${title}"]`);
    if (!card) return;
    
    const collectedEl = card.querySelector('.card-collected');
    const pctEl = card.querySelector('.card-pct');
    const progressEl = card.querySelector('.card-progress');
    const targetEl = card.querySelector('.card-target');
    const donorsEl = card.querySelector('.card-donors');
    
    if (!collectedEl) return;
    
    // Parse target
    const target = parseFloat(targetEl.dataset.targetRaw || '0');
    
    // Current collected value from text
    let currentCollected = parseFloat(collectedEl.textContent.replace(/[^0-9]/g, ''));
    if (isNaN(currentCollected)) currentCollected = 0;
    
    const newCollected = currentCollected + amount;
    
    // Current donors count
    let currentDonors = parseInt(donorsEl.dataset.donorsRaw || '0');
    if (isNaN(currentDonors)) currentDonors = 0;
    const newDonors = currentDonors + 1;
    donorsEl.dataset.donorsRaw = newDonors;
    donorsEl.textContent = newDonors.toLocaleString('id-ID') + ' donatur';
    
    // Calculate new percentage
    const newPct = target > 0 ? Math.min(100, Math.round((newCollected / target) * 100)) : 0;
    
    // Animate collected amount counter
    let start = currentCollected;
    let duration = 1500;
    let startTime = performance.now();
    
    const updateCounter = (currentTime) => {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        const current = Math.round(start + (newCollected - start) * eased);
        collectedEl.textContent = 'Rp ' + current.toLocaleString('id-ID');
        
        if (progress < 1) {
            requestAnimationFrame(updateCounter);
        } else {
            collectedEl.textContent = 'Rp ' + newCollected.toLocaleString('id-ID');
        }
    };
    requestAnimationFrame(updateCounter);
    
    // Animate pct text and progress bar
    pctEl.textContent = newPct + '%';
    progressEl.style.width = newPct + '%';
    
    // Update grand total count on the page
    document.querySelectorAll('.grand-total-counter').forEach(el => {
        let startVal = parseInt(el.textContent.replace(/[^0-9]/g, ''));
        if (isNaN(startVal)) {
            startVal = parseInt(el.dataset.target) || 42000000000;
        }
        const endVal = startVal + amount;
        el.dataset.target = endVal;
        
        let gtStart = startVal;
        let gtStartTime = performance.now();
        const updateGt = (currentTime) => {
            const elapsed = currentTime - gtStartTime;
            const progress = Math.min(elapsed / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            const current = Math.round(gtStart + (endVal - gtStart) * eased);
            el.textContent = 'Rp ' + current.toLocaleString('id-ID');
            
            if (progress < 1) {
                requestAnimationFrame(updateGt);
            } else {
                el.textContent = 'Rp ' + endVal.toLocaleString('id-ID');
            }
        };
        requestAnimationFrame(updateGt);
    });
}

// ── Prepend new donation to the feed dynamically ──────────────
function prependRecentDonation(name, amount, campaign, timeAgo) {
    const feed = document.getElementById('recent-donations-feed');
    if (!feed) return;
    
    // Check if the placeholder block exists and remove it
    const placeholder = feed.querySelector('.text-center');
    if (placeholder && placeholder.textContent.includes('Belum ada donasi')) {
        placeholder.remove();
    }
    
    const isAnon = name.toLowerCase().includes('anonim') || name === '***anonim***';
    const avatar = isAnon ? '?' : name.substring(0, 1).toUpperCase();
    const formattedAmount = 'Rp ' + amount.toLocaleString('id-ID');
    
    const itemHtml = `
    <div class="flex items-center gap-4 glass rounded-xl p-4 border border-slate-200 dark:border-white/7 animate-fade-in" style="animation: fadeIn 0.5s ease-out;">
        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-500 to-red-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
            ${avatar}
        </div>
        <div class="flex-1">
            <div class="flex items-center gap-2">
                <span class="text-slate-800 dark:text-white font-semibold text-sm">${name}</span>
                <span class="text-slate-550 dark:text-slate-500 text-xs">berdonasi untuk</span>
                <span class="text-orange-655 dark:text-orange-400 text-xs font-bold">${campaign}</span>
            </div>
            <div class="text-slate-450 dark:text-slate-500 text-xs mt-0.5">${timeAgo}</div>
        </div>
        <div class="text-green-600 dark:text-green-400 font-black text-base">${formattedAmount}</div>
    </div>
    `;
    
    feed.insertAdjacentHTML('afterbegin', itemHtml);
    
    // Limit to 10 items
    if (feed.children.length > 10) {
        feed.lastElementChild.remove();
    }
}

// ── Interactive submit & bottom forms integration ───────────
document.addEventListener('DOMContentLoaded', () => {
    // Intercept Modal Submission
    const modalForm = document.querySelector('#donasi-modal form');
    if (modalForm) {
        modalForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            
            // Show spinner
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
            
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Terjadi kesalahan pada server.');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    closeDonasiModal();
                    showDonationToast(data.message);
                    updateCardDonation(data.campaign_title, data.amount);
                    prependRecentDonation(data.donor_name, data.amount, data.campaign_title, data.time_ago);
                } else {
                    alert(data.message || 'Gagal mengirim donasi.');
                }
            })
            .catch(error => {
                console.error(error);
                alert(error.message || 'Terjadi kesalahan jaringan.');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            });
        });
    }

    // Intercept Bottom Donasi Uang Form
    const bottomUangForm = document.getElementById('donasiUangForm');
    if (bottomUangForm) {
        // Nominal buttons click logic
        const nominalButtons = bottomUangForm.querySelectorAll('.nominal-btn');
        const nominalInput = document.getElementById('nominalInput');
        
        nominalButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                nominalButtons.forEach(b => {
                    b.classList.remove('active', 'border-orange-500', 'text-orange-500');
                    b.classList.add('border-slate-200', 'dark:border-white/10', 'text-slate-700', 'dark:text-slate-300');
                });
                this.classList.remove('border-slate-200', 'dark:border-white/10', 'text-slate-700', 'dark:text-slate-300');
                this.classList.add('active', 'border-orange-500', 'text-orange-500');
                
                const amount = this.dataset.amount;
                if (amount === 'Lainnya') {
                    nominalInput.value = '';
                    nominalInput.focus();
                } else {
                    nominalInput.value = amount;
                }
            });
        });

        bottomUangForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const campaignSelect = document.getElementById('d-campaign');
            const selectedNominalBtn = bottomUangForm.querySelector('.nominal-btn.active');
            const paymentRadio = bottomUangForm.querySelector('input[name="payment"]:checked');
            const namaInput = document.getElementById('d-nama');
            const pesanInput = document.getElementById('d-pesan');
            
            if (!campaignSelect || !campaignSelect.value) {
                alert('Silakan pilih campaign donasi terlebih dahulu.');
                return;
            }
            
            let amount = nominalInput.value;
            if (!amount && selectedNominalBtn) {
                amount = selectedNominalBtn.dataset.amount;
            }
            
            if (!amount || amount < 10000) {
                alert('Silakan masukkan jumlah donasi minimal Rp 10.000.');
                return;
            }
            
            if (!paymentRadio) {
                alert('Silakan pilih metode pembayaran.');
                return;
            }
            
            const campaignTitle = campaignSelect.value;
            
            // Check auth state
            @auth
                // Find matching campaign data for modal
                const card = document.querySelector(`.campaign-card[data-campaign-title="${campaignTitle}"]`);
                let id = '1';
                let emoji = '🆘';
                
                // Open modal and pre-fill values
                openDonasiModal(id, campaignTitle, emoji);
                
                // Pre-fill nominal
                document.getElementById('modal-amount').value = amount;
                
                // Map bottom payment types to modal methods
                let modalPaymentValue = 'BCA Virtual Account';
                if (paymentRadio.value === 'qris') modalPaymentValue = 'QRIS';
                else if (paymentRadio.value === 'bank') modalPaymentValue = 'BCA Virtual Account';
                else if (paymentRadio.value === 'ewallet') modalPaymentValue = 'QRIS';
                else if (paymentRadio.value === 'minimarket') modalPaymentValue = 'QRIS';
                
                const modalRadio = document.querySelector(`input[name="payment_method"][value="${modalPaymentValue}"]`);
                if (modalRadio) {
                    modalRadio.checked = true;
                    onPaymentChange(modalRadio);
                }
                
                // Pre-fill notes
                const modalNotes = document.querySelector('textarea[name="notes"]');
                if (modalNotes) {
                    let noteText = '';
                    if (namaInput.value) noteText += 'Dari: ' + namaInput.value + '. ';
                    if (pesanInput.value) noteText += pesanInput.value;
                    modalNotes.value = noteText;
                }
            @else
                window.location.href = "{{ route('login') }}";
            @endauth
        });
    }

    // Intercept Bottom Donasi Barang Form
    const bottomBarangForm = document.getElementById('donasiBarangForm');
    if (bottomBarangForm) {
        bottomBarangForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const nama = document.getElementById('db-nama').value;
            const phone = document.getElementById('db-phone').value;
            const jenis = document.getElementById('db-jenis').value;
            const jumlah = document.getElementById('db-jumlah').value;
            const campaign = document.getElementById('db-campaign').value;
            
            if (!nama || !phone || !jenis || !jumlah || !campaign) {
                alert('Silakan lengkapi semua field bertanda bintang (*).');
                return;
            }
            
            showDonationToast('Pendaftaran donasi barang berhasil diserahkan! Tim kami akan menghubungi Anda untuk detail penjemputan.');
            this.reset();
        });
    }
});
</script>
@endsection


