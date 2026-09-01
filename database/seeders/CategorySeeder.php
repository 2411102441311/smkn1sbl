<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CMS\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Prestasi', 'type' => 'news'],
            ['name' => 'Kegiatan Sekolah', 'type' => 'news'],
            ['name' => 'Profil Sekolah', 'type' => 'page'],
            ['name' => 'Fasilitas', 'type' => 'gallery'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => Str::slug($category['name']), 'type' => $category['type']],
                $category + ['slug' => Str::slug($category['name'])]
            );
        }
    }
}
