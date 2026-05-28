@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-end">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Riwayat Verifikasi Laporan</h2>
        <p class="text-sm text-gray-500 mt-1">Daftar persetujuan dan penolakan laporan krisis yang telah dikurasi.</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] overflow-hidden">
    <table class="w-full text-left border-collapse min-w-[600px]">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100 text-[11px] uppercase tracking-wider text-gray-500">
                <th class="px-6 py-4 font-semibold">Tindakan Oleh</th>
                <th class="px-6 py-4 font-semibold">Laporan</th>
                <th class="px-6 py-4 font-semibold">Keputusan</th>
                <th class="px-6 py-4 font-semibold">Catatan (Note)</th>
                <th class="px-6 py-4 font-semibold">Waktu</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($verifications as $v)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4">
                    <div class="font-bold text-gray-900 text-sm">{{ $v->admin->name ?? 'System' }}</div>
                    <div class="text-[10px] text-gray-500">{{ $v->admin->email ?? '-' }}</div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600 truncate max-w-[200px]" title="{{ $v->report->deskripsi_kondisi ?? '-' }}">
                    {{ $v->report->jenis_bencana ?? 'Laporan Dihapus' }} <br>
                    <span class="text-[10px]">{{ Str::limit($v->report->deskripsi_kondisi ?? '-', 30) }}</span>
                </td>
                <td class="px-6 py-4">
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold 
                        {{ $v->action == 'Approved' ? 'bg-green-100 text-green-700' : ($v->action == 'Rejected' ? 'bg-red-100 text-red-700' : 'bg-orange-100 text-orange-700') }}">
                        {{ $v->action }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600 max-w-[200px] truncate">
                    {{ $v->note ?? '-' }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($v->verified_at)->format('d M, H:i') }}
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Tidak ada riwayat verifikasi.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($verifications->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        {{ $verifications->links() }}
    </div>
    @endif
</div>
@endsection
