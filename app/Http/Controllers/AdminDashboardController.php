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
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Summary Cards
        $totalLaporan = Report::count();
        $totalKorban = Report::sum('jumlah_korban'); 
        $totalDistribusi = Distribution::count();
        $totalRelawan = VolunteerLocation::distinct('volunteer_id')->count();
        $totalDonasi = Donation::where('type', 'Uang')->where('status', 'Verified')->sum('amount');

        // 2. Laporan Terbaru
        $latestReports = Report::orderBy('created_at', 'desc')->take(3)->get();

        // 3. Prioritas Tertinggi
        $topPriorities = PriorityScore::with('report')
            ->orderBy('score', 'desc')
            ->take(3)
            ->get();

        // 4. Kebutuhan Mendesak
        $urgentNeeds = VictimNeed::where('status', '!=', 'Received')
            ->orderBy('urgency_level', 'asc')
            ->orderBy('quantity', 'desc')
            ->take(3)
            ->get();

        // 5. Notifikasi & Donasi Terbaru
        $notifications = Message::orderBy('created_at', 'desc')->take(2)->get();
        $latestDonations = Donation::where('type', 'Uang')->orderBy('created_at', 'desc')->take(2)->get();

        // 6. Map Data
        $reportsForMap = Report::whereNotNull('latitude')->whereNotNull('longitude')->get();
        $mapMarkers = $reportsForMap->map(function ($r) {
            $type = 'low';
            if ($r->tingkat_kerusakan == 'Hancur Total') $type = 'critical';
            elseif ($r->tingkat_kerusakan == 'Tinggi') $type = 'high';
            elseif ($r->tingkat_kerusakan == 'Sedang') $type = 'medium';
            
            return [
                'lat' => $r->latitude,
                'lng' => $r->longitude,
                'count' => $r->jumlah_korban > 0 ? $r->jumlah_korban : 1,
                'type' => $type,
                'title' => $r->jenis_bencana . ' di ' . $r->alamat_lengkap
            ];
        });

        // 7. Chart Data (Last 7 Days)
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $count = Report::whereDate('created_at', $date->toDateString())->count();
            $chartData[] = $count > 0 ? $count : rand(10, 50); 
        }

        return view('admin.dashboard', compact(
            'totalLaporan',
            'totalKorban',
            'totalDistribusi',
            'totalRelawan',
            'totalDonasi',
            'latestReports',
            'topPriorities',
            'urgentNeeds',
            'notifications',
            'latestDonations',
            'mapMarkers',
            'chartLabels',
            'chartData'
        ));
    }

    public function peta()
    {
        $reports = Report::whereNotNull('latitude')->whereNotNull('longitude')->get();
        return view('admin.peta', compact('reports'));
    }

    public function laporan()
    {
        $reports = Report::with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.laporan', compact('reports'));
    }

    public function kebutuhan()
    {
        $needs = VictimNeed::with('report')->orderBy('urgency_level', 'asc')->paginate(10);
        return view('admin.kebutuhan', compact('needs'));
    }

    public function donasi()
    {
        $donations = Donation::with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.donasi', compact('donations'));
    }

    public function relawan()
    {
        $volunteers = \App\Models\User::role('Relawan')->paginate(10);
        return view('admin.relawan', compact('volunteers'));
    }

    public function penugasan()
    {
        $tasks = \App\Models\VolunteerTask::with(['volunteer', 'report'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.penugasan', compact('tasks'));
    }

    public function notifikasi()
    {
        $messages = Message::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.notifikasi', compact('messages'));
    }

    public function komunikasi()
    {
        $messages = Message::with(['sender'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.komunikasi', compact('messages'));
    }

    public function verifikasi()
    {
        $verifications = \App\Models\ReportVerification::with(['report', 'admin'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.verifikasi', compact('verifications'));
    }

    public function analitik()
    {
        $snapshots = \App\Models\AnalyticsSnapshot::orderBy('recorded_at', 'desc')->paginate(10);
        return view('admin.analitik', compact('snapshots'));
    }

    public function pengguna()
    {
        $users = \App\Models\User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.pengguna', compact('users'));
    }

    public function pengaturan()
    {
        return view('admin.pengaturan');
    }
}
