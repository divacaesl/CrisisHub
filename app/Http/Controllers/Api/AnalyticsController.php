<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsSnapshot;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    use ApiResponse;

    /**
     * Get analytics snapshots for dashboard charts.
     */
    public function getSnapshots(Request $request)
    {
        $period = $request->query('period', 'daily'); // daily, weekly, monthly
        $metric = $request->query('metric_key'); // optional filter

        $query = AnalyticsSnapshot::where('period', $period);
        
        if ($metric) {
            $query->where('metric_key', $metric);
        }

        $data = $query->orderBy('recorded_at', 'asc')->get();

        return $this->successResponse($data, 'Analytics snapshots retrieved');
    }
}
