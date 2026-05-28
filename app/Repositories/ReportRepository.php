<?php

namespace App\Repositories;

use App\Contracts\ReportRepositoryInterface;
use App\Models\Report;

class ReportRepository implements ReportRepositoryInterface
{
    public function getAllPaginated($perPage = 15, $filters = [])
    {
        $query = Report::query();

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['disaster_type'])) {
            $query->where('disaster_type', $filters['disaster_type']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function findById($id)
    {
        return Report::findOrFail($id);
    }

    public function create(array $data)
    {
        return Report::create($data);
    }

    public function update($id, array $data)
    {
        $report = $this->findById($id);
        $report->update($data);
        return $report;
    }

    public function delete($id)
    {
        $report = $this->findById($id);
        return $report->delete();
    }

    public function findDuplicates($latitude, $longitude, $timeFrameHours = 2, $radiusMeters = 500)
    {
        // Simple Haversine formula bounding box for quick filtering could be used here.
        // For simplicity in Eloquent without raw GIS extensions, we use a basic distance calculation.
        // In a real production system, use PostGIS or MySQL ST_Distance_Sphere.
        $timeLimit = now()->subHours($timeFrameHours);

        return Report::selectRaw("*, 
            ( 6371000 * acos( cos( radians(?) ) *
            cos( radians( latitude ) )
            * cos( radians( longitude ) - radians(?)
            ) + sin( radians(?) ) *
            sin( radians( latitude ) ) )
            ) AS distance", [$latitude, $longitude, $latitude])
        ->having('distance', '<', $radiusMeters)
        ->where('created_at', '>=', $timeLimit)
        ->get();
    }
}
