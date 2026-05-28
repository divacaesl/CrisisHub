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
        // Handle File Upload
        if ($imageFile) {
            // Ideally compress image here, for now just store
            $path = $imageFile->store('reports', 'public');
            $data['photo_path'] = $path; // assuming there's a photo_path column, or we store in description
        }

        // Check for duplicates
        $duplicates = $this->reportRepository->findDuplicates($data['latitude'], $data['longitude']);
        
        if ($duplicates->count() > 0) {
            $data['flag_duplicate'] = true;
        }

        $data['status'] = 'Pending';
        $data['user_id'] = auth()->id() ?? auth('api')->id();

        $report = $this->reportRepository->create($data);

        // Async dispatch Smart Priority Scoring
        \App\Jobs\CalculatePriorityScore::dispatch($report->id);

        return $report;
    }

    public function getReportById($id)
    {
        return $this->reportRepository->findById($id);
    }
}
