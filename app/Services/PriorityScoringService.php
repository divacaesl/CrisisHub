<?php

namespace App\Services;

use App\Models\PriorityScore;
use App\Models\Report;
use App\Models\VolunteerTask;
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

        // 1. Damage Level Score (Max 100 points, weight 40%)
        $damageScore = match ($report->tingkat_kerusakan) {
            'Hancur Total' => 100,
            'Tinggi'       => 75,
            'Sedang'       => 50,
            'Rendah'       => 25,
            default        => 10,
        };

        // 2. Victims & Vulnerabilities Score (Max 100 points, weight 30%)
        // Scale victims: 100 points for 50+ victims
        $victimsBase = min(100, ($report->jumlah_korban ?? 0) * 2);
        // Vulnerable groups weights: infants (5 pts), elderly (3 pts), disabled (5 pts)
        $vulnWeight = (($report->infants_count ?? 0) * 5) + 
                      (($report->elderly_count ?? 0) * 3) + 
                      (($report->disabled_count ?? 0) * 5);
        $victimsScore = min(100, $victimsBase + $vulnWeight);

        // 3. Resource Availability Factor (Max 100 points, weight 30%)
        // Starts at 100 (complete availability, which minimizes urgency)
        $resourceAvailability = 100;

        // Deduction if logistics stock is critical (representing low resource availability)
        if ($report->logistic_stock_critical) {
            $resourceAvailability -= 40;
        }

        // Deduction based on total number of other approved/active reports in system (scarcity load)
        $activeApprovedCount = Report::whereIn('status', ['Verified', 'In Progress'])
            ->where('id', '!=', $report->id)
            ->count();
        $scarcityLoad = min(30, $activeApprovedCount * 5); // Max 30 points penalty
        $resourceAvailability -= $scarcityLoad;

        // Addition based on volunteers assigned to this specific report (representing support/buffer)
        $assignedVolunteersCount = VolunteerTask::where('report_id', $report->id)
            ->whereIn('status', ['Assigned', 'On The Way', 'On Site', 'Completed'])
            ->count();
        $volunteerBuffer = min(45, $assignedVolunteersCount * 15); // Max 45 points buffer
        $resourceAvailability += $volunteerBuffer;

        // Clamp resource availability between 0 and 100
        $resourceAvailability = max(0, min(100, $resourceAvailability));

        // Resource scarcity is the inverse of availability
        $resourceScarcity = 100 - $resourceAvailability;

        // 4. Final Priority Score Calculation (Weight: 40% Damage, 30% Victims, 30% Resource Scarcity)
        $score = ($damageScore * 0.4) + ($victimsScore * 0.3) + ($resourceScarcity * 0.3);
        $score = (int) max(10, min(100, round($score))); // Clamp between 10 and 100

        // Determine Level
        if ($score >= 80) {
            $level = 'Kritis';
        } elseif ($score >= 50) {
            $level = 'Tinggi';
        } elseif ($score >= 25) {
            $level = 'Sedang';
        } else {
            $level = 'Rendah';
        }

        // Save Priority Score record
        $priorityScore = PriorityScore::updateOrCreate(
            ['report_id' => $report->id],
            [
                'score' => $score,
                'level' => $level,
                'variables_snapshot' => json_encode([
                    'tingkat_kerusakan' => $report->tingkat_kerusakan,
                    'jumlah_korban' => $report->jumlah_korban,
                    'infants_count' => $report->infants_count,
                    'elderly_count' => $report->elderly_count,
                    'disabled_count' => $report->disabled_count,
                    'logistic_stock_critical' => $report->logistic_stock_critical,
                    'active_approved_reports' => $activeApprovedCount,
                    'assigned_volunteers' => $assignedVolunteersCount,
                    'resource_availability' => $resourceAvailability
                ]),
                'calculated_at' => now(),
            ]
        );

        // Sync to report table
        $report->update([
            'priority_score' => $score
        ]);

        return $priorityScore;
    }
}
