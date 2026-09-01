<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RegistrationsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function __construct(protected Collection $registrations)
    {
    }

    public function collection(): Collection
    {
        return $this->registrations;
    }

    public function headings(): array
    {
        return [
            'No',
            'No. Pendaftaran',
            'NIK',
            'Nama Lengkap',
            'Asal Sekolah',
            'Pilihan 1',
            'Pilihan 2',
            'Pilihan 3',
            'Rekomendasi SAW',
            'Nama Ayah',
            'Nama Ibu',
            'Status',
            'Tanggal Daftar',
        ];
    }

    /**
     * @param \App\Models\PPDB\Registration $registration
     */
    public function map($registration): array
    {
        static $no = 0;
        $no++;

        $choices = $registration->majorChoices; // sudah urut sesuai choice_order dari relasi model

        return [
            $no,
            $registration->registration_number,
            $registration->biodata->nik ?? '-',
            $registration->biodata->name ?? '-',
            $registration->biodata->school_origin ?? '-',
            optional($choices->get(0))->major?->name ?? '-',
            optional($choices->get(1))->major?->name ?? '-',
            optional($choices->get(2))->major?->name ?? '-',
            $registration->sawResult?->recommendedMajor?->name ?? 'Belum dihitung',
            $registration->parentData->father_name ?? '-',
            $registration->parentData->mother_name ?? '-',
            $this->statusLabel($registration->status),
            $registration->created_at->format('d-m-Y'),
        ];
    }

    protected function statusLabel(string $status): string
    {
        return match ($status) {
            'draft' => 'Draft',
            'submitted' => 'Menunggu Verifikasi',
            'documents_valid' => 'Berkas Valid',
            'documents_invalid' => 'Berkas Ditolak',
            'graded' => 'Nilai Diproses',
            'recommended' => 'Sudah Direkomendasikan',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
            default => ucfirst($status),
        };
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]], // baris header ditebalkan
        ];
    }
}