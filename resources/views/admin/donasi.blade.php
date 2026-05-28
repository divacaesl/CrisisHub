@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-end">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Riwayat Donasi</h2>
        <p class="text-sm text-gray-500 mt-1">Lacak penerimaan dana dan barang dari para donatur.</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100 text-[11px] uppercase tracking-wider text-gray-500">
                <th class="px-6 py-4 font-semibold">Donatur</th>
                <th class="px-6 py-4 font-semibold">Tipe / Nominal</th>
                <th class="px-6 py-4 font-semibold">Tracking Code</th>
                <th class="px-6 py-4 font-semibold">Waktu</th>
                <th class="px-6 py-4 font-semibold">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($donations as $d)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($d->user->name ?? 'Anonim') }}&background=f3f4f6" class="w-8 h-8 rounded-full">
                        <span class="font-bold text-gray-900 text-sm">{{ $d->user->name ?? 'Hamba Allah (Anonim)' }}</span>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-xs text-gray-500">{{ $d->type }}</div>
                    @if($d->type == 'Uang')
                        <div class="font-bold text-green-600">Rp {{ number_format($d->amount, 0, ',', '.') }}</div>
                    @else
                        <div class="font-bold text-gray-700">{{ $d->items }}</div>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm font-mono text-gray-600">{{ $d->tracking_code }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $d->created_at->format('d M, H:i') }}</td>
                <td class="px-6 py-4">
                    <span class="text-xs font-semibold px-2 py-1 {{ $d->status == 'Verified' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }} rounded-full">{{ $d->status }}</span>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Tidak ada riwayat donasi.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($donations->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        {{ $donations->links() }}
    </div>
    @endif
</div>
@endsection
