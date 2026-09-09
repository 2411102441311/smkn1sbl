<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RegistrationsExport extends DefaultValueBinder implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    ShouldAutoSize,
    WithCustomValueBinder
{
    protected int $no = 0;

    public function __construct(protected Collection $registrations)
    {
    }

    public function collection(): Collection
    {
        return $this->registrations;
    }

    /**
     * Memaksa kolom identitas dan nomor telepon
     * menjadi TEXT agar tidak berubah menjadi
     * scientific notation di Excel.
     */
    public function bindValue(Cell $cell, $value): bool
    {
        $textColumns = [
            'C', // No. Pendaftaran
            'D', // NIK
            'E', // NISN
            'F', // No. KK
            'G', // No. HP Siswa
            'R', // Nomor KIP

            // Ayah
            'T', // NIK Ayah
            'U', // No. HP Ayah

            // Ibu
            'X', // NIK Ibu
            'Y', // No. HP Ibu

            // Wali
            'AD', // NIK Wali
            'AE', // No. HP Wali
        ];

        if (in_array($cell->getColumn(), $textColumns, true)) {
            $cell->setValueExplicit(
                (string) $value,
                DataType::TYPE_STRING
            );

            return true;
        }

        return parent::bindValue($cell, $value);
    }

    /**
     * Header Excel
     */
    public function headings(): array
    {
        return [
            'No',
            'Periode PPDB',
            'No. Pendaftaran',

            // =========================
            // BIODATA CALON SISWA
            // =========================
            'NIK',
            'NISN',
            'No. KK',
            'No. HP Siswa',
            'Nama Lengkap',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Tinggi Badan (cm)',
            'Berat Badan (kg)',
            'Agama',
            'Alamat',
            'Asal Sekolah',
            'Memiliki KIP',
            'Nomor KIP',

            // =========================
            // DATA AYAH
            // =========================
            'Nama Ayah',
            'NIK Ayah',
            'No. HP Ayah',
            'Pekerjaan Ayah',

            // =========================
            // DATA IBU
            // =========================
            'Nama Ibu',
            'NIK Ibu',
            'No. HP Ibu',
            'Pekerjaan Ibu',

            // =========================
            // DATA WALI
            // =========================
            'Memiliki Wali',
            'Hubungan Wali',
            'Nama Wali',
            'NIK Wali',
            'No. HP Wali',
            'Pekerjaan Wali',

            // =========================
            // JURUSAN
            // =========================
            'Jurusan yang Dipilih',

            // =========================
            // ADMINISTRASI
            // =========================
            'Status',
            'Tanggal Daftar',
        ];
    }

    /**
     * Data setiap baris Excel
     */
    public function map($registration): array
    {
        $this->no++;

        $biodata = $registration->biodata;
        $parent = $registration->parentData;
        $choices = $registration->majorChoices;

        /*
         * Hanya mengambil jurusan yang dipilih.
         * Hasil rekomendasi SAW tidak ditampilkan.
         */
        $selectedMajor = optional($choices->get(0))->major?->name ?? '-';

        return [
            // =========================
            // IDENTITAS PENDAFTARAN
            // =========================
            $this->no,

            $registration->period?->name ?? '-',

            $this->textValue(
                $registration->registration_number
            ),

            // =========================
            // BIODATA CALON SISWA
            // =========================

            // NIK
            $this->textValue(
                $biodata?->nik
            ),

            // NISN
            $this->textValue(
                $biodata?->nisn
            ),

            // No. KK
            $this->textValue(
                $biodata?->family_card_number
            ),

            // No. HP Siswa
            $this->textValue(
                $biodata?->phone_number
            ),

            // Nama
            $biodata?->name ?? '-',

            // Tempat lahir
            $biodata?->place_of_birth ?? '-',

            // Tanggal lahir
            $biodata?->date_of_birth
                ? $biodata->date_of_birth->format('d-m-Y')
                : '-',

            // Jenis kelamin
            $this->genderLabel(
                $biodata?->gender
            ),

            // Tinggi badan
            $biodata?->height_cm !== null
                ? $biodata->height_cm
                : '-',

            // Berat badan
            $biodata?->weight_kg !== null
                ? $biodata->weight_kg
                : '-',

            // Agama
            $biodata?->religion ?? '-',

            // Alamat
            $biodata?->address ?? '-',

            // Asal sekolah
            $biodata?->school_origin ?? '-',

            // KIP
            $biodata?->has_kip
                ? 'Ya'
                : 'Tidak',

            // Nomor KIP
            $this->textValue(
                $biodata?->kip_number
            ),

            // =========================
            // DATA AYAH
            // =========================
            $parent?->father_name ?? '-',

            $this->textValue(
                $parent?->father_nik
            ),

            $this->textValue(
                $parent?->father_phone
            ),

            $parent?->father_occupation ?? '-',

            // =========================
            // DATA IBU
            // =========================
            $parent?->mother_name ?? '-',

            $this->textValue(
                $parent?->mother_nik
            ),

            $this->textValue(
                $parent?->mother_phone
            ),

            $parent?->mother_occupation ?? '-',

            // =========================
            // DATA WALI
            // =========================
            $parent?->has_guardian
                ? 'Ya'
                : 'Tidak',

            $parent?->has_guardian
                ? ($parent?->guardian_relationship ?? '-')
                : '-',

            $parent?->has_guardian
                ? ($parent?->guardian_name ?? '-')
                : '-',

            $parent?->has_guardian
                ? $this->textValue(
                    $parent?->guardian_nik
                )
                : '-',

            $parent?->has_guardian
                ? $this->textValue(
                    $parent?->guardian_phone
                )
                : '-',

            $parent?->has_guardian
                ? ($parent?->guardian_occupation ?? '-')
                : '-',

            // =========================
            // JURUSAN YANG DIPILIH
            // =========================
            $selectedMajor,

            // =========================
            // STATUS
            // =========================
            $this->statusLabel(
                $registration->status
            ),

            // =========================
            // TANGGAL DAFTAR
            // =========================
            $registration->created_at
                ? $registration->created_at->format('d-m-Y')
                : '-',
        ];
    }

    /**
     * Mengubah nilai menjadi string.
     */
    protected function textValue($value): string
    {
        if ($value === null || $value === '') {
            return '-';
        }

        return (string) $value;
    }

    /**
     * Label jenis kelamin.
     */
    protected function genderLabel(?string $gender): string
    {
        return match (strtoupper((string) $gender)) {
            'L' => 'Laki-laki',
            'P' => 'Perempuan',
            default => $gender ?: '-',
        };
    }

    /**
     * Label status pendaftaran.
     */
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

    /**
     * Styling worksheet.
     */
    public function styles(Worksheet $sheet): array
    {
        // =========================
        // HEADER
        // =========================
        $sheet->getStyle('A1:AI1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 11,
            ],

            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
                'wrapText' => true,
            ],
        ]);

        // Tinggi header
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Freeze header
        $sheet->freezePane('A2');

        // =========================
        // FILTER OTOMATIS
        // =========================
        $lastRow = $sheet->getHighestRow();

        if ($lastRow >= 1) {
            $sheet->setAutoFilter(
                "A1:AI{$lastRow}"
            );
        }

        // =========================
        // ALIGNMENT DATA
        // =========================
        if ($lastRow > 1) {

            $sheet->getStyle(
                "A2:AI{$lastRow}"
            )
                ->getAlignment()
                ->setVertical('top');

            // Alamat
            $sheet->getStyle(
                "O2:O{$lastRow}"
            )
                ->getAlignment()
                ->setWrapText(true);

            // Data wali
            $sheet->getStyle(
                "AA2:AF{$lastRow}"
            )
                ->getAlignment()
                ->setWrapText(true);
        }

        // =========================
        // LEBAR KOLOM
        // =========================
        $widths = [

            // Nomor
            'A' => 6,
            'B' => 14,
            'C' => 20,

            // Biodata
            'D' => 20, // NIK
            'E' => 18, // NISN
            'F' => 20, // KK
            'G' => 18, // HP Siswa
            'H' => 28, // Nama
            'I' => 18, // Tempat lahir
            'J' => 15, // Tanggal lahir
            'K' => 16, // Jenis kelamin
            'L' => 16, // Tinggi
            'M' => 16, // Berat
            'N' => 18, // Agama
            'O' => 35, // Alamat
            'P' => 25, // Asal sekolah
            'Q' => 15, // KIP
            'R' => 20, // Nomor KIP

            // Ayah
            'S' => 25, // Nama
            'T' => 20, // NIK
            'U' => 18, // HP
            'V' => 22, // Pekerjaan

            // Ibu
            'W' => 25, // Nama
            'X' => 20, // NIK
            'Y' => 18, // HP
            'Z' => 22, // Pekerjaan

            // Wali
            'AA' => 16, // Memiliki wali
            'AB' => 22, // Hubungan
            'AC' => 28, // Nama
            'AD' => 20, // NIK
            'AE' => 18, // HP
            'AF' => 22, // Pekerjaan

            // Jurusan
            'AG' => 25,

            // Administrasi
            'AH' => 22,
            'AI' => 18,
        ];

        foreach ($widths as $column => $width) {
            $sheet->getColumnDimension($column)
                ->setWidth($width);
        }

        return [];
    }
}