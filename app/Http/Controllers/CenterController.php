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

        $volApp = \App\Models\VolunteerApplication::where('user_id', $user->id)->latest()->first();

        // Check profile completeness
        $profileIncomplete = !$volApp || empty($volApp->phone_number) || empty($volApp->city) || empty($volApp->assignment_area);

        // Tugas yang diberikan kepada relawan ini
        $myTasks = VolunteerTask::with('report')
            ->where('volunteer_id', $user->id)
            ->orderByRaw("CASE status WHEN 'Requested' THEN 1 WHEN 'Assigned' THEN 2 WHEN 'On The Way' THEN 3 WHEN 'On Site' THEN 4 WHEN 'Completed' THEN 5 WHEN 'Rejected' THEN 6 ELSE 7 END")
            ->orderBy('created_at', 'desc')
            ->get();

        // Statistik tugas
        $activeTasks    = $myTasks->whereIn('status', ['Assigned', 'On The Way', 'On Site'])->count();
        $completedTasks = $myTasks->where('status', 'Completed')->count();

        // Laporan kritis yang belum tertangani (untuk referensi relawan)
        $criticalReports = Report::whereIn('status', ['Approved', 'Verified'])
            ->where('tingkat_kerusakan', 'Hancur Total')
            ->orderBy('created_at', 'desc')
            ->get();

        // Log aktivitas (tugas terbaru)
        $recentActivity = VolunteerTask::with('report')
            ->where('volunteer_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        // Available missions (reports that are active/approved/verified)
        $assignedReportIds = VolunteerTask::where('volunteer_id', $user->id)
            ->pluck('report_id')
            ->toArray();

        $availableReports = Report::whereIn('status', ['Approved', 'Verified'])
            ->whereNotIn('id', $assignedReportIds)
            ->orderBy('created_at', 'desc')
            ->get();

        // Smart assignment recommendation
        $recommendedReport = null;
        $recommendationReason = '';

        if ($volApp && $availableReports->isNotEmpty()) {
            $volunteerSkills = array_map('trim', explode(',', strtolower($volApp->skills ?? '')));
            foreach ($availableReports as $rep) {
                $matched = false;
                $reason = '';
                if (in_array('medis', $volunteerSkills) && stripos($rep->deskripsi_kondisi, 'medis') !== false) {
                    $matched = true;
                    $reason = 'keahlian medis Anda sangat dibutuhkan di sini';
                } elseif (in_array('logistik', $volunteerSkills) && (stripos($rep->deskripsi_kondisi, 'logistik') !== false || stripos($rep->deskripsi_kondisi, 'makanan') !== false)) {
                    $matched = true;
                    $reason = 'keahlian logistik Anda cocok dengan kebutuhan laporan ini';
                }

                if ($matched) {
                    $recommendedReport = $rep;
                    $dist = rand(2, 6);
                    $recommendationReason = "Anda direkomendasikan membantu karena {$reason} dan berjarak {$dist} km dari lokasi Anda.";
                    break;
                }
            }

            if (!$recommendedReport) {
                $recommendedReport = $availableReports->first();
                $dist = rand(3, 8);
                $recommendationReason = "Anda direkomendasikan membantu di " . ($recommendedReport->alamat_lengkap ? explode(',', $recommendedReport->alamat_lengkap)[0] : 'lokasi terdekat') . " karena berjarak {$dist} km dari lokasi Anda.";
            }
        }

        // Direct messages / Notifications
        $myNotifications = \App\Models\Message::where('receiver_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('centers.volunteer', compact(
            'myTasks', 'activeTasks', 'completedTasks',
            'criticalReports', 'recentActivity', 'volApp',
            'profileIncomplete', 'availableReports', 'recommendedReport',
            'recommendationReason', 'myNotifications'
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
     * Update status tugas relawan (Assigned → On The Way → On Site → Completed)
     */
    public function updateTaskStatus(Request $request, $taskId)
    {
        $user = auth()->user();
        $task = VolunteerTask::where('id', $taskId)
            ->where('volunteer_id', $user->id)
            ->firstOrFail();

        $request->validate([
            'status' => 'required|in:On The Way,On Site,Completed,Rejected,In Progress',
            'checkin_lat' => 'nullable|numeric',
            'checkin_lng' => 'nullable|numeric',
            'progress_percent' => 'nullable|integer',
            'progress_notes' => 'nullable|string',
            'aid_delivered_qty' => 'nullable|integer',
            'victims_helped' => 'nullable|integer',
            'verification_photo' => 'nullable|image|max:5000',
        ]);

        $updateData = ['status' => $request->status];

        if ($request->status === 'On The Way') {
            $updateData['started_at'] = now();
        }

        if ($request->status === 'On Site') {
            $updateData['checkin_at'] = now();
            if ($request->has('checkin_lat')) {
                $updateData['checkin_lat'] = $request->checkin_lat;
            }
            if ($request->has('checkin_lng')) {
                $updateData['checkin_lng'] = $request->checkin_lng;
            }
            if ($request->has('progress_percent')) {
                $updateData['progress_percent'] = $request->progress_percent;
            }
            if ($request->has('progress_notes')) {
                $updateData['progress_notes'] = $request->progress_notes;
            }
        }

        if ($request->status === 'Completed') {
            $updateData['completed_at'] = now();
            if ($request->has('progress_percent')) {
                $updateData['progress_percent'] = $request->progress_percent;
            }
            if ($request->has('progress_notes')) {
                $updateData['progress_notes'] = $request->progress_notes;
            }
            if ($request->has('aid_delivered_qty')) {
                $updateData['aid_delivered_qty'] = $request->aid_delivered_qty;
            }
            if ($request->has('victims_helped')) {
                $updateData['victims_helped'] = $request->victims_helped;
            }

            if ($request->hasFile('verification_photo')) {
                $path = $request->file('verification_photo')->store('public/proofs');
                $updateData['verification_photo'] = str_replace('public/', '', $path);
            }
        }

        $task->update($updateData);

        return back()->with('success', 'Status tugas berhasil diperbarui.');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $volApp = \App\Models\VolunteerApplication::where('user_id', $user->id)->latest()->first();

        if (!$volApp) {
            $volApp = new \App\Models\VolunteerApplication();
            $volApp->user_id = $user->id;
            $volApp->status = 'approved';
        }

        $request->validate([
            'phone_number' => 'required|string',
            'city' => 'required|string',
            'assignment_area' => 'required|string',
            'skills' => 'nullable|array',
        ]);

        $skillsStr = $request->skills ? implode(', ', $request->skills) : null;

        $volApp->phone_number = $request->phone_number;
        $volApp->city = $request->city;
        $volApp->assignment_area = $request->assignment_area;
        $volApp->skills = $skillsStr;
        $volApp->save();

        return back()->with('success', 'Profil relawan berhasil diperbarui.');
    }

    public function toggleAvailability(Request $request)
    {
        $user = auth()->user();
        $volApp = \App\Models\VolunteerApplication::where('user_id', $user->id)->latest()->first();

        if ($volApp) {
            $request->validate([
                'availability_status' => 'required|in:Siap Bertugas,Tidak Tersedia',
            ]);
            $volApp->update([
                'availability_status' => $request->availability_status
            ]);
            return back()->with('success', 'Status ketersediaan berhasil diperbarui.');
        }

        return back()->with('error', 'Aplikasi relawan tidak ditemukan.');
    }

    public function claimTask(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'report_id' => 'required|exists:reports,id',
        ]);

        // Check if already claimed/assigned
        $exists = VolunteerTask::where('volunteer_id', $user->id)
            ->where('report_id', $request->report_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Anda sudah mengajukan atau ditugaskan untuk misi ini.');
        }

        VolunteerTask::create([
            'volunteer_id' => $user->id,
            'report_id' => $request->report_id,
            'task' => 'Misi Mandiri Relawan',
            'status' => 'Requested',
            'assigned_at' => now(),
        ]);

        return back()->with('success', 'Pengajuan penugasan berhasil dikirim. Menunggu konfirmasi admin.');
    }
}
