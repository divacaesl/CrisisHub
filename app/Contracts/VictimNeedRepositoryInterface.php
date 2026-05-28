<?php

namespace App\Contracts;

interface VictimNeedRepositoryInterface
{
    public function getByReportId($reportId);
    public function create(array $data);
    public function update($id, array $data);
}
