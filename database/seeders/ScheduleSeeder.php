<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\Trip;
use Carbon\Carbon;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $trips = Trip::where('status', 'active')->get();

        if ($trips->isEmpty()) {
            $this->command->warn('⚠  No active trips found. Run TripSeeder first.');
            return;
        }

        $created = 0;
        $today = Carbon::today();

        // Fare configs per operator
        $operatorFares = [
            'Philippine Airlines' => ['economy' => 3800, 'business' => 9500,  'first' => 18000],
            'Cebu Pacific'        => ['economy' => 2100, 'business' => 6500,  'first' => null ],
            'AirAsia'             => ['economy' => 1800, 'business' => 5800,  'first' => null ],
            'default'             => ['economy' => 2500, 'business' => 7000,  'first' => 15000],
        ];

        // Departure slots (hour, minute, duration_hours)
        $slots = [
            ['dep' => [5, 0],  'dur' => 1.5],
            ['dep' => [7, 30], 'dur' => 1.5],
            ['dep' => [9, 45], 'dur' => 1.5],
            ['dep' => [12, 0], 'dur' => 1.5],
            ['dep' => [14, 30],'dur' => 1.5],
            ['dep' => [17, 0], 'dur' => 1.5],
            ['dep' => [19, 30],'dur' => 1.5],
            ['dep' => [21, 0], 'dur' => 1.5],
        ];

        foreach ($trips as $trip) {
            $fares = $operatorFares[$trip->operator] ?? $operatorFares['default'];

            // Generate schedules for the next 60 days, ~4 per week per trip
            for ($weekOffset = 0; $weekOffset < 9; $weekOffset++) {
                // Pick 4 days spread across the week
                $days = [0, 2, 4, 6]; // Mon/Wed/Fri/Sun offsets

                foreach ($days as $dayOffset) {
                    $date = $today->copy()->addWeeks($weekOffset)->addDays($dayOffset);

                    // Skip if date is in the past
                    if ($date->isPast()) {
                        $date = $today->copy()->addDay();
                    }

                    // Pick a slot based on trip id + day for variety
                    $slotIndex = ($trip->id + $dayOffset) % count($slots);
                    $slot = $slots[$slotIndex];

                    $departure = $date->copy()
                        ->setHour($slot['dep'][0])
                        ->setMinute($slot['dep'][1])
                        ->setSecond(0);

                    $arrival = $departure->copy()->addMinutes((int)($slot['dur'] * 60));

                    // Fare class: mix economy/business, first only for PAL
                    $fareClasses = ['economy'];
                    if ($fares['business']) $fareClasses[] = 'business';
                    if ($fares['first'])    $fareClasses[] = 'first';

                    $fareClass = $fareClasses[($trip->id + $dayOffset + $weekOffset) % count($fareClasses)];
                    $baseFare  = $fares[$fareClass] ?? $fares['economy'];

                    // Add small price variation per week
                    $baseFare = round($baseFare * (1 + ($weekOffset * 0.015)), -1);

                    $capacity = in_array($fareClass, ['business', 'first']) ? 30 : 150;

                    // Avoid duplicate schedules
                    $exists = Schedule::where('trip_id', $trip->id)
                        ->where('departure_at', $departure)
                        ->where('fare_class', $fareClass)
                        ->exists();

                    if (!$exists) {
                        Schedule::create([
                            'trip_id'         => $trip->id,
                            'departure_at'    => $departure,
                            'arrival_at'      => $arrival,
                            'capacity'        => $capacity,
                            'available_seats' => $capacity,
                            'fare_class'      => $fareClass,
                            'base_fare'       => $baseFare,
                            'status'          => 'scheduled',
                        ]);
                        $created++;
                    }
                }
            }
        }

        $this->command->info("✅ {$created} schedules seeded across {$trips->count()} trips.");
    }
}
