@extends('layouts.admin')

@section('content')
<div class="mb-4 flex flex-wrap justify-between items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-white font-display">GIS Monitoring & Tracking</h2>
        <p class="text-xs text-gray-400 mt-1">Pemetaan koordinat real-time seluruh laporan krisis bencana terverifikasi CrisisHub.</p>
    </div>
    
    <!-- Map Legend -->
    <div class="card-glass border border-white/5 rounded-xl px-4 py-2 text-[9px] uppercase tracking-wider font-extrabold flex items-center space-x-4">
        <div class="flex items-center"><span class="w-2.5 h-2.5 rounded-full bg-red-500 mr-1.5 shadow-[0_0_8px_rgba(239,68,68,0.8)]"></span>Hancur Total</div>
        <div class="flex items-center"><span class="w-2.5 h-2.5 rounded-full bg-orange-500 mr-1.5 shadow-[0_0_8px_rgba(249,115,22,0.8)]"></span>Tinggi</div>
        <div class="flex items-center"><span class="w-2.5 h-2.5 rounded-full bg-yellow-400 mr-1.5 shadow-[0_0_8px_rgba(250,204,21,0.8)]"></span>Sedang</div>
        <div class="flex items-center"><span class="w-2.5 h-2.5 rounded-full bg-green-500 mr-1.5 shadow-[0_0_8px_rgba(34,197,94,0.8)]"></span>Rendah</div>
    </div>
</div>

<!-- Map Container -->
<div class="card-glass rounded-2xl overflow-hidden flex flex-col border border-white/10" style="height: calc(100vh - 200px);">
    <div id="full-map" class="w-full h-full" style="background: #0f1110;"></div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const map = L.map('full-map', {
            zoomControl: false,
            attributionControl: false
        }).setView([-6.914744, 107.609810], 9);
        
        L.control.zoom({ position: 'topleft' }).addTo(map);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            maxZoom: 19
        }).addTo(map);

        const reports = @json($reports);

        reports.forEach(r => {
            if (!r.latitude || !r.longitude) return;

            let color = r.tingkat_kerusakan === 'Hancur Total' ? '#EF4444' : 
                        (r.tingkat_kerusakan === 'Tinggi' ? '#F97316' : 
                        (r.tingkat_kerusakan === 'Sedang' ? '#FACC15' : '#22C55E'));
            
            const iconHtml = `
                <div class="relative flex items-center justify-center w-8 h-8">
                    <div class="absolute inset-0 rounded-full opacity-40 animate-ping" style="background-color: ${color}"></div>
                    <div class="relative z-10 w-6 h-6 rounded-full flex items-center justify-center text-white text-[10px] font-bold shadow-lg" style="background-color: ${color}">
                        ⚠
                    </div>
                </div>
            `;
            
            const icon = L.divIcon({
                html: iconHtml,
                className: '',
                iconSize: [32, 32],
                iconAnchor: [16, 16]
            });

            const popupContent = `
                <div class="p-2 text-gray-200" style="font-family: 'Inter', sans-serif;">
                    <div class="flex items-center gap-1.5 mb-1">
                        <span class="text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded bg-white/5 border border-white/10 text-yellow-500">${r.jenis_bencana}</span>
                        <span class="text-[8px] font-bold text-gray-500">ID: #${r.id}</span>
                    </div>
                    <h4 class="font-extrabold text-white text-xs mb-1">${r.alamat_lengkap}</h4>
                    <p class="text-[10px] text-gray-400 mb-2 leading-snug">${r.deskripsi_kondisi}</p>
                    <div class="flex justify-between items-center text-[8px] text-gray-500 pt-1.5 border-t border-white/5">
                        <span>Korban: <strong>${r.jumlah_korban}</strong></span>
                        <span>Kerusakan: <strong style="color:${color}">${r.tingkat_kerusakan}</strong></span>
                    </div>
                </div>
            `;

            L.marker([r.latitude, r.longitude], {icon: icon})
             .bindPopup(popupContent, {maxWidth: 240})
             .addTo(map);
        });
    });
</script>
@endpush
@endsection
