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

<div class="mb-6 flex justify-between items-end">
    <div>
        <h2 class="text-2xl font-bold text-white font-display">Pusat Komunikasi</h2>
        <p class="text-xs text-gray-400 mt-1">Kelola perpesanan dan komunikasi antar pengguna serta tim relawan.</p>
    </div>
    <button onclick="document.getElementById('compose-panel').classList.toggle('hidden')" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-400 text-black text-xs font-bold uppercase tracking-wider rounded-lg transition-all">
        + Tulis Pesan
    </button>
</div>

{{-- Compose Panel --}}
<div id="compose-panel" class="hidden mb-6">
    <div class="card-glass rounded-2xl p-6">
        <h3 class="font-bold text-white text-sm uppercase tracking-wider mb-4 text-yellow-500">Kirim Pesan Baru</h3>
        <form method="POST" action="{{ route('admin.komunikasi.reply') }}" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Channel / Kategori</label>
                    <select name="channel" class="w-full px-3 py-2 text-sm bg-[#141714] border border-white/10 rounded-lg text-gray-300 focus:outline-none focus:border-yellow-500">
                        <option value="general">General</option>
                        <option value="emergency">Emergency</option>
                        <option value="logistics">Logistics</option>
                        <option value="relawan">Relawan</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Isi Pesan</label>
                <textarea name="content" required rows="4" placeholder="Tulis pesan untuk tim atau pengumuman internal..." class="w-full px-3 py-2 text-sm bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-yellow-500"></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('compose-panel').classList.add('hidden')" class="px-4 py-2 bg-white/5 hover:bg-white/10 text-gray-300 text-xs font-bold uppercase rounded-lg border border-white/10">Batal</button>
                <button type="submit" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-400 text-black text-xs font-bold uppercase rounded-lg">Kirim Pesan</button>
            </div>
        </form>
    </div>
</div>

{{-- Message List --}}
<div class="card-glass rounded-2xl overflow-hidden">
    <div class="divide-y divide-white/5">
        @forelse($messages as $m)
        <div class="p-5 flex items-start space-x-4 hover:bg-white/[0.01] transition-colors">
            <div class="w-9 h-9 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-xs font-bold text-yellow-400 shrink-0">
                {{ strtoupper(substr($m->sender->name ?? 'S', 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex justify-between items-center mb-1">
                    <h4 class="font-bold text-white text-sm">{{ $m->sender->name ?? 'System' }}</h4>
                    <span class="text-xs text-gray-500">{{ $m->created_at->format('d M Y, H:i') }}</span>
                </div>
                <p class="text-sm text-gray-300 mt-1 leading-relaxed">{{ $m->content }}</p>
                <div class="mt-2 flex space-x-2">
                    <span class="bg-white/5 border border-white/10 text-gray-400 px-2 py-0.5 rounded text-[10px] font-semibold uppercase tracking-wider">{{ $m->type }}</span>
                    @if($m->channel)
                    <span class="bg-blue-500/10 border border-blue-500/20 text-blue-400 px-2 py-0.5 rounded text-[10px] font-semibold uppercase tracking-wider">CH: {{ $m->channel }}</span>
                    @endif
                </div>
            </div>
            {{-- Tombol reply fungsional: buka compose panel dan set channel yang sama --}}
            <button onclick="openReply('{{ $m->channel ?? 'general' }}')" class="text-gray-500 hover:text-yellow-400 transition-colors flex-shrink-0 mt-1" title="Balas Pesan">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
            </button>
        </div>
        @empty
        <div class="p-10 text-center text-gray-500">
            <svg class="w-10 h-10 mx-auto text-gray-700 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
            <span class="text-sm">Belum ada riwayat komunikasi.</span>
        </div>
        @endforelse
    </div>

    @if($messages->hasPages())
    <div class="px-6 py-4 border-t border-white/5">
        {{ $messages->links() }}
    </div>
    @endif
</div>

<script>
function openReply(channel) {
    const panel = document.getElementById('compose-panel');
    panel.classList.remove('hidden');
    const select = panel.querySelector('select[name="channel"]');
    if (select) {
        for (let opt of select.options) {
            if (opt.value === channel) { opt.selected = true; break; }
        }
    }
    panel.scrollIntoView({ behavior: 'smooth' });
    panel.querySelector('textarea').focus();
}
</script>
@endsection
