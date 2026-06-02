<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches), sidebarOpen: false }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — CrisisHub</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { font-family: 'Outfit', sans-serif; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #dc2626; border-radius: 3px; }
        
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
        }
        .dark .glass-panel {
            background: rgba(15, 23, 42, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
        }

        /* Dynamic input overrides to prevent contrast issues and ensure readability */
        input:not([type="checkbox"]):not([type="radio"]), select, textarea {
            background-color: rgba(255, 255, 255, 0.9) !important;
            color: #0f172a !important;
            border: 1px solid rgba(0, 0, 0, 0.1) !important;
            transition: all 0.3s ease;
        }
        .dark input:not([type="checkbox"]):not([type="radio"]), .dark select, .dark textarea {
            background-color: rgba(30, 41, 59, 0.8) !important;
            color: #e2e8f0 !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }
        input:not([type="checkbox"]):not([type="radio"]):focus, select:focus, textarea:focus {
            border-color: #dc2626 !important;
            outline: none !important;
            box-shadow: 0 0 10px rgba(220, 38, 38, 0.15) !important;
        }
        select option {
            background-color: #ffffff !important;
            color: #0f172a !important;
        }
        .dark select option {
            background-color: #1e293b !important;
            color: #e2e8f0 !important;
        }
        ::placeholder {
            color: #64748b !important;
            opacity: 0.8 !important;
        }
        .dark ::placeholder {
            color: #94a3b8 !important;
        }
    </style>
    @yield('head')
</head>
<body class="bg-slate-50 text-slate-900 dark:bg-[#0a0f1e] dark:text-slate-100 antialiased overflow-hidden flex h-screen transition-colors duration-300">

    <!-- Video & Particle Background -->
    <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
        <video autoplay loop muted playsinline class="absolute top-0 left-0 w-full h-full object-cover opacity-[0.05] dark:opacity-[0.15] mix-blend-multiply dark:mix-blend-screen">
            <source src="https://assets.mixkit.co/videos/preview/mixkit-abstract-technology-particle-loop-32819-large.mp4" type="video/mp4">
        </video>
        <!-- Overlay to ensure text readability -->
        <div class="absolute inset-0 bg-gradient-to-br from-slate-50/80 to-slate-100/90 dark:from-[#0a0f1e]/80 dark:to-[#0f172a]/95"></div>
    </div>

    <!-- Sidebar (Mobile Overlay) -->
    <div x-show="sidebarOpen" class="fixed inset-0 z-40 bg-slate-900/50 dark:bg-black/50 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 z-50 w-72 glass-panel border-r border-slate-200 dark:border-white/10 flex flex-col transform transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-auto" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        
        <!-- Logo -->
        <div class="flex items-center justify-between h-20 px-6 border-b border-slate-200 dark:border-white/10">
            <a href="/" class="flex items-center gap-3">
                <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-red-500 to-orange-600 rounded-xl">
                    <i class="fas fa-shield-alt text-white text-lg"></i>
                </div>
                <div>
                    <span class="text-xl font-bold text-slate-900 dark:text-white">Crisis<span class="text-red-600 dark:text-red-500">Hub</span></span>
                    <div class="text-[10px] uppercase font-bold tracking-widest text-slate-500 dark:text-slate-400">@yield('role', 'Dashboard')</div>
                </div>
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden text-slate-500 hover:text-red-500">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1.5 custom-scrollbar">
            <!-- Riwayat (Everyone gets this) -->
            <div class="mb-2 px-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Riwayat Saya</div>
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/5 font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 font-semibold' : '' }}">
                <i class="fas fa-history w-5 text-center"></i> Semua Riwayat
            </a>

            @role('Relawan')
            <a href="{{ route('center.volunteer') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/5 font-medium transition-colors {{ request()->routeIs('center.volunteer') ? 'bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 font-semibold' : '' }}">
                <i class="fas fa-hands-helping w-5 text-center text-blue-500"></i> Volunteer Center
            </a>
            @endrole

            @role('Organisasi Bantuan')
            <a href="{{ route('center.organization') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/5 font-medium transition-colors {{ request()->routeIs('center.organization') ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-semibold' : '' }}">
                <i class="fas fa-building w-5 text-center text-emerald-500"></i> Riwayat Organisasi
            </a>
            @endrole

            @role('Admin')
            <div class="mt-6 mb-2 px-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Akses Khusus</div>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/5 font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-semibold' : '' }}">
                <i class="fas fa-satellite-dish w-5 text-center text-indigo-500"></i> Admin Center
            </a>
            @endrole

        </nav>

        <!-- User Info / Bottom -->
        <div class="p-4 border-t border-slate-200 dark:border-white/10">
            <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-slate-300 to-slate-400 dark:from-slate-700 dark:to-slate-800 flex items-center justify-center text-slate-700 dark:text-white font-bold">
                    {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-900 dark:text-white truncate">{{ auth()->user()->name ?? 'User' }}</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ auth()->user()->email ?? 'user@example.com' }}</p>
                </div>
            </div>
            
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col min-w-0 overflow-hidden relative">
        <!-- Header -->
        <header class="h-20 glass-panel border-b border-slate-200 dark:border-white/10 flex items-center justify-between px-6 z-30">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="lg:hidden text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">@yield('page_title', 'Overview')</h1>
            </div>

            <div class="flex items-center gap-4">
                <!-- SOS Button for Citizen/Volunteer -->
                @yield('header_actions')

                <!-- Notifications -->
                <button class="relative w-10 h-10 rounded-full flex items-center justify-center text-slate-500 hover:bg-slate-200 dark:text-slate-400 dark:hover:bg-slate-800 transition-colors">
                    <i class="fas fa-bell"></i>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full animate-ping"></span>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>

                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode" class="w-10 h-10 rounded-full flex items-center justify-center text-slate-500 hover:bg-slate-200 dark:text-slate-400 dark:hover:bg-slate-800 transition-colors">
                    <i class="fas" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
                </button>
            </div>
        </header>

        <!-- Page Content -->
        <div class="flex-1 overflow-y-auto p-6 md:p-8 custom-scrollbar relative z-20">
            @yield('content')
        </div>
    </main>

    @yield('modals')
    @yield('scripts')
</body>
</html>
