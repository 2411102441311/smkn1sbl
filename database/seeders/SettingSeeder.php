<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CMS\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'school_name' => 'SMK Negeri 1 Sebulu',
            'school_address' => 'Jl. Pendidikan, Sebulu, Kutai Kartanegara, Kalimantan Timur',
            'school_email' => 'smkn1sbl@gmail.com',
            'school_phone' => '(0541) 000-000',
            'ppdb_open' => '1',
        ];

        foreach ($defaults as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value, 'group' => 'general']);
        }
    }
}
