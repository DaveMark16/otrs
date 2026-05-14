<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminOtrsSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@otrs.com'],
            [
                'name' => 'mOTRS Admin',
                'password' => Hash::make('Otrs@2026Secure!'),
                'role' => 'admin',
                
                'email_verified_at' => now(),
            ]
        );
    }
}