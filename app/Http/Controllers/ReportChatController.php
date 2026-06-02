<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportChatController extends Controller
{
    public function getMessages($reportId)
    {
        $report = Report::findOrFail($reportId);
        
        // Cek authorization: Hanya pembuat laporan atau admin yang boleh melihat
        if (auth()->id() !== $report->user_id && !auth()->user()->hasRole(['Admin', 'Super Admin'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $messages = Message::with('sender:id,name')
            ->where('channel', 'report-' . $report->id)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'content' => $msg->content,
                    'sender_name' => $msg->sender->name,
                    'sender_id' => $msg->sender_id,
                    'is_admin' => \App\Models\User::find($msg->sender_id)->hasRole(['Admin', 'Super Admin']),
                    'time' => $msg->created_at->format('H:i, d M Y'),
                ];
            });

        return response()->json($messages);
    }

    public function sendMessage(Request $request, $reportId)
    {
        $report = Report::findOrFail($reportId);
        
        if (auth()->id() !== $report->user_id && !auth()->user()->hasRole(['Admin', 'Super Admin'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'channel' => 'report-' . $report->id,
            'content' => $request->content,
            'type' => 'direct'
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'content' => $message->content,
                'sender_name' => auth()->user()->name,
                'sender_id' => auth()->id(),
                'is_admin' => auth()->user()->hasRole(['Admin', 'Super Admin']),
                'time' => $message->created_at->format('H:i, d M Y'),
            ]
        ]);
    }
}
