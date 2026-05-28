<?php

namespace App\Services;

use App\Models\PriorityScore;
use App\Models\Report;
use Exception;

class PriorityScoringService
{
    /**
     * Calculate and save the priority score for a given report.
     *
     * @param int $reportId
     * @return PriorityScore
     */
    public function calculateForReport($reportId)
    {
        $report = Report::findOrFail($reportId);

        // For this calculation, we assume these variables are either available
        // on the report, or we estimate them based on damage_level and victims_count.
        // In a real scenario, the report would have these detailed fields.
        
        // Normalize variables to 0-100 scale
        $kerusakan = ($report->damage_level / 5) * 100;
        $balita = min(($report->victims_count * 0.1), 100); // estimate 10% are toddlers
        $lansia = min(($report->victims_count * 0.15), 100); // estimate 15% are elderly
        $difabel = min(($report->victims_count * 0.05), 100); // estimate 5% are disabled
        $keluarga = min($report->victims_count, 100);
        $stok = 100; // Assume critical stock need (100) by default initially
        $akses = 50; // Average accessibility assumption

        // Formula: score = (kerusakan*0.25) + (balita*0.20) + (lansia*0.15) + (difabel*0.15) + (keluarga*0.10) + (stok*0.10) + (akses*0.05)
        $score = ($kerusakan * 0.25) + 
                 ($balita * 0.20) + 
                 ($lansia * 0.15) + 
                 ($difabel * 0.15) + 
                 ($keluarga * 0.10) + 
                 ($stok * 0.10) + 
                 ($akses * 0.05);
                 
        $score = round($score);

        // Determine Level
        if ($score >= 76) {
            $level = 'Kritis';
        } elseif ($score >= 51) {
            $level = 'Tinggi';
        } elseif ($score >= 26) {
            $level = 'Sedang';
        } else {
            $level = 'Rendah';
        }

        // Save to Database
        return PriorityScore::updateOrCreate(
            ['report_id' => $report->id],
            [
                'score' => $score,
                'level' => $level,
                'variables_snapshot' => json_encode([
                    'kerusakan' => $kerusakan,
                    'balita' => $balita,
                    'lansia' => $lansia,
                    'difabel' => $difabel,
                    'keluarga' => $keluarga,
                    'stok' => $stok,
                    'akses' => $akses,
                ]),
                'calculated_at' => now(),
            ]
        );
    }
}
