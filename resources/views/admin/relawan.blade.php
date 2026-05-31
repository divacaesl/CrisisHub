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

<div class="mb-6 flex flex-wrap items-center justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-white font-display">Volunteer Management</h2>
        <p class="text-xs text-gray-400 mt-1">Pantau lokasi, keaktifan, dan tugaskan relawan kemanusiaan di lapangan.</p>
    </div>
    
    <!-- Search -->
    <form method="GET" class="flex gap-2">
        <div class="relative">
            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/></svg>
            <input name="search" value="{{ request('search') }}" placeholder="Cari relawan..." class="pl-9 pr-4 py-2 text-xs rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-yellow-500/50 w-48 md:w-64" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
        </div>
        <button type="submit" class="px-3.5 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-lg text-xs font-bold text-white uppercase tracking-wider transition-colors">Search</button>
    </form>
</div>

<!-- Volunteer Table -->
<div class="card-glass rounded-2xl overflow-hidden mb-6">
    <table class="w-full text-sm text-left">
        <thead>
            <tr class="bg-white/[0.02] border-b border-white/5 text-[10px] uppercase tracking-wider text-gray-500 font-semibold">
                <th class="px-6 py-4">Nama Relawan</th>
                <th class="px-6 py-4">Email</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4">Terdaftar</th>
                <th class="px-6 py-4 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5 text-gray-300">
            @forelse($volunteers as $v)
            <tr class="hover:bg-white/[0.01] transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($v->name) }}&background=E8C547&color=000&bold=true" class="w-8 h-8 rounded-full border border-white/10">
                        <span class="font-bold text-white text-xs">{{ $v->name }}</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-xs text-gray-400">{{ $v->email }}</td>
                <td class="px-6 py-4">
                    <span class="text-[9px] font-extrabold uppercase tracking-widest px-2 py-0.5 rounded border border-green-500/20 bg-green-500/10 text-green-400">AKTIF</span>
                </td>
                <td class="px-6 py-4 text-xs text-gray-500">{{ $v->created_at->format('d M Y') }}</td>
                <td class="px-6 py-4 text-right">
                    <button onclick="openAssignModal({{ $v->id }}, '{{ addslashes($v->name) }}')" class="px-2.5 py-1.5 text-[10px] font-bold uppercase rounded bg-yellow-500/10 text-yellow-500 hover:bg-yellow-500 hover:text-black border border-yellow-500/25 transition-all">
                        Tugaskan Relawan
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                    <svg class="w-10 h-10 mx-auto text-gray-700 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span class="text-xs">Tidak ada relawan terdaftar yang cocok dengan pencarian Anda.</span>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-4">{{ $volunteers->links() }}</div>

<!-- Task Assignment Modal -->
<div id="assign-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm hidden">
    <div class="card-glass rounded-2xl w-full max-w-md overflow-hidden shadow-2xl border border-white/10 mx-4">
        <div class="px-6 py-4 border-b border-white/5 bg-white/[0.02] flex justify-between items-center">
            <h3 class="font-bold text-white font-display text-base">Assign Volunteer Task</h3>
            <button onclick="closeAssignModal()" class="text-gray-400 hover:text-white">&times;</button>
        </div>
        <form method="POST" action="{{ route('admin.relawan.assign') }}" class="p-6 space-y-4">
            @csrf
            <input type="hidden" id="volunteer-id-input" name="volunteer_id" value="">
            
            <div>
                <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Relawan</label>
                <input id="volunteer-name-input" type="text" readonly class="w-full px-3 py-2 text-sm bg-white/5 border border-white/10 rounded-lg text-gray-400 focus:outline-none select-none">
            </div>

            <div>
                <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Target Bencana / Laporan</label>
                <select name="report_id" required class="w-full px-3 py-2 text-sm bg-[#141714] border border-white/10 rounded-lg text-gray-300 focus:outline-none focus:border-yellow-500">
                    <option value="" disabled selected>Pilih bencana aktif...</option>
                    @foreach($reports as $rep)
                    <option value="{{ $rep->id }}">#{{ $rep->id }} - {{ $rep->jenis_bencana }} ({{ Str::limit($rep->alamat_lengkap, 30) }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Deskripsi Tugas Lapangan</label>
                <textarea name="task" required rows="4" placeholder="Misal: Salurkan logistik makanan medis ke posko tenda darurat..." class="w-full px-3 py-2 text-sm bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-yellow-500"></textarea>
            </div>

            <div class="flex justify-end gap-2 border-t border-white/5 pt-4">
                <button type="button" onclick="closeAssignModal()" class="px-4 py-2 bg-white/5 hover:bg-white/10 text-gray-300 text-xs font-bold uppercase rounded-lg border border-white/10">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-400 text-black text-xs font-bold uppercase rounded-lg">Tugaskan Relawan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAssignModal(id, name) {
        document.getElementById('volunteer-id-input').value = id;
        document.getElementById('volunteer-name-input').value = name;
        document.getElementById('assign-modal').classList.remove('hidden');
    }

    function closeAssignModal() {
        document.getElementById('assign-modal').classList.add('hidden');
    }
</script>
@endsection
