<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => '123',
            'role' => 'admin',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'vendor',
            'email' => 'vendor@gmail.com',
            'password' => '123',
            'role' => 'vendor',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => '123',
            'role' => 'user',
        ]);
    }
}
