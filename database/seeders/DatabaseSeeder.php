<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Enums\UserRole;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // create superadmin user
        User::create([
            'name' => 'John Doe',
            'email' => 'supeadmin@mail.com',
            'password' => Hash::make('123456'),
            'role' => UserRole::SUPERADMIN,
            'phone' => '05335016986',
            'email_verified_at' => now(),
        ]);
    }
}
