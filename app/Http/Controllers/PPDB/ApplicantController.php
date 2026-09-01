<?php

namespace App\Http\Controllers\PPDB;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\PPDB\Applicant;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    public function index(Request $request)
    {
        $applicants = Applicant::with('registration')
            ->when($request->search, fn ($q) => $q->where('full_name', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(15);

        return view('ppdb.applicants.index', compact('applicants'));
    }

    // Formulir pendaftaran publik (form calon siswa baru)
    public function create()
    {
        $majors = Major::orderBy('name')->get();
        return view('ppdb.create', compact('majors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'nisn' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'previous_school' => 'nullable|string|max:255',
            'chosen_major' => 'required|string|max:100',
        ]);

        $applicant = Applicant::create($data);

        $applicant->registration()->create([
            'wave' => 'Gelombang 1',
            'registration_date' => now(),
            'status' => 'pending',
        ]);

        return redirect()
            ->route('ppdb.applicants.show', $applicant)
            ->with('success', 'Pendaftaran berhasil! Nomor pendaftaran Anda: ' . $applicant->registration_number);
    }

    public function show(Applicant $applicant)
    {
        $applicant->load(['registration.verification', 'documents']);
        return view('ppdb.applicants.show', compact('applicant'));
    }

    public function destroy(Applicant $applicant)
    {
        $applicant->delete();
        return back()->with('success', 'Data pendaftar berhasil dihapus.');
    }
}
