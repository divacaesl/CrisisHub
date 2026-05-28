<?php

namespace App\Contracts;

interface ReportRepositoryInterface
{
    public function getAllPaginated($perPage = 15, $filters = []);
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function findDuplicates($latitude, $longitude, $timeFrameHours = 2, $radiusMeters = 500);
}
