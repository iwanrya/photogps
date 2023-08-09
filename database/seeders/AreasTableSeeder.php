<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = array(
            ['name' => '100m2未満'],
            ['name' => '100m2 - 300m2'],
            ['name' => '300m2以上'],
        );

        DB::table('areas')->insert($areas);
    }
}
