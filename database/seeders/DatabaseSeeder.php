<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Medication;
use App\Models\Supply;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        Supply::factory(30)->create();


        $this->call(MedicationSupplySeeder::class);
    }
}
