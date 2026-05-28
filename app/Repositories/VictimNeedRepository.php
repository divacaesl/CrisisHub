<?php

namespace App\Repositories;

use App\Contracts\VictimNeedRepositoryInterface;
use App\Models\VictimNeed;

class VictimNeedRepository implements VictimNeedRepositoryInterface
{
    public function getByReportId($reportId)
    {
        return VictimNeed::where('report_id', $reportId)->orderBy('urgency_level', 'asc')->get();
    }

    public function create(array $data)
    {
        return VictimNeed::create($data);
    }

    public function update($id, array $data)
    {
        $need = VictimNeed::findOrFail($id);
        $need->update($data);
        return $need;
    }
}
