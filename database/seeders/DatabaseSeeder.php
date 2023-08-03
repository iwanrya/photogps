<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = new UsersTableSeeder();
        $users->run();

        $projects = new ProjectsTableSeeder();
        $projects->run();

        $customers = new CustomersTableSeeder();
        $customers->run();

        $status = new StatusTableSeeder();
        $status->run();
    }
}
