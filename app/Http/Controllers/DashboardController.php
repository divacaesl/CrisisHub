<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Donation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the standard user dashboard.
     */
    public function index()
    {
        $user = auth()->user();
        
        // Dynamic stats for the user
        $reportCount = Report::where('user_id', $user->id)
            ->whereIn('status', ['Pending', 'Verified', 'In Progress'])
            ->count();
            
        $needCount = Report::where('user_id', $user->id)
            ->where('status', 'In Progress')
            ->count();

        $resolvedCount = Report::where('user_id', $user->id)
            ->where('status', 'Resolved')
            ->count();

        // Get user donations
        $donations = $user->donations()->orderBy('created_at', 'desc')->get();
        
        // Get recent public reports to show on the public feed
        $recentReports = Report::orderBy('created_at', 'desc')->take(5)->get();

        // Get user's own reports to display separately
        $myReports = Report::where('user_id', $user->id)->orderBy('created_at', 'desc')->take(5)->get();

        $volunteerApp = \App\Models\VolunteerApplication::where('user_id', $user->id)->latest()->first();

        return view('dashboard.index', compact(
            'reportCount', 
            'needCount', 
            'resolvedCount',
            'donations', 
            'recentReports',
            'myReports',
            'volunteerApp'
        ));
    }
}
