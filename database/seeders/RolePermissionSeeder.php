<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auth\Role;
use App\Models\Auth\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            'CMS' => ['pages.manage', 'news.manage', 'gallery.manage', 'announcements.manage', 'settings.manage'],
            'PPDB' => ['applicants.manage', 'registrations.manage', 'verification.manage'],
            'Theme' => ['themes.manage', 'banners.manage'],
            'Pakar' => ['questions.manage', 'knowledge.manage', 'rules.manage'],
            'SPK' => ['criteria.manage', 'alternatives.manage', 'rankings.manage'],
            'Reporting' => ['reports.view'],
            'Auth' => ['users.manage', 'roles.manage'],
        ];

        $allPermissionIds = [];

        foreach ($modules as $module => $slugs) {
            foreach ($slugs as $slug) {
                $permission = Permission::firstOrCreate(
                    ['slug' => $module . '.' . $slug],
                    ['name' => $module . ' - ' . $slug, 'module' => $module]
                );
                $allPermissionIds[] = $permission->id;
            }
        }

        $superAdmin = Role::firstOrCreate(
            ['slug' => 'super-admin'],
            ['name' => 'Super Admin', 'description' => 'Akses penuh ke seluruh modul sistem.']
        );
        $superAdmin->permissions()->sync($allPermissionIds);

        $ppdbAdmin = Role::firstOrCreate(
            ['slug' => 'admin-ppdb'],
            ['name' => 'Admin PPDB', 'description' => 'Mengelola pendaftaran siswa baru.']
        );
        $ppdbAdmin->permissions()->sync(
            Permission::where('module', 'PPDB')->pluck('id')
        );

        $editorCms = Role::firstOrCreate(
            ['slug' => 'editor-cms'],
            ['name' => 'Editor CMS', 'description' => 'Mengelola konten website (berita, halaman, galeri).']
        );
        $editorCms->permissions()->sync(
            Permission::where('module', 'CMS')->pluck('id')
        );
    }
}
