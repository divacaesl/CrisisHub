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

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
    <div class="card-glass rounded-2xl p-5 flex items-center justify-between">
        <div>
            <span class="text-[10px] text-gray-500 font-bold uppercase tracking-wider block">Total Dana Terverifikasi</span>
            <span class="text-2xl font-black text-green-400 font-display mt-1 block">Rp {{ number_format($totalVerified, 0, ',', '.') }}</span>
        </div>
        <div class="text-xl">💰</div>
    </div>
    <div class="card-glass rounded-2xl p-5 flex items-center justify-between">
        <div>
            <span class="text-[10px] text-gray-500 font-bold uppercase tracking-wider block">Menunggu Verifikasi</span>
            <span class="text-2xl font-black text-yellow-500 font-display mt-1 block">
                {{ number_format($totalPending) }} <span class="text-xs text-gray-400 font-normal">Donasi</span>
            </span>
        </div>
        <div class="text-xl">⏳</div>
    </div>
</div>

{{-- Filters & Actions Bar --}}
<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
    <div class="flex items-center gap-3 flex-wrap">
        <form method="GET" class="flex gap-2">
            <select name="status" onchange="this.form.submit()" class="px-3 py-2 text-xs rounded-lg text-gray-300 focus:outline-none" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                <option value="">Semua Status</option>
                <option value="Submitted" {{ request('status') == 'Submitted' ? 'selected' : '' }}>Submitted</option>
                <option value="Verified" {{ request('status') == 'Verified' ? 'selected' : '' }}>Verified</option>
                <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            <select name="type" onchange="this.form.submit()" class="px-3 py-2 text-xs rounded-lg text-gray-300 focus:outline-none" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                <option value="">Semua Tipe</option>
                <option value="Uang" {{ request('type') == 'Uang' ? 'selected' : '' }}>Uang (Transfer)</option>
                <option value="Barang" {{ request('type') == 'Barang' ? 'selected' : '' }}>Barang / Logistik</option>
            </select>
        </form>
    </div>
    <a href="{{ route('admin.donasi.export') }}" class="flex items-center gap-2 px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-lg bg-white/5 hover:bg-white/10 text-gray-300 border border-white/10 transition-all">
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        Export CSV Logs
    </a>
</div>

<!-- Donation Table -->
<div class="card-glass rounded-2xl overflow-hidden mb-6">
    <table class="w-full text-sm text-left">
        <thead>
            <tr class="bg-white/[0.02] border-b border-white/5 text-[10px] uppercase tracking-wider text-gray-500 font-semibold">
                <th class="px-6 py-4">Donatur</th>
                <th class="px-6 py-4">Nominal / Barang</th>
                <th class="px-6 py-4">No. Resi / Tracking</th>
                <th class="px-6 py-4">Tgl Donasi</th>
                <th class="px-6 py-4">Bukti Transfer</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5 text-gray-300">
            @forelse($donations as $d)
            <tr class="hover:bg-white/[0.01] transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($d->user->name ?? 'Anonim') }}&background=E8C547&color=000&bold=true" class="w-8 h-8 rounded-full border border-white/10">
                        <div>
                            <span class="font-bold text-white text-xs block leading-tight">{{ $d->user->name ?? 'Hamba Allah' }}</span>
                            <span class="text-[9px] text-gray-500">{{ $d->type }}</span>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    @if($d->type == 'Uang')
                        <span class="font-extrabold text-green-400 text-xs">Rp {{ number_format($d->amount, 0, ',', '.') }}</span>
                    @else
                        <span class="font-bold text-white text-xs block">{{ $d->items ?? 'Logistik Bantuan' }}</span>
                        <span class="text-[9px] text-gray-500">Kuantitas Tertera</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-xs font-mono text-gray-400">
                    {{ $d->tracking_code }}
                </td>
                <td class="px-6 py-4 text-xs text-gray-500">
                    {{ $d->created_at->format('d M Y, H:i') }}
                </td>
                <td class="px-6 py-4">
                    @if($d->payment_proof)
                        <button onclick="viewProof('{{ asset('storage/' . $d->payment_proof) }}')" class="text-[10px] text-yellow-500 hover:text-yellow-400 font-bold underline">
                            Lihat Bukti
                        </button>
                    @elseif($d->proof)
                        <button onclick="viewProof('{{ asset('storage/' . $d->proof) }}')" class="text-[10px] text-yellow-500 hover:text-yellow-400 font-bold underline">
                            Lihat Bukti
                        </button>
                    @else
                        <span class="text-[10px] text-gray-600">No Proof</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    @php $s = $d->status; @endphp
                    <span class="text-[9px] font-extrabold uppercase tracking-widest px-2 py-0.5 rounded border 
                        {{ $s == 'Verified' ? 'bg-green-500/10 border-green-500/20 text-green-400' : ($s == 'Rejected' ? 'bg-red-500/10 border-red-500/20 text-red-400' : 'bg-yellow-500/10 border-yellow-500/20 text-yellow-400') }}">
                        {{ $s }}
                    </span>
                </td>
                <td class="px-6 py-4 text-right">
                    @if($s == 'Submitted')
                    <div class="flex items-center justify-end gap-1.5">
                        @if($d->type === 'Barang')
                        <button type="button" onclick="openVerifyLogistikModal('{{ route('admin.donasi.verify', $d->id) }}')" class="px-2.5 py-1 text-[9px] font-black uppercase rounded bg-green-500/10 text-green-400 border border-green-500/20 hover:bg-green-500/20 transition-all">Verify</button>
                        @else
                        <form method="POST" action="{{ route('admin.donasi.verify', $d->id) }}" class="inline">
                            @csrf
                            <input type="hidden" name="action" value="Verified">
                            <button type="submit" class="px-2.5 py-1 text-[9px] font-black uppercase rounded bg-green-500/10 text-green-400 border border-green-500/20 hover:bg-green-500/20 transition-all">Verify</button>
                        </form>
                        @endif
                        <form method="POST" action="{{ route('admin.donasi.verify', $d->id) }}" class="inline">
                            @csrf
                            <input type="hidden" name="action" value="Rejected">
                            <button type="submit" class="px-2.5 py-1 text-[9px] font-black uppercase rounded bg-red-500/10 text-red-400 border border-red-500/20 hover:bg-red-500/20 transition-all">Reject</button>
                        </form>
                    </div>
                    @else
                    <span class="text-xs text-gray-600 font-bold">—</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                    <svg class="w-10 h-10 mx-auto text-gray-700 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    <span class="text-xs">Belum ada donasi terdaftar saat ini.</span>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-4">{{ $donations->appends(request()->query())->links() }}</div>

<!-- Proof Preview Modal -->
<div id="proof-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm hidden" onclick="closeProof()">
    <div class="relative max-w-lg w-full p-4" onclick="event.stopPropagation()">
        <button onclick="closeProof()" class="absolute top-2 right-6 text-white text-3xl font-bold hover:text-gray-300 focus:outline-none">&times;</button>
        <div class="card-glass rounded-2xl overflow-hidden p-2 border border-white/10">
            <img id="proof-image" src="" alt="Bukti Transfer" class="w-full h-auto max-h-[75vh] object-contain rounded-xl">
        </div>
    </div>
</div>

<!-- Verify Logistik Modal -->
<div id="verify-logistik-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm hidden" onclick="closeVerifyLogistikModal()">
    <div class="relative max-w-lg w-full p-6 card-glass rounded-2xl border border-white/10" onclick="event.stopPropagation()">
        <button onclick="closeVerifyLogistikModal()" class="absolute top-4 right-6 text-gray-400 hover:text-white">&times;</button>
        <h3 class="text-lg font-bold text-white mb-4">Verifikasi Donasi Barang</h3>
        <p class="text-xs text-gray-400 mb-4">Unggah foto bukti penerimaan barang di posko sebelum memverifikasi donasi ini.</p>
        <form id="verify-logistik-form" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="action" value="Verified">
            <div class="mb-4">
                <input type="file" name="admin_proof_image" accept="image/*" required class="w-full text-xs text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-green-500/10 file:text-green-400 hover:file:bg-green-500/20 cursor-pointer">
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeVerifyLogistikModal()" class="px-4 py-2 text-xs font-bold text-gray-400 hover:text-white transition-colors">Batal</button>
                <button type="submit" class="px-4 py-2 text-xs font-bold bg-green-600 hover:bg-green-500 text-white rounded-lg transition-colors">Upload & Verifikasi</button>
            </div>
        </form>
    </div>
</div>

<script>
    function viewProof(url) {
        document.getElementById('proof-image').src = url;
        document.getElementById('proof-modal').classList.remove('hidden');
    }

    function closeProof() {
        document.getElementById('proof-modal').classList.add('hidden');
    }

    function openVerifyLogistikModal(actionUrl) {
        document.getElementById('verify-logistik-form').action = actionUrl;
        document.getElementById('verify-logistik-modal').classList.remove('hidden');
    }

    function closeVerifyLogistikModal() {
        document.getElementById('verify-logistik-modal').classList.add('hidden');
    }
</script>
@endsection
