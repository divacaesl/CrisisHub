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
        <h2 class="text-2xl font-bold text-white font-display">Volunteer Task Logs</h2>
        <p class="text-xs text-gray-400 mt-1">Kelola dan pantau status distribusi tugas tim relawan CrisisHub di lapangan.</p>
    </div>
    {{-- Filter status --}}
    <form method="GET" class="flex gap-2">
        <select name="status" onchange="this.form.submit()" class="px-3 py-2 text-xs rounded-lg text-gray-300 focus:outline-none" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
            <option value="">Semua Status</option>
            <option value="Assigned" {{ request('status') === 'Assigned' ? 'selected' : '' }}>Assigned</option>
            <option value="In Progress" {{ request('status') === 'In Progress' ? 'selected' : '' }}>In Progress</option>
            <option value="Completed" {{ request('status') === 'Completed' ? 'selected' : '' }}>Completed</option>
            <option value="Rejected" {{ request('status') === 'Rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
    </form>
</div>

<!-- Task Table -->
<div class="card-glass rounded-2xl overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead>
            <tr class="bg-white/[0.02] border-b border-white/5 text-[10px] uppercase tracking-wider text-gray-500 font-semibold">
                <th class="px-6 py-4">Relawan</th>
                <th class="px-6 py-4">Tugas & Bencana</th>
                <th class="px-6 py-4">Lokasi Bencana</th>
                <th class="px-6 py-4">Waktu Penugasan</th>
                <th class="px-6 py-4">Status Tugas</th>
                <th class="px-6 py-4 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5 text-gray-300">
            @forelse($tasks as $t)
            <tr class="hover:bg-white/[0.01] transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-7 h-7 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-[10px] text-yellow-400 font-black">
                            {{ substr($t->volunteer->name ?? 'R', 0, 1) }}
                        </div>
                        <div>
                            <span class="font-bold text-white text-xs block">{{ $t->volunteer->name ?? 'Unknown Relawan' }}</span>
                            <span class="text-[9px] text-gray-500">{{ $t->volunteer->email ?? '-' }}</span>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="font-bold text-white text-xs leading-normal">{{ $t->task ?? 'Tugas Umum Penyelamatan' }}</div>
                    <div class="text-[10px] text-gray-500 mt-0.5">Target: {{ $t->report->jenis_bencana ?? 'Umum' }}</div>
                </td>
                <td class="px-6 py-4 text-xs text-gray-400 max-w-[200px] truncate" title="{{ $t->report->alamat_lengkap ?? '-' }}">
                    {{ $t->report->alamat_lengkap ?? 'Lokasi Umum' }}
                </td>
                <td class="px-6 py-4 text-xs text-gray-500">
                    {{ $t->created_at ? $t->created_at->format('d M Y, H:i') : '-' }}
                </td>
                <td class="px-6 py-4">
                    @php $status = $t->status ?? 'Assigned'; @endphp
                    <span class="text-[9px] font-extrabold uppercase tracking-widest px-2.5 py-1 rounded border
                        @if($status === 'Completed') bg-green-500/10 border-green-500/20 text-green-400
                        @elseif($status === 'In Progress') bg-blue-500/10 border-blue-500/20 text-blue-400
                        @elseif($status === 'Rejected') bg-red-500/10 border-red-500/20 text-red-400
                        @else bg-yellow-500/10 border-yellow-500/20 text-yellow-400 @endif">
                        {{ $status }}
                    </span>
                </td>
                <td class="px-6 py-4 text-right">
                    @if($status !== 'Completed' && $status !== 'Rejected')
                    <div class="flex items-center justify-end gap-1.5">
                        @if($status === 'Assigned')
                        <form method="POST" action="{{ route('admin.penugasan.update-status', $t->id) }}" class="inline">
                            @csrf
                            <input type="hidden" name="status" value="In Progress">
                            <button type="submit" class="px-2.5 py-1 text-[9px] font-black uppercase rounded bg-blue-500/10 text-blue-400 border border-blue-500/20 hover:bg-blue-500/20 transition-all">
                                → Mulai
                            </button>
                        </form>
                        @endif
                        <form method="POST" action="{{ route('admin.penugasan.update-status', $t->id) }}" class="inline">
                            @csrf
                            <input type="hidden" name="status" value="Completed">
                            <button type="submit" class="px-2.5 py-1 text-[9px] font-black uppercase rounded bg-green-500/10 text-green-400 border border-green-500/20 hover:bg-green-500/20 transition-all">
                                ✓ Selesai
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
                    <svg class="w-10 h-10 mx-auto text-gray-700 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    <span class="text-xs">Belum ada riwayat penugasan relawan lapangan.</span>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-4">{{ $tasks->appends(request()->query())->links() }}</div>
@endsection
