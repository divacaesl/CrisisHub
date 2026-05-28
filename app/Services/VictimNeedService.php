<?php

namespace App\Services;

use App\Contracts\VictimNeedRepositoryInterface;
use App\Contracts\ReportRepositoryInterface;
use Exception;

class VictimNeedService
{
    protected $victimNeedRepository;
    protected $reportRepository;

    public function __construct(
        VictimNeedRepositoryInterface $victimNeedRepository,
        ReportRepositoryInterface $reportRepository
    ) {
        $this->victimNeedRepository = $victimNeedRepository;
        $this->reportRepository = $reportRepository;
    }

    public function getNeedsForReport($reportId)
    {
        // Check if report exists
        $this->reportRepository->findById($reportId);
        
        return $this->victimNeedRepository->getByReportId($reportId);
    }

    public function addNeedToReport($reportId, array $data)
    {
        // Check if report exists
        $this->reportRepository->findById($reportId);

        $data['report_id'] = $reportId;
        $data['user_id'] = auth('api')->id();
        $data['status'] = 'Pending';

        return $this->victimNeedRepository->create($data);
    }
}
