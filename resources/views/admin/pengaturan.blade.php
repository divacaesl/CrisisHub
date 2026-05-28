@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-end">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Pengaturan Sistem</h2>
        <p class="text-sm text-gray-500 mt-1">Konfigurasi umum aplikasi dan preferensi notifikasi.</p>
    </div>
    <button class="bg-[#0B5A42] hover:bg-[#094D38] text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition-colors">
        Simpan Perubahan
    </button>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-2 space-y-6">
        <!-- Pengaturan Umum -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Pengaturan Umum</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Aplikasi</label>
                    <input type="text" value="CrisisHub" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-[#0B5A42] focus:border-[#0B5A42] text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email Kontak Darurat</label>
                    <input type="email" value="emergency@crisishub.com" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-[#0B5A42] focus:border-[#0B5A42] text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Singkat</label>
                    <textarea class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-[#0B5A42] focus:border-[#0B5A42] text-sm" rows="3">Platform manajemen krisis dan penyaluran bantuan terpadu.</textarea>
                </div>
            </div>
        </div>

        <!-- Mode Darurat -->
        <div class="bg-red-50 rounded-2xl border border-red-100 shadow-sm p-6">
            <h3 class="text-lg font-bold text-red-700 mb-2">Mode Siaga Bencana (Defcon 1)</h3>
            <p class="text-sm text-red-600 mb-4">Mengaktifkan mode ini akan menyalakan sirine pada aplikasi relawan dan membekukan fitur donasi non-prioritas.</p>
            <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition-colors">
                Aktifkan Mode Darurat
            </button>
        </div>
    </div>

    <!-- Integrasi & API -->
    <div class="space-y-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Integrasi Pihak Ketiga</h3>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 border border-gray-100 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/e/e1/Logo_of_YouTube_%282015-2017%29.svg" class="h-5 grayscale opacity-50">
                        <span class="text-sm font-semibold text-gray-700">BMKG API</span>
                    </div>
                    <span class="text-[10px] font-bold text-green-600 bg-green-50 px-2 py-1 rounded">Connected</span>
                </div>
                
                <div class="flex items-center justify-between p-3 border border-gray-100 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"></path></svg>
                        <span class="text-sm font-semibold text-gray-700">Payment Gateway</span>
                    </div>
                    <span class="text-[10px] font-bold text-green-600 bg-green-50 px-2 py-1 rounded">Connected</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
