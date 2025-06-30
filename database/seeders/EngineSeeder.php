<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Engine;

class EngineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Engine::insert([
            ['code' => '1.6 TDI', 'power' => 105, 'fuel_type' => 'diesel', 'capacity' => 1.6],
            ['code' => '2.0 TSI', 'power' => 200, 'fuel_type' => 'petrol', 'capacity' => 2.0],
            ['code' => '1.8 VTEC', 'power' => 160, 'fuel_type' => 'petrol', 'capacity' => 1.8],
            ['code' => '1.2 Hybrid', 'power' => 100, 'fuel_type' => 'hybrid', 'capacity' => 1.2],
            ['code' => '5.0 V8', 'power' => 450, 'fuel_type' => 'petrol', 'capacity' => 5.0],
        ]);
    }
}
