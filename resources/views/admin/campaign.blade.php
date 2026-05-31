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

<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-white font-display">Campaign Management</h2>
        <p class="text-xs text-gray-400 mt-1">Kelola program donasi kemanusiaan dan tanggap darurat CrisisHub.</p>
    </div>
    <button onclick="toggleModal('create-campaign-modal')" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-400 text-black text-xs font-bold uppercase tracking-wider rounded-lg transition-all flex items-center gap-2 shadow-lg shadow-yellow-500/10">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        New Campaign
    </button>
</div>

<!-- Campaign Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-10">
    @forelse($campaigns as $camp)
    @php
        $pct = $camp->target_amount > 0 ? min(100, round(($camp->collected_amount / $camp->target_amount) * 100)) : 0;
    @endphp
    <div class="card-glass rounded-2xl p-5 flex flex-col justify-between hover:scale-[1.01] transition-all duration-300">
        <div>
            <!-- Header -->
            <div class="flex justify-between items-start mb-3">
                <div class="text-2xl">{{ $camp->emoji ?? '🆘' }}</div>
                <div class="flex gap-1.5">
                    <span class="text-[9px] font-extrabold uppercase tracking-widest px-2 py-0.5 rounded-full" style="background: rgba(59,130,246,0.15); border: 1px solid rgba(59,130,246,0.3); color: #60A5FA;">
                        {{ $camp->tag ?? 'AKTIF' }}
                    </span>
                    <span class="text-[9px] font-extrabold uppercase tracking-widest px-2 py-0.5 rounded-full border {{ $camp->is_active ? 'bg-green-500/10 border-green-500/20 text-green-400' : 'bg-red-500/10 border-red-500/20 text-red-400' }}">
                        {{ $camp->is_active ? 'Active' : 'Closed' }}
                    </span>
                </div>
            </div>

            <!-- Title & Desc -->
            <h4 class="text-base font-bold text-white mb-1.5 font-display">{{ $camp->title }}</h4>
            <div class="flex items-center text-[10px] text-gray-500 gap-1 mb-3">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                <span class="truncate">{{ $camp->location }}</span>
            </div>
            <p class="text-xs text-gray-400 line-clamp-3 mb-4 leading-relaxed">{{ $camp->description }}</p>
        </div>

        <div>
            <!-- Metrics -->
            <div class="space-y-2 mb-4">
                <div class="flex justify-between items-end text-xs">
                    <div>
                        <span class="text-[10px] text-gray-500 block uppercase font-bold tracking-wider">Collected</span>
                        <span class="font-extrabold text-green-400 text-sm">Rp {{ number_format($camp->collected_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] text-gray-500 block uppercase font-bold tracking-wider">Target</span>
                        <span class="font-bold text-white text-xs">Rp {{ number_format($camp->target_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
                <!-- Progress -->
                <div class="w-full bg-white/5 rounded-full h-2 overflow-hidden border border-white/5">
                    <div class="bg-gradient-to-r from-yellow-500 to-green-500 h-full rounded-full" style="width: {{ $pct }}%"></div>
                </div>
                <div class="flex justify-between text-[9px] text-gray-500">
                    <span>{{ $pct }}% Complete</span>
                    <span>Deadline: {{ \Carbon\Carbon::parse($camp->deadline)->format('d M Y') }}</span>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-2 pt-3 border-t border-white/5">
                <button onclick="openEditModal({{ json_encode($camp) }})" class="px-2.5 py-1.5 text-[10px] font-bold uppercase rounded bg-white/5 hover:bg-white/10 text-gray-300 border border-white/10 transition-colors">
                    Edit
                </button>
                <form method="POST" action="{{ route('admin.campaign.destroy', $camp->id) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus campaign ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-2.5 py-1.5 text-[10px] font-bold uppercase rounded bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/20 transition-colors">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full card-glass rounded-2xl p-12 text-center text-gray-500">
        <svg class="w-12 h-12 mx-auto text-gray-700 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        <span class="text-sm">Tidak ada program campaign saat ini. Buat campaign baru untuk memulai donasi.</span>
    </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-5">{{ $campaigns->links() }}</div>

<!-- Modal Create -->
<div id="create-campaign-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm hidden">
    <div class="card-glass rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl border border-white/10 mx-4">
        <div class="px-6 py-4 border-b border-white/5 bg-white/[0.02] flex justify-between items-center">
            <h3 class="font-bold text-white font-display text-base">Create Donation Campaign</h3>
            <button onclick="toggleModal('create-campaign-modal')" class="text-gray-400 hover:text-white">&times;</button>
        </div>
        <form method="POST" action="{{ route('admin.campaign.store') }}" class="p-6 space-y-4">
            @csrf
            <div class="grid grid-cols-3 gap-3">
                <div class="col-span-1">
                    <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Emoji</label>
                    <input name="emoji" type="text" placeholder="🆘" value="🆘" class="w-full px-3 py-2 text-sm bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-yellow-500">
                </div>
                <div class="col-span-2">
                    <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Campaign Title</label>
                    <input name="title" required type="text" placeholder="Peduli Korban Gempa..." class="w-full px-3 py-2 text-sm bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-yellow-500">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Location</label>
                    <input name="location" required type="text" placeholder="Kab. Bandung, Jabar" class="w-full px-3 py-2 text-sm bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-yellow-500">
                </div>
                <div>
                    <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Tag (Short Label)</label>
                    <input name="tag" type="text" placeholder="AKTIF" value="AKTIF" class="w-full px-3 py-2 text-sm bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-yellow-500">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Target Amount (Rp)</label>
                    <input name="target_amount" required type="number" min="100000" placeholder="10000000" class="w-full px-3 py-2 text-sm bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-yellow-500">
                </div>
                <div>
                    <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Deadline Date</label>
                    <input name="deadline" required type="date" class="w-full px-3 py-2 text-sm bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-yellow-500">
                </div>
            </div>
            <div>
                <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Campaign Description</label>
                <textarea name="description" required rows="3" placeholder="Jelaskan secara rinci tentang program donasi ini..." class="w-full px-3 py-2 text-sm bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-yellow-500"></textarea>
            </div>
            <div class="flex items-center space-x-2 pt-2">
                <input name="is_active" type="hidden" value="1">
            </div>
            <div class="flex justify-end gap-2 border-t border-white/5 pt-4">
                <button type="button" onclick="toggleModal('create-campaign-modal')" class="px-4 py-2 bg-white/5 hover:bg-white/10 text-gray-300 text-xs font-bold uppercase rounded-lg border border-white/10">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-400 text-black text-xs font-bold uppercase rounded-lg">Save Campaign</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="edit-campaign-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm hidden">
    <div class="card-glass rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl border border-white/10 mx-4">
        <div class="px-6 py-4 border-b border-white/5 bg-white/[0.02] flex justify-between items-center">
            <h3 class="font-bold text-white font-display text-base">Edit Donation Campaign</h3>
            <button onclick="toggleModal('edit-campaign-modal')" class="text-gray-400 hover:text-white">&times;</button>
        </div>
        <form id="edit-campaign-form" method="POST" action="" class="p-6 space-y-4">
            @csrf
            @method('PATCH')
            <div class="grid grid-cols-3 gap-3">
                <div class="col-span-1">
                    <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Emoji</label>
                    <input id="edit_emoji" name="emoji" type="text" class="w-full px-3 py-2 text-sm bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none">
                </div>
                <div class="col-span-2">
                    <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Campaign Title</label>
                    <input id="edit_title" name="title" required type="text" class="w-full px-3 py-2 text-sm bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Location</label>
                    <input id="edit_location" name="location" required type="text" class="w-full px-3 py-2 text-sm bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none">
                </div>
                <div>
                    <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Tag</label>
                    <input id="edit_tag" name="tag" type="text" class="w-full px-3 py-2 text-sm bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Target Amount (Rp)</label>
                    <input id="edit_target_amount" name="target_amount" required type="number" class="w-full px-3 py-2 text-sm bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none">
                </div>
                <div>
                    <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Deadline Date</label>
                    <input id="edit_deadline" name="deadline" required type="date" class="w-full px-3 py-2 text-sm bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none">
                </div>
            </div>
            <div>
                <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Campaign Description</label>
                <textarea id="edit_description" name="description" required rows="3" class="w-full px-3 py-2 text-sm bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none"></textarea>
            </div>
            <div class="flex items-center gap-2">
                <input id="edit_is_active" type="checkbox" name="is_active" value="1" class="rounded bg-white/5 border-white/10 text-yellow-500 focus:ring-0">
                <label class="text-xs text-gray-300 font-semibold select-none cursor-pointer" for="edit_is_active">Campaign ini Aktif & Terbuka untuk Donasi</label>
            </div>
            <div class="flex justify-end gap-2 border-t border-white/5 pt-4">
                <button type="button" onclick="toggleModal('edit-campaign-modal')" class="px-4 py-2 bg-white/5 hover:bg-white/10 text-gray-300 text-xs font-bold uppercase rounded-lg border border-white/10">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-400 text-black text-xs font-bold uppercase rounded-lg">Update Campaign</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleModal(id) {
        const modal = document.getElementById(id);
        modal.classList.toggle('hidden');
    }

    function openEditModal(camp) {
        document.getElementById('edit-campaign-form').action = `/admin/campaign/${camp.id}`;
        document.getElementById('edit_emoji').value = camp.emoji || '🆘';
        document.getElementById('edit_title').value = camp.title;
        document.getElementById('edit_location').value = camp.location;
        document.getElementById('edit_tag').value = camp.tag || 'AKTIF';
        document.getElementById('edit_target_amount').value = camp.target_amount;
        document.getElementById('edit_deadline').value = camp.deadline;
        document.getElementById('edit_description').value = camp.description;
        document.getElementById('edit_is_active').checked = !!camp.is_active;
        toggleModal('edit-campaign-modal');
    }
</script>
@endsection
