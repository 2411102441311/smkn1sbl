<?php

namespace App\Http\Controllers\PPDB;

use App\Http\Controllers\Controller;
use App\Models\PPDB\Registration;
use App\Models\PPDB\Verification;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function index()
    {
        $registrations = Registration::with(['applicant', 'verification'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(15);

        return view('ppdb.verification.index', compact('registrations'));
    }

    public function store(Request $request, Registration $registration)
    {
        $data = $request->validate([
            'status' => 'required|in:valid,invalid',
            'remarks' => 'nullable|string',
        ]);

        $verification = Verification::updateOrCreate(
            ['registration_id' => $registration->id],
            [
                'verified_by' => auth()->id(),
                'status' => $data['status'],
                'remarks' => $data['remarks'] ?? null,
                'verified_at' => now(),
            ]
        );

        $registration->update([
            'status' => $data['status'] === 'valid' ? 'verified' : 'rejected',
        ]);

        return back()->with('success', 'Verifikasi berkas berhasil disimpan.');
    }
}
