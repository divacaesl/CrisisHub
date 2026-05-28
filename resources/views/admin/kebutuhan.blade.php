@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-end">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Kebutuhan Mendesak</h2>
        <p class="text-sm text-gray-500 mt-1">Daftar permintaan barang dan logistik dari titik krisis.</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100 text-[11px] uppercase tracking-wider text-gray-500">
                <th class="px-6 py-4 font-semibold">Barang / Kategori</th>
                <th class="px-6 py-4 font-semibold">Kuantitas</th>
                <th class="px-6 py-4 font-semibold">Urgensi</th>
                <th class="px-6 py-4 font-semibold">Lokasi Laporan</th>
                <th class="px-6 py-4 font-semibold">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($needs as $n)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="font-bold text-gray-900 text-sm">{{ $n->item_name }}</div>
                    <div class="text-xs text-gray-500">{{ $n->category }}</div>
                </td>
                <td class="px-6 py-4 font-bold text-gray-700">{{ $n->quantity }}</td>
                <td class="px-6 py-4">
                    @if($n->urgency_level == 1)
                        <span class="text-xs font-bold text-red-600 bg-red-100 px-2 py-1 rounded">Sangat Mendesak</span>
                    @else
                        <span class="text-xs font-bold text-orange-600 bg-orange-100 px-2 py-1 rounded">Mendesak</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-gray-600 max-w-[200px] truncate">
                    {{ $n->report->alamat_lengkap ?? 'Unknown' }}
                </td>
                <td class="px-6 py-4">
                    <span class="text-xs font-semibold px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full">{{ $n->status }}</span>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Tidak ada data kebutuhan.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($needs->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        {{ $needs->links() }}
    </div>
    @endif
</div>
@endsection
