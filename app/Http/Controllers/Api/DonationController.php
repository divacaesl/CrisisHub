<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DonationController extends Controller
{
    use ApiResponse;

    /**
     * Submit a new donation.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'campaign_id' => 'nullable|exists:campaigns,id',
            'type' => 'required|in:Uang,Barang',
            'amount' => 'required_if:type,Uang|numeric|min:10000',
            'items' => 'required_if:type,Barang|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), 422, $validator->errors());
        }

        $donation = Donation::create([
            'user_id' => auth('api')->id(), // can be null if anonymous is allowed
            'campaign_id' => $request->campaign_id,
            'type' => $request->type,
            'amount' => $request->type === 'Uang' ? $request->amount : null,
            'items' => $request->type === 'Barang' ? $request->items : null,
            'status' => 'Submitted',
            'tracking_code' => 'DON-' . strtoupper(Str::random(10)),
        ]);

        // Logic for Payment Gateway would go here (e.g. Midtrans Snap token generation)

        return $this->successResponse($donation, 'Donation submitted successfully', 201);
    }

    /**
     * Track a donation by tracking code.
     */
    public function track($trackingCode)
    {
        $donation = Donation::where('tracking_code', $trackingCode)->first();

        if (!$donation) {
            return $this->errorResponse('Donation not found', 404);
        }

        return $this->successResponse($donation, 'Donation tracking details retrieved');
    }
}
