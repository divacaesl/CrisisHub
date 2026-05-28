<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Distribution;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DistributionController extends Controller
{
    use ApiResponse;

    /**
     * Track the status of a distribution.
     */
    public function track($id)
    {
        $distribution = Distribution::find($id);

        if (!$distribution) {
            return $this->errorResponse('Distribution not found', 404);
        }

        return $this->successResponse($distribution, 'Distribution tracking details retrieved');
    }

    /**
     * Scan QR code to verify delivery.
     */
    public function verifyDelivery(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'qr_code' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), 422, $validator->errors());
        }

        $distribution = Distribution::where('qr_code', $request->qr_code)->first();

        if (!$distribution) {
            return $this->errorResponse('Invalid QR Code', 404);
        }

        if ($distribution->status === 'Diterima') {
            return $this->errorResponse('This distribution has already been marked as received.', 400);
        }

        $distribution->update([
            'status' => 'Diterima',
            'received_at' => now(),
        ]);

        return $this->successResponse($distribution, 'Delivery verified successfully via QR Code');
    }
}
