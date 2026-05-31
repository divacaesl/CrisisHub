@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-white font-display">Aid Distribution & Needs</h2>
    <p class="text-xs text-gray-400 mt-1">Daftar lengkap kebutuhan logistik darurat, medis, dan pangan yang diposting oleh titik bencana krisis.</p>
</div>

<!-- Table -->
<div class="card-glass rounded-2xl overflow-hidden mb-6">
    <table class="w-full text-sm text-left">
        <thead>
            <tr class="bg-white/[0.02] border-b border-white/5 text-[10px] uppercase tracking-wider text-gray-500 font-semibold">
                <th class="px-6 py-4">Nama Barang & Kategori</th>
                <th class="px-6 py-4">Kuantitas</th>
                <th class="px-6 py-4">Tingkat Urgensi</th>
                <th class="px-6 py-4">Lokasi Bencana</th>
                <th class="px-6 py-4">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5 text-gray-300">
            @forelse($needs as $n)
            <tr class="hover:bg-white/[0.01] transition-colors">
                <td class="px-6 py-4">
                    <span class="font-bold text-white text-xs block leading-tight">{{ $n->item_name }}</span>
                    <span class="text-[9px] text-gray-500">{{ $n->category }}</span>
                </td>
                <td class="px-6 py-4 font-black text-white text-xs">
                    {{ number_format($n->quantity) }} <span class="text-gray-500 font-normal">Unit</span>
                </td>
                <td class="px-6 py-4">
                    @if(($n->urgency_level ?? 1) == 1 || $n->urgency_level == 'Critical' || $n->urgency_level == 'Kritis')
                        <span class="text-[8px] font-extrabold uppercase tracking-widest px-2 py-0.5 rounded border border-red-500/20 bg-red-500/10 text-red-400">
                            Critical Urgensi
                        </span>
                    @else
                        <span class="text-[8px] font-extrabold uppercase tracking-widest px-2 py-0.5 rounded border border-orange-500/20 bg-orange-500/10 text-orange-400">
                            Medium Urgensi
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 text-xs text-gray-400 max-w-[200px] truncate" title="{{ $n->report->alamat_lengkap ?? '-' }}">
                    {{ $n->report->alamat_lengkap ?? 'Lokasi tidak terdeteksi' }}
                </td>
                <td class="px-6 py-4">
                    @php $s = $n->status ?? 'Requested'; @endphp
                    <span class="text-[9px] font-extrabold uppercase tracking-widest px-2 py-0.5 rounded border 
                        {{ $s == 'Received' || $s == 'Dipenuhi' ? 'bg-green-500/10 border-green-500/20 text-green-400' : 'bg-yellow-500/10 border-yellow-500/20 text-yellow-400' }}">
                        {{ $s }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                    <svg class="w-10 h-10 mx-auto text-gray-700 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <span class="text-xs">Tidak ada data kebutuhan logistik yang diajukan saat ini.</span>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-4">{{ $needs->links() }}</div>
@endsection
