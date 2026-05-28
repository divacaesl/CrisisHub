@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-end">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Pusat Komunikasi</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola perpesanan dan komunikasi antar pengguna serta tim relawan.</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] overflow-hidden">
    <div class="divide-y divide-gray-100">
        @forelse($messages as $m)
        <div class="p-5 flex items-start space-x-4 hover:bg-gray-50 transition-colors">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($m->sender->name ?? 'System') }}&background=0B5A42&color=fff" class="w-10 h-10 rounded-full shrink-0 shadow-sm">
            <div class="flex-1 min-w-0">
                <div class="flex justify-between items-center mb-1">
                    <h4 class="font-bold text-gray-900 text-sm">{{ $m->sender->name ?? 'System' }}</h4>
                    <span class="text-xs text-gray-400">{{ $m->created_at->format('d M Y, H:i') }}</span>
                </div>
                <p class="text-sm text-gray-600 mt-1">{{ $m->content }}</p>
                <div class="mt-2 flex space-x-2">
                    <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-[10px] font-semibold uppercase tracking-wider">{{ $m->type }}</span>
                    @if($m->channel)
                    <span class="bg-blue-50 text-blue-600 px-2 py-0.5 rounded text-[10px] font-semibold uppercase tracking-wider">CH: {{ $m->channel }}</span>
                    @endif
                </div>
            </div>
            <button class="text-gray-400 hover:text-green-600 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg></button>
        </div>
        @empty
        <div class="p-10 text-center text-gray-400">Belum ada riwayat komunikasi.</div>
        @endforelse
    </div>
    
    @if($messages->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        {{ $messages->links() }}
    </div>
    @endif
</div>
@endsection
