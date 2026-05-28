@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-end">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Pusat Notifikasi</h2>
        <p class="text-sm text-gray-500 mt-1">Log pemberitahuan sistem dan pesan peringatan.</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="divide-y divide-gray-100">
        @forelse($messages as $m)
        <div class="p-5 flex items-start space-x-4 hover:bg-gray-50 transition-colors">
            <div class="bg-{{ $m->type == 'broadcast' ? 'blue' : 'green' }}-100 text-{{ $m->type == 'broadcast' ? 'blue' : 'green' }}-600 p-2.5 rounded-full shrink-0">
                @if($m->type == 'broadcast')
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                @else
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex justify-between items-center mb-1">
                    <h4 class="font-bold text-gray-900 text-sm uppercase tracking-wide">{{ $m->type }}</h4>
                    <span class="text-xs text-gray-400">{{ $m->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-sm text-gray-600">{{ $m->content }}</p>
                <div class="mt-2 text-[10px] text-gray-400 font-mono">
                    Sender: {{ $m->sender->name ?? 'System' }} &bull; Channel: {{ $m->channel ?? 'All' }}
                </div>
            </div>
        </div>
        @empty
        <div class="p-10 text-center text-gray-400">Belum ada notifikasi baru.</div>
        @endforelse
    </div>
    
    @if($messages->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        {{ $messages->links() }}
    </div>
    @endif
</div>
@endsection
