<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Trip;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;

class SeedSchedules extends Command
{
    protected $signature   = 'seed:schedules {--fresh : Truncate schedules first}';
    protected $description = 'Seed schedules for all active trips so users can book flights';

    public function handle()
    {
        if ($this->option('fresh')) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Schedule::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            $this->info('Schedules cleared.');
        }

        $trips = Trip::where('status', 'active')->get();

        if ($trips->isEmpty()) {
            $this->error('No active trips found! Run php artisan seed:trips first.');
            return;
        }

        // Base fare by aircraft capacity
        $baseFare = function ($maxPax) {
            if ($maxPax >= 380) return 24000;
            if ($maxPax >= 300) return 18000;
            if ($maxPax >= 220) return 12000;
            if ($maxPax >= 180) return  8000;
            return 5500;
        };

        // Flight duration estimate by route type (hours)
        $duration = function (Trip $trip) {
            $long  = ['United States','Canada','United Kingdom','France','Germany','Netherlands','Italy','Spain','Switzerland','Finland','Turkey','Russia','Australia','New Zealand','South Africa','Kenya','Nigeria','Egypt','Brazil','Mexico'];
            $med   = ['Japan','South Korea','China','Hong Kong','Taiwan','India','Bangladesh','Sri Lanka','Nepal','United Arab Emirates','Saudi Arabia','Qatar','Kuwait','Oman','Bahrain','Israel','Jordan'];

            if (in_array($trip->destination_country, $long))  return rand(13, 17);
            if (in_array($trip->destination_country, $med))   return rand(4,  9);
            return rand(1, 4); // short haul
        };

        $bar   = $this->output->createProgressBar($trips->count());
        $bar->start();
        $count = 0;

        foreach ($trips as $trip) {
            $fare     = $baseFare($trip->max_passengers ?? 180);
            $capacity = $trip->max_passengers ?? 180;
            $hours    = $duration($trip);

            /*
             * 6 schedules per trip spread over the next 30 days:
             * 3 fare classes × 2 time slots each
             */
            $schedules = [
                // Economy — most affordable
                ['fare_class' => 'economy', 'multiplier' => 1.0,  'offset' =>  1, 'hour' =>  6],
                ['fare_class' => 'economy', 'multiplier' => 1.0,  'offset' =>  4, 'hour' => 14],
                ['fare_class' => 'economy', 'multiplier' => 1.0,  'offset' =>  8, 'hour' => 20],
                ['fare_class' => 'economy', 'multiplier' => 1.0,  'offset' => 12, 'hour' =>  8],
                ['fare_class' => 'economy', 'multiplier' => 1.0,  'offset' => 18, 'hour' => 16],
                ['fare_class' => 'economy', 'multiplier' => 1.0,  'offset' => 25, 'hour' => 10],

                // Business — 2.5x
                ['fare_class' => 'business', 'multiplier' => 2.5, 'offset' =>  2, 'hour' =>  7],
                ['fare_class' => 'business', 'multiplier' => 2.5, 'offset' =>  6, 'hour' => 15],
                ['fare_class' => 'business', 'multiplier' => 2.5, 'offset' => 15, 'hour' =>  9],
                ['fare_class' => 'business', 'multiplier' => 2.5, 'offset' => 22, 'hour' => 18],

                // First — 5x
                ['fare_class' => 'first',    'multiplier' => 5.0, 'offset' =>  3, 'hour' =>  8],
                ['fare_class' => 'first',    'multiplier' => 5.0, 'offset' => 10, 'hour' => 11],
            ];

            foreach ($schedules as $s) {
                $departure = now()
                    ->addDays($s['offset'])
                    ->setHour($s['hour'])
                    ->setMinute(0)
                    ->setSecond(0);

                $arrival = (clone $departure)->addHours($hours);

                Schedule::create([
                    'trip_id'         => $trip->id,
                    'departure_at'    => $departure,
                    'arrival_at'      => $arrival,
                    'capacity'        => $capacity,
                    'available_seats' => $capacity,
                    'fare_class'      => $s['fare_class'],
                    'base_fare'       => round($fare * $s['multiplier'], 2),
                    'status'          => 'scheduled',
                ]);

                $count++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("✅ {$count} schedules seeded across {$trips->count()} trips!");
        $this->table(
            ['Stat', 'Value'],
            [
                ['Total Trips',          $trips->count()],
                ['Total Schedules',      $count],
                ['Schedules per Trip',   12],
                ['Fare Classes',         'economy · business · first'],
                ['Date Range',           'Today + 1 to +30 days'],
                ['Status',               'scheduled — visible in booking'],
            ]
        );
    }
}