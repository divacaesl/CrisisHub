@extends('layouts.admin')

@section('content')
{{-- Flash Messages --}}
@if(session('success'))
<div id="flash-toast" class="fixed top-5 right-5 z-50 flex items-center space-x-3 px-5 py-3.5 rounded-xl shadow-2xl text-sm font-semibold text-white transition-all duration-300" style="background: rgba(34,197,94,0.15); border: 1px solid rgba(34,197,94,0.4); backdrop-filter: blur(10px);">
    <svg class="w-4 h-4 text-green-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    <span>{{ session('success') }}</span>
</div>
<script>setTimeout(() => document.getElementById('flash-toast')?.remove(), 4000)</script>
@endif

<div class="mb-6">
    <h2 class="text-2xl font-bold text-white font-display">Verification Center</h2>
    <p class="text-xs text-gray-400 mt-1">Kurasi dan verifikasi laporan bencana, pendaftaran relawan, serta kemitraan NGO.</p>
</div>

<!-- Parent Tabs (Disaster Reports vs Volunteer Applications vs Organization Applications) -->
<div class="flex items-center space-x-2 border-b border-white/5 mb-6">
    <button onclick="switchParentTab('tab-reports', this)" class="parent-tab-btn px-5 py-3 text-xs font-black uppercase tracking-wider text-yellow-500 border-b-2 border-yellow-500 transition-all focus:outline-none flex items-center gap-2">
        <i class="fas fa-bullhorn text-sm"></i> Laporan Krisis ({{ $pending->total() }})
    </button>
    <button onclick="switchParentTab('tab-volunteers', this)" class="parent-tab-btn px-5 py-3 text-xs font-black uppercase tracking-wider text-gray-400 hover:text-white transition-all focus:outline-none flex items-center gap-2">
        <i class="fas fa-hands-helping text-sm"></i> Pendaftaran Relawan ({{ $pendingVolunteers->count() }})
    </button>
    <button onclick="switchParentTab('tab-organizations', this)" class="parent-tab-btn px-5 py-3 text-xs font-black uppercase tracking-wider text-gray-400 hover:text-white transition-all focus:outline-none flex items-center gap-2">
        <i class="fas fa-handshake text-sm"></i> Kemitraan NGO ({{ $pendingOrgs->count() }})
    </button>
</div>

<!-- ========================================== -->
<!-- 1. PARENT TAB: DISASTER REPORTS -->
<!-- ========================================== -->
<div id="tab-reports" class="parent-tab-pane space-y-6">
    <!-- Sub Tabs Navigation -->
    <div class="flex items-center space-x-2 mb-4 bg-white/[0.02] p-1.5 rounded-xl border border-white/5 w-fit">
        <button onclick="switchSubTab('reports-pending', this, 'rep-btn')" class="rep-btn px-4 py-1.5 text-[10px] font-bold uppercase rounded-lg bg-yellow-500 text-black shadow transition-all focus:outline-none">
            Pending ({{ $pending->total() }})
        </button>
        <button onclick="switchSubTab('reports-approved', this, 'rep-btn')" class="rep-btn px-4 py-1.5 text-[10px] font-bold uppercase rounded-lg text-gray-400 hover:text-white transition-all focus:outline-none">
            Approved History
        </button>
        <button onclick="switchSubTab('reports-rejected', this, 'rep-btn')" class="rep-btn px-4 py-1.5 text-[10px] font-bold uppercase rounded-lg text-gray-400 hover:text-white transition-all focus:outline-none">
            Rejected History
        </button>
    </div>

    <!-- Reports: Pending -->
    <div id="reports-pending" class="sub-tab-pane">
        <div class="card-glass rounded-2xl overflow-hidden shadow-xl">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-white/[0.02] border-b border-white/5 text-[10px] uppercase tracking-wider text-gray-500 font-semibold text-left">
                        <th class="px-5 py-3.5">ID</th>
                        <th class="px-5 py-3.5">Bencana</th>
                        <th class="px-5 py-3.5">Lokasi</th>
                        <th class="px-5 py-3.5">Kerusakan</th>
                        <th class="px-5 py-3.5">Korban</th>
                        <th class="px-5 py-3.5">Tanggal</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-gray-300">
                    @forelse($pending as $r)
                    <tr class="hover:bg-white/[0.01] transition-colors">
                        <td class="px-5 py-4 text-xs text-gray-500">#{{ $r->id }}</td>
                        <td class="px-5 py-4">
                            <span class="font-bold text-white text-xs block">{{ $r->jenis_bencana }}</span>
                            <span class="text-[10px] text-gray-500 line-clamp-1 max-w-[200px]">{{ $r->deskripsi_kondisi }}</span>
                        </td>
                        <td class="px-5 py-4 text-xs text-gray-400 max-w-[150px] truncate">{{ $r->alamat_lengkap }}</td>
                        <td class="px-5 py-4">
                            <span class="text-[9px] font-extrabold uppercase tracking-widest px-2 py-0.5 rounded border border-orange-500/20 bg-orange-500/10 text-orange-400">
                                {{ $r->tingkat_kerusakan }}
                            </span>
                        </td>
                        <td class="px-5 py-4 font-bold text-white text-xs">{{ number_format($r->jumlah_korban) }}</td>
                        <td class="px-5 py-4 text-xs text-gray-500">{{ $r->created_at->format('d/m H:i') }}</td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <button onclick="openVerificationModal('report', {{ $r->id }}, 'Approved')" class="px-2.5 py-1.5 text-[10px] font-bold uppercase rounded bg-green-500/10 text-green-400 hover:bg-green-500/20 border border-green-500/20 transition-all">✓ Approve</button>
                                <button onclick="openVerificationModal('report', {{ $r->id }}, 'Rejected')" class="px-2.5 py-1.5 text-[10px] font-bold uppercase rounded bg-red-500/10 text-red-400 hover:bg-red-500/20 border border-red-500/20 transition-all">✕ Reject</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-12 text-center text-gray-500">
                            <svg class="w-10 h-10 mx-auto text-gray-700 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-xs">Tidak ada laporan krisis yang butuh verifikasi saat ini.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $pending->links() }}</div>
    </div>

    <!-- Reports: Approved -->
    <div id="reports-approved" class="sub-tab-pane hidden">
        <div class="card-glass rounded-2xl overflow-hidden shadow-xl">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-white/[0.02] border-b border-white/5 text-[10px] uppercase tracking-wider text-gray-500 font-semibold text-left">
                        <th class="px-5 py-3.5">ID</th>
                        <th class="px-5 py-3.5">Bencana</th>
                        <th class="px-5 py-3.5">Lokasi</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5">Catatan Admin</th>
                        <th class="px-5 py-3.5">Diperbarui</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-gray-300">
                    @forelse($approved as $r)
                    <tr class="hover:bg-white/[0.01] transition-colors">
                        <td class="px-5 py-4 text-xs text-gray-500">#{{ $r->id }}</td>
                        <td class="px-5 py-4">
                            <span class="font-bold text-white text-xs block">{{ $r->jenis_bencana }}</span>
                        </td>
                        <td class="px-5 py-4 text-xs text-gray-400 max-w-[150px] truncate">{{ $r->alamat_lengkap }}</td>
                        <td class="px-5 py-4">
                            <span class="text-[9px] font-extrabold px-2 py-0.5 rounded border border-green-500/20 bg-green-500/10 text-green-400">APPROVED</span>
                        </td>
                        <td class="px-5 py-4 text-xs text-gray-400 max-w-[200px] truncate">{{ $r->admin_notes ?? 'Tanpa catatan' }}</td>
                        <td class="px-5 py-4 text-xs text-gray-500">{{ $r->updated_at->format('d M Y, H:i') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-5 py-8 text-center text-gray-500 text-xs">Belum ada riwayat laporan disetujui.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Reports: Rejected -->
    <div id="reports-rejected" class="sub-tab-pane hidden">
        <div class="card-glass rounded-2xl overflow-hidden shadow-xl">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-white/[0.02] border-b border-white/5 text-[10px] uppercase tracking-wider text-gray-500 font-semibold text-left">
                        <th class="px-5 py-3.5">ID</th>
                        <th class="px-5 py-3.5">Bencana</th>
                        <th class="px-5 py-3.5">Lokasi</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5">Catatan Penolakan</th>
                        <th class="px-5 py-3.5">Diperbarui</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-gray-300">
                    @forelse($rejected as $r)
                    <tr class="hover:bg-white/[0.01] transition-colors">
                        <td class="px-5 py-4 text-xs text-gray-500">#{{ $r->id }}</td>
                        <td class="px-5 py-4">
                            <span class="font-bold text-white text-xs block">{{ $r->jenis_bencana }}</span>
                        </td>
                        <td class="px-5 py-4 text-xs text-gray-400 max-w-[150px] truncate">{{ $r->alamat_lengkap }}</td>
                        <td class="px-5 py-4">
                            <span class="text-[9px] font-extrabold px-2 py-0.5 rounded border border-red-500/20 bg-red-500/10 text-red-400">REJECTED</span>
                        </td>
                        <td class="px-5 py-4 text-xs text-gray-400 max-w-[200px] truncate">{{ $r->admin_notes ?? 'Tanpa catatan' }}</td>
                        <td class="px-5 py-4 text-xs text-gray-500">{{ $r->updated_at->format('d M Y, H:i') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-5 py-8 text-center text-gray-500 text-xs">Belum ada riwayat laporan ditolak.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- 2. PARENT TAB: VOLUNTEER APPLICATIONS -->
<!-- ========================================== -->
<div id="tab-volunteers" class="parent-tab-pane space-y-6 hidden">
    <!-- Sub Tabs Navigation -->
    <div class="flex items-center space-x-2 mb-4 bg-white/[0.02] p-1.5 rounded-xl border border-white/5 w-fit">
        <button onclick="switchSubTab('vol-pending', this, 'vol-btn')" class="vol-btn px-4 py-1.5 text-[10px] font-bold uppercase rounded-lg bg-yellow-500 text-black shadow transition-all focus:outline-none">
            Pending ({{ $pendingVolunteers->count() }})
        </button>
        <button onclick="switchSubTab('vol-approved', this, 'vol-btn')" class="vol-btn px-4 py-1.5 text-[10px] font-bold uppercase rounded-lg text-gray-400 hover:text-white transition-all focus:outline-none">
            Approved ({{ $approvedVolunteers->count() }})
        </button>
        <button onclick="switchSubTab('vol-rejected', this, 'vol-btn')" class="vol-btn px-4 py-1.5 text-[10px] font-bold uppercase rounded-lg text-gray-400 hover:text-white transition-all focus:outline-none">
            Rejected
        </button>
    </div>

    <!-- Volunteers: Pending -->
    <div id="vol-pending" class="sub-tab-pane">
        <div class="card-glass rounded-2xl overflow-hidden shadow-xl">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-white/[0.02] border-b border-white/5 text-[10px] uppercase tracking-wider text-gray-500 font-semibold text-left">
                        <th class="px-5 py-3.5">Nama Pendaftar</th>
                        <th class="px-5 py-3.5">Kota Domisili</th>
                        <th class="px-5 py-3.5">Kontak</th>
                        <th class="px-5 py-3.5">Keahlian Khusus</th>
                        <th class="px-5 py-3.5">Pengalaman Kerelawanan</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-gray-300">
                    @forelse($pendingVolunteers as $v)
                    <tr class="hover:bg-white/[0.01] transition-colors">
                        <td class="px-5 py-4">
                            <span class="font-bold text-white text-xs block">{{ $v->user->name ?? 'User Hilang' }}</span>
                            <span class="text-[9px] text-gray-500 block">{{ $v->user->email ?? '-' }}</span>
                        </td>
                        <td class="px-5 py-4 text-xs text-gray-400">{{ $v->city }}</td>
                        <td class="px-5 py-4 text-xs text-gray-400">
                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', $v->phone_number) }}" target="_blank" class="text-green-500 font-bold flex items-center gap-1 hover:underline">
                                <i class="fab fa-whatsapp"></i> {{ $v->phone_number }}
                            </a>
                        </td>
                        <td class="px-5 py-4 text-xs text-yellow-500 font-semibold">{{ $v->skills ?? '-' }}</td>
                        <td class="px-5 py-4 text-xs text-gray-500 max-w-[200px] truncate" title="{{ $v->experience }}">{{ $v->experience ?? 'Tanpa riwayat' }}</td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <button onclick="openVerificationModal('volunteer', {{ $v->id }}, 'approved')" class="px-2.5 py-1.5 text-[10px] font-bold uppercase rounded bg-green-500/10 text-green-400 hover:bg-green-500/20 border border-green-500/20 transition-all">✓ ACC</button>
                                <button onclick="openVerificationModal('volunteer', {{ $v->id }}, 'rejected')" class="px-2.5 py-1.5 text-[10px] font-bold uppercase rounded bg-red-500/10 text-red-400 hover:bg-red-500/20 border border-red-500/20 transition-all">✕ Tolak</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center text-gray-500">
                            <i class="fas fa-users text-3xl mb-2 text-gray-700 block"></i>
                            <span class="text-xs">Tidak ada pendaftaran relawan baru saat ini.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Volunteers: Approved -->
    <div id="vol-approved" class="sub-tab-pane hidden">
        <div class="card-glass rounded-2xl overflow-hidden shadow-xl">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-white/[0.02] border-b border-white/5 text-[10px] uppercase tracking-wider text-gray-500 font-semibold text-left">
                        <th class="px-5 py-3.5">Nama Relawan</th>
                        <th class="px-5 py-3.5">Kota Domisili</th>
                        <th class="px-5 py-3.5">Kontak</th>
                        <th class="px-5 py-3.5">Keahlian</th>
                        <th class="px-5 py-3.5">Status Akses</th>
                        <th class="px-5 py-3.5">Diverifikasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-gray-300">
                    @forelse($approvedVolunteers as $v)
                    <tr class="hover:bg-white/[0.01] transition-colors">
                        <td class="px-5 py-4 font-bold text-white text-xs">{{ $v->user->name ?? 'User' }}</td>
                        <td class="px-5 py-4 text-xs text-gray-400">{{ $v->city }}</td>
                        <td class="px-5 py-4 text-xs text-gray-400">{{ $v->phone_number }}</td>
                        <td class="px-5 py-4 text-xs text-green-400 font-medium">{{ $v->skills }}</td>
                        <td class="px-5 py-4">
                            <span class="text-[9px] font-extrabold px-2 py-0.5 rounded border border-green-500/20 bg-green-500/10 text-green-400">ACTIVE RELAWAN</span>
                        </td>
                        <td class="px-5 py-4 text-xs text-gray-500">{{ $v->updated_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-5 py-8 text-center text-gray-500 text-xs">Belum ada relawan terdaftar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Volunteers: Rejected -->
    <div id="vol-rejected" class="sub-tab-pane hidden">
        <div class="card-glass rounded-2xl overflow-hidden shadow-xl">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-white/[0.02] border-b border-white/5 text-[10px] uppercase tracking-wider text-gray-500 font-semibold text-left">
                        <th class="px-5 py-3.5">Nama Pendaftar</th>
                        <th class="px-5 py-3.5">Domisili</th>
                        <th class="px-5 py-3.5">Alasan Tolak</th>
                        <th class="px-5 py-3.5">Diperbarui</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-gray-300">
                    @forelse($rejectedVolunteers as $v)
                    <tr class="hover:bg-white/[0.01] transition-colors">
                        <td class="px-5 py-4 font-bold text-white text-xs">{{ $v->user->name ?? 'User' }}</td>
                        <td class="px-5 py-4 text-xs text-gray-400">{{ $v->city }}</td>
                        <td class="px-5 py-4 text-xs text-red-400 italic">Profil tidak memadai untuk respon cepat lapangan.</td>
                        <td class="px-5 py-4 text-xs text-gray-500">{{ $v->updated_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-5 py-8 text-center text-gray-500 text-xs">Tidak ada riwayat penolakan relawan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- 3. PARENT TAB: ORGANIZATION APPLICATIONS -->
<!-- ========================================== -->
<div id="tab-organizations" class="parent-tab-pane space-y-6 hidden">
    <!-- Sub Tabs Navigation -->
    <div class="flex items-center space-x-2 mb-4 bg-white/[0.02] p-1.5 rounded-xl border border-white/5 w-fit">
        <button onclick="switchSubTab('org-pending', this, 'org-btn')" class="org-btn px-4 py-1.5 text-[10px] font-bold uppercase rounded-lg bg-yellow-500 text-black shadow transition-all focus:outline-none">
            Pending ({{ $pendingOrgs->count() }})
        </button>
        <button onclick="switchSubTab('org-approved', this, 'org-btn')" class="org-btn px-4 py-1.5 text-[10px] font-bold uppercase rounded-lg text-gray-400 hover:text-white transition-all focus:outline-none">
            Approved Partners ({{ $approvedOrgs->count() }})
        </button>
        <button onclick="switchSubTab('org-rejected', this, 'org-btn')" class="org-btn px-4 py-1.5 text-[10px] font-bold uppercase rounded-lg text-gray-400 hover:text-white transition-all focus:outline-none">
            Rejected
        </button>
    </div>

    <!-- Organizations: Pending -->
    <div id="org-pending" class="sub-tab-pane">
        <div class="card-glass rounded-2xl overflow-hidden shadow-xl">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-white/[0.02] border-b border-white/5 text-[10px] uppercase tracking-wider text-gray-500 font-semibold text-left">
                        <th class="px-5 py-3.5">Nama Instansi / NGO</th>
                        <th class="px-5 py-3.5">Tipe Instansi</th>
                        <th class="px-5 py-3.5">Nomor Akta Legalitas</th>
                        <th class="px-5 py-3.5">Penanggung Jawab</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-gray-300">
                    @forelse($pendingOrgs as $o)
                    <tr class="hover:bg-white/[0.01] transition-colors">
                        <td class="px-5 py-4">
                            <span class="font-bold text-white text-xs block">{{ $o->organization_name }}</span>
                            <span class="text-[9px] text-gray-500 block">Akun: {{ $o->user->name ?? 'User' }} ({{ $o->user->email ?? '-' }})</span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="px-2 py-0.5 text-[9px] font-black uppercase rounded bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                {{ $o->type }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-xs font-mono text-gray-400">{{ $o->registration_number ?? 'Bypass Akta' }}</td>
                        <td class="px-5 py-4 text-xs text-gray-300 font-medium">{{ $o->contact_person }}</td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <button onclick="openVerificationModal('organization', {{ $o->id }}, 'approved')" class="px-2.5 py-1.5 text-[10px] font-bold uppercase rounded bg-green-500/10 text-green-400 hover:bg-green-500/20 border border-green-500/20 transition-all">✓ ACC</button>
                                <button onclick="openVerificationModal('organization', {{ $o->id }}, 'rejected')" class="px-2.5 py-1.5 text-[10px] font-bold uppercase rounded bg-red-500/10 text-red-400 hover:bg-red-500/20 border border-red-500/20 transition-all">✕ Tolak</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center text-gray-500">
                            <i class="fas fa-handshake-slash text-3xl mb-2 text-gray-700 block"></i>
                            <span class="text-xs">Tidak ada pengajuan kemitraan instansi/NGO baru.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Organizations: Approved -->
    <div id="org-approved" class="sub-tab-pane hidden">
        <div class="card-glass rounded-2xl overflow-hidden shadow-xl">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-white/[0.02] border-b border-white/5 text-[10px] uppercase tracking-wider text-gray-500 font-semibold text-left">
                        <th class="px-5 py-3.5">Nama Instansi / NGO</th>
                        <th class="px-5 py-3.5">Tipe</th>
                        <th class="px-5 py-3.5">Penanggung Jawab</th>
                        <th class="px-5 py-3.5">Status Kemitraan</th>
                        <th class="px-5 py-3.5">Sejak</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-gray-300">
                    @forelse($approvedOrgs as $o)
                    <tr class="hover:bg-white/[0.01] transition-colors">
                        <td class="px-5 py-4 font-bold text-white text-xs">{{ $o->organization_name }}</td>
                        <td class="px-5 py-4 text-xs text-gray-400">{{ $o->type }}</td>
                        <td class="px-5 py-4 text-xs text-gray-400">{{ $o->contact_person }}</td>
                        <td class="px-5 py-4">
                            <span class="text-[9px] font-extrabold px-2 py-0.5 rounded border border-emerald-500/20 bg-emerald-500/10 text-emerald-400">MITRA RESMI ACTIVE</span>
                        </td>
                        <td class="px-5 py-4 text-xs text-gray-500">{{ $o->updated_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-5 py-8 text-center text-gray-500 text-xs">Belum ada mitra instansi terdaftar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Organizations: Rejected -->
    <div id="org-rejected" class="sub-tab-pane hidden">
        <div class="card-glass rounded-2xl overflow-hidden shadow-xl">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-white/[0.02] border-b border-white/5 text-[10px] uppercase tracking-wider text-gray-500 font-semibold text-left">
                        <th class="px-5 py-3.5">Nama Instansi / NGO</th>
                        <th class="px-5 py-3.5">Tipe</th>
                        <th class="px-5 py-3.5">Alasan Penolakan</th>
                        <th class="px-5 py-3.5">Diperbarui</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-gray-300">
                    @forelse($rejectedOrgs as $o)
                    <tr class="hover:bg-white/[0.01] transition-colors">
                        <td class="px-5 py-4 font-bold text-white text-xs">{{ $o->organization_name }}</td>
                        <td class="px-5 py-4 text-xs text-gray-400">{{ $o->type }}</td>
                        <td class="px-5 py-4 text-xs text-red-400 italic">Legalitas akta / otorisasi instansi diragukan.</td>
                        <td class="px-5 py-4 text-xs text-gray-500">{{ $o->updated_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-5 py-8 text-center text-gray-500 text-xs">Tidak ada riwayat penolakan kemitraan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SHARED VERIFICATION FORM MODAL -->
<div id="verify-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm hidden">
    <div class="card-glass rounded-2xl w-full max-w-md overflow-hidden shadow-2xl border border-white/10 mx-4">
        <div class="px-6 py-4 border-b border-white/5 bg-white/[0.02] flex justify-between items-center">
            <h3 id="modal-title" class="font-bold text-white font-display text-base">Verifikasi Pengajuan</h3>
            <button onclick="closeVerificationModal()" class="text-gray-400 hover:text-white text-xl">&times;</button>
        </div>
        <form id="verify-form" method="POST" action="" class="p-6 space-y-4">
            @csrf
            <input type="hidden" id="action-input" name="action" value="">
            <div>
                <label class="text-[10px] uppercase font-bold text-gray-400 block mb-1.5">Catatan Kurator / Admin</label>
                <textarea name="notes" placeholder="Berikan catatan persetujuan/penolakan..." rows="4" class="w-full px-3 py-2 text-sm bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:border-yellow-500"></textarea>
            </div>
            <div class="flex justify-end gap-2 border-t border-white/5 pt-4">
                <button type="button" onclick="closeVerificationModal()" class="px-4 py-2 bg-white/5 hover:bg-white/10 text-gray-300 text-xs font-bold uppercase rounded-lg border border-white/10">Batal</button>
                <button id="submit-btn" type="submit" class="px-4 py-2 text-xs font-bold uppercase rounded-lg">Konfirmasi</button>
            </div>
        </form>
    </div>
</div>

<!-- Dynamic Verification Controls Scripts -->
<script>
    // Switches parent dashboard tabs (Reports vs Volunteers vs Organizations)
    function switchParentTab(tabId, el) {
        document.querySelectorAll('.parent-tab-pane').forEach(p => p.classList.add('hidden'));
        document.getElementById(tabId).classList.remove('hidden');

        document.querySelectorAll('.parent-tab-btn').forEach(btn => {
            btn.classList.remove('text-yellow-500', 'border-yellow-500');
            btn.classList.add('text-gray-400');
        });
        el.classList.add('text-yellow-500', 'border-yellow-500');
        el.classList.remove('text-gray-400');
    }

    // Switches sub tables tabs (Pending vs Approved vs Rejected)
    function switchSubTab(tabId, el, classSelector) {
        // Find sibling elements in sub tab
        const container = el.closest('.parent-tab-pane');
        container.querySelectorAll('.sub-tab-pane').forEach(pane => pane.classList.add('hidden'));
        container.querySelector('#' + tabId).classList.remove('hidden');

        container.querySelectorAll('.' + classSelector).forEach(btn => {
            btn.classList.remove('bg-yellow-500', 'text-black', 'shadow');
            btn.classList.add('text-gray-400');
        });
        el.classList.add('bg-yellow-500', 'text-black', 'shadow');
        el.classList.remove('text-gray-400');
    }

    // Opens shared action modals with dynamic routing
    function openVerificationModal(type, targetId, action) {
        const form = document.getElementById('verify-form');
        const actionInput = document.getElementById('action-input');
        const title = document.getElementById('modal-title');
        const submitBtn = document.getElementById('submit-btn');

        // Map endpoints
        if (type === 'report') {
            form.action = `/admin/laporan/${targetId}/verify`;
        } else if (type === 'volunteer') {
            form.action = `/admin/apply/volunteer/${targetId}/verify`;
        } else if (type === 'organization') {
            form.action = `/admin/apply/organization/${targetId}/verify`;
        }

        actionInput.value = action;

        // Custom titles and styles based on action selection
        const formattedType = type === 'report' ? 'Laporan Krisis' : (type === 'volunteer' ? 'Relawan' : 'Kemitraan NGO');
        const isApproved = action === 'Approved' || action === 'approved';

        if (isApproved) {
            title.textContent = `Setujui (ACC) ${formattedType}`;
            submitBtn.textContent = 'Approve / ACC';
            submitBtn.className = 'px-4 py-2 bg-green-500 hover:bg-green-400 text-black text-xs font-bold uppercase rounded-lg shadow-md';
        } else {
            title.textContent = `Tolak ${formattedType}`;
            submitBtn.textContent = 'Reject / Tolak';
            submitBtn.className = 'px-4 py-2 bg-red-500 hover:bg-red-400 text-white text-xs font-bold uppercase rounded-lg shadow-md';
        }

        document.getElementById('verify-modal').classList.remove('hidden');
    }

    function closeVerificationModal() {
        document.getElementById('verify-modal').classList.add('hidden');
    }
</script>
@endsection
