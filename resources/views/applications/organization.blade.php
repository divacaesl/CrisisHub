@extends('layouts.public')

@section('title', 'Daftar Mitra Organisasi')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 min-h-screen" style="padding-top: 7rem;">
    <!-- Page Header -->
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white font-display">Formulir Kemitraan Organisasi</h1>
            <p class="text-slate-500 text-sm mt-1">Daftarkan instansi/NGO Anda sebagai mitra resmi.</p>
        </div>
    </div>
    
    <div class="max-w-3xl mx-auto">
    <!-- Alerts -->
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
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-emerald-500/10 rounded-full blur-xl"></div>
            
            @if($existingApp->status == 'pending' || $existingApp->status == 'under_review')
                <!-- Status: PENDING / UNDER REVIEW -->
                <div class="text-center py-6">
                    <div class="relative inline-flex items-center justify-center mb-6">
                        <div class="w-20 h-20 rounded-full bg-emerald-500/10 text-emerald-500 flex items-center justify-center animate-pulse">
                            <i class="fas fa-building-user text-4xl"></i>
                        </div>
                        <span class="absolute top-0 right-0 flex h-4 w-4">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-4 w-4 bg-emerald-500"></span>
                        </span>
                    </div>
                    
                    <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white font-display">Pendaftaran Kemitraan Diproses</h2>
                    <p class="text-slate-500 mt-2 max-w-md mx-auto text-sm leading-relaxed">Pengajuan kemitraan instansi/organisasi Anda **({{ $existingApp->organization_name }})** telah masuk sistem verifikasi kami.</p>
                    
                    <!-- Progress Timeline Tracker -->
                    <div class="max-w-md mx-auto mt-10 p-5 rounded-2xl bg-slate-50 dark:bg-white/[0.02] border border-slate-200 dark:border-white/5 text-left space-y-6">
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[10px]"><i class="fas fa-check"></i></div>
                                <div class="w-0.5 h-12 bg-emerald-500"></div>
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-slate-950 dark:text-white uppercase tracking-wider">Kemitraan Diajukan</h4>
                                <p class="text-[11px] text-slate-400 mt-0.5">Dokumen registrasi diterima pada {{ $existingApp->created_at->format('d M Y') }}</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-6 h-6 rounded-full bg-yellow-500 text-white flex items-center justify-center text-[10px] animate-pulse"><i class="fas fa-sync-alt animate-spin"></i></div>
                                <div class="w-0.5 h-12 bg-slate-200 dark:bg-slate-700"></div>
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-slate-950 dark:text-white uppercase tracking-wider">Verifikasi Akta & Legalitas</h4>
                                <p class="text-[11px] text-slate-400 mt-0.5">Pemeriksaan nomor registrasi dan validitas penanggung jawab.</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-6 h-6 rounded-full bg-slate-200 dark:bg-slate-800 text-slate-400 flex items-center justify-center text-[10px]"><i class="fas fa-handshake"></i></div>
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-slate-400 uppercase tracking-wider">Penerbitan Akses Kemitraan</h4>
                                <p class="text-[11px] text-slate-400 mt-0.5">Penetapan sebagai mitra logistik/evakuasi resmi.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Application Details summary -->
                    <div class="max-w-md mx-auto mt-6 border-t border-slate-200 dark:border-white/10 pt-6 text-left">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-3">Rincian Pengajuan</h3>
                        <div class="grid grid-cols-2 gap-4 text-xs">
                            <div>
                                <span class="text-slate-400 block">Nama Instansi:</span>
                                <span class="font-bold text-slate-900 dark:text-slate-200">{{ $existingApp->organization_name }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block">Tipe Instansi:</span>
                                <span class="font-bold text-slate-900 dark:text-slate-200">{{ $existingApp->type }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block">Penanggung Jawab (PJ):</span>
                                <span class="font-bold text-slate-900 dark:text-slate-200">{{ $existingApp->contact_person }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block">Nomor Akta/Registrasi:</span>
                                <span class="font-bold text-slate-900 dark:text-slate-200">{{ $existingApp->registration_number ?? 'Tidak Melampirkan' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            @elseif($existingApp->status == 'approved')
                <!-- Status: APPROVED -->
                <div class="text-center py-8">
                    <div class="w-24 h-24 rounded-full bg-emerald-500/10 text-emerald-500 flex items-center justify-center mx-auto mb-6 shadow-lg shadow-emerald-500/20 relative">
                        <i class="fas fa-handshake-angle text-5xl"></i>
                        <span class="absolute bottom-0 right-0 w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center border-4 border-white dark:border-[#0a0f1e] text-xs">
                            <i class="fas fa-shield"></i>
                        </span>
                    </div>
                    
                    <h2 class="text-3xl font-black text-slate-900 dark:text-white font-display">Kemitraan Resmi Aktif!</h2>
                    <p class="text-slate-500 mt-2 max-w-md mx-auto text-sm leading-relaxed">Organisasi Anda **({{ $existingApp->organization_name }})** telah resmi disetujui sebagai mitra terpercaya CrisisHub. Akses **Organization Center** Anda telah diaktifkan.</p>
                    
                    <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('center.organization') }}" class="px-8 py-3.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold rounded-xl shadow-xl transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-building text-lg"></i> Masuk Organization Center
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
                        <i class="fas fa-ban text-4xl"></i>
                    </div>
                    
                    <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white font-display">Kemitraan Belum Disetujui</h2>
                    <p class="text-slate-500 mt-2 max-w-md mx-auto text-sm leading-relaxed">Mohon maaf, pengajuan kemitraan organisasi **{{ $existingApp->organization_name }}** belum dapat kami setujui saat ini.</p>
                    
                    <!-- Admin Rejection Notes -->
                    <div class="max-w-md mx-auto mt-6 p-4 rounded-xl bg-red-500/5 border border-red-500/20 text-left">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-red-400 block mb-1">Catatan Evaluasi Admin:</span>
                        <p class="text-xs text-red-700 dark:text-red-400 italic">"Nomor registrasi/akta tidak valid atau tidak sesuai dengan basis data NGO terdaftar. Harap verifikasi nomor legalitas organisasi Anda dengan benar."</p>
                    </div>

                    <!-- Resubmit trigger -->
                    <div class="mt-8">
                        <form action="{{ url('/apply/organization') }}" method="POST">
                            @csrf
                            <input type="hidden" name="organization_name" value="clear">
                            <button type="submit" name="resubmit_clear" value="true" class="px-8 py-3.5 bg-gradient-to-r from-red-600 to-orange-500 hover:from-red-700 hover:to-orange-600 text-white font-bold rounded-xl shadow-lg transition-transform hover:scale-[1.02] flex items-center gap-2 mx-auto">
                                <i class="fas fa-redo"></i> Ajukan Permohonan Kemitraan Ulang
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    @else
        <!-- VIEW 2: FRESH FORM TO APPLY -->
        <div class="glass-panel rounded-3xl p-8 shadow-2xl relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-emerald-500/10 rounded-full blur-xl"></div>
            
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400 rounded-2xl mb-4 shadow-lg shadow-emerald-500/10">
                    <i class="fas fa-handshake text-3xl"></i>
                </div>
                <h2 class="text-2xl font-black text-slate-900 dark:text-white font-display">Daftar Mitra Resmi</h2>
                <p class="text-slate-500 mt-2 text-sm max-w-sm mx-auto">Bergabunglah sebagai NGO/Mitra resmi CrisisHub untuk kordinasi distribusi bantuan berskala besar.</p>
            </div>

            <form action="{{ url('/apply/organization') }}" method="POST" class="space-y-6">
                @csrf
                
                <h4 class="text-xs font-black text-slate-950 dark:text-white uppercase tracking-widest border-b border-slate-200 dark:border-white/10 pb-2 mb-4 flex items-center gap-1.5">
                    <i class="fas fa-info-circle text-emerald-500"></i> Informasi Utama Organisasi
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wide">Nama Instansi / NGO</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                                <i class="fas fa-building"></i>
                            </span>
                            <input type="text" name="organization_name" required placeholder="Contoh: ACT, PMI Cabang Bandung" class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wide">Tipe Instansi</label>
                        <select name="type" required class="w-full px-4 py-2.5 bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                            <option value="NGO">LSM / NGO (Non-Government Organization)</option>
                            <option value="Corporate">Corporate / Sektor Swasta</option>
                            <option value="Government">Instansi Pemerintah / BUMN</option>
                            <option value="Community">Komunitas Masyarakat Lokal</option>
                        </select>
                    </div>
                </div>

                <h4 class="text-xs font-black text-slate-950 dark:text-white uppercase tracking-widest border-b border-slate-200 dark:border-white/10 pb-2 mb-4 pt-4 flex items-center gap-1.5">
                    <i class="fas fa-shield text-emerald-500"></i> Dokumen & Legalitas
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wide">Nomor Akta / Registrasi Resmi (Opsional)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                                <i class="fas fa-file-invoice"></i>
                            </span>
                            <input type="text" name="registration_number" placeholder="Contoh: AHU-0012345.AH.01.04" class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wide">Kontak / Penanggung Jawab (Nama & WhatsApp)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                                <i class="fas fa-user-tie"></i>
                            </span>
                            <input type="text" name="contact_person" required placeholder="Contoh: Ahmad Yani (081299991234)" class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                        </div>
                    </div>
                </div>

                <!-- Terms conditions -->
                <div class="p-4 rounded-xl bg-emerald-500/5 border border-emerald-500/10 flex items-start gap-3">
                    <input type="checkbox" required id="agree" class="mt-1 w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                    <label for="agree" class="text-xs text-slate-500 dark:text-slate-400 cursor-pointer">
                        Sebagai perwakilan organisasi, saya menyatakan bahwa data yang diberikan adalah benar dan sah secara hukum. Kami berkomitmen untuk berkolaborasi dan mendistribusikan bantuan kemanusiaan secara transparan melalui sistem kordinasi terpadu CrisisHub.
                    </label>
                </div>

                <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold rounded-xl shadow-lg transition-transform transform hover:scale-[1.01] uppercase tracking-wider text-xs">
                    Kirim Formulir Kemitraan
                </button>
            </form>
        </div>
    @endif
</div>
    </div>
</div>
@endsection
