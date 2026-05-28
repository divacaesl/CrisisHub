<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    use ApiResponse;

    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'disaster_type']);
        $reports = $this->reportService->getAllReports(15, $filters);
        
        return $this->successResponse($reports->items(), 'Reports retrieved successfully', 200, [
            'pagination' => [
                'current_page' => $reports->currentPage(),
                'last_page' => $reports->lastPage(),
                'per_page' => $reports->perPage(),
                'total' => $reports->total()
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'disaster_type' => 'required|string|max:255',
            'damage_level' => 'required|integer|min:1|max:5',
            'victims_count' => 'required|integer|min:0',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Max 5MB
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), 422, $validator->errors());
        }

        $report = $this->reportService->createReport(
            $validator->validated(), 
            $request->file('photo')
        );

        return $this->successResponse($report, 'Report created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $report = $this->reportService->getReportById($id);
            return $this->successResponse($report, 'Report retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Report not found', 404);
        }
    }

    /**
     * Get needs for a specific report.
     */
    public function getNeeds($id, \App\Services\VictimNeedService $victimNeedService)
    {
        try {
            $needs = $victimNeedService->getNeedsForReport($id);
            return $this->successResponse($needs, 'Victim needs retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Report not found', 404);
        }
    }

    /**
     * Add a need to a specific report.
     */
    public function addNeed(Request $request, $id, \App\Services\VictimNeedService $victimNeedService)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|string|max:255',
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'urgency_level' => 'required|integer|min:1|max:4',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), 422, $validator->errors());
        }

        try {
            $need = $victimNeedService->addNeedToReport($id, $validator->validated());
            return $this->successResponse($need, 'Victim need added successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to add need. Report may not exist.', 404);
        }
    }

    /**
     * Verify a report (Admin only).
     */
    public function verify(Request $request, $id)
    {
            'action' => 'required|in:Approved,Rejected,Flagged Duplicate',
            'note' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), 422, $validator->errors());
        }

        try {
            $report = $this->reportService->getReportById($id);
            
            // Log the verification
            \App\Models\ReportVerification::create([
                'report_id' => $report->id,
                'admin_id' => auth('api')->id(),
                'action' => $validator->validated()['action'],
                'note' => $validator->validated()['note'] ?? null,
            ]);

            // Update report status
            $statusMap = [
                'Approved' => 'Verified',
                'Rejected' => 'Rejected',
                'Flagged Duplicate' => 'Pending' // Requires further review
            ];

            $report->update([
                'status' => $statusMap[$validator->validated()['action']]
            ]);

            return $this->successResponse($report, 'Report verified successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to verify report. It may not exist.', 404);
        }
}
