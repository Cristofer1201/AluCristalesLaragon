<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new User();
        $admin->name = 'Superadmin';
        $admin->email = 'superadmin@alucristales.com';
        $admin->email_verified_at = now();
        $admin->password = Hash::make('Superadmin2025!');
        $admin->is_enabled = true;
        $admin->password_active = true;
        $admin->save();

        $admin->assignRole('Administrador');
    }
}
