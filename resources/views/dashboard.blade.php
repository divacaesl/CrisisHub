<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CrisisHub - Charity & Disaster Relief</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .font-serif-custom { font-family: 'Merriweather', serif; }
    </style>
</head>
<body class="antialiased bg-[#F9F6F0]">

    <!-- Transparent Navigation over Hero -->
    <nav class="absolute top-0 w-full z-50 py-6 px-12 flex justify-between items-center text-white">
        <div class="flex items-center space-x-2">
            <!-- Simple custom logo -->
            <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span class="text-2xl font-serif-custom font-bold tracking-wider">CrisisHub</span>
        </div>
        <div class="hidden md:flex space-x-10 text-xs font-bold uppercase tracking-[0.15em]">
            <a href="#" class="text-yellow-400">Home</a>
            <a href="#" class="hover:text-yellow-400 transition">About Us</a>
            <a href="#" class="hover:text-yellow-400 transition">Projects</a>
            <a href="#" class="hover:text-yellow-400 transition">Volunteer</a>
            <a href="#" class="hover:text-yellow-400 transition">Donate</a>
            <a href="#" class="hover:text-yellow-400 transition">Contact</a>
            <!-- Auth Links -->
            @auth
                <form method="POST" action="{{ route('logout') }}" class="inline ml-4 border-l border-white/30 pl-8">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="hover:text-red-400 transition text-gray-300">Logout</a>
                </form>
            @else
                <a href="{{ route('login') }}" class="ml-4 border-l border-white/30 pl-8 hover:text-yellow-400 transition">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="hover:text-yellow-400 transition ml-6">Register</a>
                @endif
            @endauth
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative w-full h-[85vh] bg-cover bg-center flex items-center" style="background-image: url('/images/hero.png');">
        <!-- Dark gradient overlay for text readability -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent"></div>
        
        <div class="relative z-10 px-12 md:px-24 max-w-4xl mt-12">
            <span class="text-white text-xs font-bold tracking-[0.25em] uppercase mb-6 block opacity-90">Make an Impact</span>
            <h1 class="text-white text-6xl md:text-[5.5rem] font-serif-custom font-bold leading-[1.1] mb-8">
                Your Support <br>is Powerful.
            </h1>
            <p class="text-gray-200 text-lg md:text-xl max-w-xl mb-12 leading-relaxed opacity-90 font-light">
                We seek out world changers and difference makers around the globe, and equip them to fulfill their unique purpose.
            </p>
            <button class="bg-[#F4D03F] text-black px-12 py-4 font-bold text-xs uppercase tracking-[0.2em] hover:bg-yellow-500 transition shadow-lg">
                Donate
            </button>
        </div>
    </div>

    <!-- Mid Section: We Work Together -->
    <div class="w-full bg-white flex flex-col md:flex-row min-h-[650px]">
        <div class="w-full md:w-1/2 bg-cover bg-center min-h-[400px] md:min-h-full" style="background-image: url('/images/mid.png');"></div>
        <div class="w-full md:w-1/2 p-12 md:p-24 flex flex-col justify-center">
            <h2 class="text-4xl md:text-[2.75rem] font-serif-custom font-bold text-gray-900 mb-6">We Work Together</h2>
            <span class="text-gray-400 text-xs font-bold tracking-[0.2em] uppercase mb-10 block">We Listen. We Advise</span>
            
            <p class="text-gray-500 mb-8 leading-relaxed font-light text-[15px]">
                CrisisHub seeks and builds relationships with individuals who are making a difference in their communities. By finding those who are already creating change, we are deepening impact instead of duplicating it.
            </p>
            <p class="text-gray-400 text-[14px] leading-relaxed mb-16 font-light">
                The work of our organization is aimed at targeted assistance to victims in the form of charitable donations from sponsors and patrons, as well as providing material, technical, informational and legal and humanitarian assistance through charitable events and programs. We also offer additional resources to families with children all over the world as well as support to schools and kindergartens located in poor regions.
            </p>

            <div class="flex justify-between border-t border-gray-100 pt-10">
                <div>
                    <div class="text-[#F4D03F] mb-4"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                    <div class="text-4xl font-serif-custom font-bold text-gray-900 tracking-tight">2354+</div>
                    <div class="text-gray-400 text-xs mt-2 uppercase tracking-wider font-semibold">Donation</div>
                </div>
                <div>
                    <div class="text-[#F4D03F] mb-4"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>
                    <div class="text-4xl font-serif-custom font-bold text-gray-900 tracking-tight">3500+</div>
                    <div class="text-gray-400 text-xs mt-2 uppercase tracking-wider font-semibold">Helped People</div>
                </div>
                <div>
                    <div class="text-[#F4D03F] mb-4"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg></div>
                    <div class="text-4xl font-serif-custom font-bold text-gray-900 tracking-tight">500+</div>
                    <div class="text-gray-400 text-xs mt-2 uppercase tracking-wider font-semibold">Volunteers</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Section: Featured Causes -->
    <div class="py-24 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto text-center">
        <h2 class="text-4xl md:text-5xl font-serif-custom font-bold text-gray-900 mb-6">Featured Causes</h2>
        <span class="text-gray-400 text-xs font-bold tracking-[0.2em] uppercase mb-20 block">We Listen. We Advise</span>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
            <!-- Cause 1 -->
            <div class="bg-white shadow-xl hover:shadow-2xl transition duration-300 flex flex-col h-full">
                <div class="h-64 bg-cover bg-center" style="background-image: url('/images/cause1.png');"></div>
                <div class="p-8 text-center flex-1 flex flex-col justify-between items-center">
                    <div>
                        <p class="text-[11px] text-gray-400 mb-5 tracking-widest uppercase">Raised: <span class="font-bold text-gray-900">Rp 300,000</span> / Goal: Rp 460,000</p>
                        <h3 class="text-2xl font-serif-custom font-bold text-gray-900 mb-8 px-2 leading-tight">Livestock for Orphaned Children in Congo</h3>
                    </div>
                    <button class="bg-[#F4D03F] text-black px-8 py-3 text-[11px] font-bold uppercase tracking-[0.2em] hover:bg-yellow-500 transition">Donate Now</button>
                </div>
            </div>
            
            <!-- Cause 2 -->
            <div class="bg-white shadow-xl hover:shadow-2xl transition duration-300 flex flex-col h-full">
                <div class="h-64 bg-cover bg-center" style="background-image: url('/images/cause2.png');"></div>
                <div class="p-8 text-center flex-1 flex flex-col justify-between items-center">
                    <div>
                        <p class="text-[11px] text-gray-400 mb-5 tracking-widest uppercase">Raised: <span class="font-bold text-gray-900">Rp 270,000</span> / Goal: Rp 300,000</p>
                        <h3 class="text-2xl font-serif-custom font-bold text-gray-900 mb-8 px-2 leading-tight">Changing Young Lives and Communities in Limpopo</h3>
                    </div>
                    <button class="bg-[#F4D03F] text-black px-8 py-3 text-[11px] font-bold uppercase tracking-[0.2em] hover:bg-yellow-500 transition">Donate Now</button>
                </div>
            </div>

            <!-- Cause 3 -->
            <div class="bg-white shadow-xl hover:shadow-2xl transition duration-300 flex flex-col h-full">
                <div class="h-64 bg-cover bg-center" style="background-image: url('/images/cause3.png');"></div>
                <div class="p-8 text-center flex-1 flex flex-col justify-between items-center">
                    <div>
                        <p class="text-[11px] text-gray-400 mb-5 tracking-widest uppercase">Raised: <span class="font-bold text-gray-900">Rp 100,000</span> / Goal: Rp 150,000</p>
                        <h3 class="text-2xl font-serif-custom font-bold text-gray-900 mb-8 px-2 leading-tight">Toilets & Water for school children, rural India</h3>
                    </div>
                    <button class="bg-[#F4D03F] text-black px-8 py-3 text-[11px] font-bold uppercase tracking-[0.2em] hover:bg-yellow-500 transition">Donate Now</button>
                </div>
            </div>
        </div>

        <div class="mt-20">
            <button class="text-[11px] text-gray-400 font-bold uppercase tracking-[0.2em] hover:text-gray-900 transition border-b border-gray-300 pb-1">All Causes</button>
        </div>
    </div>

</body>
</html>
