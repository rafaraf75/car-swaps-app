<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarModelEngineSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('car_model_engine')->insert([
            ['car_model_id' => 1, 'engine_id' => 1],
            ['car_model_id' => 1, 'engine_id' => 2],
            ['car_model_id' => 2, 'engine_id' => 1],
            ['car_model_id' => 3, 'engine_id' => 3],
            ['car_model_id' => 4, 'engine_id' => 4],
            ['car_model_id' => 5, 'engine_id' => 5],
        ]);
    }
}
