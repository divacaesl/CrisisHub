<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; padding: 20px; }
        .container { max-w-xl: 600px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .header { background-color: #1e293b; color: white; padding: 30px; text-align: center; }
        .content { padding: 30px; }
        .receipt-box { background-color: #f1f5f9; border-radius: 8px; padding: 20px; margin-top: 20px; border: 1px dashed #cbd5e1; }
        .row { display: flex; justify-content: space-between; margin-bottom: 10px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px; }
        .row:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
        .label { color: #64748b; font-size: 14px; }
        .value { color: #0f172a; font-weight: bold; }
        .total { font-size: 24px; color: #ef4444; font-weight: 900; }
        .footer { background-color: #f8fafc; text-align: center; padding: 20px; color: #94a3b8; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0;">CrisisHub</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.8;">E-Kuitansi Donasi Anda</p>
        </div>
        <div class="content">
            <p>Halo, <strong>{{ $donation->user->name }}</strong>,</p>
            <p>Terima kasih atas kebaikan hati Anda! Donasi Anda telah kami terima dan akan segera disalurkan untuk misi kemanusiaan.</p>
            
            <div class="receipt-box">
                <div class="row">
                    <span class="label">No. Resi:</span>
                    <span class="value">{{ $donation->tracking_code }}</span>
                </div>
                <div class="row">
                    <span class="label">Tanggal:</span>
                    <span class="value">{{ $donation->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="row">
                    <span class="label">Metode Pembayaran:</span>
                    <span class="value">{{ $donation->payment_method }}</span>
                </div>
                <div class="row" style="margin-top: 20px; padding-top: 20px; border-top: 2px solid #e2e8f0;">
                    <span class="label" style="font-size: 18px; line-height: 28px;">Total Donasi:</span>
                    <span class="total">Rp {{ number_format($donation->amount, 0, ',', '.') }}</span>
                </div>
            </div>

            <p style="margin-top: 30px;">Anda dapat mencetak atau mengunduh resi resmi dari Dashboard Anda di website CrisisHub.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} CrisisHub. All rights reserved.<br>
            Email ini dihasilkan secara otomatis.
        </div>
    </div>
</body>
</html>
