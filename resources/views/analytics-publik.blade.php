@extends('layouts.public')

@section('title', 'Analitik Bencana — CrisisHub')
@section('meta_description', 'Data dan statistik bencana di Indonesia. Laporan terverifikasi, donasi terkumpul, dan kontribusi relawan CrisisHub.')

@section('content')
<div class="min-h-screen bg-[#0D0F0D] py-12 px-6">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-black text-white font-display mb-3">📊 Analitik Kemanusiaan</h1>
            <p class="text-gray-400 max-w-xl mx-auto">Transparansi data bencana, donasi, dan kontribusi relawan CrisisHub secara publik.</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="rounded-2xl p-6 text-center border border-white/10" style="background: rgba(255,255,255,0.03);">
                <div class="text-4xl font-black text-yellow-400 mb-1">{{ number_format($totalLaporan) }}</div>
                <div class="text-sm text-gray-400 uppercase tracking-wider font-bold">Total Laporan Bencana</div>
                <div class="text-xs text-gray-600 mt-1">Sejak platform aktif</div>
            </div>
            <div class="rounded-2xl p-6 text-center border border-white/10" style="background: rgba(255,255,255,0.03);">
                <div class="text-4xl font-black text-green-400 mb-1">Rp {{ number_format($totalDonasi / 1000000, 1) }}M</div>
                <div class="text-sm text-gray-400 uppercase tracking-wider font-bold">Dana Donasi Terkumpul</div>
                <div class="text-xs text-gray-600 mt-1">Donasi terverifikasi</div>
            </div>
            <div class="rounded-2xl p-6 text-center border border-white/10" style="background: rgba(255,255,255,0.03);">
                <div class="text-4xl font-black text-blue-400 mb-1">{{ number_format($totalRelawan) }}</div>
                <div class="text-sm text-gray-400 uppercase tracking-wider font-bold">Relawan Terdaftar</div>
                <div class="text-xs text-gray-600 mt-1">Aktif bertugas</div>
            </div>
        </div>

        <!-- Disaster Types -->
        @if($disasterTypes->count() > 0)
        <div class="rounded-2xl p-6 border border-white/10 mb-8" style="background: rgba(255,255,255,0.03);">
            <h2 class="text-lg font-bold text-white mb-5">Jenis Bencana Terlaporkan</h2>
            @php $maxTotal = $disasterTypes->max('total') ?: 1; @endphp
            <div class="space-y-4">
                @foreach($disasterTypes as $type)
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm text-gray-300 font-semibold">{{ $type->jenis_bencana }}</span>
                        <span class="text-xs text-yellow-400 font-bold">{{ $type->total }} kasus</span>
                    </div>
                    <div class="h-2 rounded-full bg-white/5">
                        <div class="h-2 rounded-full bg-gradient-to-r from-yellow-500 to-orange-500 transition-all duration-500"
                             style="width: {{ ($type->total / $maxTotal) * 100 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- CTA -->
        <div class="text-center">
            <p class="text-gray-500 text-sm mb-4">Ingin berkontribusi dalam penanggulangan bencana?</p>
            <div class="flex justify-center gap-4 flex-wrap">
                <a href="{{ route('donate') }}" class="px-6 py-3 bg-yellow-500 hover:bg-yellow-400 text-black font-bold rounded-xl text-sm transition-all">Donasi Sekarang</a>
                <a href="{{ route('volunteer') }}" class="px-6 py-3 border border-white/20 hover:border-white/40 text-white font-bold rounded-xl text-sm transition-all">Daftar Relawan</a>
            </div>
        </div>
    </div>
</div>
@endsection
