<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class SampleBookingsSeeder extends Seeder
{
    public function run()
    {
        // Ensure schedule exists
        $schedule = Schedule::first();
        if (!$schedule) {
            $this->command->error('No schedule found. Please run ScheduleSeeder first.');
            return;
        }

        Booking::create([
            'user_id' => 1,
            'schedule_id' => $schedule->id,
            'reference_no' => 'BK-SAMPLE-001',
            'status' => 'pending',
            'total_amount' => 1200,
            'passenger_count' => 2,
            'contact_email' => 'test@example.com',
            'expires_at' => now()->addMinutes(30),
        ]);

        $this->command->info('Sample booking created.');
    }
}