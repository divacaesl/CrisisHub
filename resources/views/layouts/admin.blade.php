<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CrisisHub — Command Center</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --gold: #dc2626;
            --gold-dim: #991b1b;
            --bg-base: #f8fafc;
            --bg-card: #ffffff;
            --bg-card2: #f1f5f9;
            --border: rgba(0,0,0,0.07);
            --sidebar-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #475569;
            --header-bg: rgba(255, 255, 255, 0.85);
        }
        .dark {
            --gold: #E8C547;
            --gold-dim: #B89A2A;
            --bg-base: #0D0F0E;
            --bg-card: #141714;
            --bg-card2: #1A1E1B;
            --border: rgba(255,255,255,0.07);
            --sidebar-bg: #0B0E0C;
            --text-main: #e2e8f0;
            --text-muted: #94a3b8;
            --header-bg: rgba(13,15,14,0.85);
        }
        * { font-family: 'Inter', sans-serif; }
        h1,h2,h3,.font-display { font-family: 'Space Grotesk', sans-serif; }
        body { background: var(--bg-base); color: var(--text-main); transition: background 0.3s ease, color 0.3s ease; }
        
        .sidebar-scroll::-webkit-scrollbar { width: 3px; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(232,197,71,0.3); border-radius: 10px; }
        
        .gold-glow { box-shadow: 0 0 20px rgba(220, 38, 38, 0.15); }
        .dark .gold-glow { box-shadow: 0 0 20px rgba(232,197,71,0.15); }
        
        .active-nav { background: rgba(220,38,38,0.08); border: 1px solid rgba(220,38,38,0.25); color: #dc2626 !important; }
        .active-nav svg { color: #dc2626 !important; }
        
        .dark .active-nav { background: rgba(232,197,71,0.12); border: 1px solid rgba(232,197,71,0.25); color: #E8C547 !important; }
        .dark .active-nav svg { color: #E8C547 !important; }
        
        .card-glass {
            background: var(--bg-card);
            border: 1px solid var(--border);
            backdrop-filter: blur(10px);
            transition: border-color 0.2s ease, background-color 0.2s ease;
        }
        .card-glass:hover { border-color: rgba(220,38,38,0.25); }
        .dark .card-glass:hover { border-color: rgba(232,197,71,0.25); }
        
        .stat-card { transition: transform 0.2s, border-color 0.2s, background-color 0.2s; }
        .stat-card:hover { transform: translateY(-2px); border-color: rgba(220,38,38,0.3) !important; }
        .dark .stat-card:hover { border-color: rgba(232,197,71,0.3) !important; }
        
        /* Pulse animation */
        @keyframes pulse-gold {
            0%, 100% { box-shadow: 0 0 0 0 rgba(232,197,71,0.5); }
            50% { box-shadow: 0 0 0 6px rgba(232,197,71,0); }
        }
        .pulse-gold { animation: pulse-gold 2s infinite; }
        
        /* Scrollbar for main content */
        main::-webkit-scrollbar { width: 4px; }
        main::-webkit-scrollbar-track { background: transparent; }
        main::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
        
        /* Leaflet dark override */
        .dark .leaflet-tile-pane { filter: brightness(0.7) contrast(1.1); }

        /* Dynamic input overrides to prevent contrast issues and ensure readability */
        input:not([type="checkbox"]):not([type="radio"]), select, textarea {
            background-color: var(--bg-card) !important;
            color: var(--text-main) !important;
            border: 1px solid var(--border) !important;
        }
        input:not([type="checkbox"]):not([type="radio"]):focus, select:focus, textarea:focus {
            border-color: var(--gold) !important;
            outline: none !important;
            box-shadow: 0 0 10px rgba(220, 38, 38, 0.15) !important;
        }
        .dark input:not([type="checkbox"]):not([type="radio"]):focus, .dark select:focus, .dark textarea:focus {
            box-shadow: 0 0 10px rgba(232, 197, 71, 0.25) !important;
        }
        select option {
            background-color: var(--bg-card) !important;
            color: var(--text-main) !important;
        }
        ::placeholder {
            color: var(--text-muted) !important;
            opacity: 0.8 !important;
        }

        /* Sidebar Nav Item styling */
        .sidebar-nav-item {
            color: var(--text-muted) !important;
            transition: all 0.15s ease;
            border: 1px solid transparent;
        }
        .sidebar-nav-item:hover {
            color: var(--text-main) !important;
            background: rgba(220, 38, 38, 0.05) !important;
        }
        .dark .sidebar-nav-item:hover {
            background: rgba(255, 255, 255, 0.05) !important;
        }
        .sidebar-nav-item svg {
            color: var(--text-muted) !important;
            transition: all 0.15s ease;
        }
        .sidebar-nav-item:hover svg {
            color: var(--text-main) !important;
        }

        /* Smart Dynamic Light Theme Contrast Overrides */
        html:not(.dark) .text-white:not(.badge):not(.btn):not([class*="bg-red"]):not([class*="bg-green"]):not([class*="bg-blue"]):not([class*="bg-orange"]):not([class*="bg-teal"]):not([class*="bg-purple"]):not([class*="bg-indigo"]):not([class*="bg-emerald"]):not([class*="bg-amber"]):not([class*="bg-slate"]):not([class*="bg-gray"]) {
            color: var(--text-main) !important;
        }
        html:not(.dark) .text-gray-300:not(.badge):not(.btn):not([class*="bg-"]) {
            color: var(--text-muted) !important;
        }
        html:not(.dark) .text-gray-400:not(.badge):not(.btn):not([class*="bg-"]) {
            color: var(--text-muted) !important;
        }
        html:not(.dark) td {
            color: var(--text-main) !important;
        }
        html:not(.dark) th {
            color: var(--text-muted) !important;
        }
        html:not(.dark) h1, html:not(.dark) h2, html:not(.dark) h3, html:not(.dark) h4, html:not(.dark) h5, html:not(.dark) h6 {
            color: var(--text-main) !important;
        }
    </style>
</head>
<body class="text-slate-700 dark:text-gray-200 antialiased flex h-screen overflow-hidden" style="background: var(--bg-base);">

    <!-- Sidebar -->
    <aside class="w-64 flex flex-col h-full flex-shrink-0 z-20 border-r" style="background: var(--sidebar-bg); border-color: var(--border);">
        <!-- Logo -->
        <div class="px-5 py-5 flex items-center space-x-3 border-b" style="border-color: var(--border);">
            <img src="/images/logo.png" alt="CrisisHub Logo" class="w-9 h-9 rounded-full object-cover flex-shrink-0">
            <div>
                <h1 class="text-lg font-bold leading-tight font-display" style="color: var(--text-main);">CrisisHub</h1>
                <p class="text-[9px] tracking-widest uppercase" style="color: var(--gold);">Command Center</p>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-3 py-4 sidebar-scroll overflow-y-auto space-y-5 pb-32">
            <!-- Core -->
            <div>
                <div class="text-[9px] uppercase font-bold tracking-widest mb-2 px-3" style="color: rgba(232,197,71,0.5);">Core</div>
                <div class="space-y-0.5">
                    @php $pc = \App\Models\Report::where('status','Pending')->count(); @endphp
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg font-medium text-sm transition-all duration-150 {{ request()->routeIs('admin.dashboard') ? 'active-nav' : 'sidebar-nav-item' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span>Dashboard Overview</span>
                    </a>
                    <a href="{{ route('admin.peta') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg font-medium text-sm transition-all duration-150 {{ request()->routeIs('admin.peta') ? 'active-nav' : 'sidebar-nav-item' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                        <span>GIS Monitoring</span>
                    </a>
                    <a href="{{ route('admin.analitik') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg font-medium text-sm transition-all duration-150 {{ request()->routeIs('admin.analitik') ? 'active-nav' : 'sidebar-nav-item' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        <span>Analytics</span>
                    </a>
                </div>
            </div>

            <!-- Reports & Verification -->
            <div>
                <div class="text-[9px] uppercase font-bold tracking-widest mb-2 px-3" style="color: rgba(232,197,71,0.5);">Laporan</div>
                <div class="space-y-0.5">
                    <a href="{{ route('admin.laporan') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg font-medium text-sm transition-all duration-150 {{ request()->routeIs('admin.laporan') ? 'active-nav' : 'sidebar-nav-item' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span>Disaster Reports</span>
                    </a>
                    <a href="{{ route('admin.verifikasi') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg font-medium text-sm transition-all duration-150 {{ request()->routeIs('admin.verifikasi') ? 'active-nav' : 'sidebar-nav-item' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Verification Center</span>
                        @if($pc > 0)<span class="ml-auto text-[9px] font-bold px-1.5 py-0.5 rounded-full text-black" style="background:var(--gold);">{{ $pc }}</span>@endif
                    </a>
                    <a href="{{ route('admin.kebutuhan') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg font-medium text-sm transition-all duration-150 {{ request()->routeIs('admin.kebutuhan') ? 'active-nav' : 'sidebar-nav-item' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        <span>Aid Distribution</span>
                    </a>
                </div>
            </div>

            <!-- People -->
            <div>
                <div class="text-[9px] uppercase font-bold tracking-widest mb-2 px-3" style="color: rgba(232,197,71,0.5);">People</div>
                <div class="space-y-0.5">
                    <a href="{{ route('admin.relawan') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg font-medium text-sm transition-all duration-150 {{ request()->routeIs('admin.relawan') ? 'active-nav' : 'sidebar-nav-item' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span>Volunteer Management</span>
                    </a>
                    <a href="{{ route('admin.penugasan') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg font-medium text-sm transition-all duration-150 {{ request()->routeIs('admin.penugasan') ? 'active-nav' : 'sidebar-nav-item' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        <span>Assignment</span>
                    </a>
                    <a href="{{ route('admin.pengguna') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg font-medium text-sm transition-all duration-150 {{ request()->routeIs('admin.pengguna') ? 'active-nav' : 'sidebar-nav-item' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>User Management</span>
                    </a>
                    <a href="{{ route('admin.roles') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg font-medium text-sm transition-all duration-150 {{ request()->routeIs('admin.roles') ? 'active-nav' : 'sidebar-nav-item' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                        <span>Role Management</span>
                    </a>
                </div>
            </div>

            <!-- Finance -->
            <div>
                <div class="text-[9px] uppercase font-bold tracking-widest mb-2 px-3" style="color: rgba(232,197,71,0.5);">Finance</div>
                <div class="space-y-0.5">
                    <a href="{{ route('admin.donasi') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg font-medium text-sm transition-all duration-150 {{ request()->routeIs('admin.donasi') ? 'active-nav' : 'sidebar-nav-item' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Donation Management</span>
                    </a>
                    <a href="{{ route('admin.campaign') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg font-medium text-sm transition-all duration-150 {{ request()->routeIs('admin.campaign') ? 'active-nav' : 'sidebar-nav-item' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                        <span>Campaign Management</span>
                    </a>
                </div>
            </div>

            <!-- System -->
            <div>
                <div class="text-[9px] uppercase font-bold tracking-widest mb-2 px-3" style="color: rgba(232,197,71,0.5);">System</div>
                <div class="space-y-0.5">
                    <a href="{{ route('admin.notifikasi') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg font-medium text-sm transition-all duration-150 {{ request()->routeIs('admin.notifikasi') ? 'active-nav' : 'sidebar-nav-item' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span>Emergency Broadcast</span>
                    </a>
                    <a href="{{ route('admin.pengaturan') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg font-medium text-sm transition-all duration-150 {{ request()->routeIs('admin.pengaturan') ? 'active-nav' : 'sidebar-nav-item' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>System Settings</span>
                    </a>
                </div>
            </div>

        <!-- Sidebar Bottom: SOS + User -->

        <div class="p-4 space-y-3 border-t" style="border-color: var(--border);">
            <!-- SOS Button -->
            <button class="w-full flex items-center space-x-3 p-3 rounded-xl transition-all text-left group" style="background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.25);">
                <div class="w-8 h-8 rounded-lg bg-red-500 flex items-center justify-center flex-shrink-0 pulse-gold">
                    <span class="text-[10px] font-black text-white">SOS</span>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-xs font-bold text-red-400">Darurat Sekarang</div>
                    <div class="text-[9px] text-gray-500">Kirim sinyal bantuan</div>
                </div>
                <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <!-- User -->
            <div class="relative group cursor-pointer">
                <div class="flex items-center space-x-3 p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-white/5 transition-all">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=E8C547&color=000&bold=true" class="w-8 h-8 rounded-full flex-shrink-0">
                    <div class="flex-1 min-w-0">
                        <div class="text-xs font-bold text-slate-800 dark:text-white truncate">{{ auth()->user()->name ?? 'Admin' }}</div>
                        <div class="text-[9px] text-slate-500 dark:text-gray-500">{{ auth()->user()->roles->pluck('name')->first() ?? 'Super Admin' }}</div>
                    </div>
                    <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
                <!-- Dropdown -->
                <div class="absolute bottom-full left-0 right-0 mb-1 rounded-xl overflow-hidden opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50" style="background: var(--bg-card2); border: 1px solid var(--border);">
                    <a href="{{ route('dashboard') }}" class="w-full flex items-center space-x-3 px-4 py-2.5 text-xs text-slate-700 dark:text-gray-300 hover:bg-slate-100 dark:hover:bg-white/5 transition-colors font-semibold border-b border-slate-200 dark:border-white/5">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span>Dashboard Utama</span>
                    </a>
                    <a href="{{ route('home') }}" class="w-full flex items-center space-x-3 px-4 py-2.5 text-xs text-slate-700 dark:text-gray-300 hover:bg-slate-100 dark:hover:bg-white/5 transition-colors font-semibold border-b border-slate-200 dark:border-white/5">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                        <span>Website Utama</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center space-x-3 px-4 py-2.5 text-xs text-red-400 hover:bg-red-500/10 transition-colors font-semibold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            <span>Keluar (Logout)</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        <!-- Topbar -->
        <header class="flex items-center justify-between px-7 py-4 z-10 shrink-0 border-b" style="background: var(--header-bg); border-color: var(--border); backdrop-filter: blur(10px); transition: background-color 0.3s ease, border-color 0.3s ease;">
            <!-- Left: Breadcrumb -->
            <div>
                <h2 class="text-base font-bold font-display" style="color: var(--text-main);">
                    @if(request()->routeIs('admin.dashboard')) 🏠 Dashboard
                    @elseif(request()->routeIs('admin.peta')) 🗺️ Peta Bencana
                    @elseif(request()->routeIs('admin.laporan')) 📋 Laporan Bencana
                    @elseif(request()->routeIs('admin.kebutuhan')) ❤️ Kebutuhan
                    @elseif(request()->routeIs('admin.donasi')) 💰 Donasi
                    @elseif(request()->routeIs('admin.relawan')) 👥 Relawan
                    @elseif(request()->routeIs('admin.penugasan')) 📌 Penugasan
                    @elseif(request()->routeIs('admin.notifikasi')) 🔔 Notifikasi
                    @else ⚙️ Sistem
                    @endif
                </h2>
                <p class="text-[10px] text-gray-500 mt-0.5">{{ now()->translatedFormat('l, d F Y • H:i') }} WIB</p>
            </div>

            <!-- Right -->
            <div class="flex items-center space-x-3">
                <!-- Link to Main Website -->
                <a href="{{ route('home') }}" class="hidden md:flex items-center space-x-2 px-3 py-1.5 rounded-lg border border-slate-200 dark:border-white/10 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors text-xs font-semibold text-slate-600 dark:text-gray-300">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    <span>Web Utama</span>
                </a>

                <!-- Live Indicator -->
                <div class="flex items-center space-x-2 px-3 py-1.5 rounded-full" style="background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.2);">
                    <span class="relative flex h-1.5 w-1.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-green-500"></span>
                    </span>
                    <span class="text-[9px] font-bold text-green-400 tracking-widest uppercase">Live</span>
                </div>

                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode" class="p-2 rounded-lg hover:bg-slate-200/50 dark:hover:bg-white/5 transition-colors text-gray-400 dark:hover:text-white" title="Ganti Tema">
                    <template x-if="darkMode">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.364l-.707-.707M12 5a7 7 0 100 14 7 7 0 000-14z"></path></svg>
                    </template>
                    <template x-if="!darkMode">
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    </template>
                </button>

                <!-- Notification Bell -->
                <button class="relative p-2 rounded-lg hover:bg-slate-200/50 dark:hover:bg-white/5 transition-colors text-gray-400 dark:hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="absolute top-1 right-1 w-2 h-2 rounded-full text-black text-[7px] font-black flex items-center justify-center" style="background: var(--gold);"></span>
                </button>

                <!-- Divider -->
                <div class="h-6 w-px" style="background: var(--border);"></div>

                <!-- Profile Dropdown -->
                <div class="relative group cursor-pointer">
                    <div class="flex items-center space-x-2.5">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=dc2626&color=fff&bold=true" class="w-8 h-8 rounded-full">
                        <div class="hidden md:block">
                            <div class="text-xs font-bold truncate" style="color: var(--text-main);">{{ auth()->user()->name ?? 'Admin' }}</div>
                            <div class="text-[9px]" style="color: var(--text-muted);">{{ auth()->user()->roles->pluck('name')->first() ?? 'Admin' }}</div>
                        </div>
                        <svg class="w-3.5 h-3.5" style="color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="absolute right-0 top-full mt-2 w-48 rounded-xl overflow-hidden opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 animate-fade-in" style="background: var(--bg-card2); border: 1px solid var(--border);">
                        <a href="{{ route('dashboard') }}" class="w-full flex items-center space-x-3 px-4 py-2.5 text-xs text-gray-300 hover:bg-white/5 transition-colors font-semibold border-b border-white/5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            <span>Dashboard Utama</span>
                        </a>
                        <a href="{{ route('home') }}" class="w-full flex items-center space-x-3 px-4 py-2.5 text-xs text-gray-300 hover:bg-white/5 transition-colors font-semibold border-b border-white/5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                            <span>Website Utama</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center space-x-3 px-4 py-2.5 text-xs text-red-400 hover:bg-red-500/10 transition-colors font-semibold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                <span>Keluar (Logout)</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto">
            <div class="px-7 py-6 max-w-[1800px] mx-auto">
                @yield('content')
            </div>
        </main>

        <!-- Status Footer Bar -->
        <footer class="px-7 py-3 shrink-0 border-t flex items-center justify-between" style="background: var(--bg-card); border-color: var(--border);">
            <div class="flex items-center space-x-6 text-[10px]">
                <div class="flex items-center space-x-1.5 text-green-400">
                    <div class="w-1.5 h-1.5 rounded-full bg-green-400"></div>
                    <span class="font-semibold">Sistem Aman</span>
                </div>
                <div class="flex items-center space-x-1.5 text-gray-500">
                    <div class="w-1.5 h-1.5 rounded-full bg-green-400"></div>
                    <span>Server Online · Uptime 99.9%</span>
                </div>
                <div class="hidden md:flex items-center space-x-1.5 text-gray-500">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Resp. Rata-rata: 12ms</span>
                </div>
            </div>
            <div class="text-[10px] text-gray-600">© 2025 CrisisHub · Tanggap, Peduli, Selamatkan</div>
        </footer>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    @stack('scripts')
</body>
</html>
