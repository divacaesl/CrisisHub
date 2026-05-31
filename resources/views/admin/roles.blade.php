@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-white font-display">Role Management</h2>
    <p class="text-xs text-gray-400 mt-1">Daftar hak akses dan jumlah pengguna per peran di ekosistem CrisisHub.</p>
</div>

<!-- Role Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-10">
    @foreach($roles as $role)
    @php
        $userCount = $usersByRole[$role->name] ?? 0;
        $color = 'yellow';
        $icon = '🛡️';
        if ($role->name === 'Admin') {
            $color = 'red';
            $icon = '👑';
        } elseif ($role->name === 'Relawan') {
            $color = 'green';
            $icon = '⛑️';
        } elseif ($role->name === 'Organisasi Bantuan') {
            $color = 'indigo';
            $icon = '🏢';
        }
    @endphp
    <div class="card-glass rounded-2xl p-5 hover:scale-[1.01] transition-all duration-300 flex flex-col justify-between h-64">
        <div>
            <!-- Header -->
            <div class="flex justify-between items-center mb-4">
                <span class="text-2xl">{{ $icon }}</span>
                <span class="text-[9px] font-extrabold uppercase tracking-widest px-2.5 py-1 rounded bg-white/5 border border-white/10 text-gray-400">
                    ID: #{{ $role->id }}
                </span>
            </div>
            
            <h4 class="text-lg font-black text-white font-display">{{ $role->name }}</h4>
            <div class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mt-1 mb-3">Guard: {{ $role->guard_name }}</div>
            
            <!-- Permissions Snippet -->
            <div class="text-[11px] text-gray-400 leading-relaxed line-clamp-3">
                @if($role->name === 'Admin')
                    Akses penuh di seluruh sistem, verifikasi laporan krisis, penugasan relawan, pengelolaan donasi, dan broadcast darurat.
                @elseif($role->name === 'Relawan')
                    Akses ke relawan center, pelaporan posisi GPS real-time, penerimaan tugas penyelamatan bencana, dan update log korban.
                @elseif($role->name === 'Organisasi Bantuan')
                    Akses ke pusat bantuan organisasi, pendataan logistik bantuan, manajemen relawan internal, dan penyaluran barang.
                @else
                    Akses dasar warga negara, pelaporan bencana krisis dasar, pengajuan donasi, dan penerimaan notifikasi darurat.
                @endif
            </div>
        </div>
        
        <!-- User Count -->
        <div class="flex justify-between items-center pt-3 border-t border-white/5 mt-4">
            <span class="text-xs text-gray-500 font-bold uppercase tracking-wider">Active Users</span>
            <span class="font-extrabold text-white text-base font-display">{{ number_format($userCount) }} <span class="text-xs text-gray-500 font-normal">Jiwa</span></span>
        </div>
    </div>
    @endforeach
</div>

<!-- Extra Permission Matrix Info -->
<div class="card-glass rounded-2xl p-6">
    <h3 class="text-base font-bold text-white font-display mb-4 flex items-center gap-2">
        <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        Spatie Permission Security Policy
    </h3>
    <div class="text-xs text-gray-400 leading-relaxed space-y-2">
        <p>CrisisHub menggunakan sistem RBAC (Role-Based Access Control) berbasis Spatie Laravel Permission. Seluruh aksi dikendalikan secara ketat lewat middleware:</p>
        <ul class="list-disc pl-5 space-y-1">
            <li><code class="text-yellow-400 font-mono text-[11px]">role:Admin</code>: Berhak mengakses dashboard command center & control room.</li>
            <li><code class="text-yellow-400 font-mono text-[11px]">role:Relawan</code>: Berhak mengakses posko virtual relawan & penugasan lapangan.</li>
            <li><code class="text-yellow-400 font-mono text-[11px]">role:Organisasi Bantuan</code>: Berhak mengelola kampanye mandiri dan logistik.</li>
        </ul>
    </div>
</div>
@endsection
