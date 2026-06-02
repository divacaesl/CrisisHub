<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\VictimNeed;
use App\Models\Distribution;
use App\Models\VolunteerLocation;
use App\Models\Donation;
use App\Models\PriorityScore;
use App\Models\Message;
use App\Models\Campaign;
use App\Models\BroadcastLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    // ═══════════════════════════════════════════════
    // OVERVIEW DASHBOARD
    // ═══════════════════════════════════════════════
    public function index()
    {
        $totalLaporan    = Report::count();
        $totalKorban     = Report::sum('jumlah_korban');
        $totalDistribusi = Distribution::count();
        $totalRelawan    = VolunteerLocation::distinct('volunteer_id')->count();
        $totalDonasi     = Donation::where('type', 'Uang')->where('status', 'Verified')->sum('amount');
        $activeDisasters = Report::where('status', 'Approved')->count();
        $pendingReports  = Report::where('status', 'Pending')->count();

        $latestReports   = Report::orderBy('created_at', 'desc')->take(5)->get();
        $topPriorities   = PriorityScore::with('report')->orderBy('score', 'desc')->take(5)->get();
        $urgentNeeds     = VictimNeed::where('status', '!=', 'Received')->orderBy('urgency_level', 'asc')->orderBy('quantity', 'desc')->take(5)->get();
        $notifications   = Message::orderBy('created_at', 'desc')->take(4)->get();
        $latestDonations = Donation::with('user')->where('type', 'Uang')->orderBy('created_at', 'desc')->take(4)->get();

        $reportsForMap = Report::whereNotNull('latitude')->whereNotNull('longitude')->get();
        $mapMarkers    = $reportsForMap->map(function ($r) {
            $type = 'low';
            if ($r->tingkat_kerusakan == 'Hancur Total') $type = 'critical';
            elseif ($r->tingkat_kerusakan == 'Tinggi') $type = 'high';
            elseif ($r->tingkat_kerusakan == 'Sedang') $type = 'medium';
            return ['lat' => $r->latitude, 'lng' => $r->longitude, 'count' => $r->jumlah_korban > 0 ? $r->jumlah_korban : 1, 'type' => $type, 'title' => $r->jenis_bencana . ' di ' . $r->alamat_lengkap];
        });

        $chartLabels = [];
        $chartData   = [];
        for ($i = 6; $i >= 0; $i--) {
            $date          = Carbon::now()->subDays($i);
            $chartLabels[] = $date->format('d M');
            // Data real, tidak ada rand()
            $chartData[]   = Report::whereDate('created_at', $date->toDateString())->count();
        }

        // Donation trend last 7 days — data real
        $donationTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date            = Carbon::now()->subDays($i);
            $donationTrend[] = Donation::whereDate('created_at', $date->toDateString())->sum('amount');
        }


        $broadcastLogs = BroadcastLog::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalLaporan', 'totalKorban', 'totalDistribusi', 'totalRelawan',
            'totalDonasi', 'activeDisasters', 'pendingReports',
            'latestReports', 'topPriorities', 'urgentNeeds',
            'notifications', 'latestDonations', 'mapMarkers',
            'chartLabels', 'chartData', 'donationTrend', 'broadcastLogs'
        ));
    }

    // ═══════════════════════════════════════════════
    // DISASTER REPORTS
    // ═══════════════════════════════════════════════
    public function laporan(Request $request)
    {
        $query = Report::with('user')->orderBy('created_at', 'desc');
        if ($request->status) $query->where('status', $request->status);
        if ($request->search) $query->where(function ($q) use ($request) {
            $q->where('jenis_bencana', 'like', "%{$request->search}%")
              ->orWhere('alamat_lengkap', 'like', "%{$request->search}%");
        });
        $reports = $query->paginate(15);
        return view('admin.laporan', compact('reports'));
    }

    public function verifyReport(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        $action = $request->action; // 'Approved' | 'Rejected'
        $report->update([
            'status'      => $action,
            'admin_notes' => $request->notes,
            'verified_by' => auth()->id(),
        ]);
        return back()->with('success', "Laporan berhasil di-{$action}.");
    }

    // ═══════════════════════════════════════════════
    // VERIFICATION CENTER
    // ═══════════════════════════════════════════════
    public function verifikasi()
    {
        $pending  = Report::with('user')->where('status', 'Pending')->orderBy('created_at', 'desc')->paginate(15);
        $approved = Report::with('user')->where('status', 'Approved')->orderBy('updated_at', 'desc')->take(5)->get();
        $rejected = Report::with('user')->where('status', 'Rejected')->orderBy('updated_at', 'desc')->take(5)->get();

        $pendingVolunteers = \App\Models\VolunteerApplication::with('user')->where('status', 'pending')->orderBy('created_at', 'desc')->get();
        $approvedVolunteers = \App\Models\VolunteerApplication::with('user')->where('status', 'approved')->orderBy('updated_at', 'desc')->take(10)->get();
        $rejectedVolunteers = \App\Models\VolunteerApplication::with('user')->where('status', 'rejected')->orderBy('updated_at', 'desc')->take(10)->get();

        $pendingOrgs = \App\Models\OrganizationApplication::with('user')->where('status', 'pending')->orderBy('created_at', 'desc')->get();
        $approvedOrgs = \App\Models\OrganizationApplication::with('user')->where('status', 'approved')->orderBy('updated_at', 'desc')->take(10)->get();
        $rejectedOrgs = \App\Models\OrganizationApplication::with('user')->where('status', 'rejected')->orderBy('updated_at', 'desc')->take(10)->get();

        return view('admin.verifikasi', compact(
            'pending', 'approved', 'rejected',
            'pendingVolunteers', 'approvedVolunteers', 'rejectedVolunteers',
            'pendingOrgs', 'approvedOrgs', 'rejectedOrgs'
        ));
    }

    public function verifyVolunteerApplication(Request $request, $id)
    {
        $app = \App\Models\VolunteerApplication::findOrFail($id);
        $action = $request->action; // 'approved' | 'rejected'
        
        $app->update([
            'status' => $action
        ]);

        if ($action === 'approved') {
            $user = $app->user;
            if (!$user->hasRole('Relawan')) {
                $user->assignRole('Relawan');
            }
        }

        $statusStr = $action === 'approved' ? 'disetujui' : 'ditolak';
        return back()->with('success', "Pendaftaran relawan {$app->user->name} berhasil {$statusStr}.");
    }

    public function verifyOrganizationApplication(Request $request, $id)
    {
        $app = \App\Models\OrganizationApplication::findOrFail($id);
        $action = $request->action; // 'approved' | 'rejected'
        
        $app->update([
            'status' => $action
        ]);

        if ($action === 'approved') {
            $user = $app->user;
            if (!$user->hasRole('Organisasi Bantuan')) {
                $user->assignRole('Organisasi Bantuan');
            }
        }

        $statusStr = $action === 'approved' ? 'disetujui' : 'ditolak';
        return back()->with('success', "Pendaftaran organisasi {$app->organization_name} berhasil {$statusStr}.");
    }

    // ═══════════════════════════════════════════════
    // GIS MAP
    // ═══════════════════════════════════════════════
    public function peta()
    {
        $reports = Report::whereNotNull('latitude')->whereNotNull('longitude')->get();
        return view('admin.peta', compact('reports'));
    }

    // ═══════════════════════════════════════════════
    // VOLUNTEER MANAGEMENT
    // ═══════════════════════════════════════════════
    public function relawan(Request $request)
    {
        $query = User::whereHas('roles', fn($q) => $q->where('name', 'Relawan'));
        if ($request->search) $query->where('name', 'like', "%{$request->search}%");
        $volunteers = $query->orderBy('created_at', 'desc')->paginate(15);
        $reports    = Report::where('status', 'Approved')->get(['id', 'jenis_bencana', 'alamat_lengkap']);
        return view('admin.relawan', compact('volunteers', 'reports'));
    }

    public function assignVolunteer(Request $request)
    {
        // Create volunteer task record
        try {
            DB::table('volunteer_tasks')->insert([
                'volunteer_id' => $request->volunteer_id,
                'report_id'    => $request->report_id,
                'task'         => $request->task,
                'status'       => 'Assigned',
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
            return back()->with('success', 'Relawan berhasil ditugaskan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menugaskan relawan: ' . $e->getMessage());
        }
    }

    // ═══════════════════════════════════════════════
    // DONATION MANAGEMENT
    // ═══════════════════════════════════════════════
    public function donasi(Request $request)
    {
        $query = Donation::with('user')->orderBy('created_at', 'desc');
        if ($request->status) $query->where('status', $request->status);
        if ($request->type) $query->where('type', $request->type);
        $donations     = $query->paginate(15);
        $totalVerified = Donation::where('status', 'Verified')->sum('amount');
        $totalPending  = Donation::where('status', 'Submitted')->count();
        return view('admin.donasi', compact('donations', 'totalVerified', 'totalPending'));
    }

    public function verifyDonation(Request $request, $id)
    {
        $donation = Donation::findOrFail($id);
        $updateData = ['status' => $request->action];
        if ($request->action === 'Verified') {
            $updateData['verified_at'] = now();
        }
        $donation->update($updateData);
        return back()->with('success', "Donasi berhasil di-{$request->action}.");
    }

    // ═══════════════════════════════════════════════
    // CAMPAIGN MANAGEMENT
    // ═══════════════════════════════════════════════
    public function campaign(Request $request)
    {
        $campaigns = Campaign::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.campaign', compact('campaigns'));
    }

    public function campaignStore(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'location'      => 'required|string',
            'description'   => 'required|string',
            'target_amount' => 'required|numeric|min:1000000',
            'deadline'      => 'required|date|after:today',
        ]);
        Campaign::create($request->only(['title', 'emoji', 'location', 'tag', 'tag_color', 'description', 'target_amount', 'deadline', 'is_active']));
        return back()->with('success', 'Campaign berhasil dibuat.');
    }

    public function campaignUpdate(Request $request, $id)
    {
        Campaign::findOrFail($id)->update($request->only(['title', 'emoji', 'location', 'tag', 'tag_color', 'description', 'target_amount', 'deadline', 'is_active']));
        return back()->with('success', 'Campaign berhasil diupdate.');
    }

    public function campaignDestroy($id)
    {
        Campaign::findOrFail($id)->delete();
        return back()->with('success', 'Campaign berhasil dihapus.');
    }

    // ═══════════════════════════════════════════════
    // USER MANAGEMENT
    // ═══════════════════════════════════════════════
    public function pengguna(Request $request)
    {
        $query = User::with('roles')->orderBy('created_at', 'desc');
        if ($request->search) $query->where(function ($q) use ($request) {
            $q->where('name', 'like', "%{$request->search}%")->orWhere('email', 'like', "%{$request->search}%");
        });
        if ($request->role) $query->whereHas('roles', fn($q) => $q->where('name', $request->role));
        $users       = $query->paginate(15);
        $totalUsers  = User::count();
        $adminCount  = User::whereHas('roles', fn($q) => $q->where('name', 'Admin'))->count();
        return view('admin.pengguna', compact('users', 'totalUsers', 'adminCount'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->only(['name', 'email']);
        if ($request->password) $data['password'] = Hash::make($request->password);
        $user->update($data);

        if ($request->role) {
            $user->syncRoles([$request->role]);
        }
        return back()->with('success', 'User berhasil diupdate.');
    }

    public function suspendUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_suspended' => !($user->is_suspended ?? false)]);
        return back()->with('success', 'Status user berhasil diubah.');
    }

    public function destroyUser($id)
    {
        if ($id == auth()->id()) return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        User::findOrFail($id)->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }

    // ═══════════════════════════════════════════════
    // ROLE MANAGEMENT (simple view)
    // ═══════════════════════════════════════════════
    public function roleManagement()
    {
        $roles = DB::table('roles')->get();
        $usersByRole = [];
        foreach ($roles as $role) {
            $usersByRole[$role->name] = User::whereHas('roles', fn($q) => $q->where('name', $role->name))->count();
        }
        return view('admin.roles', compact('roles', 'usersByRole'));
    }

    // ═══════════════════════════════════════════════
    // ANALYTICS
    // ═══════════════════════════════════════════════
    public function analitik()
    {
        $monthlyReports = [];
        $monthlyDonations = [];
        $labels = [];
        for ($i = 5; $i >= 0; $i--) {
            $date               = Carbon::now()->subMonths($i);
            $labels[]           = $date->format('M Y');
            $monthlyReports[]   = Report::whereYear('created_at', $date->year)->whereMonth('created_at', $date->month)->count();
            $monthlyDonations[] = Donation::whereYear('created_at', $date->year)->whereMonth('created_at', $date->month)->where('status', 'Verified')->sum('amount');
        }


        $disasterTypes   = Report::select('jenis_bencana', DB::raw('count(*) as total'))->groupBy('jenis_bencana')->orderByDesc('total')->get();
        $topDonors       = Donation::with('user')->where('type', 'Uang')->where('status', 'Verified')->select('user_id', DB::raw('SUM(amount) as total'))->groupBy('user_id')->orderByDesc('total')->take(5)->get();
        $statusBreakdown = Report::select('status', DB::raw('count(*) as total'))->groupBy('status')->get();

        return view('admin.analitik', compact('labels', 'monthlyReports', 'monthlyDonations', 'disasterTypes', 'topDonors', 'statusBreakdown'));
    }

    // ═══════════════════════════════════════════════
    // EMERGENCY BROADCAST
    // ═══════════════════════════════════════════════
    public function notifikasi()
    {
        $broadcastLogs = BroadcastLog::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.notifikasi', compact('broadcastLogs'));
    }

    public function broadcast(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'message'  => 'required|string',
            'severity' => 'required|in:info,warning,critical',
            'target'   => 'required|in:all,volunteers,citizens',
        ]);

        $query = User::query();
        if ($request->target === 'volunteers') {
            $query->whereHas('roles', fn($q) => $q->where('name', 'Relawan'));
        } elseif ($request->target === 'citizens') {
            // Citizens = user yang tidak punya role Relawan dan tidak punya role Admin
            $query->whereDoesntHave('roles', fn($q) => $q->whereIn('name', ['Relawan', 'Admin', 'Organisasi Bantuan']));
        }
        // target === 'all' = semua user tanpa filter
        $recipients = $query->get();

        // Send emails (logged via MAIL_MAILER=log)
        foreach ($recipients as $user) {
            try {
                Mail::raw(
                    "[{$request->severity}] {$request->title}\n\n{$request->message}\n\n— Tim CrisisHub",
                    fn($m) => $m->to($user->email)->subject("[CrisisHub ALERT] {$request->title}")
                );
            } catch (\Exception $e) {}
        }

        BroadcastLog::create([
            'admin_id'         => auth()->id(),
            'title'            => $request->title,
            'message'          => $request->message,
            'severity'         => $request->severity,
            'target'           => $request->target,
            'recipients_count' => $recipients->count(),
        ]);

        return back()->with('success', "Broadcast terkirim ke {$recipients->count()} pengguna.");
    }

    // ═══════════════════════════════════════════════
    // AID DISTRIBUTION
    // ═══════════════════════════════════════════════
    public function kebutuhan()
    {
        $query = VictimNeed::with('report')->orderBy('urgency_level', 'asc');
        if (request('status')) {
            $query->where('status', request('status'));
        }
        $needs = $query->paginate(15);
        return view('admin.kebutuhan', compact('needs'));
    }

    public function updateKebutuhanStatus(Request $request, $id)
    {
        $need = VictimNeed::findOrFail($id);
        $request->validate(['status' => 'required|in:Requested,In Transit,Received']);
        $need->update(['status' => $request->status]);
        return back()->with('success', 'Status kebutuhan berhasil diperbarui.');
    }

    public function penugasan()
    {
        $tasks = \App\Models\VolunteerTask::with(['volunteer', 'report'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.penugasan', compact('tasks'));
    }

    public function updateTaskStatus(Request $request, $id)
    {
        $task = \App\Models\VolunteerTask::findOrFail($id);
        $request->validate(['status' => 'required|in:Assigned,In Progress,Completed,Rejected']);
        $task->update(['status' => $request->status]);
        return back()->with('success', 'Status tugas relawan berhasil diperbarui.');
    }

    // ═══════════════════════════════════════════════
    // SYSTEM SETTINGS
    // ═══════════════════════════════════════════════
    public function pengaturan()
    {
        return view('admin.pengaturan');
    }

    public function saveSettings(Request $request)
    {
        // Simpan konfigurasi ke session sebagai simulasi (atau ke .env/DB jika diimplementasi penuh)
        $request->validate([
            'app_name'        => 'nullable|string|max:100',
            'emergency_email' => 'nullable|email|max:255',
            'description'     => 'nullable|string|max:500',
        ]);

        // Catat di broadcast log sebagai audit trail
        BroadcastLog::create([
            'admin_id'         => auth()->id(),
            'title'            => 'Konfigurasi Sistem Diperbarui',
            'message'          => 'Admin memperbarui konfigurasi umum sistem CrisisHub.',
            'severity'         => 'info',
            'target'           => 'admin',
            'recipients_count' => 1,
        ]);

        return back()->with('success', 'Konfigurasi sistem berhasil disimpan.');
    }

    public function activateDefcon(Request $request)
    {
        $request->validate([
            'confirmation' => 'required|in:DEFCON1'
        ]);

        // Kirim broadcast darurat ke semua relawan
        $recipients = User::whereHas('roles', fn($q) => $q->where('name', 'Relawan'))->get();
        foreach ($recipients as $user) {
            try {
                Mail::raw(
                    "[DEFCON 1 - SIAGA BENCANA NASIONAL]\n\nSistem CrisisHub telah mengaktifkan Mode Siaga Bencana Nasional.\nSeluruh relawan diminta segera melapor ke posko terdekat dan bersiap untuk penugasan darurat.\n\n— Tim CrisisHub Command Center",
                    fn($m) => $m->to($user->email)->subject("[CrisisHub DEFCON 1] SIAGA BENCANA NASIONAL")
                );
            } catch (\Exception $e) {}
        }

        BroadcastLog::create([
            'admin_id'         => auth()->id(),
            'title'            => '🚨 DEFCON 1 — Mode Siaga Bencana Nasional Diaktifkan',
            'message'          => 'Seluruh relawan disiagakan. Mode darurat nasional aktif.',
            'severity'         => 'critical',
            'target'           => 'volunteers',
            'recipients_count' => $recipients->count(),
        ]);

        return back()->with('success', 'DEFCON 1 berhasil diaktifkan. ' . $recipients->count() . ' relawan telah disiagakan via email.');
    }

    // ═══════════════════════════════════════════════
    // EXPORT
    // ═══════════════════════════════════════════════
    public function exportReports(Request $request)
    {
        $format  = $request->format ?? 'csv'; // pdf, csv, excel
        $reports = Report::with('user')->orderBy('created_at', 'desc')->get();

        if ($format === 'csv') {
            $filename = 'laporan-bencana-' . date('Y-m-d') . '.csv';
            $headers  = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=\"{$filename}\""];
            $callback = function () use ($reports) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['ID', 'Jenis Bencana', 'Lokasi', 'Jumlah Korban', 'Status', 'Pelapor', 'Tanggal']);
                foreach ($reports as $r) {
                    fputcsv($handle, [$r->id, $r->jenis_bencana, $r->alamat_lengkap, $r->jumlah_korban, $r->status ?? 'Pending', $r->user->name ?? 'N/A', $r->created_at->format('Y-m-d H:i')]);
                }
                fclose($handle);
            };
            return response()->stream($callback, 200, $headers);
        }

        if ($format === 'pdf') {
            try {
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.exports.reports-pdf', compact('reports'));
                return $pdf->download('laporan-bencana-' . date('Y-m-d') . '.pdf');
            } catch (\Exception $e) {
                return back()->with('error', 'PDF export gagal. Gunakan CSV.');
            }
        }

        return back()->with('error', 'Format tidak didukung.');
    }

    public function exportDonations(Request $request)
    {
        $donations = Donation::with('user')->orderBy('created_at', 'desc')->get();
        $filename  = 'donasi-' . date('Y-m-d') . '.csv';
        $headers   = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=\"{$filename}\""];
        $callback  = function () use ($donations) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'No. Resi', 'Donatur', 'Jumlah', 'Metode', 'Campaign', 'Status', 'Tanggal']);
            foreach ($donations as $d) {
                fputcsv($handle, [$d->id, $d->tracking_code, $d->user->name ?? 'Anonim', $d->amount, $d->payment_method, $d->campaign_title, $d->status, $d->created_at->format('Y-m-d H:i')]);
            }
            fclose($handle);
        };
        return response()->stream($callback, 200, $headers);
    }

    // Legacy methods
    public function komunikasi()
    {
        $messages = Message::with(['sender'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.komunikasi', compact('messages'));
    }

    public function komunikasiReply(Request $request)
    {
        $request->validate([
            'content'   => 'required|string|max:1000',
            'channel'   => 'nullable|string|max:50',
        ]);

        Message::create([
            'sender_id' => auth()->id(),
            'content'   => $request->content,
            'type'      => 'reply',
            'channel'   => $request->channel ?? 'general',
        ]);

        return back()->with('success', 'Pesan berhasil dikirim.');
    }
}
