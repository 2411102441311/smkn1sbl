<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Pendaftar PPDB</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #1e293b; }
        h1 { font-size: 16px; margin-bottom: 2px; }
        p.subtitle { margin-top: 0; color: #64748b; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #cbd5e1; padding: 6px 8px; text-align: left; vertical-align: top; }
        th { background-color: #1d4ed8; color: #ffffff; font-size: 10px; text-transform: uppercase; }
        tr:nth-child(even) { background-color: #eff6ff; }
        .text-center { text-align: center; }
        .footer { margin-top: 16px; font-size: 9px; color: #94a3b8; }
    </style>
</head>
<body>

    <h1>Laporan Pendaftar PPDB — {{ \App\Models\CMS\Setting::get('school_name', 'SMK Negeri 1 Sebulu') }}</h1>
    <p class="subtitle">Dicetak pada {{ now()->translatedFormat('d F Y, H:i') }} WITA &middot; Total: {{ $registrations->count() }} pendaftar</p>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>No. Pendaftaran</th>
                <th>Nama</th>
                <th>Asal Sekolah</th>
                <th>Pilihan 1</th>
                <th>Pilihan 2</th>
                <th>Pilihan 3</th>
                <th>Rekomendasi SAW</th>
                <th>Status</th>
                <th>Tgl Daftar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $i => $registration)
                @php
                    $choices = $registration->majorChoices;
                    $statusLabels = [
                        'draft' => 'Draft',
                        'submitted' => 'Menunggu Verifikasi',
                        'documents_valid' => 'Berkas Valid',
                        'documents_invalid' => 'Berkas Ditolak',
                        'graded' => 'Nilai Diproses',
                        'recommended' => 'Direkomendasikan',
                        'accepted' => 'Diterima',
                        'rejected' => 'Ditolak',
                    ];
                @endphp
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $registration->registration_number }}</td>
                    <td>{{ $registration->biodata->name ?? '-' }}</td>
                    <td>{{ $registration->biodata->school_origin ?? '-' }}</td>
                    <td>{{ optional($choices->get(0))->major?->name ?? '-' }}</td>
                    <td>{{ optional($choices->get(1))->major?->name ?? '-' }}</td>
                    <td>{{ optional($choices->get(2))->major?->name ?? '-' }}</td>
                    <td>{{ $registration->sawResult?->recommendedMajor?->name ?? 'Belum dihitung' }}</td>
                    <td>{{ $statusLabels[$registration->status] ?? ucfirst($registration->status) }}</td>
                    <td>{{ $registration->created_at->format('d-m-Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">Tidak ada data pendaftar pada rentang ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="footer">
        Dokumen ini digenerate otomatis oleh Sistem Informasi {{ \App\Models\CMS\Setting::get('school_name', 'SMK Negeri 1 Sebulu') }}.
    </p>

</body>
</html>