<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update admin user
        User::updateOrCreate(
            [
                'dduc_id' => 'DDUCADMIN001',
            ],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'Admin',
                'is_active' => true,
            ]
        );

        $this->command->info('Admin user created successfully!');
        $this->command->info('DDUC ID: DDUCADMIN001');
        $this->command->info('Password: admin123');
        $this->command->info('Role: Admin');
    }
}

