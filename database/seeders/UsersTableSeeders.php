<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [];
        $faker = Factory::create();

        for ($i = 0; $i < 15; $i++) {
            $data[$i] = [
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'username' => $faker->unique()->userName,
                'email_verified_at' => now(),
                'password' => bcrypt('password')
            ];
        }
        $data[] = [
            'name' => 'admin',
            'email' => 'test1@sakura-global.co.id',
            'username' => 'admin',
            'email_verified_at' => now(),
            'password' => bcrypt('password')
        ];

        DB::table('users')->insert($data);
    }
}
