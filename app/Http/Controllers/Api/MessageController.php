<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    use ApiResponse;

    /**
     * Broadcast a message to a specific region/channel.
     */
    public function broadcast(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'channel' => 'required|string',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), 422, $validator->errors());
        }

        $message = Message::create([
            'sender_id' => auth('api')->id(),
            'channel' => $request->channel,
            'content' => $request->content,
            'type' => 'broadcast',
        ]);

        // Here we would typically dispatch an Event like EmergencyBroadcast
        // event(new \App\Events\EmergencyBroadcast($message));

        return $this->successResponse($message, 'Message broadcasted successfully', 201);
    }
}
