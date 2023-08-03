<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status_names = ['start', 'pending', 'on progress', 'delivered', 'finish', 'stop', 'cancel'];
        $status = [];

        for ($i = 0; $i < count($status_names); $i++) {
            $status_name = $status_names[$i];
            $status[] = [
                'name' => $status_name
            ];
        }

        DB::table('status')->insert($status);
    }
}
