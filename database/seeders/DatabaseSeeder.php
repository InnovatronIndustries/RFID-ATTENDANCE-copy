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
        \Schema::disableForeignKeyConstraints();

        $this->call([
            SchoolTableSeeder::class,
            RoleTableSeeder::class,
            UserTableSeeder::class,
        ]);

        \Schema::enableForeignKeyConstraints();
    }
}
