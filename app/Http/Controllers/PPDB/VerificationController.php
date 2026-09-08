<?php

namespace App\Http\Controllers\PPDB;

use App\Http\Controllers\Controller;
use App\Models\PPDB\Registration;
use App\Models\PPDB\Verification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function index()
    {
        $registrations = Registration::with(['biodata', 'documents', 'verification'])
            ->whereIn('status', ['submitted', 'documents_invalid'])
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
                'verified_by' => Auth::id(),
                'status' => $data['status'],
                'remarks' => $data['remarks'] ?? null,
                'verified_at' => now(),
            ]
        );

        $registration->update([
            'status' => $data['status'] === 'valid'
                ? 'documents_valid'
                : 'documents_invalid',
        ]);

        return back()->with('success', 'Verifikasi berkas berhasil disimpan.');
    }
}
