<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        User::factory()->times(25)->create();
        User::create([
            'name' => 'rucci',
            'email' => 'rucci@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('rucci'),
        ]);
        Task::factory()->times(250)->create();
    }
}
