@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-wrap justify-between items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-white font-display">System Configuration</h2>
        <p class="text-xs text-gray-400 mt-1">Konfigurasi parameter umum, integrasi BMKG, dan status tanggap bencana CrisisHub.</p>
    </div>
    <button onclick="alert('Perubahan konfigurasi disimpan!')" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-400 text-black text-xs font-bold uppercase tracking-wider rounded-lg transition-all shadow-lg shadow-yellow-500/10">
        Save Configurations
    </button>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-10">
    <!-- Left Column: Form Settings (8 cols) -->
    <div class="lg:col-span-8 flex flex-col gap-6">
        <!-- Pengaturan Umum -->
        <div class="card-glass rounded-2xl p-6">
            <h3 class="font-display font-bold text-white text-sm uppercase tracking-wider mb-4 border-b border-white/5 pb-2 text-yellow-500">
                General Parameters
            </h3>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Nama Sistem Aplikasi</label>
                        <input type="text" value="CrisisHub Command Center" class="w-full px-3 py-2 text-sm bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-yellow-500">
                    </div>
                    <div>
                        <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Email Kontak Darurat Utama</label>
                        <input type="email" value="emergency@crisishub.com" class="w-full px-3 py-2 text-sm bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-yellow-500">
                    </div>
                </div>
                <div>
                    <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Deskripsi Singkat Sistem</label>
                    <textarea rows="3" class="w-full px-3 py-2 text-sm bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-yellow-500">Platform terpadu untuk koordinasi tanggap darurat, manajemen relawan, integrasi peta GIS bencana, dan penyaluran donasi kemanusiaan secara real-time.</textarea>
                </div>
            </div>
        </div>

        <!-- Mode Darurat Defcon 1 -->
        <div class="rounded-2xl p-6 border bg-red-500/5 border-red-500/20">
            <div class="flex items-start space-x-3">
                <div class="w-10 h-10 rounded-lg bg-red-500/20 border border-red-500/30 flex items-center justify-center text-red-500 shrink-0">
                    🚨
                </div>
                <div>
                    <h3 class="font-display font-bold text-red-400 text-sm uppercase tracking-wider mb-1">
                        Mode Siaga Bencana Nasional (DEFCON 1)
                    </h3>
                    <p class="text-[11px] text-gray-400 leading-normal mb-4">
                        Mengaktifkan DEFCON 1 akan membekukan seluruh fitur donasi non-prioritas di web publik, membunyikan sirine virtual real-time di aplikasi seluruh relawan aktif, dan memaksa prioritas evakuasi kritis di wilayah peta terdekat. Aksi ini sangat sensitif.
                    </p>
                    <button onclick="alert('DEFCON 1 diaktifkan! Sirine darurat dipancarkan.')" class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white text-xs font-bold uppercase tracking-wider rounded-lg transition-all shadow-lg shadow-red-600/10">
                        Aktifkan DEFCON 1 Now
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Integrasi (4 cols) -->
    <div class="lg:col-span-4 flex flex-col gap-6">
        <div class="card-glass rounded-2xl p-6">
            <h3 class="font-display font-bold text-white text-sm uppercase tracking-wider mb-4 border-b border-white/5 pb-2 text-gray-400">
                Third-Party Integrations
            </h3>

            <div class="space-y-4">
                <!-- BMKG -->
                <div class="flex items-center justify-between p-3.5 bg-white/[0.02] border border-white/5 rounded-xl">
                    <div class="flex items-center space-x-3">
                        <div class="text-xl">🌋</div>
                        <div>
                            <span class="text-xs font-bold text-white block">BMKG API Gateway</span>
                            <span class="text-[9px] text-gray-500">Auto Earthquakes Sync</span>
                        </div>
                    </div>
                    <span class="text-[9px] font-extrabold uppercase tracking-widest px-2 py-0.5 rounded border border-green-500/20 bg-green-500/10 text-green-400">
                        Connected
                    </span>
                </div>

                <!-- Payment Gateway -->
                <div class="flex items-center justify-between p-3.5 bg-white/[0.02] border border-white/5 rounded-xl">
                    <div class="flex items-center space-x-3">
                        <div class="text-xl">💳</div>
                        <div>
                            <span class="text-xs font-bold text-white block">Midtrans Sandbox</span>
                            <span class="text-[9px] text-gray-500">Donation Processing</span>
                        </div>
                    </div>
                    <span class="text-[9px] font-extrabold uppercase tracking-widest px-2 py-0.5 rounded border border-green-500/20 bg-green-500/10 text-green-400">
                        Connected
                    </span>
                </div>

                <!-- Leaflet -->
                <div class="flex items-center justify-between p-3.5 bg-white/[0.02] border border-white/5 rounded-xl">
                    <div class="flex items-center space-x-3">
                        <div class="text-xl">🗺️</div>
                        <div>
                            <span class="text-xs font-bold text-white block">OpenStreetMap GIS</span>
                            <span class="text-[9px] text-gray-500">Map Rendering Core</span>
                        </div>
                    </div>
                    <span class="text-[9px] font-extrabold uppercase tracking-widest px-2 py-0.5 rounded border border-green-500/20 bg-green-500/10 text-green-400">
                        Connected
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
