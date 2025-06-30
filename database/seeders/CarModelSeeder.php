<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CarModel;

class CarModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CarModel::insert([
        [
            'brand' => 'Volkswagen',
            'model' => 'Golf',
            'generation' => 'VII',
            'year_start' => 2012,
            'year_end' => 2019
        ],
        [
            'brand' => 'Volkswagen',
            'model' => 'Passat',
            'generation' => 'B8',
            'year_start' => 2015,
            'year_end' => null
        ],
        [
            'brand' => 'Honda',
            'model' => 'Civic',
            'generation' => 'X',
            'year_start' => 2016,
            'year_end' => 2021
        ],
        [
            'brand' => 'Toyota',
            'model' => 'Corolla',
            'generation' => 'XII',
            'year_start' => 2018,
            'year_end' => null
        ],
        [
            'brand' => 'Ford',
            'model' => 'Mustang',
            'generation' => '6th',
            'year_start' => 2015,
            'year_end' => null
        ],
    ]);
    }
}
