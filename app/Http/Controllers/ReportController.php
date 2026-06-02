<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\PriorityScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Store a newly created disaster report.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_bencana' => 'required|string',
            'tingkat_kerusakan' => 'required|string|in:Rendah,Sedang,Tinggi,Hancur Total',
            'jumlah_korban' => 'required|integer|min:0',
            'infants_count' => 'required|integer|min:0',
            'elderly_count' => 'required|integer|min:0',
            'disabled_count' => 'required|integer|min:0',
            'family_members' => 'required|integer|min:0',
            'logistic_stock_critical' => 'nullable|string', // Checkboxes send string 'on' when checked
            'deskripsi_kondisi' => 'required|string',
            'kebutuhan_mendesak' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // Max 5MB
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'alamat_lengkap' => 'nullable|string',
        ]);

        $data = $request->except(['foto', 'logistic_stock_critical']);
        $data['user_id'] = auth()->id();
        $data['status'] = 'Pending';
        $data['logistic_stock_critical'] = $request->has('logistic_stock_critical');

        // Handle File Upload
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('reports', 'public');
            $data['foto_path'] = $path;
        }

        // Check for duplicates within 500 meters and 2 hours
        $timeLimit = now()->subHours(2);
        $radiusMeters = 500;
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        // Fetch recent reports to calculate distance in PHP (SQLite compatible)
        $recentReports = Report::where('created_at', '>=', $timeLimit)->get();
        $isDuplicate = false;

        foreach ($recentReports as $rep) {
            $latFrom = deg2rad((float) $latitude);
            $lonFrom = deg2rad((float) $longitude);
            $latTo = deg2rad((float) $rep->latitude);
            $lonTo = deg2rad((float) $rep->longitude);
  
            $latDelta = $latTo - $latFrom;
            $lonDelta = $lonTo - $lonFrom;
  
            $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
            $distance = $angle * 6371000; // Earth radius in meters

            if ($distance < $radiusMeters) {
                $isDuplicate = true;
                break;
            }
        }

        if ($isDuplicate) {
            $data['flag_duplicate'] = true;
        }

        // Create Report
        $report = Report::create($data);

        // Calculate and save Priority Score using AI PriorityScoringService
        app(\App\Services\PriorityScoringService::class)->calculateForReport($report->id);

        return redirect()->route('dashboard')->with('success', 'Berhasil menambahkan laporan SOS! Laporan Anda telah masuk ke Riwayat Laporan Saya dan sedang menunggu diverifikasi oleh admin.');
    }
}
