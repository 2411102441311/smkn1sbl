<?php

namespace App\Http\Controllers\PPDB;

use App\Http\Controllers\Controller;
use App\Models\PPDB\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $registrations = Registration::with('applicant')
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15);

        return view('ppdb.registrations.index', compact('registrations'));
    }

    public function updateStatus(Request $request, Registration $registration)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,verified,accepted,rejected',
            'notes' => 'nullable|string',
        ]);

        $registration->update($data);

        return back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }
}
