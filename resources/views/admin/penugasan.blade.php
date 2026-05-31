@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-white font-display">Volunteer Task Logs</h2>
    <p class="text-xs text-gray-400 mt-1">Daftar lengkap distribusi dan log tugas tim relawan CrisisHub di lapangan.</p>
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
                    <span class="text-[9px] font-extrabold uppercase tracking-widest px-2.5 py-1 rounded border 
                        {{ $t->status == 'Completed' || $t->status == 'Selesai' ? 'bg-green-500/10 border-green-500/20 text-green-400' : 'bg-yellow-500/10 border-yellow-500/20 text-yellow-400' }}">
                        {{ $t->status ?? 'Assigned' }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                    <svg class="w-10 h-10 mx-auto text-gray-700 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    <span class="text-xs">Belum ada riwayat penugasan relawan lapangan.</span>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-4">{{ $tasks->links() }}</div>
@endsection
