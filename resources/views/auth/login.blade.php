<x-guest-layout>
    <!-- Left Column: Image/Branding -->
    <div class="hidden lg:flex w-1/2 relative flex-col justify-center items-center p-12 overflow-hidden">
        <div class="absolute inset-0 bg-red-600/20 dark:bg-red-900/30 mix-blend-multiply dark:mix-blend-overlay z-10"></div>
        <img src="/images/hero_disaster.png" class="absolute inset-0 w-full h-full object-cover" alt="CrisisHub Disaster Relief">
        
        <!-- Overlay Gradient -->
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/60 to-transparent z-10"></div>
        
        <div class="relative z-20 text-center text-white mt-auto">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-red-500 to-orange-600 rounded-2xl mb-6 shadow-2xl">
                <i class="fas fa-shield-alt text-4xl"></i>
            </div>
            <h1 class="text-4xl font-black mb-4">Crisis<span class="text-red-500">Hub</span></h1>
            <p class="text-lg text-slate-300 max-w-md mx-auto">Platform digital terpadu untuk pelaporan bencana, koordinasi relawan, dan donasi transparan di seluruh Indonesia.</p>
        </div>
    </div>

    <!-- Right Column: Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12">
        <div class="w-full max-w-md glass-panel p-8 sm:p-10 rounded-3xl relative overflow-hidden">
            <!-- Decorative blur blobs -->
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-red-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-orange-500/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10">
                <div class="text-center mb-10">
                    <div class="lg:hidden inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-red-500 to-orange-600 rounded-2xl mb-4 shadow-xl">
                        <i class="fas fa-shield-alt text-3xl text-white"></i>
                    </div>
                    <h2 class="text-3xl font-black text-slate-900 dark:text-white">Selamat Datang</h2>
                    <p class="text-slate-500 dark:text-slate-400 mt-2">Masuk ke akun CrisisHub Anda</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="pl-11 w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl py-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label for="password" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs font-semibold text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition-colors">Lupa sandi?</a>
                            @endif
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password" class="pl-11 w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl py-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-red-600 focus:ring-red-500 bg-slate-50 dark:bg-slate-900 dark:border-slate-700">
                        <label for="remember_me" class="ml-2 text-sm text-slate-600 dark:text-slate-400">Ingat saya</label>
                    </div>

                    <div>
                        <button type="submit" class="w-full flex items-center justify-center gap-2 py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-700 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all transform hover:-translate-y-0.5">
                            Masuk Sekarang <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </form>

                <!-- Back to Home -->
                <div class="mt-8 text-center">
                    <a href="/" class="text-sm font-semibold text-slate-500 hover:text-slate-900 dark:hover:text-white transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
