<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Swap;

class SwapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Swap::insert([
            [
                'car_model_id' => 1,
                'engine_id' => 1,
            ],
            [
                'car_model_id' => 2,
                'engine_id' => 2,
            ],
            [
                'car_model_id' => 3,
                'engine_id' => 3,
            ],
        ]);
    }
}
