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

<div class="mb-6">
    <h2 class="text-2xl font-bold text-white font-display">Emergency Broadcast Center</h2>
    <p class="text-xs text-gray-400 mt-1">Kirim peringatan darurat seketika ke email seluruh relawan dan warga terdaftar.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    <!-- Broadcast Form (7 cols) -->
    <div class="lg:col-span-5 flex flex-col gap-5">
        <div class="card-glass rounded-2xl p-6">
            <h3 class="font-bold text-white font-display text-sm uppercase tracking-wider mb-4 flex items-center gap-2 text-yellow-500">
                <span>📣</span> Compose Alert
            </h3>
            
            <form method="POST" action="{{ route('admin.broadcast') }}" class="space-y-4">
                @csrf
                
                <div>
                    <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Alert Title</label>
                    <input name="title" required type="text" placeholder="Peringatan Bencana Banjir..." class="w-full px-3 py-2 text-sm bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-yellow-500">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Severity Level</label>
                        <select name="severity" required class="w-full px-3 py-2 text-sm bg-[#141714] border border-white/10 rounded-lg text-gray-300 focus:outline-none focus:border-yellow-500">
                            <option value="info">Info (Standard)</option>
                            <option value="warning">Warning (Medium)</option>
                            <option value="critical">Critical (Urgent)</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Target Audience</label>
                        <select name="target" required class="w-full px-3 py-2 text-sm bg-[#141714] border border-white/10 rounded-lg text-gray-300 focus:outline-none focus:border-yellow-500">
                            <option value="all">Semua Pengguna</option>
                            <option value="volunteers">Hanya Relawan</option>
                            <option value="citizens">Hanya Warga (Citizens)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1">Message Body</label>
                    <textarea name="message" required rows="6" placeholder="Ketik rincian instruksi evakuasi atau informasi bantuan secara lengkap di sini..." class="w-full px-3 py-2 text-sm bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-yellow-500"></textarea>
                </div>

                <button type="submit" class="w-full py-2.5 bg-red-600 hover:bg-red-500 text-white text-xs font-bold uppercase tracking-wider rounded-lg transition-all shadow-lg shadow-red-600/10">
                    Broadcast Now 🚀
                </button>
            </form>
        </div>
    </div>

    <!-- History Logs (7 cols) -->
    <div class="lg:col-span-7 flex flex-col gap-5">
        <div class="card-glass rounded-2xl p-6">
            <h3 class="font-bold text-white font-display text-sm uppercase tracking-wider mb-4 text-gray-400">
                Broadcast History Logs
            </h3>

            <div class="divide-y divide-white/5 space-y-4">
                @forelse($broadcastLogs as $log)
                <div class="pt-4 first:pt-0 flex flex-col gap-1.5">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center gap-1.5">
                            @php
                                $sev = $log->severity;
                                $color = $sev === 'critical' ? 'bg-red-500/10 border-red-500/20 text-red-400' :
                                         ($sev === 'warning' ? 'bg-orange-500/10 border-orange-500/20 text-orange-400' :
                                         'bg-blue-500/10 border-blue-500/20 text-blue-400');
                            @endphp
                            <span class="text-[8px] font-extrabold uppercase tracking-widest px-2 py-0.5 rounded border {{ $color }}">
                                {{ $sev }}
                            </span>
                            <span class="text-[8px] font-extrabold uppercase tracking-widest px-2 py-0.5 rounded bg-white/5 border border-white/10 text-gray-400">
                                Target: {{ $log->target }}
                            </span>
                        </div>
                        <span class="text-[9px] text-gray-500">{{ $log->created_at->diffForHumans() }}</span>
                    </div>

                    <h4 class="text-xs font-black text-white font-display">{{ $log->title }}</h4>
                    <p class="text-[11px] text-gray-400 leading-normal">{{ $log->message }}</p>

                    <div class="flex justify-between items-center text-[9px] text-gray-500 mt-1 border-t border-white/5 pt-1.5">
                        <span>Penerima: <strong>{{ $log->recipients_count }} users</strong></span>
                        <span>Dikirim pada: {{ $log->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
                @empty
                <div class="text-center text-xs text-gray-500 py-10">Belum ada riwayat broadcast dikirim.</div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-4">{{ $broadcastLogs->links() }}</div>
        </div>
    </div>
</div>
@endsection
