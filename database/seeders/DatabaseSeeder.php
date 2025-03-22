<?php

namespace Database\Seeders;

use App\Models\Plan;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // Create one admin user
        User::factory()->admin()->create();

        // // Create one regular user
        User::factory()->user()->create();
        
        // // Create one affiliate user
        User::factory()->affiliate()->create();

        // Create 5 plans
        Plan::factory(5)->create();
    }
}
