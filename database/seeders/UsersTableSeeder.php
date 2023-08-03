<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [];
        $faker = Factory::create();

        // Developer Accounts (Test Purpose)
        $users[] = [
            'name' => 'sgmt super admin',
            'email' => 'test1@sakura-global.co.id',
            'username' => 'admin',
            'email_verified_at' => now(),
            'password' => bcrypt('t5kskadg')
        ];

        $users[] = [
            'name' => 'sgmt as admin',
            'email' => 'test2@sakura-global.co.id',
            'username' => 'sgmt_admin',
            'email_verified_at' => now(),
            'password' => bcrypt('t5kskadg')
        ];

        $users[] = [
            'name' => 'sgmt as staff',
            'email' => 'test3@sakura-global.co.id',
            'username' => 'sgmt_staff',
            'email_verified_at' => now(),
            'password' => bcrypt('t5kskadg')
        ];

        if (App::isProduction() === false) {
            for ($i = 0; $i < 15; $i++) {
                $users[] = [
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'username' => $faker->unique()->userName,
                    'email_verified_at' => now(),
                    'password' => bcrypt('password')
                ];
            }
        }

        DB::table('users')->insert($users);
    }
}
