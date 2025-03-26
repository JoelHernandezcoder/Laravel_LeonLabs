<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Medication;
use App\Models\Supply;

class MedicationSupplySeeder extends Seeder
{
    public function run()
    {
        $medications = Medication::all();
        $supplies = Supply::all();

        foreach ($medications as $medication) {
            $numberOfRelations = rand(1, 3);

            for ($i = 0; $i < $numberOfRelations; $i++) {
                $supply = $supplies->random();
                $quantity = rand(1, 10);

                DB::table('medication_supply')->insert([
                    'medication_id' => $medication->id,
                    'supply_id' => $supply->id,
                    'quantity_per_unit' => $quantity,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
