<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FourSquareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('four_squares')->insert([
            'total_records'=>'202',
            'current_latitude'=>'52.377956',
            'current_longitude'=>'4.897070',
            'current_limit'=>'200'
        ]);
    }
}
