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
                <div class="glass bg-white/80 dark:bg-transparent rounded-2xl p-6 border border-slate-200 dark:border-orange-500/20 shadow-xl dark:shadow-none">
                    <h3 class="text-slate-900 dark:text-white font-bold mb-4">Bantu Korban Sekarang</h3>
                    <div class="space-y-3">
                        @auth
                        <button onclick="openDonasiModalDetail()" class="block w-full text-center py-3.5 bg-gradient-to-r from-orange-600 to-red-600 text-white font-bold rounded-xl transition-all hover:opacity-90 hover:scale-[1.02] shadow-md">
                            <i class="fas fa-hand-holding-usd mr-2"></i>Donasi Uang
                        </button>
                        <button onclick="openLogistikModal()" class="block w-full text-center py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl transition-all hover:opacity-90 hover:scale-[1.02] shadow-md">
                            <i class="fas fa-box-open mr-2"></i>Donasi Logistik
                        </button>
                        <button onclick="openVolunteerModal()" class="block w-full text-center py-3.5 bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 text-slate-800 dark:text-white font-medium rounded-xl transition-all hover:bg-slate-200 dark:hover:bg-white/10 hover:scale-[1.02]">
                            <i class="fas fa-hard-hat mr-2"></i>Jadi Relawan
                        </button>
                        @else
                        <a href="{{ route('login') }}" class="block w-full text-center py-3.5 bg-gradient-to-r from-orange-600 to-red-600 text-white font-bold rounded-xl transition-all hover:opacity-90 shadow-md">
                            <i class="fas fa-hand-holding-usd mr-2"></i>Donasi Uang
                        </a>
                        <a href="{{ route('login') }}" class="block w-full text-center py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl transition-all hover:opacity-90 shadow-md">
                            <i class="fas fa-box-open mr-2"></i>Donasi Logistik
                        </a>
                        <a href="{{ route('login') }}" class="block w-full text-center py-3.5 bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 text-slate-800 dark:text-white font-medium rounded-xl transition-all hover:bg-slate-200 dark:hover:bg-white/10">
                            <i class="fas fa-hard-hat mr-2"></i>Jadi Relawan
                        </a>
                        @endauth
                    </div>
                </div>

                <div class="glass bg-white/80 dark:bg-transparent rounded-2xl p-6 border border-slate-200 dark:border-white/7 shadow-xl dark:shadow-none">
                    <h3 class="text-slate-900 dark:text-white font-bold mb-4">Informasi Posko</h3>
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

{{-- ==================== DONATION MODAL ==================== --}}
@auth
<div id="donasi-modal-detail" class="fixed inset-0 z-[99999] hidden overflow-y-auto p-4 md:p-6 justify-center items-start" onclick="if(event.target===this) closeDonasiModalDetail()">
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm pointer-events-none"></div>
    <div class="relative w-full max-w-lg my-8 mx-auto bg-white dark:bg-slate-900 rounded-3xl shadow-2xl z-10 border border-orange-500/20">

        {{-- Header --}}
        <div class="px-6 pt-6 pb-4 border-b border-slate-200 dark:border-white/10 flex items-center justify-between">
            <div>
                <p class="text-orange-500 dark:text-orange-400 text-xs font-bold uppercase tracking-widest mb-1">Donasi untuk</p>
                <h3 class="text-slate-900 dark:text-white font-black text-xl leading-tight">🌊 Darurat Banjir Jakarta Utara</h3>
            </div>
            <button onclick="closeDonasiModalDetail()" class="w-9 h-9 rounded-full bg-slate-100 dark:bg-white/10 hover:bg-red-100 dark:hover:bg-red-500/20 flex items-center justify-center text-slate-500 hover:text-red-500 transition-all ml-4">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Form --}}
        <form action="{{ route('donate.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            <input type="hidden" name="campaign_title" value="Darurat Banjir Jakarta Utara">

            {{-- Nominal --}}
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-3">① Pilih Nominal</p>
                <div class="grid grid-cols-3 gap-2 mb-3">
                    @foreach([50000, 100000, 250000, 500000, 1000000, 2500000] as $nom)
                    <button type="button" onclick="selectNominalDetail({{ $nom }}, this)"
                        class="detail-nominal-preset py-2.5 text-xs font-bold rounded-xl border border-slate-200 dark:border-white/10 text-slate-600 dark:text-slate-400 hover:border-orange-500 hover:text-orange-500 hover:bg-orange-500/5 transition-all">
                        Rp {{ number_format($nom, 0, ',', '.') }}
                    </button>
                    @endforeach
                </div>
                <input type="number" name="amount" id="detail-amount"
                    class="w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/10 rounded-xl py-3 px-4 text-slate-900 dark:text-white font-bold text-sm placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all"
                    placeholder="Nominal lain (min. Rp 10.000)" min="10000" required>
            </div>

            {{-- Metode Pembayaran --}}
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-3">② Metode Pembayaran</p>
                <div class="grid grid-cols-2 gap-2">
                    @foreach([['val'=>'BCA','num'=>'008-888-1234','name'=>'CrisisHub Foundation','label'=>'BCA'],['val'=>'Mandiri','num'=>'170-000-8888','name'=>'CrisisHub Foundation','label'=>'Mandiri'],['val'=>'BRI','num'=>'0096-01-004321-50-6','name'=>'CrisisHub Foundation','label'=>'BRI'],['val'=>'QRIS','num'=>'QRIS-CRISISHUB-2024','name'=>'CrisisHub QRIS','label'=>'QRIS']] as $pm)
                    <label class="detail-pm-label flex items-center gap-2 border border-slate-200 dark:border-white/10 rounded-xl p-3 cursor-pointer hover:border-orange-500 hover:bg-orange-500/5 transition-all"
                           data-number="{{ $pm['num'] }}" data-name="{{ $pm['name'] }}">
                        <input type="radio" name="payment_method" value="{{ $pm['val'] }}" class="hidden" required onchange="onDetailPaymentChange(this)">
                        <span class="text-xs font-bold text-slate-700 dark:text-slate-300">{{ $pm['label'] }}</span>
                    </label>
                    @endforeach
                </div>
                <div id="detail-bank-box" class="hidden mt-4 bg-slate-50 dark:bg-slate-800/50 rounded-2xl p-4 border border-slate-200 dark:border-white/10">
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-1" id="detail-bank-label">Transfer ke:</p>
                    <div class="text-lg font-black text-slate-900 dark:text-white" id="detail-bank-num"></div>
                    <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">a.n. <span id="detail-bank-name"></span></div>
                </div>
            </div>

            {{-- Catatan --}}
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-3">③ Catatan (Opsional)</p>
                <textarea name="notes" rows="2" class="w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/10 rounded-xl py-3 px-4 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all" placeholder="Pesan atau doa untuk korban..."></textarea>
            </div>

            {{-- Upload Bukti --}}
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-3">④ Upload Bukti Transfer</p>
                <label class="block border-2 border-dashed border-slate-200 dark:border-white/10 rounded-2xl p-4 text-center cursor-pointer hover:border-orange-500 hover:bg-orange-500/5 transition-all">
                    <i class="fas fa-cloud-upload-alt text-2xl text-slate-400 mb-2 block"></i>
                    <span class="text-xs text-slate-400">Pilih file gambar (JPG/PNG, maks 4MB)</span>
                    <input type="file" name="proof_image" accept="image/*" class="hidden">
                </label>
            </div>

            <button type="submit" class="w-full py-4 bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-500 hover:to-red-500 text-white font-black rounded-xl transition-all hover:scale-[1.02] shadow-lg shadow-orange-500/30">
                <i class="fas fa-heart mr-2"></i>Kirim Donasi
            </button>
        </form>
    </div>
</div>

{{-- ==================== LOGISTIK MODAL ==================== --}}
@auth
<div id="logistik-modal" class="fixed inset-0 flex items-center justify-center bg-slate-900/80 backdrop-blur-sm hidden p-4" style="z-index: 99998;" onclick="if(event.target===this) closeLogistikModal()">
    <div class="bg-white dark:bg-slate-900 rounded-3xl w-full max-w-lg shadow-2xl relative flex flex-col max-h-[90vh]">
        <!-- Modal Header -->
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center bg-white dark:bg-slate-900 rounded-t-3xl shrink-0">
            <div>
                <p class="text-blue-500 dark:text-blue-400 text-xs font-bold uppercase tracking-widest mb-1">Kirim Bantuan Logistik</p>
                <h2 class="text-2xl font-black text-slate-900 dark:text-white">📦 Donasi Barang</h2>
            </div>
            <button onclick="closeLogistikModal()" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:bg-red-100 hover:text-red-500 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Modal Body (Form) -->
        <div class="p-6 md:p-8 overflow-y-auto flex-1">
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4 mb-6">
                <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-2"><i class="fas fa-info-circle text-blue-500 mr-2"></i>Panduan Logistik</h4>
                <p class="text-xs text-slate-600 dark:text-slate-400 mb-2">Silakan kirimkan barang donasi Anda menggunakan jasa ekspedisi/kurir ke alamat posko berikut:</p>
                <div class="text-xs font-bold text-slate-900 dark:text-white bg-white dark:bg-slate-800 p-2 rounded border border-slate-200 dark:border-slate-700">
                    📍 {{ $disaster['posko'] }} <br>
                    📞 {{ $disaster['phone'] }}
                </div>
            </div>

            <form action="{{ route('donate.logistik') }}" method="POST" id="form-logistik" class="space-y-4">
                @csrf
                <input type="hidden" name="campaign_title" value="{{ $disaster['title'] }}">

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Jenis Barang & Estimasi Jumlah/Berat <span class="text-red-500">*</span></label>
                    <textarea name="items" rows="3" required class="w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all" placeholder="Contoh: 1 Dus Mie Instan, 5 Kg Beras, 10 Pakaian Layak Pakai"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Nomor Resi Pengiriman (JNE/JNT/SiCepat/Gojek/dll) <span class="text-red-500">*</span></label>
                    <input type="text" name="resi_pengiriman" required class="w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-slate-900 dark:text-white text-sm font-bold placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all" placeholder="Contoh: JNAC-123456789">
                    <p class="text-[10px] text-slate-500 mt-1">Kami memerlukan nomor resi agar admin dapat mencocokkan barang yang sampai di posko.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Catatan (Opsional)</label>
                    <input type="text" name="notes" class="w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all" placeholder="Contoh: Paket atas nama Budi">
                </div>

                <button type="submit" class="w-full mt-4 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-black rounded-xl transition-all hover:scale-[1.02] shadow-lg shadow-blue-500/30 flex items-center justify-center gap-2">
                    <i class="fas fa-paper-plane"></i> Daftarkan Resi & Kirim
                </button>
            </form>
        </div>
    </div>
</div>
@endauth

{{-- ==================== VOLUNTEER MODAL ==================== --}}
<div id="volunteer-modal-detail" class="fixed inset-0 flex items-center justify-center bg-slate-900/80 backdrop-blur-sm hidden p-4" style="z-index: 99998;">
    <div class="bg-white dark:bg-slate-900 rounded-3xl w-full max-w-3xl shadow-2xl relative flex flex-col max-h-[90vh]">
        <!-- Modal Header -->
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center bg-white dark:bg-slate-900 rounded-t-3xl shrink-0">
            <div>
                <h2 class="text-2xl font-black text-slate-900 dark:text-white">🤝 Formulir Pendaftaran Relawan</h2>
                <p class="text-sm text-slate-500">Bergabung dengan tim relawan CrisisHub untuk bencana banjir ini.</p>
            </div>
            <button onclick="closeVolunteerModal()" class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:bg-red-100 hover:text-red-500 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6 md:p-8 overflow-y-auto flex-1">
            <form id="volunteerFormDetail" action="{{ url('/apply/volunteer') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <input type="hidden" name="preferred_team" value="Tim Evakuasi Banjir">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Nama Lengkap *</label>
                        <input type="text" name="full_name" value="{{ auth()->user()->name ?? '' }}" required class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Email *</label>
                        <input type="email" value="{{ auth()->user()->email ?? '' }}" disabled class="w-full px-4 py-2.5 bg-slate-100 dark:bg-slate-800 border-none rounded-xl text-sm text-slate-500 cursor-not-allowed">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Nomor HP/WhatsApp *</label>
                        <input type="text" name="phone_number" required placeholder="+62 812 xxxx xxxx" class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Kota Domisili *</label>
                        <input type="text" name="city" required placeholder="Contoh: Jakarta Utara" class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Kategori Relawan *</label>
                        <select name="category" required class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="Profesional">Profesional (Dokter, Insinyur, dll)</option>
                            <option value="Mahasiswa">Mahasiswa</option>
                            <option value="Masyarakat Umum">Masyarakat Umum</option>
                            <option value="Pensiunan">Pensiunan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Ketersediaan Waktu *</label>
                        <select name="availability" required class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                            <option value="" disabled selected>Pilih Waktu</option>
                            <option value="Full Time">Siap Panggilan (Full Time)</option>
                            <option value="Weekend">Akhir Pekan Saja</option>
                            <option value="Weekday">Hari Kerja</option>
                            <option value="Remote">Hanya Remote</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">Area Penugasan *</label>
                    <select name="assignment_area" required class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                        <option value="" disabled selected>Pilih Area</option>
                        <option value="Dalam Kota">Hanya Dalam Kota Domisili</option>
                        <option value="Dalam Provinsi">Dalam Satu Provinsi</option>
                        <option value="Seluruh Indonesia">Siap ke Seluruh Indonesia</option>
                    </select>
                </div>

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

                <div class="flex items-start gap-3">
                    <input type="checkbox" required id="agree_detail" class="mt-1 w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                    <label for="agree_detail" class="text-xs text-slate-500 dark:text-slate-400 cursor-pointer">
                        Saya menyetujui <a href="#" class="text-emerald-500 font-bold hover:underline">Syarat & Ketentuan</a> dan bersedia mengikuti pelatihan serta misi yang ditugaskan oleh CrisisHub.
                    </label>
                </div>

                <button type="submit" id="submitVolunteerDetail" class="w-full py-4 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-500 hover:to-green-500 text-white font-bold rounded-xl shadow-lg transition-transform transform hover:scale-[1.01] flex items-center justify-center gap-2">
                    <i class="fas fa-paper-plane"></i> Kirim Pendaftaran Relawan
                </button>
            </form>
        </div>
    </div>
</div>
@endauth

{{-- Success/Error Modals --}}
@if(session('success'))
<div id="success-modal-detail" class="fixed inset-0 flex items-center justify-center bg-slate-900/80 backdrop-blur-sm p-4" style="z-index: 999999;">
    <div class="bg-white dark:bg-slate-900 rounded-3xl w-full max-w-md shadow-2xl flex flex-col items-center text-center p-8">
        <div class="w-24 h-24 rounded-full bg-green-500/10 text-green-500 flex justify-center items-center mb-6">
            <i class="fas fa-check-circle text-6xl"></i>
        </div>
        <h2 class="text-3xl font-black text-slate-900 dark:text-white mb-2">Berhasil!</h2>
        <p class="text-slate-500 dark:text-slate-400 mb-8">{{ session('success') }}</p>
        <button onclick="document.getElementById('success-modal-detail').style.display='none'" class="w-full py-3.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold rounded-xl">Tutup</button>
    </div>
</div>
@endif
@if(session('donation_success'))
<div id="success-modal-donation" class="fixed inset-0 flex items-center justify-center bg-slate-900/80 backdrop-blur-sm p-4" style="z-index: 999999;">
    <div class="bg-white dark:bg-slate-900 rounded-3xl w-full max-w-md shadow-2xl flex flex-col items-center text-center p-8">
        <div class="w-24 h-24 rounded-full bg-orange-500/10 text-orange-500 flex justify-center items-center mb-6">
            <i class="fas fa-heart text-6xl"></i>
        </div>
        <h2 class="text-3xl font-black text-slate-900 dark:text-white mb-2">Terima Kasih! 🎉</h2>
        <p class="text-slate-500 dark:text-slate-400 mb-8">{{ session('donation_success') }}</p>
        <button onclick="document.getElementById('success-modal-donation').style.display='none'" class="w-full py-3.5 bg-gradient-to-r from-orange-500 to-red-600 text-white font-bold rounded-xl">Tutup</button>
    </div>
</div>
@endif

@endsection

@section('scripts')
<script>
function openDonasiModalDetail() {
    const m = document.getElementById('donasi-modal-detail');
    m.classList.remove('hidden');
    m.classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function closeDonasiModalDetail() {
    const m = document.getElementById('donasi-modal-detail');
    m.classList.add('hidden');
    m.classList.remove('flex');
    document.body.style.overflow = '';
}
function openVolunteerModal() {
    if (Notification.permission !== 'granted' && Notification.permission !== 'denied') {
        Notification.requestPermission();
    }
    document.getElementById('volunteer-modal-detail').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeVolunteerModal() {
    document.getElementById('volunteer-modal-detail').classList.add('hidden');
    document.body.style.overflow = '';
}
function openLogistikModal() {
    document.getElementById('logistik-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeLogistikModal() {
    document.getElementById('logistik-modal').classList.add('hidden');
    document.body.style.overflow = '';
}
function selectNominalDetail(amount, btn) {
    document.getElementById('detail-amount').value = amount;
    document.querySelectorAll('.detail-nominal-preset').forEach(b =>
        b.classList.remove('border-orange-500','text-orange-500','bg-orange-500/10'));
    btn.classList.add('border-orange-500','text-orange-500','bg-orange-500/10');
}
function onDetailPaymentChange(radio) {
    const lbl = radio.closest('label');
    document.querySelectorAll('.detail-pm-label').forEach(l =>
        l.classList.remove('border-orange-500','bg-orange-500/10'));
    lbl.classList.add('border-orange-500','bg-orange-500/10');
    document.getElementById('detail-bank-num').textContent = lbl.dataset.number;
    document.getElementById('detail-bank-name').textContent = lbl.dataset.name;
    document.getElementById('detail-bank-box').classList.remove('hidden');
}
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { closeDonasiModalDetail(); closeVolunteerModal(); }
});

// AJAX Volunteer submit with validation + desktop notification
document.getElementById('volunteerFormDetail')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    document.querySelectorAll('.error-text-detail').forEach(el => el.remove());
    document.querySelectorAll('[data-detail-input]').forEach(el => el.classList.remove('border-red-500'));

    const btn = document.getElementById('submitVolunteerDetail');
    const orig = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';
    btn.disabled = true;

    try {
        const res = await fetch(this.action, {
            method: 'POST', body: new FormData(this),
            headers: { 'Accept': 'application/json' }
        });
        const data = await res.json();

        if (!res.ok) {
            if (res.status === 422) {
                for (const [field, messages] of Object.entries(data.errors || {})) {
                    const inp = this.querySelector(`[name="${field}"]`);
                    if (inp) {
                        inp.classList.add('border-red-500');
                        const err = document.createElement('p');
                        err.className = 'text-red-500 text-xs mt-1 error-text-detail font-bold';
                        err.innerHTML = `<i class="fas fa-exclamation-triangle"></i> ${messages[0]}`;
                        inp.parentNode.appendChild(err);
                    }
                }
            } else {
                alert(data.message || 'Terjadi kesalahan.');
                if (Notification.permission === 'granted') {
                    new Notification('Gagal Mendaftar', { body: data.message, icon: '/favicon.ico' });
                }
            }
        } else {
            closeVolunteerModal();
            const sm = document.getElementById('success-modal-detail');
            if (sm) { sm.querySelector('p').innerText = data.message; sm.style.display = 'flex'; }
            if (Notification.permission === 'granted') {
                new Notification('Pendaftaran Berhasil! ✅', { body: data.message, icon: '/favicon.ico' });
            } else if (Notification.permission !== 'denied') {
                Notification.requestPermission().then(p => {
                    if (p === 'granted') new Notification('Pendaftaran Berhasil! ✅', { body: data.message, icon: '/favicon.ico' });
                });
            }
            this.reset();
        }
    } catch {
        alert('Gagal menghubungi server. Coba lagi.');
    } finally {
        btn.innerHTML = orig;
        btn.disabled = false;
    }
});
</script>
@endsection
