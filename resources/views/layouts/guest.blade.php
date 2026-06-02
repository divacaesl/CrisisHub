<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CrisisHub') }} - Masuk</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { font-family: 'Outfit', sans-serif; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        .dark .glass-panel {
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body class="text-slate-900 dark:text-slate-100 antialiased overflow-x-hidden transition-colors duration-300">

    <!-- Video Background Loop -->
    <div class="fixed inset-0 z-[-1]">
        <video autoplay loop muted playsinline class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-60 dark:opacity-30">
            <source src="https://assets.mixkit.co/videos/preview/mixkit-abstract-technology-particle-loop-32819-large.mp4" type="video/mp4">
        </video>
        <!-- Gradients for depth -->
        <div class="absolute inset-0 bg-gradient-to-br from-slate-100/90 to-slate-200/90 dark:from-[#0f172a]/90 dark:to-black/90"></div>
    </div>

    <!-- Toggle Dark Mode -->
    <button @click="darkMode = !darkMode" class="absolute top-6 right-6 z-50 w-12 h-12 rounded-full glass-panel flex items-center justify-center text-slate-500 hover:text-red-500 dark:text-slate-400 dark:hover:text-white transition-all hover:scale-110">
        <i class="fas" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
    </button>

    <div class="min-h-screen flex">
        {{ $slot }}
    </div>

</body>
</html>
