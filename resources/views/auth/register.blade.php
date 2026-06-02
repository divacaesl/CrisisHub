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

    <!-- Right Column: Register Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12">
        <div class="w-full max-w-md glass-panel p-8 sm:p-10 rounded-3xl relative overflow-hidden">
            <!-- Decorative blur blobs -->
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-red-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-orange-500/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10">
                <div class="text-center mb-8">
                    <div class="lg:hidden inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-red-500 to-orange-600 rounded-2xl mb-4 shadow-xl">
                        <i class="fas fa-shield-alt text-3xl text-white"></i>
                    </div>
                    <h2 class="text-3xl font-black text-slate-900 dark:text-white">Buat Akun Baru</h2>
                    <p class="text-slate-500 dark:text-slate-400 mt-2">Daftar untuk mulai berkontribusi di CrisisHub</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-user"></i>
                            </div>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="pl-11 w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl py-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500 text-sm" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="pl-11 w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl py-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Kata Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="new-password" class="pl-11 w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl py-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Konfirmasi Kata Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="pl-11 w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl py-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500 text-sm" />
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full flex items-center justify-center gap-2 py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-700 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all transform hover:-translate-y-0.5">
                            Daftar Sekarang <i class="fas fa-user-plus"></i>
                        </button>
                    </div>
                </form>

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-slate-200 dark:border-slate-700"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white dark:bg-slate-900 text-slate-500">Atau daftar dengan</span>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('google.login') }}" class="w-full flex items-center justify-center gap-3 py-3.5 px-4 border border-slate-200 dark:border-slate-700 rounded-xl shadow-sm text-sm font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google">
                            Daftar dengan Google
                        </a>
                    </div>
                </div>

                <div class="mt-6 text-center">
                    <p class="text-sm text-slate-600 dark:text-slate-400">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-bold text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300">Masuk di sini</a>
                    </p>
                </div>

                <!-- Back to Home -->
                <div class="mt-6 text-center">
                    <a href="/" class="text-sm font-semibold text-slate-500 hover:text-slate-900 dark:hover:text-white transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
