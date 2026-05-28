@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-end">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Data Laporan Bencana</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola dan verifikasi laporan krisis yang masuk dari pengguna.</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-[11px] uppercase tracking-wider text-gray-500">
                    <th class="px-6 py-4 font-semibold">Tipe & Tingkat</th>
                    <th class="px-6 py-4 font-semibold">Lokasi</th>
                    <th class="px-6 py-4 font-semibold">Pelapor</th>
                    <th class="px-6 py-4 font-semibold">Waktu</th>
                    <th class="px-6 py-4 font-semibold">Status</th>
                    <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($reports as $r)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">{{ $r->jenis_bencana }}</div>
                        <div class="text-xs {{ $r->tingkat_kerusakan == 'Hancur Total' ? 'text-red-500' : 'text-orange-500' }} font-semibold">{{ $r->tingkat_kerusakan }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 truncate max-w-[200px]" title="{{ $r->alamat_lengkap }}">
                        {{ $r->alamat_lengkap }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        {{ $r->user->name ?? 'Anonim' }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $r->created_at->format('d M, H:i') }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold 
                            {{ $r->status == 'Verified' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $r->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <button class="text-blue-600 hover:text-blue-800 text-sm font-semibold">Detail</button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">Tidak ada laporan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($reports->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        {{ $reports->links() }}
    </div>
    @endif
</div>
@endsection
