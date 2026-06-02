<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-sky-50 rounded-lg text-sky-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h2 class="font-semibold text-xl text-sky-950 leading-tight">
                {{ __('Profile & Account Care') }}
            </h2>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-[#f0f9ff] via-[#e0f2fe]/70 to-[#eef2ff] py-12 relative overflow-hidden">
        <!-- Background decorative blobs for premium care theme -->
        <div class="absolute top-10 left-10 w-72 h-72 bg-sky-200/40 rounded-full blur-3xl -z-10 pointer-events-none"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-blue-200/30 rounded-full blur-3xl -z-10 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Top Caring Welcome Banner -->
            <div class="relative bg-gradient-to-r from-sky-400 via-blue-500 to-indigo-600 text-white rounded-2xl p-6 sm:p-8 shadow-lg shadow-sky-500/20 mb-8 overflow-hidden">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute right-20 -bottom-10 w-32 h-32 bg-sky-300/20 rounded-full blur-xl"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="max-w-2xl">
                        <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-semibold uppercase tracking-wider mb-2">CrisisHub Care</span>
                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight mb-2">Pusat Kepedulian Akun Anda</h1>
                        <p class="text-sky-100 text-sm sm:text-base leading-relaxed">
                            Kami sangat peduli terhadap keamanan dan keakuratan data Anda. Di sini, Anda dapat memperbarui profil dan kata sandi Anda dengan tenang, mengetahui bahwa setiap informasi dilindungi oleh sistem keamanan berstandar tinggi.
                        </p>
                    </div>
                    <div class="hidden md:block flex-shrink-0 text-white/90">
                        <!-- Caring Hands Heart SVG Icon -->
                        <svg class="w-24 h-24 stroke-current" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Main Grid Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left side: Profile info (wider) -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="profile-card relative bg-white/90 backdrop-blur-md border border-sky-100/70 shadow-md shadow-sky-100/50 rounded-2xl p-6 sm:p-8 overflow-hidden transition-all duration-300 hover:shadow-lg hover:shadow-sky-100/70">
                        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-sky-400 via-blue-500 to-indigo-500"></div>
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Right side: Password and Account Deletion (narrower) -->
                <div class="space-y-6">
                    <div class="profile-card relative bg-white/90 backdrop-blur-md border border-sky-100/70 shadow-md shadow-sky-100/50 rounded-2xl p-6 sm:p-8 overflow-hidden transition-all duration-300 hover:shadow-lg hover:shadow-sky-100/70">
                        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-sky-400 via-blue-500 to-indigo-500"></div>
                        @include('profile.partials.update-password-form')
                    </div>

                    <div class="profile-card relative bg-white/90 backdrop-blur-md border border-red-100/60 shadow-md shadow-red-100/30 rounded-2xl p-6 sm:p-8 overflow-hidden transition-all duration-300 hover:shadow-lg hover:shadow-red-100/40">
                        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-red-400 to-rose-500"></div>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scoped style overrides for form elements on this page -->
    <style>
        .profile-card input, 
        .profile-card select, 
        .profile-card textarea {
            border-color: #cbd5e1 !important;
            transition: all 0.3s ease !important;
            border-radius: 0.5rem !important;
        }
        .profile-card input:focus, 
        .profile-card select:focus, 
        .profile-card textarea:focus {
            border-color: #0ea5e9 !important;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.2) !important;
            outline: none !important;
        }
        /* Override general gray-800 buttons inside profile cards to match care/soft blue theme */
        .profile-card button.bg-gray-800, 
        .profile-card button[type="submit"]:not(.bg-red-600):not(.bg-red-700):not(.bg-secondary):not(.bg-transparent):not([class*="bg-red"]) {
            background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%) !important;
            color: white !important;
            font-weight: 600 !important;
            font-family: 'Outfit', sans-serif !important;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.15) !important;
            border: none !important;
            transition: all 0.3s ease !important;
            text-transform: none !important;
            letter-spacing: normal !important;
            font-size: 0.875rem !important;
            padding: 0.625rem 1.25rem !important;
            border-radius: 0.5rem !important;
        }
        .profile-card button.bg-gray-800:hover, 
        .profile-card button[type="submit"]:not(.bg-red-600):not(.bg-red-700):not(.bg-secondary):not(.bg-transparent):not([class*="bg-red"]):hover {
            background: linear-gradient(135deg, #0284c7 0%, #1d4ed8 100%) !important;
            box-shadow: 0 6px 15px rgba(37, 99, 235, 0.25) !important;
            transform: translateY(-1px);
        }
        .profile-card button.bg-gray-800:active, 
        .profile-card button[type="submit"]:not(.bg-red-600):not(.bg-red-700):not(.bg-secondary):not(.bg-transparent):not([class*="bg-red"]):active {
            transform: translateY(0);
        }
    </style>
</x-app-layout>
