<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Major;
use App\Http\Controllers\MajorController;

class MajorSeeder extends Seeder
{
    // Isi tabel `majors` dari data yang sama dipakai MajorController (biar konsisten,
    // baik untuk tampilan homepage/detail jurusan MAUPUN untuk relasi database PPDB.
    public function run(): void
    {
        foreach (MajorController::data() as $major) {
            Major::updateOrCreate(
                ['slug' => $major['slug']],
                [
                    'code' => $major['code'],
                    'name' => $major['name'],
                    'description' => $major['desc'],
                    'icon' => $major['icon'],
                    'logo' => $major['logo'] ?? null,
                    'color_from' => $major['color_from'],
                    'color_to' => $major['color_to'],
                    'capacity' => 36,
                ]
            );
        }
    }
}