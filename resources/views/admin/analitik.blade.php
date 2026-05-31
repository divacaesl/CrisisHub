@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-white font-display">Command Center Analytics</h2>
        <p class="text-xs text-gray-400 mt-1">Laporan analitik, performa mitigasi respons, dan tren filantropi CrisisHub.</p>
    </div>
</div>

<!-- Charts Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Chart 1: Tren Laporan Bencana Bulanan -->
    <div class="card-glass rounded-2xl p-5 flex flex-col justify-between h-80">
        <div class="mb-3">
            <span class="text-[10px] text-gray-500 font-bold uppercase tracking-wider block">Insiden & Laporan Bencana</span>
            <h4 class="text-sm font-bold text-white font-display">Tren Bencana (6 Bulan Terakhir)</h4>
        </div>
        <div class="flex-1 relative w-full h-full">
            <canvas id="reportsTrendChart" class="w-full h-full"></canvas>
        </div>
    </div>

    <!-- Chart 2: Tren Filantropi Donasi Masuk -->
    <div class="card-glass rounded-2xl p-5 flex flex-col justify-between h-80">
        <div class="mb-3">
            <span class="text-[10px] text-gray-500 font-bold uppercase tracking-wider block">Aktivitas Donasi Finansial</span>
            <h4 class="text-sm font-bold text-white font-display">Tren Dana Terverifikasi (6 Bulan Terakhir)</h4>
        </div>
        <div class="flex-1 relative w-full h-full">
            <canvas id="donationsTrendChart" class="w-full h-full"></canvas>
        </div>
    </div>
</div>

<!-- Details Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <!-- Breakdown Tipe Bencana -->
    <div class="card-glass rounded-2xl p-5 flex flex-col h-80">
        <h4 class="text-sm font-bold text-white font-display mb-4 border-b border-white/5 pb-2">Kategori Bencana Terbanyak</h4>
        <div class="flex-1 overflow-y-auto space-y-3.5 sidebar-scroll pr-1">
            @forelse($disasterTypes as $type)
            <div class="flex justify-between items-center">
                <span class="text-xs text-gray-300 font-medium">{{ $type->jenis_bencana }}</span>
                <span class="text-[10px] font-bold text-yellow-500 px-2 py-0.5 rounded bg-yellow-500/10 border border-yellow-500/20">
                    {{ $type->total }} Kasus
                </span>
            </div>
            @empty
            <div class="text-center text-xs text-gray-500 py-12">Belum ada statistik kategori bencana.</div>
            @endforelse
        </div>
    </div>

    <!-- Top Donors -->
    <div class="card-glass rounded-2xl p-5 flex flex-col h-80">
        <h4 class="text-sm font-bold text-white font-display mb-4 border-b border-white/5 pb-2">Donatur Terdermawan</h4>
        <div class="flex-1 overflow-y-auto space-y-3 sidebar-scroll pr-1">
            @forelse($topDonors as $donor)
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($donor->user->name ?? 'Anonim') }}&background=E8C547&color=000&bold=true" class="w-6.5 h-6.5 rounded-full border border-white/10">
                    <span class="text-xs text-gray-300 font-medium truncate w-24 md:w-32">{{ $donor->user->name ?? 'Anonim' }}</span>
                </div>
                <span class="text-xs font-black text-green-400">Rp {{ number_format($donor->total, 0, ',', '.') }}</span>
            </div>
            @empty
            <div class="text-center text-xs text-gray-500 py-12">Belum ada data donasi terverifikasi.</div>
            @endforelse
        </div>
    </div>

    <!-- Status Breakdown -->
    <div class="card-glass rounded-2xl p-5 flex flex-col h-80">
        <h4 class="text-sm font-bold text-white font-display mb-4 border-b border-white/5 pb-2">Status Akurasi Laporan</h4>
        <div class="flex-1 overflow-y-auto space-y-3.5 sidebar-scroll pr-1">
            @forelse($statusBreakdown as $sb)
            @php
                $statusName = $sb->status ?? 'Pending';
                $color = $statusName == 'Approved' ? 'text-green-400 border-green-500/20 bg-green-500/10' : 
                         ($statusName == 'Rejected' ? 'text-red-400 border-red-500/20 bg-red-500/10' : 
                         'text-yellow-400 border-yellow-500/20 bg-yellow-500/10');
            @endphp
            <div class="flex justify-between items-center">
                <span class="text-xs text-gray-300 font-medium">{{ $statusName }}</span>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded border {{ $color }}">
                    {{ $sb->total }} Laporan
                </span>
            </div>
            @empty
            <div class="text-center text-xs text-gray-500 py-12">Belum ada status sebaran laporan.</div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const labels = @json($labels);
        
        // Reports Trend Chart
        const reportsData = @json($monthlyReports);
        const ctxReports = document.getElementById('reportsTrendChart').getContext('2d');
        
        let gradReports = ctxReports.createLinearGradient(0, 0, 0, 200);
        gradReports.addColorStop(0, 'rgba(232, 197, 71, 0.25)');
        gradReports.addColorStop(1, 'rgba(232, 197, 71, 0)');

        new Chart(ctxReports, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Laporan',
                    data: reportsData,
                    borderColor: '#E8C547',
                    backgroundColor: gradReports,
                    borderWidth: 2,
                    pointBackgroundColor: '#E8C547',
                    pointBorderColor: '#000',
                    pointBorderWidth: 1.5,
                    pointRadius: 3.5,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#9CA3AF', font: { size: 9 } },
                        border: { display: false },
                        grid: { color: 'rgba(255,255,255,0.05)', drawBorder: false }
                    },
                    x: {
                        ticks: { color: '#9CA3AF', font: { size: 9 } },
                        border: { display: false },
                        grid: { display: false }
                    }
                }
            }
        });

        // Donations Trend Chart
        const donationsData = @json($monthlyDonations);
        const ctxDonations = document.getElementById('donationsTrendChart').getContext('2d');

        new Chart(ctxDonations, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Dana Donasi (Rp)',
                    data: donationsData,
                    backgroundColor: '#10B981',
                    borderRadius: 4,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { 
                            color: '#9CA3AF', 
                            font: { size: 9 },
                            callback: function(value) {
                                if (value >= 1e6) return 'Rp ' + (value / 1e6) + 'M';
                                return 'Rp ' + value;
                            }
                        },
                        border: { display: false },
                        grid: { color: 'rgba(255,255,255,0.05)', drawBorder: false }
                    },
                    x: {
                        ticks: { color: '#9CA3AF', font: { size: 9 } },
                        border: { display: false },
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection
