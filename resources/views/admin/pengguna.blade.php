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
@if(session('error'))
<div id="flash-err" class="fixed top-5 right-5 z-50 flex items-center space-x-3 px-5 py-3.5 rounded-xl shadow-2xl text-sm font-semibold text-white" style="background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.4); backdrop-filter: blur(10px);">
    <svg class="w-4 h-4 text-red-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
    <span>{{ session('error') }}</span>
</div>
<script>setTimeout(() => document.getElementById('flash-err')?.remove(), 4000)</script>
@endif

<!-- Quick Metrics -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
    <div class="card-glass rounded-2xl p-5 flex items-center justify-between">
        <div>
            <span class="text-[10px] text-gray-500 font-bold uppercase tracking-wider block">Total Registered Users</span>
            <span class="text-2xl font-black text-white font-display mt-1 block">{{ number_format($totalUsers) }}</span>
        </div>
        <div class="text-xl">👥</div>
    </div>
    <div class="card-glass rounded-2xl p-5 flex items-center justify-between">
        <div>
            <span class="text-[10px] text-gray-500 font-bold uppercase tracking-wider block">Super Administrators</span>
            <span class="text-2xl font-black text-white font-display mt-1 block">{{ number_format($adminCount) }}</span>
        </div>
        <div class="text-xl">👑</div>
    </div>
    <div class="card-glass rounded-2xl p-5 flex items-center justify-between">
        <div>
            <span class="text-[10px] text-gray-500 font-bold uppercase tracking-wider block">Banned / Suspended</span>
            <span class="text-2xl font-black text-red-400 font-display mt-1 block">
                {{ number_format($users->where('is_suspended', true)->count()) }}
            </span>
        </div>
        <div class="text-xl">🚫</div>
    </div>
</div>

<div class="mb-6 flex flex-wrap items-center justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-white font-display">User Directory</h2>
        <p class="text-xs text-gray-400 mt-1">Ubah peran, kelola akun, dan tangguhkan akun pengguna bermasalah.</p>
    </div>

    <!-- Filters -->
    <div class="flex gap-2 flex-wrap items-center">
        <form method="GET" class="flex gap-2">
            <div class="relative">
                <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/></svg>
                <input name="search" value="{{ request('search') }}" placeholder="Cari nama / email..." class="pl-9 pr-4 py-2 text-xs rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-yellow-500/50 w-44 md:w-56" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
            </div>
            <select name="role" onchange="this.form.submit()" class="px-3 py-2 text-xs rounded-lg text-gray-300 focus:outline-none" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                <option value="">Semua Peran</option>
                <option value="Admin" {{ request('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                <option value="Relawan" {{ request('role') == 'Relawan' ? 'selected' : '' }}>Relawan</option>
                <option value="Organisasi Bantuan" {{ request('role') == 'Organisasi Bantuan' ? 'selected' : '' }}>Organisasi Bantuan</option>
            </select>
        </form>
    </div>
</div>

<!-- Table -->
<div class="card-glass rounded-2xl overflow-hidden mb-6">
    <table class="w-full text-sm text-left">
        <thead>
            <tr class="bg-white/[0.02] border-b border-white/5 text-[10px] uppercase tracking-wider text-gray-500 font-semibold">
                <th class="px-6 py-4">Nama & Email</th>
                <th class="px-6 py-4">Peran (Role)</th>
                <th class="px-6 py-4">Status Akun</th>
                <th class="px-6 py-4">Bergabung</th>
                <th class="px-6 py-4 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5 text-gray-300">
            @forelse($users as $u)
            <tr class="hover:bg-white/[0.01] transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($u->name) }}&background=E8C547&color=000&bold=true" class="w-9 h-9 rounded-full border border-white/10">
                        <div>
                            <span class="font-bold text-white text-xs block leading-tight">{{ $u->name }}</span>
                            <span class="text-[10px] text-gray-500">{{ $u->email }}</span>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="flex flex-wrap gap-1">
                        @forelse($u->roles as $role)
                            <span class="px-2 py-0.5 rounded bg-yellow-500/10 border border-yellow-500/20 text-yellow-500 text-[8px] font-extrabold uppercase tracking-wider">
                                {{ $role->name }}
                            </span>
                        @empty
                            <span class="px-2 py-0.5 rounded bg-white/5 border border-white/10 text-gray-500 text-[8px] font-extrabold uppercase tracking-wider">
                                Citizen
                            </span>
                        @endforelse
                    </div>
                </td>
                <td class="px-6 py-4">
                    @if($u->is_suspended ?? false)
                        <span class="px-2 py-0.5 rounded bg-red-500/10 border border-red-500/20 text-red-400 text-[9px] font-extrabold uppercase tracking-widest">
                            Suspended
                        </span>
                    @else
                        <span class="px-2 py-0.5 rounded bg-green-500/10 border border-green-500/20 text-green-400 text-[9px] font-extrabold uppercase tracking-widest">
                            Active
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 text-xs text-gray-500">
                    {{ $u->created_at->format('d M Y') }}
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-1.5">
                        <!-- Edit -->
                        <button onclick='openEditModal({{ json_encode($u) }}, "{{ $u->roles->pluck("name")->first() }}")' class="px-2.5 py-1.5 text-[10px] font-bold uppercase rounded bg-white/5 hover:bg-white/10 text-gray-300 border border-white/10 transition-colors">
                            Edit
                        </button>
                        <!-- Suspend Toggle -->
                        <form method="POST" action="{{ route('admin.pengguna.suspend', $u->id) }}" class="inline">
                            @csrf
                            <button type="submit" class="px-2.5 py-1.5 text-[10px] font-bold uppercase rounded transition-colors {{ ($u->is_suspended ?? false) ? 'bg-green-500/10 border-green-500/20 text-green-400 hover:bg-green-500/20' : 'bg-orange-500/10 border-orange-500/20 text-orange-400 hover:bg-orange-500/20' }}">
                                {{ ($u->is_suspended ?? false) ? '✓ Unban' : '🚫 Ban' }}
                            </button>
                        </form>
                        <!-- Delete -->
                        <form method="POST" action="{{ route('admin.pengguna.destroy', $u->id) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2.5 py-1.5 text-[10px] font-bold uppercase rounded bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/20 transition-colors">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                    <svg class="w-10 h-10 mx-auto text-gray-700 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span class="text-xs">Tidak ada data pengguna ditemukan.</span>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-4">{{ $users->appends(request()->query())->links() }}</div>

<!-- User Edit Modal -->
<div id="edit-user-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm hidden">
    <div class="card-glass rounded-2xl w-full max-w-md overflow-hidden shadow-2xl border border-white/10 mx-4">
        <div class="px-6 py-4 border-b border-white/5 bg-white/[0.02] flex justify-between items-center">
            <h3 class="font-bold text-white font-display text-base">Edit User Profile</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-white">&times;</button>
        </div>
        <form id="edit-user-form" method="POST" action="" class="p-6 space-y-4">
            @csrf
            @method('PATCH')
            
            <div>
                <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Nama Lengkap</label>
                <input id="edit_name" name="name" required type="text" class="w-full px-3 py-2 text-sm bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-yellow-500">
            </div>

            <div>
                <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Email Address</label>
                <input id="edit_email" name="email" required type="email" class="w-full px-3 py-2 text-sm bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-yellow-500">
            </div>

            <div>
                <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Password Baru (Opsional)</label>
                <input name="password" type="password" placeholder="Kosongkan jika tidak ingin diubah" class="w-full px-3 py-2 text-sm bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-yellow-500">
            </div>

            <div>
                <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Peran Akses (Role)</label>
                <select id="edit_role" name="role" required class="w-full px-3 py-2 text-sm bg-[#141714] border border-white/10 rounded-lg text-gray-300 focus:outline-none focus:border-yellow-500">
                    <option value="">Citizen (Akses Dasar)</option>
                    <option value="Admin">Admin</option>
                    <option value="Relawan">Relawan</option>
                    <option value="Organisasi Bantuan">Organisasi Bantuan</option>
                </select>
            </div>

            <div class="flex justify-end gap-2 border-t border-white/5 pt-4">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-white/5 hover:bg-white/10 text-gray-300 text-xs font-bold uppercase rounded-lg border border-white/10">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-400 text-black text-xs font-bold uppercase rounded-lg">Update User</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(user, firstRole) {
        document.getElementById('edit-user-form').action = `/admin/pengguna/${user.id}`;
        document.getElementById('edit_name').value = user.name;
        document.getElementById('edit_email').value = user.email;
        document.getElementById('edit_role').value = firstRole || '';
        document.getElementById('edit-user-modal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('edit-user-modal').classList.add('hidden');
    }
</script>
@endsection
