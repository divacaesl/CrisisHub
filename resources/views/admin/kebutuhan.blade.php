@extends('layouts.admin')

@section('content')
{{-- Flash Messages --}}
@if(session('success'))
<div id="flash-toast" class="fixed top-5 right-5 z-50 flex items-center space-x-3 px-5 py-3.5 rounded-xl shadow-2xl text-sm font-semibold text-white" style="background: rgba(34,197,94,0.15); border: 1px solid rgba(34,197,94,0.4); backdrop-filter: blur(10px);">
    <svg class="w-4 h-4 text-green-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    <span>{{ session('success') }}</span>
</div>
<script>setTimeout(() => document.getElementById('flash-toast')?.remove(), 4000)</script>
@endif

<div class="mb-6 flex flex-wrap items-center justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-white font-display">Aid Distribution & Needs</h2>
        <p class="text-xs text-gray-400 mt-1">Daftar lengkap kebutuhan logistik darurat, medis, dan pangan yang diposting oleh titik bencana krisis.</p>
    </div>
    {{-- Filter status --}}
    <form method="GET" class="flex gap-2">
        <select name="status" onchange="this.form.submit()" class="px-3 py-2 text-xs rounded-lg text-gray-300 focus:outline-none" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
            <option value="">Semua Status</option>
            <option value="Requested" {{ request('status') === 'Requested' ? 'selected' : '' }}>Requested</option>
            <option value="In Transit" {{ request('status') === 'In Transit' ? 'selected' : '' }}>In Transit</option>
            <option value="Received" {{ request('status') === 'Received' ? 'selected' : '' }}>Received</option>
        </select>
    </form>
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
                <th class="px-6 py-4 text-right">Aksi</th>
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
                            Critical
                        </span>
                    @else
                        <span class="text-[8px] font-extrabold uppercase tracking-widest px-2 py-0.5 rounded border border-orange-500/20 bg-orange-500/10 text-orange-400">
                            Medium
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 text-xs text-gray-400 max-w-[200px] truncate" title="{{ $n->report->alamat_lengkap ?? '-' }}">
                    {{ $n->report->alamat_lengkap ?? 'Lokasi tidak terdeteksi' }}
                </td>
                <td class="px-6 py-4">
                    @php $s = $n->status ?? 'Requested'; @endphp
                    <span class="text-[9px] font-extrabold uppercase tracking-widest px-2 py-0.5 rounded border
                        @if($s == 'Received' || $s == 'Dipenuhi') bg-green-500/10 border-green-500/20 text-green-400
                        @elseif($s == 'In Transit') bg-blue-500/10 border-blue-500/20 text-blue-400
                        @else bg-yellow-500/10 border-yellow-500/20 text-yellow-400 @endif">
                        {{ $s }}
                    </span>
                </td>
                <td class="px-6 py-4 text-right">
                    @if($s !== 'Received' && $s !== 'Dipenuhi')
                    <div class="flex items-center justify-end gap-1.5">
                        @if($s === 'Requested')
                        <form method="POST" action="{{ route('admin.kebutuhan.update-status', $n->id) }}" class="inline">
                            @csrf
                            <input type="hidden" name="status" value="In Transit">
                            <button type="submit" class="px-2.5 py-1 text-[9px] font-black uppercase rounded bg-blue-500/10 text-blue-400 border border-blue-500/20 hover:bg-blue-500/20 transition-all">
                                → In Transit
                            </button>
                        </form>
                        @endif
                        <form method="POST" action="{{ route('admin.kebutuhan.update-status', $n->id) }}" class="inline">
                            @csrf
                            <input type="hidden" name="status" value="Received">
                            <button type="submit" class="px-2.5 py-1 text-[9px] font-black uppercase rounded bg-green-500/10 text-green-400 border border-green-500/20 hover:bg-green-500/20 transition-all">
                                ✓ Received
                            </button>
                        </form>
                    </div>
                    @else
                    <span class="text-[10px] text-gray-600">—</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                    <svg class="w-10 h-10 mx-auto text-gray-700 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <span class="text-xs">Tidak ada data kebutuhan logistik yang diajukan saat ini.</span>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-4">{{ $needs->appends(request()->query())->links() }}</div>
@endsection
