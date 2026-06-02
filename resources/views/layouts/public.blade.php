<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CrisisHub') — Platform Manajemen Bencana Indonesia</title>
    <meta name="description" content="@yield('description', 'CrisisHub adalah platform digital terpadu untuk pelaporan bencana, koordinasi relawan, distribusi bantuan, dan donasi transparan di Indonesia.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { font-family: 'Outfit', sans-serif; }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        .dark ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #dc2626; border-radius: 3px; }

        /* Premium Ambient Aura Backdrop */
        .premium-ambient-aura {
            position: fixed;
            inset: 0;
            z-index: -2;
            pointer-events: none;
            overflow: hidden;
            background: #f8fafc;
            transition: background 0.5s ease;
        }
        .dark .premium-ambient-aura {
            background: #0f172a;
        }
        .premium-ambient-aura::before,
        .premium-ambient-aura::after {
            content: '';
            position: absolute;
            width: 700px;
            height: 700px;
            border-radius: 50%;
            filter: blur(140px);
            opacity: 0.45;
            mix-blend-mode: multiply;
            animation: ambientFloat 25s infinite ease-in-out;
            transition: background 0.5s ease, opacity 0.5s ease;
        }
        .dark .premium-ambient-aura::before,
        .dark .premium-ambient-aura::after {
            mix-blend-mode: screen;
            opacity: 0.18;
        }
        
        .premium-ambient-aura::before {
            background: radial-gradient(circle, #ffe4e6 0%, transparent 70%); /* Rose blush in light */
            top: -10%;
            left: -10%;
        }
        .dark .premium-ambient-aura::before {
            background: radial-gradient(circle, #991b1b 0%, transparent 70%); /* Deep red in dark */
        }
        
        .premium-ambient-aura::after {
            background: radial-gradient(circle, #ffedd5 0%, transparent 70%); /* Amber blush in light */
            bottom: -10%;
            right: -10%;
            animation-delay: -12s;
        }
        .dark .premium-ambient-aura::after {
            background: radial-gradient(circle, #431407 0%, transparent 70%); /* Deep orange in dark */
        }
        
        @keyframes ambientFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(120px, 60px) scale(1.15); }
        }

        /* Dynamic Hero Transitions */
        .hero-dynamic {
            transition: background 0.5s ease, color 0.5s ease;
        }
        
        /* Specialized Page Gradients */
        .hero-home {
            background: linear-gradient(135deg, #f8fafc 0%, #fff1f2 40%, #f8fafc 70%, #f1f5f9 100%);
        }
        .dark .hero-home {
            background: linear-gradient(135deg, #0f172a 0%, #1e0000 40%, #0f172a 70%, #0a0f1e 100%);
        }
        
        .hero-volunteer {
            background: linear-gradient(135deg, #f8fafc 0%, #dcfce7 40%, #f1f5f9 100%);
        }
        .dark .hero-volunteer {
            background: linear-gradient(135deg, #0f172a 0%, #052e16 40%, #0f172a 100%);
        }
        
        .hero-donate {
            background: linear-gradient(135deg, #f8fafc 0%, #ffedd5 40%, #fee2e2 70%, #f1f5f9 100%);
        }
        .dark .hero-donate {
            background: linear-gradient(135deg, #0f172a 0%, #1a0000 40%, #431407 70%, #0f172a 100%);
        }
        
        .hero-contact {
            background: linear-gradient(135deg, #f8fafc 0%, #dbeafe 50%, #f1f5f9 100%);
        }
        .dark .hero-contact {
            background: linear-gradient(135deg, #0f172a 0%, #0c1a35 50%, #0f172a 100%);
        }
        
        .hero-about {
            background: linear-gradient(135deg, #f8fafc 0%, #fee2e2 50%, #f1f5f9 100%);
        }
        .dark .hero-about {
            background: linear-gradient(135deg, #0f172a 0%, #1e0000 50%, #0f172a 100%);
        }

        /* Dynamic slate-to-gray Premium Footer */
        .footer-dynamic {
            background: linear-gradient(to bottom, #f1f5f9 0%, #e2e8f0 100%) !important;
            border-top: 1px solid rgba(0,0,0,0.06) !important;
            transition: background 0.5s ease, border-color 0.5s ease;
        }
        .dark .footer-dynamic {
            background: #080e1a !important;
            border-top: 1px solid rgba(255,255,255,0.05) !important;
        }

        /* Dynamic Payment Modal Backdrop & Border */
        .premium-modal {
            background: linear-gradient(160deg, #ffffff 0%, #fff7ed 60%, #fff1f2 100%) !important;
            border: 1px solid rgba(220, 38, 38, 0.15) !important;
        }
        .dark .premium-modal {
            background: linear-gradient(160deg, #0f172a 0%, #1a0a0a 60%, #1e1020 100%) !important;
            border: 1px solid rgba(249, 115, 22, 0.25) !important;
        }

        /* Premium Glassmorphic Sparkle Refraction */
        .premium-sparkle-glass {
            position: relative;
            background: rgba(255, 255, 255, 0.65) !important;
            backdrop-filter: blur(25px) !important;
            border: 1px solid rgba(255, 255, 255, 0.6) !important;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.03), 
                        inset 0 1px 0 rgba(255, 255, 255, 0.8),
                        inset 0 -1px 0 rgba(0, 0, 0, 0.02) !important;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .dark .premium-sparkle-glass {
            background: rgba(15, 23, 42, 0.65) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.45), 
                        inset 0 1px 0 rgba(255, 255, 255, 0.1),
                        inset 0 -1px 0 rgba(0, 0, 0, 0.4) !important;
        }
        .premium-sparkle-glass:hover {
            border-color: rgba(220, 38, 38, 0.25) !important;
            box-shadow: 0 20px 50px rgba(220, 38, 38, 0.08), 
                        inset 0 1px 0 rgba(255, 255, 255, 0.9) !important;
            transform: translateY(-4px);
        }
        .dark .premium-sparkle-glass:hover {
            border-color: rgba(239, 68, 68, 0.35) !important;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6), 
                        0 0 30px rgba(239, 68, 68, 0.15),
                        inset 0 1px 0 rgba(255, 255, 255, 0.15) !important;
        }

        /* Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.02);
            transition: all 0.3s ease;
        }
        .dark .glass {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
        }
        .glass-light {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 0, 0, 0.08);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
        }
        .dark .glass-light {
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #ef4444, #f97316, #fbbf24);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .gradient-text-blue {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Animated gradient bg */
        .hero-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 30%, #0f172a 60%, #1a0000 100%);
            background-size: 400% 400%;
            animation: gradientShift 8s ease infinite;
        }
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Pulse ring animation */
        .pulse-ring {
            animation: pulseRing 2s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
        }
        @keyframes pulseRing {
            0% { transform: scale(0.8); opacity: 1; }
            80%, 100% { transform: scale(2.2); opacity: 0; }
        }

        /* Counter animation */
        .count-up { transition: all 1s ease; }

        /* Card hover */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 25px 50px rgba(220, 38, 38, 0.2);
        }

        /* Navbar scroll effect */
        .navbar-scrolled {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px);
            box-shadow: 0 4px 30px rgba(0,0,0,0.05);
        }
        .dark .navbar-scrolled {
            background: rgba(15, 23, 42, 0.98) !important;
            box-shadow: 0 4px 30px rgba(0,0,0,0.5);
        }

        /* Progress bar */
        .progress-bar {
            background: linear-gradient(90deg, #dc2626, #f97316);
            border-radius: 99px;
            transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Glow effects */
        .glow-red { box-shadow: 0 0 20px rgba(220, 38, 38, 0.4); }
        .glow-orange { box-shadow: 0 0 20px rgba(249, 115, 22, 0.4); }
        .glow-blue { box-shadow: 0 0 20px rgba(59, 130, 246, 0.4); }

        /* Step connector */
        .step-line::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, #dc2626, transparent);
        }

        /* Badge */
        .badge-urgent {
            background: linear-gradient(135deg, #dc2626, #7f1d1d);
            animation: badgePulse 1.5s ease-in-out infinite;
        }
        @keyframes badgePulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        /* Map styling */
        #disaster-map { border-radius: 16px; }
        .leaflet-popup-content-wrapper {
            background: #1e293b;
            color: #e2e8f0;
            border: 1px solid rgba(220, 38, 38, 0.3);
        }
        .leaflet-popup-tip { background: #1e293b; }

        /* Floating particles */
        .particle {
            position: absolute;
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
            pointer-events: none;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); opacity: 0.3; }
            50% { transform: translateY(-20px); opacity: 0.7; }
        }

        /* Section fade in */
        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Custom checkbox / radio */
        .custom-radio {
            appearance: none;
            width: 18px; height: 18px;
            border: 2px solid #475569;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s;
        }
        .custom-radio:checked {
            border-color: #dc2626;
            background: #dc2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.2);
        }

        /* Tabs */
        .tab-btn.active {
            background: linear-gradient(135deg, #dc2626, #f97316);
            color: white;
        }

        /* SOS Button */
        .sos-btn {
            background: linear-gradient(135deg, #dc2626, #991b1b);
            animation: sosPulse 2s ease-in-out infinite;
        }
        @keyframes sosPulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.7); }
            70% { box-shadow: 0 0 0 20px rgba(220, 38, 38, 0); }
        }

        /* Timeline */
        .timeline-dot::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 100%;
            transform: translateX(-50%);
            width: 2px;
            height: 40px;
            background: linear-gradient(to bottom, #dc2626, transparent);
        }

        /* Input styles */
        .form-input {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: #0f172a;
            border-radius: 10px;
            padding: 12px 16px;
            width: 100%;
            transition: all 0.3s;
            outline: none;
        }
        .dark .form-input {
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid rgba(71, 85, 105, 0.5);
            color: #e2e8f0;
        }
        .form-input:focus {
            border-color: #dc2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15);
        }
        .form-input::placeholder { color: #64748b; }
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #475569;
            margin-bottom: 6px;
            transition: color 0.3s;
        }
        .dark .form-label {
            color: #94a3b8;
        }
        .form-select {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: #0f172a;
            border-radius: 10px;
            padding: 12px 16px;
            width: 100%;
            transition: all 0.3s;
            outline: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23475569' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
        }
        .dark .form-select {
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid rgba(71, 85, 105, 0.5);
            color: #e2e8f0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2394a3b8' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        }
        .form-select:focus { border-color: #dc2626; box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15); }

        /* FAQ accordion */
        .faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.4s ease; }
        .faq-answer.open { max-height: 300px; }
        .faq-item.open .faq-icon { transform: rotate(45deg); }
        .faq-icon { transition: transform 0.3s ease; }

        /* News card image */
        .news-img { transition: transform 0.5s ease; }
        .news-card:hover .news-img { transform: scale(1.08); }

        /* Shimmer Sweep Effect */
        @keyframes shimmerSweep {
            0% { left: -150%; }
            50% { left: -150%; }
            100% { left: 150%; }
        }
        .shimmer-btn {
            position: relative;
            overflow: hidden;
        }
        .shimmer-btn::after {
            content: '';
            position: absolute;
            top: 0;
            left: -150%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.45) 50%, rgba(255,255,255,0) 100%);
            transform: skewX(-25deg);
            animation: shimmerSweep 4.5s ease-in-out infinite;
            pointer-events: none;
        }

        /* Premium card glow */
        .premium-card-glow {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(0, 0, 0, 0.06) !important;
        }
        .dark .premium-card-glow {
            border: 1px solid rgba(255, 255, 255, 0.07) !important;
        }
        .premium-card-glow:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
            border-color: rgba(220, 38, 38, 0.15) !important;
        }
        .dark .premium-card-glow:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            border-color: rgba(239, 68, 68, 0.25) !important;
        }

        /* Smart Dynamic Light Theme Contrast Overrides for Public Pages */
        html:not(.dark) *:not(.dark-content):not(.dark-content *) > .text-white:not(.badge):not(.btn):not([class*="bg-"]):not([class*="btn-"]):not(.badge-urgent):not(.sos-btn) {
            color: #0f172a !important;
        }
        html:not(.dark) *:not(.dark-content):not(.dark-content *) > .text-slate-300:not(.badge):not(.btn):not([class*="bg-"]) {
            color: #334155 !important;
        }
        html:not(.dark) *:not(.dark-content):not(.dark-content *) > .text-slate-400:not(.badge):not(.btn):not([class*="bg-"]) {
            color: #475569 !important;
        }
        html:not(.dark) *:not(.dark-content):not(.dark-content *) > .text-slate-500:not(.badge):not(.btn):not([class*="bg-"]) {
            color: #64748b !important;
        }
        html:not(.dark) .hero-dynamic h1,
        html:not(.dark) .hero-dynamic h2,
        html:not(.dark) .hero-dynamic h3 {
            color: #0f172a !important;
        }
        html:not(.dark) .hero-dynamic p,
        html:not(.dark) .hero-dynamic span:not(.badge):not(.btn):not([class*="bg-"]) {
            color: #334155 !important;
        }
        html:not(.dark) .hero-dynamic .text-green-400 {
            color: #15803d !important;
        }
        html:not(.dark) .hero-dynamic .text-orange-400 {
            color: #c2410c !important;
        }
        html:not(.dark) .hero-dynamic .text-blue-400 {
            color: #1d4ed8 !important;
        }
        html:not(.dark) .hero-dynamic .text-red-400 {
            color: #b91c1c !important;
        }
        
        /* Light mode dynamic input validation labels */
        html:not(.dark) .form-label {
            color: #334155 !important;
        }
        html:not(.dark) .form-input::placeholder,
        html:not(.dark) .form-select::placeholder,
        html:not(.dark) textarea::placeholder {
            color: #94a3b8 !important;
        }
    </style>

    @yield('head')
</head>
<body class="bg-slate-50 text-slate-900 dark:bg-[#0f172a] dark:text-slate-100 antialiased transition-colors duration-300">

    <!-- Premium Ambient Aura & Video Particle Background -->
    <div class="premium-ambient-aura"></div>
    <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
        <video autoplay loop muted playsinline class="absolute top-0 left-0 w-full h-full object-cover opacity-[0.03] dark:opacity-[0.12] mix-blend-multiply dark:mix-blend-screen">
            <source src="https://assets.mixkit.co/videos/preview/mixkit-abstract-technology-particle-loop-32819-large.mp4" type="video/mp4">
        </video>
    </div>

    <!-- Navbar -->
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-18 py-4">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-3 group">
                    <div class="relative w-10 h-10">
                        <div class="absolute inset-0 bg-red-600 rounded-xl rotate-12 group-hover:rotate-0 transition-transform duration-300"></div>
                        <div class="relative flex items-center justify-center w-10 h-10 bg-gradient-to-br from-red-500 to-orange-600 rounded-xl">
                            <i class="fas fa-shield-alt text-white text-lg"></i>
                        </div>
                    </div>
                    <div>
                        <span class="text-xl font-bold text-slate-900 dark:text-white">Crisis<span class="text-red-600 dark:text-red-500">Hub</span></span>
                        <div class="text-xs text-slate-500 dark:text-slate-400 leading-none -mt-0.5">Tanggap Bencana</div>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-1">
                    <a href="/" class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-red-600 dark:hover:text-white hover:bg-slate-200/50 dark:hover:bg-white/10 transition-all duration-200 {{ request()->is('/') ? 'text-red-600 dark:text-white bg-slate-200/50 dark:bg-white/10' : '' }}">
                        <i class="fas fa-home mr-1.5"></i>Beranda
                    </a>
                    <a href="/about" class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-red-600 dark:hover:text-white hover:bg-slate-200/50 dark:hover:bg-white/10 transition-all duration-200 {{ request()->is('about') ? 'text-red-600 dark:text-white bg-slate-200/50 dark:bg-white/10' : '' }}">
                        <i class="fas fa-info-circle mr-1.5"></i>Tentang
                    </a>
                    <a href="/peta-bencana" class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-red-600 dark:hover:text-white hover:bg-slate-200/50 dark:hover:bg-white/10 transition-all duration-200">
                        <i class="fas fa-map-marked-alt mr-1.5"></i>Peta Bencana
                    </a>
                    <a href="/volunteer" class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-red-600 dark:hover:text-white hover:bg-slate-200/50 dark:hover:bg-white/10 transition-all duration-200 {{ request()->is('volunteer') ? 'text-red-600 dark:text-white bg-slate-200/50 dark:bg-white/10' : '' }}">
                        <i class="fas fa-hands-helping mr-1.5"></i>Relawan
                    </a>
                    <a href="/donate" class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-red-600 dark:hover:text-white hover:bg-slate-200/50 dark:hover:bg-white/10 transition-all duration-200 {{ request()->is('donate') ? 'text-red-600 dark:text-white bg-slate-200/50 dark:bg-white/10' : '' }}">
                        <i class="fas fa-heart mr-1.5"></i>Donasi
                    </a>
                    <a href="/contact" class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-red-600 dark:hover:text-white hover:bg-slate-200/50 dark:hover:bg-white/10 transition-all duration-200 {{ request()->is('contact') ? 'text-red-600 dark:text-white bg-slate-200/50 dark:bg-white/10' : '' }}">
                        <i class="fas fa-phone mr-1.5"></i>Kontak
                    </a>
                </div>

                <!-- Right CTA -->
                <div class="hidden md:flex items-center gap-3">
                    <!-- Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode" class="w-10 h-10 rounded-full flex items-center justify-center text-slate-500 hover:bg-slate-200 dark:text-slate-400 dark:hover:bg-slate-800 transition-colors duration-200">
                        <i class="fas" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
                    </button>

                    <a href="/report" class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white text-sm font-semibold rounded-xl transition-all duration-200 glow-red shadow-lg">
                        <i class="fas fa-exclamation-triangle"></i>
                        Laporkan
                    </a>
                    @auth
                        @php
                            $userRoles = auth()->user()->roles->pluck('name')->implode(', ');
                            $roleDisplay = $userRoles ?: 'Pengguna';
                        @endphp
                        <div class="relative group">
                            <button class="flex items-center gap-2 px-4 py-2 border border-slate-300 dark:border-slate-600 hover:border-slate-400 text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white text-sm font-medium rounded-xl transition-all duration-200">
                                <i class="fas fa-user-circle"></i>
                                <span class="hidden sm:inline">{{ auth()->user()->name }} ({{ $roleDisplay }})</span>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-100 dark:border-slate-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <div class="py-1">
                                    @if(auth()->user()->hasRole('Admin'))
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700">Admin Dashboard</a>
                                    @endif
                                    <a href="{{ url('/dashboard') }}" class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700">
                                        <i class="fas fa-history mr-1.5"></i> Riwayat
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-slate-100 dark:hover:bg-slate-700">
                                            <i class="fas fa-sign-out-alt mr-1.5"></i> Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 border border-slate-300 dark:border-slate-600 hover:border-slate-400 text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white text-sm font-medium rounded-xl transition-all duration-200">
                            Masuk
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu btn -->
                <button id="mobileMenuBtn" class="md:hidden p-2 rounded-lg text-slate-300 hover:text-white hover:bg-white/10 transition-all">
                    <i class="fas fa-bars text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden glass border-t border-white/10">
            <div class="px-4 py-4 space-y-2">
                <a href="/" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/10 transition-all">
                    <i class="fas fa-home w-5"></i>Beranda
                </a>
                <a href="/about" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/10 transition-all">
                    <i class="fas fa-info-circle w-5"></i>Tentang
                </a>
                <a href="/peta-bencana" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/10 transition-all">
                    <i class="fas fa-map-marked-alt w-5"></i>Peta Bencana
                </a>
                <a href="/volunteer" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/10 transition-all">
                    <i class="fas fa-hands-helping w-5"></i>Relawan
                </a>
                <a href="/donate" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/10 transition-all">
                    <i class="fas fa-heart w-5"></i>Donasi
                </a>
                <a href="/contact" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/10 transition-all">
                    <i class="fas fa-phone w-5"></i>Kontak
                </a>
                <div class="pt-2 border-t border-white/10">
                    <a href="/report" class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-gradient-to-r from-red-600 to-orange-600 text-white font-semibold rounded-xl mb-2">
                        <i class="fas fa-exclamation-triangle"></i>Laporkan Bencana
                    </a>
                    @auth
                        @if(auth()->user()->hasRole('Admin'))
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/10 transition-all">
                                <i class="fas fa-user-shield w-5"></i>Admin Dashboard
                            </a>
                        @endif
                        <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/10 transition-all">
                            <i class="fas fa-history w-5"></i>Riwayat Saya
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="w-full text-left flex items-center gap-3 px-4 py-3 rounded-xl text-red-400 hover:text-red-300 hover:bg-white/10 transition-all">
                                <i class="fas fa-sign-out-alt w-5"></i>Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/10 transition-all">
                            <i class="fas fa-sign-in-alt w-5"></i>Masuk
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-dynamic border-t">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                <!-- Brand -->
                <div class="lg:col-span-1">
                    <a href="/" class="flex items-center gap-3 mb-4">
                        <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-red-500 to-orange-600 rounded-xl">
                            <i class="fas fa-shield-alt text-white text-lg"></i>
                        </div>
                        <span class="text-xl font-bold text-white">Crisis<span class="text-red-500">Hub</span></span>
                    </a>
                    <p class="text-slate-400 text-sm leading-relaxed mb-6">
                        Platform digital terpadu untuk manajemen bencana, koordinasi relawan, dan distribusi bantuan yang transparan di seluruh Indonesia.
                    </p>
                    <div class="flex gap-3">
                        <a href="#" class="w-9 h-9 glass rounded-lg flex items-center justify-center text-slate-400 hover:text-white hover:border-red-500 transition-all">
                            <i class="fab fa-instagram text-sm"></i>
                        </a>
                        <a href="#" class="w-9 h-9 glass rounded-lg flex items-center justify-center text-slate-400 hover:text-white transition-all">
                            <i class="fab fa-twitter text-sm"></i>
                        </a>
                        <a href="#" class="w-9 h-9 glass rounded-lg flex items-center justify-center text-slate-400 hover:text-white transition-all">
                            <i class="fab fa-facebook text-sm"></i>
                        </a>
                        <a href="#" class="w-9 h-9 glass rounded-lg flex items-center justify-center text-slate-400 hover:text-white transition-all">
                            <i class="fab fa-youtube text-sm"></i>
                        </a>
                        <a href="#" class="w-9 h-9 glass rounded-lg flex items-center justify-center text-slate-400 hover:text-white transition-all">
                            <i class="fab fa-tiktok text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-white font-semibold mb-5">Navigasi</h4>
                    <ul class="space-y-3">
                        <li><a href="/" class="text-slate-400 hover:text-red-400 text-sm transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-red-600"></i>Beranda</a></li>
                        <li><a href="/about" class="text-slate-400 hover:text-red-400 text-sm transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-red-600"></i>Tentang Kami</a></li>
                        <li><a href="/peta-bencana" class="text-slate-400 hover:text-red-400 text-sm transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-red-600"></i>Peta Bencana</a></li>
                        <li><a href="/volunteer" class="text-slate-400 hover:text-red-400 text-sm transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-red-600"></i>Relawan</a></li>
                        <li><a href="/donate" class="text-slate-400 hover:text-red-400 text-sm transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-red-600"></i>Donasi</a></li>
                        <li><a href="/contact" class="text-slate-400 hover:text-red-400 text-sm transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-red-600"></i>Kontak</a></li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h4 class="text-white font-semibold mb-5">Informasi</h4>
                    <ul class="space-y-3">
                        <li><a href="/terms" class="text-slate-400 hover:text-red-400 text-sm transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-red-600"></i>Syarat & Ketentuan</a></li>
                        <li><a href="/privacy" class="text-slate-400 hover:text-red-400 text-sm transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-red-600"></i>Kebijakan Privasi</a></li>
                        <li><a href="/help" class="text-slate-400 hover:text-red-400 text-sm transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-red-600"></i>Pusat Bantuan</a></li>
                        <li><a href="/analytics" class="text-slate-400 hover:text-red-400 text-sm transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-red-600"></i>Statistik Publik</a></li>
                        <li><a href="/report" class="text-slate-400 hover:text-red-400 text-sm transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-red-600"></i>Laporkan Bencana</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-white font-semibold mb-5">Hubungi Kami</h4>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-red-600/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-map-marker-alt text-red-400 text-xs"></i>
                            </div>
                            <p class="text-slate-400 text-sm">Jl. Sudirman No. 45, Jakarta Pusat, DKI Jakarta 10210</p>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-red-600/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-phone text-red-400 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-slate-400 text-sm">Hotline 24 Jam</p>
                                <p class="text-red-400 font-bold text-base">119 ext. 9</p>
                            </div>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-red-600/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-envelope text-red-400 text-xs"></i>
                            </div>
                            <p class="text-slate-400 text-sm">info@crisishub.id</p>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-green-600/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fab fa-whatsapp text-green-400 text-xs"></i>
                            </div>
                            <p class="text-slate-400 text-sm">+62 812-3456-7890</p>
                        </li>
                    </ul>

                    <!-- Emergency Banner -->
                    <div class="mt-5 p-3 bg-gradient-to-r from-red-900/40 to-red-800/20 border border-red-700/30 rounded-xl">
                        <div class="flex items-center gap-2 mb-1">
                            <div class="w-2 h-2 rounded-full bg-red-500 badge-urgent"></div>
                            <span class="text-red-400 text-xs font-bold">DARURAT 24 JAM</span>
                        </div>
                        <p class="text-white font-bold text-xl">119 ext. 9</p>
                        <p class="text-slate-400 text-xs">Layanan Tanggap Darurat Bencana</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-white/5 py-5">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-slate-500 text-sm">© {{ date('Y') }} CrisisHub. Hak cipta dilindungi undang-undang.</p>
                <div class="flex items-center gap-2 text-slate-500 text-sm">
                    <i class="fas fa-heart text-red-600 text-xs"></i>
                    <span>Dibangun dengan cinta untuk Indonesia</span>
                    <span class="text-red-500">🇮🇩</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                const icon = mobileMenuBtn.querySelector('i');
                icon.classList.toggle('fa-bars');
                icon.classList.toggle('fa-times');
            });
        }

        // Scroll fade-up animation
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
        document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));

        // Counter animation
        function animateCounter(el, target, duration = 2000, prefix = '', suffix = '') {
            const start = 0;
            const startTime = performance.now();
            const update = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                const current = Math.round(start + (target - start) * eased);
                el.textContent = prefix + current.toLocaleString('id-ID') + suffix;
                if (progress < 1) requestAnimationFrame(update);
            };
            requestAnimationFrame(update);
        }

        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
                    entry.target.classList.add('counted');
                    const target = parseInt(entry.target.dataset.target);
                    const prefix = entry.target.dataset.prefix || '';
                    const suffix = entry.target.dataset.suffix || '';
                    animateCounter(entry.target, target, 2000, prefix, suffix);
                }
            });
        }, { threshold: 0.3 });
        document.querySelectorAll('[data-target]').forEach(el => counterObserver.observe(el));

        // FAQ Accordion
        document.querySelectorAll('.faq-item').forEach(item => {
            const btn = item.querySelector('.faq-btn');
            const answer = item.querySelector('.faq-answer');
            const icon = item.querySelector('.faq-icon');
            if (btn) {
                btn.addEventListener('click', () => {
                    const isOpen = item.classList.contains('open');
                    document.querySelectorAll('.faq-item.open').forEach(openItem => {
                        openItem.classList.remove('open');
                        openItem.querySelector('.faq-answer').classList.remove('open');
                    });
                    if (!isOpen) {
                        item.classList.add('open');
                        answer.classList.add('open');
                    }
                });
            }
        });

        // Tabs
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const group = btn.dataset.group;
                const target = btn.dataset.tab;
                document.querySelectorAll(`[data-group="${group}"].tab-btn`).forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                document.querySelectorAll(`[data-group-content="${group}"]`).forEach(content => {
                    content.classList.add('hidden');
                });
                document.getElementById(target)?.classList.remove('hidden');
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
