<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing users to prevent duplicate/hashing issues
        \App\Models\User::truncate();

        // Admin
        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@ppc.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
        ]);

        // Viewer
        \App\Models\User::create([
            'name' => 'Viewer User',
            'email' => 'viewer@ppc.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'viewer',
        ]);
    }
}
