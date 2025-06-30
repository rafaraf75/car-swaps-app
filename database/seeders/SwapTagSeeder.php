<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SwapTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('swap_tag')->insert([
            ['swap_id' => 1, 'tag_id' => 1],
            ['swap_id' => 2, 'tag_id' => 3],
        ]);
    }
}
