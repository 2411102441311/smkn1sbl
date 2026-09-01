<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ThemeManager\Theme;

class ThemeSeeder extends Seeder
{
    // Tema default: biru muda khas SMK, dengan slot foto sekolah sebagai wallpaper hero
    public function run(): void
    {
        Theme::firstOrCreate(
            ['name' => 'Tema Biru SMK (Default)'],
            [
                'primary_color' => '#1D4ED8',   // biru sedang - header/CTA
                'secondary_color' => '#60A5FA', // biru muda - aksen
                'accent_color' => '#EFF6FF',    // biru sangat muda - background lembut
                'hero_image' => null,           // isi lewat Theme Manager > upload foto sekolah
                'is_active' => true,
            ]
        );
    }
}
