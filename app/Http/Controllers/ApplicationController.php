<?php

namespace App\Http\Controllers;

use App\Models\VolunteerApplication;
use App\Models\OrganizationApplication;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Show volunteer registration form or status.
     */
    public function createVolunteer()
    {
        $existingApp = VolunteerApplication::where('user_id', auth()->id())->latest()->first();
        return view('applications.volunteer', compact('existingApp'));
    }

    /**
     * Store volunteer application.
     */
    public function storeVolunteer(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'skills' => 'nullable|string|max:255',
            'experience' => 'nullable|string',
            'category' => 'nullable|string',
            'certification' => 'nullable|string',
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'motivation' => 'nullable|string',
            'availability' => 'required|string',
            'assignment_area' => 'required|string',
            'emergency_contact_name' => 'required|string',
            'emergency_contact_relation' => 'required|string',
            'emergency_contact_phone' => 'required|string',
            'preferred_team' => 'nullable|string',
            'full_name' => 'required|string|max:255',
        ]);

        $existing = VolunteerApplication::where('user_id', auth()->id())->latest()->first();
        
        if ($existing && in_array($existing->status, ['pending', 'under_review', 'approved'])) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Anda sudah memiliki pendaftaran aktif yang sedang diproses atau telah disetujui.'], 403);
            }
            return redirect()->back()->with('error', 'Anda sudah memiliki pendaftaran aktif yang sedang diproses atau telah disetujui.');
        }

        // If previously rejected, we can delete the old record to allow a fresh start
        if ($existing && $existing->status === 'rejected') {
            $existing->delete();
        }

        $cvPath = null;
        if ($request->hasFile('cv_file')) {
            $cvPath = $request->file('cv_file')->store('cv_files', 'public');
        }

        // Update the user's name if it was edited
        $request->user()->update([
            'name' => $request->full_name
        ]);

        VolunteerApplication::create([
            'user_id' => auth()->id(),
            'phone_number' => $request->phone_number,
            'city' => $request->city,
            'skills' => $request->skills,
            'experience' => $request->experience,
            'category' => $request->category,
            'certification' => $request->certification,
            'cv_path' => $cvPath,
            'motivation' => $request->motivation,
            'availability' => $request->availability,
            'assignment_area' => $request->assignment_area,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_relation' => $request->emergency_contact_relation,
            'emergency_contact_phone' => $request->emergency_contact_phone,
            'preferred_team' => $request->preferred_team,
            'status' => 'pending',
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Pengajuan relawan berhasil dikirim! Silakan periksa status di beranda Anda.']);
        }
        return redirect()->back()->with('success', 'Pengajuan relawan berhasil dikirim! Silakan periksa status di beranda Anda.');
    }

    /**
     * Show organization partnership registration form or status.
     */
    public function createOrganization()
    {
        $existingApp = OrganizationApplication::where('user_id', auth()->id())->latest()->first();
        return view('applications.organization', compact('existingApp'));
    }

    /**
     * Store organization application.
     */
    public function storeOrganization(Request $request)
    {
        $request->validate([
            'organization_name' => 'required|string|max:255',
            'type' => 'required|string|in:NGO,Corporate,Government,Community',
            'registration_number' => 'nullable|string|max:100',
            'contact_person' => 'required|string|max:255',
        ]);

        $existing = OrganizationApplication::where('user_id', auth()->id())->latest()->first();
        
        if ($existing && in_array($existing->status, ['pending', 'under_review', 'approved'])) {
            return redirect()->back()->with('error', 'Organisasi Anda sudah terdaftar atau dalam antrean verifikasi.');
        }

        // Delete rejected application to clear the slate
        if ($existing && $existing->status === 'rejected') {
            $existing->delete();
        }

        OrganizationApplication::create([
            'user_id' => auth()->id(),
            'organization_name' => $request->organization_name,
            'type' => $request->type,
            'registration_number' => $request->registration_number,
            'contact_person' => $request->contact_person,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Pengajuan kemitraan organisasi berhasil dikirim! Dokumen Anda sedang kami tinjau.');
    }
}
