<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [];
        $faker = Factory::create();

        $users = User::select('id')->pluck('id')->toArray();

        for ($i = 0; $i < 100; $i++) {

            $year = rand(2021, 2023);
            $month = rand(1, 12);
            $day = rand(1, 28);
            $hour = rand(8, 20);
            $minute = rand(0, 59);

            $date = Carbon::create($year, $month, $day, $hour, $minute, 0);

            $customers[] = [
                'name' => Str::Title($faker->name),
                'create_user_id' => $faker->randomElement($users),
                'created_at' => $date->format('Y-m-d H:i:s'),
            ];
        }

        DB::table('customers')->insert($customers);
    }
}
