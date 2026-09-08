<?php

namespace App\Http\Controllers\PPDB;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\PPDB\Applicant;
use App\Models\PPDB\Registration;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    public function index(Request $request)
    {
        $applicants = Applicant::with([
            'registration',
            'ppdbRegistration.biodata',
            'ppdbRegistration.parentData',
            'ppdbRegistration.documents',
            'ppdbRegistration.majorChoices.major',
        ])
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

    public function editRejected(Registration $registration)
    {
        abort_unless(in_array($registration->status, ['documents_invalid', 'rejected']), 404);

        $registration->load(['biodata', 'parentData', 'majorChoices.major']);
        $majors = Major::orderBy('name')->get();

        return view('ppdb.applicants.edit', compact('registration', 'majors'));
    }

    public function updateRejected(Request $request, Registration $registration)
    {
        abort_unless(in_array($registration->status, ['documents_invalid', 'rejected']), 404);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'school_origin' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'father_phone' => 'nullable|string|max:30',
            'mother_phone' => 'nullable|string|max:30',
            'major_id' => 'required|exists:majors,id',
        ]);

        $registration->biodata()->updateOrCreate(
            ['registration_id' => $registration->id],
            [
                'name' => $data['name'],
                'school_origin' => $data['school_origin'] ?? null,
                'address' => $data['address'] ?? null,
            ]
        );

        $registration->parentData()->updateOrCreate(
            ['registration_id' => $registration->id],
            [
                'father_phone' => $data['father_phone'] ?? null,
                'mother_phone' => $data['mother_phone'] ?? null,
            ]
        );

        $registration->majorChoices()->delete();
        $registration->majorChoices()->create([
            'major_id' => $data['major_id'],
            'choice_order' => 1,
        ]);

        $registration->verification()->update([
            'status' => 'pending',
            'remarks' => null,
            'verified_by' => null,
            'verified_at' => null,
        ]);
        $registration->update(['status' => 'submitted']);

        return redirect()->route('admin.ppdb.applicants.index')
            ->with('success', 'Data diperbaiki dan diajukan ulang untuk verifikasi.');
    }
}
