<?php

namespace Database\Seeders;

use App\Models\ProductionLine;
use Illuminate\Database\Seeder;

class ProductionLineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        ProductionLine::create(['name' => 'Line 1']);
        ProductionLine::create(['name' => 'Line 2']);
        ProductionLine::create(['name' => 'Line 3']);
        ProductionLine::create(['name' => 'Line 4']);
    }
}
