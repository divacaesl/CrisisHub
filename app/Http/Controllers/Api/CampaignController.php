<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CampaignController extends Controller
{
    use ApiResponse;

    /**
     * Get all active campaigns.
     */
    public function index()
    {
        $campaigns = Campaign::where('status', 'Active')->orderBy('created_at', 'desc')->paginate(10);
        
        return $this->successResponse($campaigns->items(), 'Campaigns retrieved successfully', 200, [
            'pagination' => [
                'current_page' => $campaigns->currentPage(),
                'last_page' => $campaigns->lastPage(),
                'per_page' => $campaigns->perPage(),
                'total' => $campaigns->total()
            ]
        ]);
    }

    /**
     * Store a new campaign (Organisasi Bantuan only).
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'target_amount' => 'required|numeric|min:0',
            'end_date' => 'nullable|date|after:today',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), 422, $validator->errors());
        }

        $campaign = Campaign::create([
            'org_id' => auth('api')->id(),
            'title' => $request->title,
            'description' => $request->description,
            'target_amount' => $request->target_amount,
            'current_amount' => 0,
            'status' => 'Active',
            'start_date' => now(),
            'end_date' => $request->end_date,
        ]);

        return $this->successResponse($campaign, 'Campaign created successfully', 201);
    }
}
