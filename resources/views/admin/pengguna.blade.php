@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-end">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Manajemen Pengguna</h2>
        <p class="text-sm text-gray-500 mt-1">Daftar semua pengguna terdaftar, peran, dan status akun.</p>
    </div>
    <button class="bg-[#0B5A42] hover:bg-[#094D38] text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors flex items-center space-x-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
        <span>Tambah Pengguna</span>
    </button>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100 text-[11px] uppercase tracking-wider text-gray-500">
                <th class="px-6 py-4 font-semibold">Nama & Email</th>
                <th class="px-6 py-4 font-semibold">Peran (Role)</th>
                <th class="px-6 py-4 font-semibold">Status</th>
                <th class="px-6 py-4 font-semibold text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($users as $u)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($u->name) }}&background=F3F4F6&color=374151" class="w-9 h-9 rounded-full">
                        <div>
                            <div class="font-bold text-gray-900 text-sm">{{ $u->name }}</div>
                            <div class="text-xs text-gray-500">{{ $u->email }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="flex flex-wrap gap-1">
                        @foreach($u->roles as $role)
                            <span class="px-2 py-0.5 bg-indigo-50 text-indigo-700 text-[10px] font-bold uppercase rounded">{{ $role->name }}</span>
                        @endforeach
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-xs font-semibold">Aktif</span>
                </td>
                <td class="px-6 py-4 text-right">
                    <button class="text-blue-600 hover:text-blue-800 text-sm font-semibold mr-3">Edit</button>
                    <button class="text-red-600 hover:text-red-800 text-sm font-semibold">Hapus</button>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">Tidak ada pengguna.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
