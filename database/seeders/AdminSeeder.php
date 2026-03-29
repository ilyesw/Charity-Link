<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'      => 'Administrateur',
            'email'     => 'admin@charity-link.tn',
            'password'  => Hash::make('Admin@1234'),
            'role'      => 'admin',
            'language'  => 'fr',
            'is_active' => true,
        ]);
    }
}
