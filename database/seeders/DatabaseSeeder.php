<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Medication;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Supply;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Client::factory(30)->create();
        Medication::factory(10)->create();
        Employee::factory(30)->create();
        Supply::factory(20)->create();
    }
}
