<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bukti Pendaftaran PPDB</title>

    <style>
        @page {
            margin: 30px 40px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #1e293b;
            line-height: 1.4;
        }

        /* =========================
           KOP SURAT
        ========================== */

        .kop {
            width: 100%;
            text-align: center;
            margin-bottom: 18px;
            padding-bottom: 10px;
        }

        .kop img {
            width: 100%;
            height: auto;
        }

        /* =========================
           JUDUL DOKUMEN
        ========================== */

        .document-title {
            text-align: center;
            margin: 12px 0 16px;
        }

        .document-title h1 {
            font-size: 16px;
            margin: 0;
            font-weight: bold;
            color: #1e293b;
        }

        .document-title p {
            font-size: 10px;
            margin: 3px 0 0;
            color: #64748b;
        }

        /* =========================
           NOMOR PENDAFTARAN
        ========================== */

        .reg-number {
            text-align: center;
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            padding: 9px;
            margin-bottom: 15px;
        }

        .reg-number .label {
            margin: 0;
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
        }

        .reg-number .value {
            margin: 3px 0 0;
            font-size: 17px;
            font-weight: bold;
            color: #1d4ed8;
            letter-spacing: 1px;
        }

        /* =========================
           JUDUL BAGIAN
        ========================== */

        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #1d4ed8;
            border-bottom: 1.5px solid #93c5fd;
            padding-bottom: 4px;
            margin: 16px 0 5px;
        }

        /* =========================
           TABEL DATA
        ========================== */

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        .data-table td {
            padding: 5px 5px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: top;
        }

        .data-table .label {
            width: 35%;
            color: #64748b;
        }

        .data-table .value {
            width: 65%;
            font-weight: bold;
            color: #1e293b;
        }

        /* =========================
           STATUS
        ========================== */

        .status-box {
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            padding: 7px 9px;
            margin-top: 5px;
        }

        .status-table {
            width: 100%;
            border-collapse: collapse;
        }

        .status-table td {
            border: none;
            padding: 3px 0;
        }

        .status-label {
            width: 35%;
            color: #64748b;
        }

        .status-value {
            font-weight: bold;
            color: #1d4ed8;
        }

        /* =========================
           CATATAN
        ========================== */

        .note {
            margin-top: 18px;
            padding: 8px 10px;
            background: #f8fafc;
            border-left: 3px solid #1d4ed8;
            font-size: 9px;
            color: #64748b;
        }

        /* =========================
           FOOTER
        ========================== */

        .footer {
            margin-top: 20px;
            padding-top: 8px;
            border-top: 1px solid #cbd5e1;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
        }
    </style>
</head>

<body>

    {{-- =========================
         KOP SURAT
    ========================== --}}

    <div class="kop">
        <img
            src="{{ storage_path('app/public/ppdb/kop_surat.jpeg') }}"
            style="width: 100%; height: auto;"
        >
    </div>


    {{-- =========================
         JUDUL
    ========================== --}}

    <div class="document-title">

        <h1>BUKTI PENDAFTARAN PPDB</h1>

        <p>
            Penerimaan Peserta Didik Baru
        </p>

    </div>


    {{-- =========================
         NOMOR PENDAFTARAN
    ========================== --}}

    <div class="reg-number">

        <p class="label">
            Nomor Pendaftaran
        </p>

        <p class="value">
            {{ $registration->registration_number }}
        </p>

    </div>


    {{-- =========================
         A. DATA CALON SISWA
    ========================== --}}

    <div class="section-title">
        A. Data Calon Siswa
    </div>

    <table class="data-table">

        <tr>
            <td class="label">Nama Lengkap</td>
            <td class="value">
                {{ $registration->biodata->name ?? '-' }}
            </td>
        </tr>

        <tr>
            <td class="label">NIK</td>
            <td class="value">
                {{ $registration->biodata->nik ?? '-' }}
            </td>
        </tr>

        <tr>
            <td class="label">Nomor Kartu Keluarga</td>
            <td class="value">
                {{ $registration->biodata->family_card_number ?? '-' }}
            </td>
        </tr>

        <tr>
            <td class="label">Tempat, Tanggal Lahir</td>
            <td class="value">
                {{ $registration->biodata->place_of_birth ?? '-' }},
                {{ optional($registration->biodata->date_of_birth)->format('d-m-Y') ?? '-' }}
            </td>
        </tr>

        <tr>
            <td class="label">Jenis Kelamin</td>
            <td class="value">
                {{ $registration->biodata->gender === 'L'
                    ? 'Laki-laki'
                    : ($registration->biodata->gender === 'P'
                        ? 'Perempuan'
                        : '-') }}
            </td>
        </tr>

        <tr>
            <td class="label">Asal Sekolah</td>
            <td class="value">
                {{ $registration->biodata->school_origin ?? '-' }}
            </td>
        </tr>

        <tr>
            <td class="label">Alamat</td>
            <td class="value">
                {{ $registration->biodata->address ?? '-' }}
            </td>
        </tr>

    </table>


    {{-- =========================
         B. DATA ORANG TUA
    ========================== --}}

    <div class="section-title">
        B. Data Orang Tua
    </div>

    <table class="data-table">

        <tr>
            <td class="label">Nama Ayah</td>
            <td class="value">
                {{ $registration->parentData->father_name ?? '-' }}
            </td>
        </tr>

        <tr>
            <td class="label">NIK Ayah</td>
            <td class="value">
                {{ $registration->parentData->father_nik ?? '-' }}
            </td>
        </tr>

        <tr>
            <td class="label">No. HP Ayah</td>
            <td class="value">
                {{ $registration->parentData->father_phone ?? '-' }}
            </td>
        </tr>

        <tr>
            <td class="label">Nama Ibu</td>
            <td class="value">
                {{ $registration->parentData->mother_name ?? '-' }}
            </td>
        </tr>

        <tr>
            <td class="label">NIK Ibu</td>
            <td class="value">
                {{ $registration->parentData->mother_nik ?? '-' }}
            </td>
        </tr>

        <tr>
            <td class="label">No. HP Ibu</td>
            <td class="value">
                {{ $registration->parentData->mother_phone ?? '-' }}
            </td>
        </tr>

    </table>


    {{-- =========================
         C. PILIHAN JURUSAN
    ========================== --}}

    <div class="section-title">
        C. Pilihan Jurusan
    </div>

    <table class="data-table">

        @forelse($registration->majorChoices as $choice)

            <tr>
                <td class="label">
                    Pilihan {{ $choice->choice_order }}
                </td>

                <td class="value">
                    {{ $choice->major->name ?? '-' }}
                </td>
            </tr>

        @empty

            <tr>
                <td colspan="2">
                    Belum ada pilihan jurusan.
                </td>
            </tr>

        @endforelse

    </table>


    {{-- =========================
         D. STATUS PENDAFTARAN
    ========================== --}}

    <div class="section-title">
        D. Status Pendaftaran
    </div>

    <div class="status-box">

        <table class="status-table">

            <tr>
                <td class="status-label">
                    Status Saat Ini
                </td>

                <td class="status-value">
                    {{ ucfirst(str_replace('_', ' ', $registration->status)) }}
                </td>
            </tr>

            <tr>
                <td class="status-label">
                    Tanggal Pendaftaran
                </td>

                <td class="status-value">
                    {{ $registration->created_at->format('d-m-Y H:i') }} WITA
                </td>
            </tr>

        </table>

    </div>


    {{-- =========================
         CATATAN
    ========================== --}}

    <div class="note">

        <strong>Catatan:</strong>
        Dokumen ini merupakan bukti pendaftaran PPDB yang
        dihasilkan secara otomatis oleh sistem. Harap simpan
        dokumen ini dan bawa saat proses verifikasi berkas
        di sekolah.

    </div>


    {{-- =========================
         FOOTER
    ========================== --}}

    <div class="footer">

        Dokumen ini digenerate secara otomatis oleh
        Sistem Informasi
        {{ \App\Models\CMS\Setting::get(
            'school_name',
            'SMK Negeri 1 Sebulu'
        ) }}.

    </div>

</body>
</html>