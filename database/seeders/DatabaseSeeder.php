<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CarModelSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CarModelSeeder::class);
        $this->call(EngineSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(SwapSeeder::class);
        $this->call(CarModelEngineSeeder::class);
        $this->call(SwapTagSeeder::class);
    }
}
