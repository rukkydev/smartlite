<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create a default super admin
        Admin::create([
            'uuid' => Str::random(8),
            'name' => 'Super Admin',
            'email' => 'super@adminstrator.com',
            'password' => bcrypt('SecurePass123!'), // Secure password
            'role' => 'superadmin',
            'is_active' => true,
            'email_verified_at' => now(),
            'last_login_at' => null,
            'last_login_ip' => null,
        ]);

        // Create an additional admin for testing
        Admin::create([
            'uuid' => Str::random(8),
            'name' => 'Test Admin',
            'email' => 'test@manager.com',
            'password' => bcrypt('TestPass123!'),
            'role' => 'manager',
            'is_active' => true,
            'email_verified_at' => now(),
            'last_login_at' => null,
            'last_login_ip' => null,
        ]);
    }


}