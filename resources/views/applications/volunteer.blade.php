@extends('layouts.dashboard')

@section('title', 'Daftar Relawan')
@section('role', 'Pendaftaran')
@section('page_title', 'Formulir Relawan Kemanusiaan')

@section('content')
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
        <!-- VIEW 2: FRESH FORM TO APPLY -->
        <div class="glass-panel rounded-3xl p-8 shadow-2xl relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-blue-500/10 rounded-full blur-xl"></div>
            
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 rounded-2xl mb-4 shadow-lg shadow-blue-500/10">
                    <i class="fas fa-user-plus text-3xl"></i>
                </div>
                <h2 class="text-2xl font-black text-slate-900 dark:text-white font-display">Bergabung Sebagai Relawan</h2>
                <p class="text-slate-500 mt-2 text-sm max-w-md mx-auto">Bantu sesama di garis depan mitigasi bencana. Lengkapi profil kompetensi Anda untuk mempermudah pendelegasian tugas.</p>
            </div>

            <form action="{{ url('/apply/volunteer') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wide">Nomor Telepon (WhatsApp Aktif)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                                <i class="fab fa-whatsapp text-lg"></i>
                            </span>
                            <input type="text" name="phone_number" required placeholder="Contoh: 081234567890" class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wide">Kota / Kabupaten Domisili</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                                <i class="fas fa-map-marker-alt"></i>
                            </span>
                            <input type="text" name="city" required placeholder="Contoh: Bandung Barat, Sleman" class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wide">Keahlian Khusus (Pisahkan dengan koma)</label>
                    <input type="text" name="skills" placeholder="Contoh: Tenaga Medis, Dapur Umum, Evakuasi SAR, Trauma Healing, Logistik" class="w-full px-4 py-2.5 bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wide">Pengalaman Relawan Sebelumnya</label>
                    <textarea name="experience" rows="3" placeholder="Ceritakan secara singkat pengalaman kerelawanan Anda (misal: Pernah bertugas di bencana Gempa Cianjur 2022 bagian dapur umum)..." class="w-full px-4 py-2.5 bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"></textarea>
                </div>

                <!-- Terms conditions -->
                <div class="p-4 rounded-xl bg-blue-500/5 border border-blue-500/10 flex items-start gap-3">
                    <input type="checkbox" required id="agree" class="mt-1 w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                    <label for="agree" class="text-xs text-slate-500 dark:text-slate-400 cursor-pointer">
                        Saya bersedia bertindak secara sukarela, patuh terhadap kode etik relawan krisis, serta bersedia dihubungi oleh tim kordinasi lapangan jika sewaktu-waktu dibutuhkan.
                    </label>
                </div>

                <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg transition-transform transform hover:scale-[1.01] uppercase tracking-wider text-xs">
                    Kirim Formulir Relawan
                </button>
            </form>
        </div>
    @endif
</div>
@endsection
