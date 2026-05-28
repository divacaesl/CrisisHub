<?php

namespace App\Services;

use App\Models\Report;

class PriorityCalculatorService
{
    /**
     * Calculate priority score (0-100) based on disaster metrics.
     * Formula:
     * (damage × 0.35) + (infants × 0.15) + (elderly × 0.15) + 
     * (disabled × 0.15) + (family_size × 0.10) + (logistic_shortage × 0.10)
     */
    public function calculate(Report $report): int
    {
        $score = 0.0;

        // 1. Damage Level (Max 100 points * 0.35 = 35)
        $damageScore = match ($report->tingkat_kerusakan) {
            'Hancur Total' => 100,
            'Tinggi' => 75,
            'Sedang' => 50,
            'Rendah' => 25,
            default => 0,
        };
        $score += ($damageScore * 0.35);

        // 2. Infants Count (Max 100 points * 0.15 = 15) - Assumption: 5+ infants is critical
        $infantsScore = min($report->infants_count * 20, 100);
        $score += ($infantsScore * 0.15);

        // 3. Elderly Count (Max 100 points * 0.15 = 15)
        $elderlyScore = min($report->elderly_count * 20, 100);
        $score += ($elderlyScore * 0.15);

        // 4. Disabled Count (Max 100 points * 0.15 = 15)
        $disabledScore = min($report->disabled_count * 25, 100);
        $score += ($disabledScore * 0.15);

        // 5. Family Size / Total Victims (Max 100 points * 0.10 = 10)
        $familyScore = min($report->family_members * 10, 100);
        $score += ($familyScore * 0.10);

        // 6. Logistic Shortage (Max 100 points * 0.10 = 10)
        $logisticScore = $report->logistic_stock_critical ? 100 : 0;
        $score += ($logisticScore * 0.10);

        return (int) min(round($score), 100);
    }

    /**
     * Get Priority Label based on score
     */
    public function getPriorityLabel(int $score): string
    {
        if ($score >= 81) return 'Critical';
        if ($score >= 61) return 'High';
        if ($score >= 31) return 'Medium';
        return 'Low';
    }
}
