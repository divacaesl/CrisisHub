<x-mail::message>
# Laporan Bencana Diverifikasi

Halo {{ $report->user->name }},

Laporan kondisi darurat/bencana Anda mengenai **{{ $report->jenis_bencana }}** di lokasi **{{ $report->alamat_lengkap ?? 'Lokasi Terdeteksi' }}** telah berhasil **diverifikasi** oleh tim admin CrisisHub.

Status Laporan: **{{ $report->status }}**
Tingkat Kerusakan: **{{ $report->tingkat_kerusakan }}**

Tim kami sedang menindaklanjuti laporan ini dan akan segera mengerahkan relawan serta bantuan logistik (jika dibutuhkan) ke lokasi kejadian.

<x-mail::button :url="url('/dashboard')">
Lihat Riwayat Laporan
</x-mail::button>

Tetap aman dan waspada.
Terima kasih,
**Tim {{ config('app.name') }}**
</x-mail::message>
