<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VolunteerTask;
use App\Models\Report;

class CenterController extends Controller
{
    public function volunteer()
    {
        $user = auth()->user();

        // Tugas yang diberikan kepada relawan ini
        $myTasks = VolunteerTask::with('report')
            ->where('volunteer_id', $user->id)
            ->orderByRaw("FIELD(status, 'Assigned', 'In Progress', 'Completed')")
            ->orderBy('created_at', 'desc')
            ->get();

        // Statistik tugas
        $activeTasks    = $myTasks->whereIn('status', ['Assigned', 'In Progress'])->count();
        $completedTasks = $myTasks->where('status', 'Completed')->count();

        // Laporan kritis yang belum tertangani (untuk referensi relawan)
        $criticalReports = Report::where('status', 'Approved')
            ->where('tingkat_kerusakan', 'Hancur Total')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Log aktivitas (tugas terbaru)
        $recentActivity = VolunteerTask::with('report')
            ->where('volunteer_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        return view('centers.volunteer', compact(
            'myTasks', 'activeTasks', 'completedTasks',
            'criticalReports', 'recentActivity'
        ));
    }

    public function organization()
    {
        return view('centers.organization');
    }

    public function admin()
    {
        return redirect()->route('admin.dashboard');
    }

    /**
     * Update status tugas relawan (Assigned → In Progress → Completed)
     */
    public function updateTaskStatus(Request $request, $taskId)
    {
        $user = auth()->user();
        $task = VolunteerTask::where('id', $taskId)
            ->where('volunteer_id', $user->id)
            ->firstOrFail();

        $request->validate([
            'status' => 'required|in:In Progress,Completed,Rejected'
        ]);

        $task->update(['status' => $request->status]);

        return back()->with('success', 'Status tugas berhasil diperbarui.');
    }
}
