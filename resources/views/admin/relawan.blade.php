@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-end">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Manajemen Relawan</h2>
        <p class="text-sm text-gray-500 mt-1">Daftar relawan terdaftar dan status keaktifan mereka.</p>
    </div>
    <button class="bg-[#0B5A42] hover:bg-[#094D38] text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors flex items-center space-x-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        <span>Tambah Relawan</span>
    </button>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100 text-[11px] uppercase tracking-wider text-gray-500">
                <th class="px-6 py-4 font-semibold">Nama Relawan</th>
                <th class="px-6 py-4 font-semibold">Email</th>
                <th class="px-6 py-4 font-semibold">Status</th>
                <th class="px-6 py-4 font-semibold">Terdaftar Pada</th>
                <th class="px-6 py-4 font-semibold text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($volunteers as $v)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($v->name) }}&background=E5E7EB&color=374151" class="w-8 h-8 rounded-full">
                        <span class="font-bold text-gray-900 text-sm">{{ $v->name }}</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $v->email }}</td>
                <td class="px-6 py-4">
                    <span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-xs font-semibold">Aktif</span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $v->created_at->format('d M Y') }}</td>
                <td class="px-6 py-4 text-right">
                    <button class="text-blue-600 hover:text-blue-800 text-sm font-semibold">Detail</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-gray-400 text-sm">Belum ada data relawan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    @if($volunteers->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        {{ $volunteers->links() }}
    </div>
    @endif
</div>
@endsection
