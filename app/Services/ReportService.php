<?php

namespace App\Services;

use App\Contracts\ReportRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Exception;

class ReportService
{
    protected $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function getAllReports($perPage = 15, $filters = [])
    {
        return $this->reportRepository->getAllPaginated($perPage, $filters);
    }

    public function createReport(array $data, $imageFile = null)
    {
        // Map API fields to database columns
        $mappedData = [];
        if (isset($data['disaster_type'])) {
            $mappedData['jenis_bencana'] = $data['disaster_type'];
        }
        if (isset($data['damage_level'])) {
            $levels = [
                1 => 'Rendah',
                2 => 'Sedang',
                3 => 'Tinggi',
                4 => 'Hancur Total',
                5 => 'Hancur Total',
            ];
            $mappedData['tingkat_kerusakan'] = $levels[$data['damage_level']] ?? 'Sedang';
        }
        if (isset($data['victims_count'])) {
            $mappedData['jumlah_korban'] = $data['victims_count'];
        }
        if (isset($data['description'])) {
            $mappedData['deskripsi_kondisi'] = $data['description'];
        }
        if (isset($data['latitude'])) {
            $mappedData['latitude'] = $data['latitude'];
        }
        if (isset($data['longitude'])) {
            $mappedData['longitude'] = $data['longitude'];
        }

        // Handle File Upload
        if ($imageFile) {
            $path = $imageFile->store('reports', 'public');
            $mappedData['foto_path'] = $path;
        }

        // Check for duplicates
        $duplicates = $this->reportRepository->findDuplicates($mappedData['latitude'], $mappedData['longitude']);
        
        if ($duplicates->count() > 0) {
            $mappedData['flag_duplicate'] = true;
        }

        $mappedData['status'] = 'Pending';
        $mappedData['user_id'] = auth()->id() ?? auth('api')->id();

        $report = $this->reportRepository->create($mappedData);

        // Async dispatch Smart Priority Scoring
        \App\Jobs\CalculatePriorityScore::dispatch($report->id);

        return $report;
    }

    public function getReportById($id)
    {
        return $this->reportRepository->findById($id);
    }
}
