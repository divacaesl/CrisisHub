<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bencana — CrisisHub</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 10px; color: #1f2937; background: #fff; }
        .header { background: #111827; color: white; padding: 20px 30px; border-bottom: 3px solid #f59e0b; }
        .header h1 { font-size: 20px; font-weight: bold; }
        .header p { font-size: 10px; color: #9ca3af; margin-top: 4px; }
        .meta { padding: 12px 30px; background: #f9fafb; border-bottom: 1px solid #e5e7eb; font-size: 9px; color: #6b7280; }
        table { width: 100%; border-collapse: collapse; margin-top: 0; }
        thead { background: #1f2937; color: white; }
        th { padding: 8px 10px; text-align: left; font-size: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
        tbody tr { border-bottom: 1px solid #f3f4f6; }
        tbody tr:nth-child(even) { background: #f9fafb; }
        td { padding: 7px 10px; vertical-align: top; }
        .badge { display: inline-block; padding: 2px 6px; border-radius: 3px; font-size: 7px; font-weight: bold; text-transform: uppercase; }
        .badge-critical { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .badge-high { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; }
        .badge-medium { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
        .badge-low { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
        .badge-pending { background: #fffbeb; color: #b45309; }
        .badge-approved { background: #f0fdf4; color: #15803d; }
        .badge-rejected { background: #fef2f2; color: #dc2626; }
        .footer { position: fixed; bottom: 0; left: 0; right: 0; padding: 8px 30px; background: #f9fafb; border-top: 1px solid #e5e7eb; font-size: 8px; color: #9ca3af; display: flex; justify-content: space-between; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🚨 Laporan Bencana — CrisisHub</h1>
        <p>Diekspor pada: {{ now()->format('d F Y, H:i') }} WIB &nbsp;|&nbsp; Total: {{ $reports->count() }} laporan</p>
    </div>
    <div class="meta">
        Dokumen ini bersifat RAHASIA dan hanya untuk keperluan koordinasi internal.
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">ID</th>
                <th style="width: 80px;">Bencana</th>
                <th style="width: 110px;">Lokasi</th>
                <th style="width: 65px;">Kerusakan</th>
                <th style="width: 40px;">Korban</th>
                <th style="width: 60px;">Pelapor</th>
                <th style="width: 55px;">Status</th>
                <th style="width: 60px;">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $r)
            <tr>
                <td style="color: #9ca3af;">#{{ $r->id }}</td>
                <td><strong>{{ $r->jenis_bencana }}</strong></td>
                <td style="font-size: 9px; color: #4b5563;">{{ Str::limit($r->alamat_lengkap, 50) }}</td>
                <td>
                    @if($r->tingkat_kerusakan === 'Hancur Total')
                        <span class="badge badge-critical">{{ $r->tingkat_kerusakan }}</span>
                    @elseif($r->tingkat_kerusakan === 'Tinggi')
                        <span class="badge badge-high">{{ $r->tingkat_kerusakan }}</span>
                    @elseif($r->tingkat_kerusakan === 'Sedang')
                        <span class="badge badge-medium">{{ $r->tingkat_kerusakan }}</span>
                    @else
                        <span class="badge badge-low">{{ $r->tingkat_kerusakan }}</span>
                    @endif
                </td>
                <td><strong>{{ number_format($r->jumlah_korban) }}</strong></td>
                <td style="font-size: 9px;">{{ Str::limit($r->user->name ?? 'Anonim', 20) }}</td>
                <td>
                    @if(($r->status ?? 'Pending') === 'Approved' || $r->status === 'Verified')
                        <span class="badge badge-approved">Verified</span>
                    @elseif($r->status === 'Rejected')
                        <span class="badge badge-rejected">Rejected</span>
                    @else
                        <span class="badge badge-pending">{{ $r->status ?? 'Pending' }}</span>
                    @endif
                </td>
                <td style="font-size: 9px; color: #6b7280;">{{ $r->created_at->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align: center; padding: 30px; color: #9ca3af;">Tidak ada data laporan.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <span>CrisisHub — Platform Tanggap Darurat Indonesia</span>
        <span>Dicetak oleh: Admin &nbsp;|&nbsp; Halaman <span class="pagenum"></span></span>
    </div>
</body>
</html>
