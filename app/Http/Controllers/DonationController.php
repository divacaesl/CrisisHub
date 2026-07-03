<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\DonationReceipt;

class DonationController extends Controller
{
    public function create()
    {
        return view('donations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string',
            'proof_image' => 'nullable|image|max:4096',
            'campaign_title' => 'nullable|string',
        ]);

        $receiptNumber = 'INV-' . strtoupper(\Illuminate\Support\Str::random(10));

        $proofPath = null;
        if ($request->hasFile('proof_image')) {
            $proofPath = $request->file('proof_image')->store('proofs', 'public');
        }

        $donation = Donation::create([
            'user_id'        => auth()->id(),
            'type'           => 'Uang',
            'amount'         => $request->amount,
            'payment_method' => $request->payment_method,
            'notes'          => $request->notes,
            'status'         => 'Submitted',
            'tracking_code'  => $receiptNumber,
            'proof_image'    => $proofPath,
            'campaign_title' => $request->campaign_title,
            // verified_at left null — akan diisi saat admin memverifikasi
        ]);

        // Send Email Receipt
        Mail::to(auth()->user()->email)->send(new DonationReceipt($donation));

        $donorName = '***anonim***';
        if ($donation->notes && preg_match('/^Dari:\s*([^.]+)\./i', $donation->notes, $matches)) {
            $donorName = trim($matches[1]);
        } else {
            $donorName = auth()->user()?->name ?: '***anonim***';
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Donasi untuk "' . $request->campaign_title . '" berhasil dikirim! No. Resi: ' . $receiptNumber,
                'amount' => (float)$request->amount,
                'campaign_title' => $request->campaign_title ?: 'Donasi Umum',
                'donor_name' => $donorName,
                'time_ago' => 'Baru saja',
                'receipt_number' => $receiptNumber
            ]);
        }

        return redirect()->route('donate')->with('donation_success', 'Donasi untuk "' . $request->campaign_title . '" berhasil dikirim! No. Resi: ' . $receiptNumber);
    }

    public function storeLogistik(Request $request)
    {
        $request->validate([
            'campaign_title' => 'required|string',
            'resi_pengiriman' => 'required|string',
            'items' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        $trackingCode = 'LOG-' . strtoupper(\Illuminate\Support\Str::random(10));

        $donation = Donation::create([
            'user_id'        => auth()->id(),
            'type'           => 'Barang',
            'amount'         => 0, // Not applicable for logistics
            'items'          => $request->items,
            'resi_pengiriman'=> $request->resi_pengiriman,
            'notes'          => $request->notes,
            'status'         => 'Submitted',
            'tracking_code'  => $trackingCode,
            'campaign_title' => $request->campaign_title,
            // admin_proof_image is null initially
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Donasi barang untuk "' . $request->campaign_title . '" berhasil dicatat dengan resi ' . $request->resi_pengiriman,
                'tracking_code' => $trackingCode
            ]);
        }

        return redirect()->back()->with('donation_success', 'Form donasi barang berhasil dikirim! (Resi Anda: ' . $request->resi_pengiriman . ')');
    }

    public function receipt($id)
    {
        $donation = Donation::where('user_id', auth()->id())->findOrFail($id);
        return view('donations.receipt', compact('donation'));
    }

    public function detail($id)
    {
        $campaign = \App\Models\Campaign::findOrFail($id);
        
        // Calculate dynamic donations for this specific campaign
        $totalDonations = \App\Models\Donation::where('campaign_title', $campaign->title)
            ->where('status', 'Verified')
            ->sum('amount');
            
        $donorCount = \App\Models\Donation::where('campaign_title', $campaign->title)
            ->where('status', 'Verified')
            ->count();
            
        // Combine DB collected amount with dynamic donations
        $collected = $campaign->collected_amount + $totalDonations;
        
        // Calculate percentage
        $pct = $campaign->target_amount > 0 ? min(100, round(($collected / $campaign->target_amount) * 100)) : 0;
        
        // Get recent donors for this campaign
        $recentDonors = \App\Models\Donation::with('user')
            ->where('campaign_title', $campaign->title)
            ->where('status', 'Verified')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Get the associated report if any
        $report = null;
        if ($campaign->report_id) {
            $report = \App\Models\Report::with('user')->find($campaign->report_id);
        }

        // Calculate days left
        $diffDays = (int)ceil(now()->diffInDays(\Carbon\Carbon::parse($campaign->deadline), false));
        $daysLeft = $diffDays > 0 ? $diffDays : 0;

        return view('donate-detail', compact('campaign', 'collected', 'pct', 'recentDonors', 'report', 'donorCount', 'daysLeft'));
    }
}
