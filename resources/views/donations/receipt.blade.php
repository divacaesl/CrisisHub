<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi Donasi - {{ $donation->tracking_code }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            body { background: white !important; }
            .no-print { display: none !important; }
            .print-area { box-shadow: none !important; border: none !important; }
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-2xl w-full">
        <!-- Actions -->
        <div class="mb-6 flex justify-between items-center no-print">
            <a href="{{ route('dashboard') }}" class="text-slate-500 hover:text-slate-700 font-semibold flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
            <button onclick="window.print()" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg flex items-center gap-2 transition-colors">
                <i class="fas fa-print"></i> Cetak / Simpan PDF
            </button>
        </div>

        <!-- Receipt Card -->
        <div class="bg-white print-area rounded-2xl shadow-xl overflow-hidden border border-slate-200">
            <!-- Header -->
            <div class="bg-slate-900 p-8 text-center text-white relative">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <i class="fas fa-heart text-9xl"></i>
                </div>
                <h1 class="text-3xl font-black mb-2 relative z-10">CrisisHub</h1>
                <p class="text-slate-400 relative z-10">E-Kuitansi Donasi Kemanusiaan</p>
            </div>

            <!-- Content -->
            <div class="p-8">
                <div class="flex justify-between items-end border-b border-slate-200 pb-6 mb-6">
                    <div>
                        <p class="text-sm text-slate-500 font-bold mb-1">Diterima dari:</p>
                        <h3 class="text-xl font-bold text-slate-900">{{ $donation->user->name }}</h3>
                        <p class="text-sm text-slate-600">{{ $donation->user->email }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-slate-500 font-bold mb-1">No. Resi:</p>
                        <p class="font-mono font-bold text-slate-900">{{ $donation->tracking_code }}</p>
                    </div>
                </div>

                <div class="space-y-4 mb-8">
                    <div class="flex justify-between items-center py-2">
                        <span class="text-slate-500 font-medium">Tanggal Transaksi</span>
                        <span class="font-bold text-slate-900">{{ $donation->created_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-slate-500 font-medium">Metode Pembayaran</span>
                        <span class="font-bold text-slate-900">{{ $donation->payment_method ?? 'Transfer Bank' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-slate-500 font-medium">Status</span>
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full border border-green-200">Lunas / Berhasil</span>
                    </div>
                </div>

                <!-- Total Box -->
                <div class="bg-slate-50 rounded-xl border border-slate-200 p-6 flex justify-between items-center mb-8">
                    <div>
                        <p class="text-slate-500 font-bold mb-1">Total Donasi</p>
                        <p class="text-xs text-slate-400">Termasuk biaya operasional sistem 0%</p>
                    </div>
                    <div class="text-right">
                        <h2 class="text-3xl font-black text-orange-500">Rp {{ number_format($donation->amount, 0, ',', '.') }}</h2>
                    </div>
                </div>

                <!-- Note -->
                @if($donation->notes)
                <div class="border-l-4 border-orange-500 bg-orange-50 p-4 mb-8 rounded-r-lg">
                    <p class="text-sm text-orange-800 italic">"{{ $donation->notes }}"</p>
                </div>
                @endif

                <div class="text-center text-sm text-slate-500 border-t border-slate-200 pt-6">
                    <p class="mb-2">Terima kasih atas kontribusi Anda. Bantuan Anda memberikan harapan baru.</p>
                    <p class="font-bold">CrisisHub &copy; {{ date('Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
