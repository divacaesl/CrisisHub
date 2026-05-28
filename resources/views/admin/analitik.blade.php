@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-end">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Analitik & Laporan</h2>
        <p class="text-sm text-gray-500 mt-1">Laporan metrik historis dari aktivitas krisis dan respons.</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100 text-[11px] uppercase tracking-wider text-gray-500">
                <th class="px-6 py-4 font-semibold">Periode</th>
                <th class="px-6 py-4 font-semibold">Metrik</th>
                <th class="px-6 py-4 font-semibold">Wilayah</th>
                <th class="px-6 py-4 font-semibold text-right">Nilai</th>
                <th class="px-6 py-4 font-semibold">Waktu Rekam</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($snapshots as $s)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded bg-blue-50 text-blue-600 text-[10px] font-bold uppercase tracking-wider">{{ $s->period }}</span>
                </td>
                <td class="px-6 py-4 font-bold text-gray-900 text-sm">
                    {{ str_replace('_', ' ', Str::title($s->metric_key)) }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">
                    {{ $s->wilayah ?? 'Nasional' }}
                </td>
                <td class="px-6 py-4 text-sm font-mono text-gray-800 text-right">
                    {{ number_format($s->metric_value, 2, ',', '.') }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($s->recorded_at)->format('d M, H:i') }}
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada snapshot analitik.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($snapshots->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        {{ $snapshots->links() }}
    </div>
    @endif
</div>
@endsection
