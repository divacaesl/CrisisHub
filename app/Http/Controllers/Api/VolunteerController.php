<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VolunteerLocation;
use App\Models\VolunteerTask;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VolunteerController extends Controller
{
    use ApiResponse;

    /**
     * Get nearby volunteers for a specific coordinate.
     */
    public function nearby(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'nullable|numeric' // in meters, default 5000
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), 422, $validator->errors());
        }

        $lat = $request->latitude;
        $lng = $request->longitude;
        $radius = $request->radius ?? 5000;

        // Haversine formula to find volunteers within radius
        // Note: In production, you should query the latest location per volunteer.
        // For simplicity, we just query recent locations within the last hour.
        $timeLimit = now()->subHour();

        $nearby = VolunteerLocation::with('volunteer')
            ->selectRaw("*, 
                ( 6371000 * acos( cos( radians(?) ) *
                cos( radians( latitude ) )
                * cos( radians( longitude ) - radians(?)
                ) + sin( radians(?) ) *
                sin( radians( latitude ) ) )
                ) AS distance", [$lat, $lng, $lat])
            ->having('distance', '<', $radius)
            ->where('recorded_at', '>=', $timeLimit)
            ->orderBy('distance')
            ->get();

        return $this->successResponse($nearby, 'Nearby volunteers retrieved successfully');
    }

    /**
     * Update volunteer location
     */
    public function updateLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'accuracy' => 'nullable|numeric'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), 422, $validator->errors());
        }

        // Location tracking should only be active if the volunteer has an active task.
        $hasActiveTask = VolunteerTask::where('volunteer_id', auth('api')->id())
            ->whereIn('status', ['Menuju Lokasi', 'Sedang Bertugas'])
            ->exists();

        if (!$hasActiveTask) {
            return $this->errorResponse('Location tracking is only active during an active task.', 403);
        }

        $location = VolunteerLocation::create([
            'volunteer_id' => auth('api')->id(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'accuracy' => $request->accuracy,
            'recorded_at' => now(),
        ]);

        return $this->successResponse($location, 'Location updated successfully');
    }
}
