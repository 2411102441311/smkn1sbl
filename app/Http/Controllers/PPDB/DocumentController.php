<?php

namespace App\Http\Controllers\PPDB;

use App\Http\Controllers\Controller;
use App\Models\PPDB\Applicant;
use App\Models\PPDB\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function store(Request $request, Applicant $applicant)
    {
        $data = $request->validate([
            'document_type' => 'required|string|max:100',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        $path = $request->file('file')->store('ppdb/documents', 'public');

        $applicant->documents()->create([
            'document_type' => $data['document_type'],
            'file_path' => $path,
        ]);

        return back()->with('success', 'Dokumen berhasil diunggah.');
    }

    public function destroy(Document $document)
    {
        $document->delete();
        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
