<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         
        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Head']);
        Role::firstOrCreate(['name' => 'User']);

        // Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
            ]
        );

        $admin->assignRole('Admin');

        // Head User
        $head = User::firstOrCreate(
            ['email' => 'head@test.com'],
            [
                'name' => 'Head',
                'password' => Hash::make('head123'),
            ]
        );

        $head->assignRole('Head');

        // Normal User
        $user = User::firstOrCreate(
            ['email' => 'user@test.com'],
            [
                'name' => 'User',
                'password' => Hash::make('user123'),
            ]
        );

        $user->assignRole('User');
    
    }
}
