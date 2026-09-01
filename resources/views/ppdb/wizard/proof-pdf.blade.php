<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bukti Pendaftaran</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #1e293b; }
        .header { text-align: center; border-bottom: 3px solid #1d4ed8; padding-bottom: 12px; margin-bottom: 20px; }
        .header h1 { font-size: 18px; margin: 0; color: #1d4ed8; }
        .header p { margin: 2px 0; color: #64748b; font-size: 11px; }
        .reg-number { text-align: center; background: #eff6ff; border: 2px dashed #1d4ed8; border-radius: 8px; padding: 14px; margin-bottom: 20px; }
        .reg-number p.label { margin: 0; font-size: 10px; color: #64748b; text-transform: uppercase; }
        .reg-number p.value { margin: 4px 0 0; font-size: 22px; font-weight: bold; color: #1d4ed8; letter-spacing: 1px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        table td { padding: 6px 4px; border-bottom: 1px solid #e2e8f0; vertical-align: top; }
        table td.label { width: 35%; color: #64748b; }
        table td.value { font-weight: 600; }
        h2.section { font-size: 13px; color: #1d4ed8; border-bottom: 1px solid #bfdbfe; padding-bottom: 4px; margin-top: 20px; margin-bottom: 8px; }
        .footer { margin-top: 30px; font-size: 10px; color: #94a3b8; text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <h1>BUKTI PENDAFTARAN PPDB</h1>
        <p>{{ \App\Models\CMS\Setting::get('school_name', 'SMK Negeri 1 Sebulu') }}</p>
        <p>{{ \App\Models\CMS\Setting::get('school_address', '-') }}</p>
    </div>

    <div class="reg-number">
        <p class="label">Nomor Pendaftaran</p>
        <p class="value">{{ $registration->registration_number }}</p>
    </div>

    <h2 class="section">Data Calon Siswa</h2>
    <table>
        <tr><td class="label">Nama Lengkap</td><td class="value">{{ $registration->biodata->name ?? '-' }}</td></tr>
        <tr><td class="label">NIK</td><td class="value">{{ $registration->biodata->nik ?? '-' }}</td></tr>
        <tr><td class="label">Tempat, Tanggal Lahir</td><td class="value">{{ $registration->biodata->place_of_birth ?? '-' }}, {{ optional($registration->biodata->date_of_birth)->format('d-m-Y') ?? '-' }}</td></tr>
        <tr><td class="label">Jenis Kelamin</td><td class="value">{{ $registration->biodata->gender === 'L' ? 'Laki-laki' : ($registration->biodata->gender === 'P' ? 'Perempuan' : '-') }}</td></tr>
        <tr><td class="label">Asal Sekolah</td><td class="value">{{ $registration->biodata->school_origin ?? '-' }}</td></tr>
        <tr><td class="label">Alamat</td><td class="value">{{ $registration->biodata->address ?? '-' }}</td></tr>
    </table>

    <h2 class="section">Data Orang Tua</h2>
    <table>
        <tr><td class="label">Nama Ayah</td><td class="value">{{ $registration->parentData->father_name ?? '-' }}</td></tr>
        <tr><td class="label">Nama Ibu</td><td class="value">{{ $registration->parentData->mother_name ?? '-' }}</td></tr>
    </table>

    <h2 class="section">Pilihan Jurusan</h2>
    <table>
        @forelse($registration->majorChoices as $choice)
            <tr><td class="label">Pilihan {{ $choice->choice_order }}</td><td class="value">{{ $choice->major->name ?? '-' }}</td></tr>
        @empty
            <tr><td colspan="2">Belum ada pilihan jurusan.</td></tr>
        @endforelse
        @if($registration->sawResult)
            <tr><td class="label">Rekomendasi Sistem</td><td class="value">{{ $registration->sawResult->recommendedMajor->name ?? '-' }}</td></tr>
        @endif
    </table>

    <h2 class="section">Status</h2>
    <table>
        <tr><td class="label">Status Saat Ini</td><td class="value">{{ ucfirst(str_replace('_', ' ', $registration->status)) }}</td></tr>
        <tr><td class="label">Tanggal Daftar</td><td class="value">{{ $registration->created_at->format('d F Y, H:i') }} WITA</td></tr>
    </table>

    <p class="footer">
        Dokumen ini adalah bukti pendaftaran sah. Simpan dan bawa saat verifikasi berkas ke sekolah.<br>
        Digenerate otomatis oleh Sistem Informasi {{ \App\Models\CMS\Setting::get('school_name', 'SMK Negeri 1 Sebulu') }}.
    </p>

</body>
</html>