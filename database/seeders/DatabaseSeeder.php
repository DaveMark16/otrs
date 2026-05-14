<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            TripSeeder::class,
            ScheduleSeeder::class,
            PromoSeeder::class,
        ]);
    }
}