@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-end">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Penugasan Relawan</h2>
        <p class="text-sm text-gray-500 mt-1">Status tugas dan penempatan tim relawan di lapangan.</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100 text-[11px] uppercase tracking-wider text-gray-500">
                <th class="px-6 py-4 font-semibold">Tugas / Lokasi</th>
                <th class="px-6 py-4 font-semibold">Relawan</th>
                <th class="px-6 py-4 font-semibold">Waktu Penugasan</th>
                <th class="px-6 py-4 font-semibold">Status</th>
                <th class="px-6 py-4 font-semibold text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($tasks as $t)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="font-bold text-gray-900 text-sm max-w-[250px] truncate">{{ $t->report->deskripsi_kondisi ?? 'Tugas Umum' }}</div>
                    <div class="text-xs text-gray-500 max-w-[250px] truncate">{{ $t->report->alamat_lengkap ?? '-' }}</div>
                </td>
                <td class="px-6 py-4 text-sm font-semibold text-gray-700">
                    {{ $t->volunteer->name ?? 'Unknown' }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($t->assigned_at)->format('d M, H:i') }}
                </td>
                <td class="px-6 py-4">
                    <span class="text-xs font-semibold px-2 py-1 rounded-full 
                        {{ $t->status == 'Selesai' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                        {{ $t->status }}
                    </span>
                </td>
                <td class="px-6 py-4 text-right">
                    <button class="text-blue-600 hover:text-blue-800 text-sm font-semibold">Detail</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Tidak ada penugasan aktif.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($tasks->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        {{ $tasks->links() }}
    </div>
    @endif
</div>
@endsection
