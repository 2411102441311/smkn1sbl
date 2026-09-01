<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Auth\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminRole = Role::where('slug', 'super-admin')->first();

        User::firstOrCreate(
            ['email' => 'admin@smkn1sebulu.sch.id'],
            [
                'name' => 'Administrator',
                'password' => 'password123', // Password akan otomatis di-hash karena model User.php punya cast 'password' => 'hashed'
                'role_id' => $superAdminRole?->id,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
