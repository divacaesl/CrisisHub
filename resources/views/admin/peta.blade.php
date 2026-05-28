@extends('layouts.admin')

@section('content')
<div class="mb-4 flex justify-between items-end">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Peta Sebaran Bencana</h2>
        <p class="text-sm text-gray-500 mt-1">Pantauan real-time koordinat laporan krisis.</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col" style="height: calc(100vh - 200px);">
    <div id="full-map" class="w-full h-full"></div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const map = L.map('full-map').setView([-6.914744, 107.609810], 9);
        
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            maxZoom: 19
        }).addTo(map);

        const reports = @json($reports);

        reports.forEach(r => {
            let color = r.tingkat_kerusakan === 'Hancur Total' ? '#EF4444' : 
                        (r.tingkat_kerusakan === 'Tinggi' ? '#F97316' : 
                        (r.tingkat_kerusakan === 'Sedang' ? '#FACC15' : '#22C55E'));
            
            const iconHtml = `
                <div class="relative flex items-center justify-center w-8 h-8">
                    <div class="absolute inset-0 rounded-full opacity-40 animate-ping" style="background-color: ${color}"></div>
                    <div class="relative z-10 w-6 h-6 rounded-full flex items-center justify-center text-white text-[10px] font-bold shadow-lg" style="background-color: ${color}">
                        !
                    </div>
                </div>
            `;
            
            const icon = L.divIcon({
                html: iconHtml,
                className: '',
                iconSize: [32, 32],
                iconAnchor: [16, 16]
            });

            L.marker([r.latitude, r.longitude], {icon: icon})
             .bindPopup(`<b>${r.jenis_bencana}</b><br>${r.alamat_lengkap}<br><span class="text-xs text-gray-500">${r.deskripsi_kondisi}</span>`)
             .addTo(map);
        });
    });
</script>
@endpush
@endsection
