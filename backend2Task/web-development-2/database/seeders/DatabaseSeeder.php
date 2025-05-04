<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        try {
            $driver = User::create([
                'name' => 'Driver User',
                'email' => 'd@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'driver',
            ]);

            $client = User::create([
                'name' => 'Client User',
                'email' => 'c@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'client',
            ]);

            // Confirm it worked (optional)
            $this->command->info("Users seeded: driver ID {$driver->id}, client ID {$client->id}");
        } catch (\Exception $e) {
            $this->command->error("Error seeding users: " . $e->getMessage());
        }
    }
}
