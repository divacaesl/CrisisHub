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

{{-- Filters & Actions Bar --}}
<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
    <div class="flex items-center gap-3 flex-wrap">
        <form method="GET" class="flex gap-2">
            <div class="relative">
                <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/></svg>
                <input name="search" value="{{ request('search') }}" placeholder="Cari laporan..." class="pl-9 pr-4 py-2 text-sm rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-yellow-500/50" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
            </div>
            <select name="status" onchange="this.form.submit()" class="px-3 py-2 text-sm rounded-lg text-gray-300 focus:outline-none" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                <option value="">Semua Status</option>
                <option value="Pending" {{ request('status')=='Pending'?'selected':'' }}>Pending</option>
                <option value="Approved" {{ request('status')=='Approved'?'selected':'' }}>Approved</option>
                <option value="Rejected" {{ request('status')=='Rejected'?'selected':'' }}>Rejected</option>
            </select>
        </form>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.laporan.export', ['format'=>'csv']) }}" class="flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-lg transition-all" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #9CA3AF;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Export CSV
        </a>
        <a href="{{ route('admin.laporan.export', ['format'=>'pdf']) }}" class="flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-lg transition-all" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #9CA3AF;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            Export PDF
        </a>
    </div>
</div>

{{-- Table --}}
<div class="rounded-2xl overflow-hidden" style="background: var(--bg-card); border: 1px solid var(--border);">
    <table class="w-full text-sm">
        <thead>
            <tr style="border-bottom: 1px solid var(--border); background: rgba(255,255,255,0.03);">
                <th class="text-left px-5 py-3.5 text-[10px] uppercase tracking-wider text-gray-500 font-semibold">ID</th>
                <th class="text-left px-5 py-3.5 text-[10px] uppercase tracking-wider text-gray-500 font-semibold">Jenis Bencana</th>
                <th class="text-left px-5 py-3.5 text-[10px] uppercase tracking-wider text-gray-500 font-semibold">Lokasi</th>
                <th class="text-left px-5 py-3.5 text-[10px] uppercase tracking-wider text-gray-500 font-semibold">Korban</th>
                <th class="text-left px-5 py-3.5 text-[10px] uppercase tracking-wider text-gray-500 font-semibold">Pelapor</th>
                <th class="text-left px-5 py-3.5 text-[10px] uppercase tracking-wider text-gray-500 font-semibold">Status</th>
                <th class="text-left px-5 py-3.5 text-[10px] uppercase tracking-wider text-gray-500 font-semibold">Tanggal</th>
                <th class="text-left px-5 py-3.5 text-[10px] uppercase tracking-wider text-gray-500 font-semibold">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y" style="divide-color: var(--border);">
            @forelse($reports as $report)
            <tr class="hover:bg-white/[0.02] transition-colors">
                <td class="px-5 py-3.5 text-gray-500 text-xs">#{{ $report->id }}</td>
                <td class="px-5 py-3.5">
                    <span class="font-semibold text-white text-xs">{{ $report->jenis_bencana }}</span>
                    @if($report->tingkat_kerusakan == 'Hancur Total')
                        <span class="ml-1 text-[9px] px-1.5 py-0.5 rounded-full bg-red-500/20 text-red-400 font-bold">KRITIS</span>
                    @endif
                </td>
                <td class="px-5 py-3.5 text-gray-400 text-xs max-w-[150px] truncate">{{ $report->alamat_lengkap ?? '-' }}</td>
                <td class="px-5 py-3.5 text-gray-300 text-xs font-semibold">{{ number_format($report->jumlah_korban) }}</td>
                <td class="px-5 py-3.5 text-xs">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-full flex-shrink-0 bg-gray-700 flex items-center justify-center text-[9px] text-gray-300">{{ substr($report->user->name ?? 'A', 0, 1) }}</div>
                        <span class="text-gray-400 truncate max-w-[80px]">{{ $report->user->name ?? 'Anonim' }}</span>
                    </div>
                </td>
                <td class="px-5 py-3.5">
                    @php $s = $report->status ?? 'Pending'; @endphp
                    <span class="text-[10px] font-bold px-2 py-1 rounded-full
                        {{ $s=='Approved' ? 'bg-green-500/20 text-green-400' : ($s=='Rejected' ? 'bg-red-500/20 text-red-400' : 'bg-yellow-500/20 text-yellow-400') }}">
                        {{ $s }}
                    </span>
                </td>
                <td class="px-5 py-3.5 text-gray-500 text-xs">{{ $report->created_at->format('d/m/y H:i') }}</td>
                <td class="px-5 py-3.5">
                    <div class="flex items-center gap-1.5">
                        @if(($report->status ?? 'Pending') == 'Pending')
                        <form method="POST" action="{{ route('admin.laporan.verify', $report->id) }}" class="inline">
                            @csrf
                            <input type="hidden" name="action" value="Approved">
                            <button type="submit" class="px-2.5 py-1.5 text-[10px] font-bold rounded-lg bg-green-500/20 text-green-400 hover:bg-green-500/30 transition-colors">✓ Approve</button>
                        </form>
                        <form method="POST" action="{{ route('admin.laporan.verify', $report->id) }}" class="inline">
                            @csrf
                            <input type="hidden" name="action" value="Rejected">
                            <button type="submit" class="px-2.5 py-1.5 text-[10px] font-bold rounded-lg bg-red-500/20 text-red-400 hover:bg-red-500/30 transition-colors">✕ Reject</button>
                        </form>
                        @elseif(in_array($report->status, ['Verified', 'In Progress', 'Resolved']))
                        <button onclick="openChatModal({{ $report->id }}, '{{ $report->jenis_bencana }}')" class="px-2.5 py-1.5 text-[10px] font-bold rounded-lg bg-blue-500/20 text-blue-400 hover:bg-blue-500/30 transition-colors flex items-center gap-1">
                            <i class="fas fa-comment-dots"></i> Live Chat
                        </button>
                        @else
                        <span class="text-[10px] text-gray-600">—</span>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-5 py-12 text-center text-gray-600">
                    <div class="flex flex-col items-center gap-2">
                        <svg class="w-10 h-10 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span class="text-sm">Tidak ada laporan ditemukan</span>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
<div class="mt-5">{{ $reports->withQueryString()->links() }}</div>

<!-- Chat Modal -->
<div id="chat-modal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm hidden">
    <div class="card-glass rounded-2xl w-full max-w-lg mx-4 overflow-hidden shadow-2xl flex flex-col h-[600px] max-h-[80vh] border border-white/10">
        <!-- Header -->
        <div class="bg-white/[0.02] px-6 py-4 flex justify-between items-center border-b border-white/5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center">
                    <i class="fas fa-headset"></i>
                </div>
                <div>
                    <h3 class="font-bold text-white text-base leading-tight">Live Chat Bantuan</h3>
                    <p id="chat-modal-title" class="text-xs text-blue-400 font-semibold"></p>
                </div>
            </div>
            <button onclick="closeChatModal()" class="text-gray-400 hover:text-white transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <!-- Messages -->
        <div id="chat-messages" class="flex-1 overflow-y-auto p-6 custom-scrollbar space-y-4">
            <!-- AJAX content -->
        </div>

        <!-- Input Box -->
        <div class="p-4 bg-white/[0.02] border-t border-white/5">
            <form onsubmit="sendChatMessage(event)" class="flex gap-2">
                <input type="text" id="chat-input" placeholder="Ketik pesan Anda di sini..." class="flex-1 bg-white/5 border border-white/10 text-white text-sm rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all" required autocomplete="off">
                <button type="submit" class="w-12 flex-shrink-0 bg-blue-600 hover:bg-blue-500 text-white rounded-xl flex items-center justify-center transition-colors">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Chat Feature
    let currentReportChatId = null;

    function openChatModal(reportId, title) {
        currentReportChatId = reportId;
        document.getElementById('chat-modal-title').textContent = title;
        document.getElementById('chat-modal').classList.remove('hidden');
        fetchMessages();
    }

    function closeChatModal() {
        document.getElementById('chat-modal').classList.add('hidden');
        currentReportChatId = null;
    }

    function fetchMessages() {
        if (!currentReportChatId) return;
        fetch(`/report/${currentReportChatId}/chat`)
            .then(res => res.json())
            .then(data => {
                const container = document.getElementById('chat-messages');
                container.innerHTML = '';
                data.forEach(msg => {
                    const isSelf = msg.sender_id == {{ auth()->id() }};
                    const align = isSelf ? 'justify-end' : 'justify-start';
                    const bg = isSelf ? 'bg-blue-600 text-white' : 'bg-white/10 text-gray-200 border border-white/5';
                    const name = isSelf ? 'Anda (Admin)' : msg.sender_name;
                    
                    container.innerHTML += `
                        <div class="flex ${align}">
                            <div class="max-w-[75%]">
                                <span class="text-[10px] text-gray-500 block mb-1 ${isSelf ? 'text-right' : 'text-left'}">${name} • ${msg.time}</span>
                                <div class="${bg} px-4 py-2 rounded-2xl ${isSelf ? 'rounded-tr-sm' : 'rounded-tl-sm'} text-sm shadow">
                                    ${msg.content}
                                </div>
                            </div>
                        </div>
                    `;
                });
                container.scrollTop = container.scrollHeight;
            })
            .catch(err => console.error(err));
    }

    function sendChatMessage(e) {
        e.preventDefault();
        const input = document.getElementById('chat-input');
        const content = input.value.trim();
        if (!content || !currentReportChatId) return;

        input.disabled = true;
        fetch(`/report/${currentReportChatId}/chat`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ content: content })
        })
        .then(res => res.json())
        .then(data => {
            input.value = '';
            input.disabled = false;
            fetchMessages();
        })
        .catch(err => {
            console.error(err);
            input.disabled = false;
        });
    }
</script>
@endsection
