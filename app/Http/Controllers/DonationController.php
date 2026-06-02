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

    public function receipt($id)
    {
        $donation = Donation::where('user_id', auth()->id())->findOrFail($id);
        return view('donations.receipt', compact('donation'));
    }
}
