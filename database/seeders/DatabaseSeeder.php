<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create random user with role "customer"
        \App\Models\User::factory(10)->create();

        // Create user with role "admin"
         \App\Models\User::factory()->create([
             'name' => 'Admin',
             'email' => 'admin@gmail.com',
             'role' => 'admin'
         ]);

         // Create user with role "manager"
         \App\Models\User::factory()->create([
             'name' => 'Manager',
             'email' => 'manager@gmail.com',
             'role' => 'manager'
         ]);
    }
}
