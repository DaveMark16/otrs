<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promo;
use Carbon\Carbon;

class PromoSeeder extends Seeder
{
    public function run(): void
    {
        $promos = [
            [
                'title'          => 'Summer Sale',
                'description'    => 'Enjoy 15% off all flights this summer season!',
                'discount_type'  => 'percentage',
                'discount_value' => 15,
                'promo_code'     => 'SUMMER15',
                'start_date'     => Carbon::today(),
                'end_date'       => Carbon::today()->addDays(30),
                'applies_to_all' => true,
            ],
            [
                'title'          => 'Early Bird Discount',
                'description'    => 'Book early and save ₱500 on your trip!',
                'discount_type'  => 'fixed',
                'discount_value' => 500,
                'promo_code'     => 'EARLYBIRD',
                'start_date'     => Carbon::today(),
                'end_date'       => Carbon::today()->addDays(60),
                'applies_to_all' => true,
            ],
            [
                'title'          => 'Welcome Promo',
                'description'    => 'First time booking? Get 10% off your first trip.',
                'discount_type'  => 'percentage',
                'discount_value' => 10,
                'promo_code'     => 'WELCOME10',
                'start_date'     => Carbon::today(),
                'end_date'       => Carbon::today()->addDays(90),
                'applies_to_all' => true,
            ],
            [
                'title'          => 'Payday Special',
                'description'    => 'Treat yourself on payday — ₱1,000 off any booking!',
                'discount_type'  => 'fixed',
                'discount_value' => 1000,
                'promo_code'     => 'PAYDAY1K',
                'start_date'     => Carbon::today(),
                'end_date'       => Carbon::today()->addDays(15),
                'applies_to_all' => true,
            ],
            [
                'title'          => 'Midweek Escape',
                'description'    => 'Travel midweek and save 20% on select routes.',
                'discount_type'  => 'percentage',
                'discount_value' => 20,
                'promo_code'     => 'MIDWEEK20',
                'start_date'     => Carbon::today(),
                'end_date'       => Carbon::today()->addDays(45),
                'applies_to_all' => true,
            ],
        ];

        foreach ($promos as $data) {
            Promo::updateOrCreate(
                ['promo_code' => $data['promo_code']],
                $data
            );
        }

        $this->command->info('✅ ' . count($promos) . ' promo codes seeded.');
    }
}
