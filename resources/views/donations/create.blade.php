@extends('layouts.dashboard')

@section('title', 'Berdonasi')
@section('role', 'Donatur')
@section('page_title', 'Formulir Donasi')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="text-center mb-10">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-100 text-orange-500 dark:bg-orange-500/20 rounded-full mb-4 shadow-lg shadow-orange-500/30">
            <i class="fas fa-heart text-3xl"></i>
        </div>
        <h2 class="text-3xl font-black text-slate-900 dark:text-white">Mari Berbagi Kebaikan</h2>
        <p class="text-slate-500 mt-2">Bantuan Anda sangat berarti bagi mereka yang terdampak bencana.</p>
    </div>

    @if ($errors->any())
        <div class="p-4 mb-6 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900/30 dark:text-red-400">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="glass-panel rounded-3xl p-8 border border-orange-500/20 relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-orange-500/10 rounded-full blur-3xl"></div>
        
        <form action="{{ route('donate.store') }}" method="POST" class="relative z-10 space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-3">Nominal Donasi (Rp)</label>
                <div class="grid grid-cols-3 gap-3 mb-4">
                    <label class="cursor-pointer">
                        <input type="radio" name="preset_amount" value="50000" class="peer sr-only" onclick="document.getElementById('amount').value=50000">
                        <div class="text-center py-3 px-4 rounded-xl border-2 border-slate-200 dark:border-slate-700 peer-checked:border-orange-500 peer-checked:bg-orange-50 dark:peer-checked:bg-orange-500/10 text-slate-600 dark:text-slate-300 peer-checked:text-orange-600 font-bold transition-all">
                            50 Ribu
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="preset_amount" value="100000" class="peer sr-only" onclick="document.getElementById('amount').value=100000" checked>
                        <div class="text-center py-3 px-4 rounded-xl border-2 border-slate-200 dark:border-slate-700 peer-checked:border-orange-500 peer-checked:bg-orange-50 dark:peer-checked:bg-orange-500/10 text-slate-600 dark:text-slate-300 peer-checked:text-orange-600 font-bold transition-all">
                            100 Ribu
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="preset_amount" value="500000" class="peer sr-only" onclick="document.getElementById('amount').value=500000">
                        <div class="text-center py-3 px-4 rounded-xl border-2 border-slate-200 dark:border-slate-700 peer-checked:border-orange-500 peer-checked:bg-orange-50 dark:peer-checked:bg-orange-500/10 text-slate-600 dark:text-slate-300 peer-checked:text-orange-600 font-bold transition-all">
                            500 Ribu
                        </div>
                    </label>
                </div>
                <input type="number" name="amount" id="amount" value="100000" min="10000" required class="w-full text-lg font-bold bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 focus:ring-2 focus:ring-orange-500" placeholder="Nominal lainnya...">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-3">Metode Pembayaran</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="cursor-pointer flex items-center p-3 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        <input type="radio" name="payment_method" value="Bank Transfer (BCA)" class="w-4 h-4 text-orange-500 focus:ring-orange-500 border-gray-300" required>
                        <span class="ml-3 font-semibold text-slate-700 dark:text-slate-300">BCA Virtual Account</span>
                    </label>
                    <label class="cursor-pointer flex items-center p-3 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        <input type="radio" name="payment_method" value="QRIS / E-Wallet" class="w-4 h-4 text-orange-500 focus:ring-orange-500 border-gray-300">
                        <span class="ml-3 font-semibold text-slate-700 dark:text-slate-300">QRIS (Gopay/Ovo)</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-3">Pesan atau Doa (Opsional)</label>
                <textarea name="notes" rows="3" class="w-full bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl py-3 px-4 focus:ring-2 focus:ring-orange-500" placeholder="Tuliskan doa untuk para korban..."></textarea>
            </div>

            <button type="submit" class="w-full py-4 bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white font-black text-lg rounded-xl shadow-xl shadow-orange-500/30 transition-transform hover:scale-[1.02]">
                Donasikan Sekarang <i class="fas fa-arrow-right ml-2"></i>
            </button>
        </form>
    </div>
</div>
@endsection
