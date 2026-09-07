<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\CMS\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Daftar setting yang dipakai di seluruh web (navbar, footer, section sambutan, dll).
     * Sengaja dikurasi di sini (bukan cuma nampilin yang kebetulan sudah ada di database)
     * supaya field ini tetap muncul di form walau belum pernah diisi sama sekali.
     */
    private function fields(): array
    {
        return [
            'Informasi Sekolah' => [
                ['key' => 'school_name', 'label' => 'Nama Sekolah', 'type' => 'text'],
                ['key' => 'school_email', 'label' => 'Email Sekolah', 'type' => 'text'],
                ['key' => 'school_phone', 'label' => 'Nomor Telepon/WhatsApp', 'type' => 'text'],
                ['key' => 'school_address', 'label' => 'Alamat Sekolah', 'type' => 'textarea'],
            ],
            'Kepala Sekolah' => [
                ['key' => 'principal_name', 'label' => 'Nama Kepala Sekolah', 'type' => 'text'],
                ['key' => 'principal_photo', 'label' => 'Nama File Foto (di public/images/)', 'type' => 'text'],
            ],
        ];
    }

    public function index()
    {
        $groupedFields = $this->fields();

        // Isi tiap field dengan nilai yang sekarang tersimpan di database (kalau belum ada, kosong)
        foreach ($groupedFields as $group => $fields) {
            foreach ($fields as $i => $field) {
                $groupedFields[$group][$i]['value'] = Setting::get($field['key'], '');
            }
        }

        return view('cms.settings.index', ['groupedFields' => $groupedFields]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'settings' => 'required|array',
            'settings.*' => 'nullable|string',
        ]);

        foreach ($data['settings'] as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}