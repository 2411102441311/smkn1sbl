<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SPK\Criteria;
use App\Models\SPK\Alternative;

// Contoh SPK: seleksi penerimaan siswa berprestasi (bisa disesuaikan modul lain)
class SpkSeeder extends Seeder
{
    public function run(): void
    {
        $criteria = [
            ['code' => 'C1', 'name' => 'Nilai Rata-rata Rapor', 'type' => 'benefit', 'weight' => 0.35],
            ['code' => 'C2', 'name' => 'Nilai Tes Minat Bakat', 'type' => 'benefit', 'weight' => 0.25],
            ['code' => 'C3', 'name' => 'Jarak Domisili ke Sekolah (km)', 'type' => 'cost', 'weight' => 0.15],
            ['code' => 'C4', 'name' => 'Nilai Wawancara', 'type' => 'benefit', 'weight' => 0.25],
        ];

        foreach ($criteria as $c) {
            Criteria::firstOrCreate(['code' => $c['code']], $c);
        }

        $alternatives = [
            ['code' => 'A1', 'name' => 'Calon Siswa - Ahmad'],
            ['code' => 'A2', 'name' => 'Calon Siswa - Bunga'],
            ['code' => 'A3', 'name' => 'Calon Siswa - Citra'],
        ];

        foreach ($alternatives as $a) {
            Alternative::firstOrCreate(['code' => $a['code']], $a);
        }
    }
}
