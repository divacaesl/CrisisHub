@extends('layouts.public')

@section('title', 'Peta Bencana — CrisisHub')
@section('meta_description', 'Peta real-time bencana aktif di seluruh Indonesia. Data laporan terverifikasi dari CrisisHub.')

@section('head')
<style>
    /* Override peta agar tidak kena clip navbar */
    #public-map-wrap {
        margin-top: 72px; /* tinggi navbar */
        height: calc(100vh - 72px);
        position: relative;
    }

    /* Panel overlay info */
    #map-overlay-panel {
        position: absolute;
        top: 16px;
        left: 16px;
        z-index: 1000;
        background: rgba(15, 23, 42, 0.92);
        backdrop-filter: blur(14px);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px;
        padding: 16px 20px;
        min-width: 220px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.5);
    }

    /* Leaflet popup override */
    .leaflet-popup-content-wrapper {
        background: #1e293b !important;
        color: #e2e8f0 !important;
        border: 1px solid rgba(239,68,68,0.3) !important;
        border-radius: 12px !important;
        box-shadow: 0 20px 40px rgba(0,0,0,0.5) !important;
    }
    .leaflet-popup-tip { background: #1e293b !important; }
    .leaflet-popup-content { margin: 12px 16px !important; }

    /* Custom map container */
    #public-map {
        width: 100%;
        height: 100%;
        background: #0f172a;
    }

    /* Legend */
    #map-legend {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1000;
        background: rgba(15, 23, 42, 0.9);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 50px;
        padding: 8px 20px;
        display: flex;
        gap: 16px;
        align-items: center;
    }
    .legend-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 4px;
    }
</style>
@endsection

@section('content')
<div id="public-map-wrap">
    {{-- Map --}}
    <div id="public-map"></div>

    {{-- Overlay Info Panel --}}
    <div id="map-overlay-panel">
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:10px;">
            <div style="width:8px;height:8px;border-radius:50%;background:#ef4444;box-shadow:0 0 8px #ef4444;animation: ping 2s infinite;"></div>
            <span style="font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:0.08em;color:#f1f5f9;">Live Disaster Map</span>
        </div>
        <div style="font-size:22px;font-weight:900;color:white;line-height:1.1;" id="total-count">{{ $reports->count() }}</div>
        <div style="font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:12px;">Laporan Terverifikasi</div>

        @php
            $hancurTotal = $reports->where('tingkat_kerusakan','Hancur Total')->count();
            $tinggi = $reports->where('tingkat_kerusakan','Tinggi')->count();
            $sedang = $reports->where('tingkat_kerusakan','Sedang')->count();
            $rendah = $reports->where('tingkat_kerusakan','Rendah')->count();
        @endphp

        <div style="space-y:6px;display:flex;flex-direction:column;gap:6px;">
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <div style="display:flex;align-items:center;gap:6px;">
                    <span style="width:8px;height:8px;border-radius:50%;background:#ef4444;display:inline-block;box-shadow:0 0 6px #ef4444;"></span>
                    <span style="font-size:10px;color:#94a3b8;">Hancur Total</span>
                </div>
                <span style="font-size:11px;font-weight:700;color:#ef4444;">{{ $hancurTotal }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <div style="display:flex;align-items:center;gap:6px;">
                    <span style="width:8px;height:8px;border-radius:50%;background:#f97316;display:inline-block;box-shadow:0 0 6px #f97316;"></span>
                    <span style="font-size:10px;color:#94a3b8;">Tinggi</span>
                </div>
                <span style="font-size:11px;font-weight:700;color:#f97316;">{{ $tinggi }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <div style="display:flex;align-items:center;gap:6px;">
                    <span style="width:8px;height:8px;border-radius:50%;background:#facc15;display:inline-block;box-shadow:0 0 6px #facc15;"></span>
                    <span style="font-size:10px;color:#94a3b8;">Sedang</span>
                </div>
                <span style="font-size:11px;font-weight:700;color:#facc15;">{{ $sedang }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <div style="display:flex;align-items:center;gap:6px;">
                    <span style="width:8px;height:8px;border-radius:50%;background:#22c55e;display:inline-block;box-shadow:0 0 6px #22c55e;"></span>
                    <span style="font-size:10px;color:#94a3b8;">Rendah</span>
                </div>
                <span style="font-size:11px;font-weight:700;color:#22c55e;">{{ $rendah }}</span>
            </div>
        </div>

        <div style="margin-top:12px;padding-top:10px;border-top:1px solid rgba(255,255,255,0.06);">
            <a href="{{ route('home') }}" style="font-size:10px;color:#94a3b8;text-decoration:none;display:flex;align-items:center;gap:4px;">
                ← Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
(function() {
    // Leaflet sudah di-load oleh layout public.blade.php
    const mapEl = document.getElementById('public-map');
    if (!mapEl || typeof L === 'undefined') {
        console.error('Map container or Leaflet not found');
        return;
    }

    const map = L.map('public-map', {
        zoomControl: false,
        attributionControl: false
    }).setView([-2.5, 118.0], 5);

    L.control.zoom({ position: 'bottomright' }).addTo(map);

    // Dark tile layer
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        maxZoom: 19,
        subdomains: 'abcd'
    }).addTo(map);

    // Reports data from server
    const reports = @json($reports);

    if (reports.length === 0) {
        // Show empty state overlay
        const emptyDiv = document.createElement('div');
        emptyDiv.innerHTML = `
            <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);z-index:999;text-align:center;color:rgba(255,255,255,0.4);pointer-events:none;">
                <div style="font-size:48px;margin-bottom:12px;">🗺️</div>
                <div style="font-size:14px;font-weight:600;">Belum ada laporan bencana terverifikasi</div>
                <div style="font-size:11px;margin-top:4px;color:rgba(255,255,255,0.25);">Data akan muncul setelah admin memverifikasi laporan</div>
            </div>`;
        document.getElementById('public-map-wrap').appendChild(emptyDiv);
    }

    reports.forEach(function(r) {
        if (!r.latitude || !r.longitude) return;

        var color = r.tingkat_kerusakan === 'Hancur Total' ? '#EF4444' :
                    (r.tingkat_kerusakan === 'Tinggi' ? '#F97316' :
                    (r.tingkat_kerusakan === 'Sedang' ? '#FACC15' : '#22C55E'));

        var pulseSize = r.tingkat_kerusakan === 'Hancur Total' ? 20 :
                        (r.tingkat_kerusakan === 'Tinggi' ? 16 : 13);

        var iconHtml = `
            <div style="position:relative;width:${pulseSize + 12}px;height:${pulseSize + 12}px;display:flex;align-items:center;justify-content:center;">
                <div style="position:absolute;inset:0;border-radius:50%;background:${color};opacity:0.25;animation:mapPing 2s infinite;"></div>
                <div style="position:relative;width:${pulseSize}px;height:${pulseSize}px;border-radius:50%;background:${color};display:flex;align-items:center;justify-content:center;box-shadow:0 0 12px ${color};border:2px solid rgba(255,255,255,0.3);">
                    <span style="font-size:${pulseSize > 15 ? 9 : 7}px;">⚠</span>
                </div>
            </div>`;

        var icon = L.divIcon({
            html: iconHtml,
            className: '',
            iconSize: [pulseSize + 12, pulseSize + 12],
            iconAnchor: [(pulseSize + 12) / 2, (pulseSize + 12) / 2]
        });

        var deskripsi = r.deskripsi_kondisi ? r.deskripsi_kondisi.substring(0, 100) + '...' : 'Tidak ada deskripsi.';
        var alamat = r.alamat_lengkap || 'Lokasi tidak tersedia';

        var popupHtml = `
            <div style="font-family:'Outfit',sans-serif;min-width:200px;">
                <div style="display:flex;align-items:center;gap:6px;margin-bottom:8px;">
                    <span style="font-size:8px;font-weight:800;text-transform:uppercase;letter-spacing:0.08em;padding:2px 8px;border-radius:4px;background:${color}22;color:${color};border:1px solid ${color}44;">${r.jenis_bencana}</span>
                    <span style="font-size:8px;color:#64748b;">#${r.id}</span>
                </div>
                <h4 style="font-size:12px;font-weight:700;color:#f1f5f9;margin-bottom:4px;line-height:1.4;">${alamat}</h4>
                <p style="font-size:10px;color:#94a3b8;margin-bottom:8px;line-height:1.5;">${deskripsi}</p>
                <div style="display:flex;justify-content:space-between;padding-top:8px;border-top:1px solid rgba(255,255,255,0.06);">
                    <div>
                        <div style="font-size:8px;color:#64748b;text-transform:uppercase;font-weight:600;">Korban</div>
                        <div style="font-size:13px;font-weight:900;color:white;">${r.jumlah_korban}</div>
                    </div>
                    <div>
                        <div style="font-size:8px;color:#64748b;text-transform:uppercase;font-weight:600;">Kerusakan</div>
                        <div style="font-size:11px;font-weight:700;color:${color};">${r.tingkat_kerusakan}</div>
                    </div>
                </div>
            </div>`;

        L.marker([parseFloat(r.latitude), parseFloat(r.longitude)], { icon: icon })
            .bindPopup(popupHtml, { maxWidth: 260, closeButton: true })
            .addTo(map);
    });

    // Add CSS animation for pulsing markers
    var style = document.createElement('style');
    style.textContent = `
        @keyframes mapPing {
            0%, 100% { transform: scale(1); opacity: 0.25; }
            50% { transform: scale(2); opacity: 0; }
        }
    `;
    document.head.appendChild(style);

    // Fix map size after DOM fully loaded
    setTimeout(function() { map.invalidateSize(); }, 300);
})();
</script>
@endsection
