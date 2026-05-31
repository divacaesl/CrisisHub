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
            'user_id' => auth()->id(),
            'type' => 'Uang',
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
            'status' => 'Submitted',
            'tracking_code' => $receiptNumber,
            'proof_image' => $proofPath,
            'campaign_title' => $request->campaign_title,
            'verified_at' => now(),
        ]);

        // Send Email Receipt
        Mail::to(auth()->user()->email)->send(new DonationReceipt($donation));

        return redirect()->route('donate')->with('donation_success', 'Donasi untuk "' . $request->campaign_title . '" berhasil dikirim! No. Resi: ' . $receiptNumber);
    }

    public function receipt($id)
    {
        $donation = Donation::where('user_id', auth()->id())->findOrFail($id);
        return view('donations.receipt', compact('donation'));
    }
}
