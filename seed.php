<?php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Skip trips if already exist
if (App\Models\Trip::count() === 0) {
    $trips = [
        ['name'=>'Manila-Cebu','origin'=>'Manila','destination'=>'Cebu','type'=>'air','operator'=>'Philippine Airlines','status'=>'active'],
        ['name'=>'Manila-Davao','origin'=>'Manila','destination'=>'Davao','type'=>'air','operator'=>'Cebu Pacific','status'=>'active'],
        ['name'=>'Manila-Boracay','origin'=>'Manila','destination'=>'Boracay','type'=>'air','operator'=>'AirAsia','status'=>'active'],
        ['name'=>'Manila-Iloilo','origin'=>'Manila','destination'=>'Iloilo','type'=>'air','operator'=>'Philippine Airlines','status'=>'active'],
        ['name'=>'Manila-Bacolod','origin'=>'Manila','destination'=>'Bacolod','type'=>'air','operator'=>'Cebu Pacific','status'=>'active'],
        ['name'=>'Manila-Cagayan de Oro','origin'=>'Manila','destination'=>'Cagayan de Oro','type'=>'air','operator'=>'AirAsia','status'=>'active'],
        ['name'=>'Cebu-Davao','origin'=>'Cebu','destination'=>'Davao','type'=>'air','operator'=>'Philippine Airlines','status'=>'active'],
        ['name'=>'Manila-Singapore','origin'=>'Manila','destination'=>'Singapore','type'=>'air','operator'=>'Singapore Airlines','status'=>'active'],
        ['name'=>'Manila-Tokyo','origin'=>'Manila','destination'=>'Tokyo','type'=>'air','operator'=>'Japan Airlines','status'=>'active'],
        ['name'=>'Manila-Hong Kong','origin'=>'Manila','destination'=>'Hong Kong','type'=>'air','operator'=>'Cathay Pacific','status'=>'active'],
        ['name'=>'Manila-Dubai','origin'=>'Manila','destination'=>'Dubai','type'=>'air','operator'=>'Emirates','status'=>'active'],
        ['name'=>'Manila-Kuala Lumpur','origin'=>'Manila','destination'=>'Kuala Lumpur','type'=>'air','operator'=>'AirAsia','status'=>'active'],
        ['name'=>'Manila-Seoul','origin'=>'Manila','destination'=>'Seoul','type'=>'air','operator'=>'Korean Air','status'=>'active'],
        ['name'=>'Cebu-Singapore','origin'=>'Cebu','destination'=>'Singapore','type'=>'air','operator'=>'Cebu Pacific','status'=>'active'],
        ['name'=>'Davao-Manila','origin'=>'Davao','destination'=>'Manila','type'=>'air','operator'=>'Cebu Pacific','status'=>'active'],
    ];
    foreach ($trips as $t) App\Models\Trip::create($t);
}
echo App\Models\Trip::count() . " trips exist\n";

// Users
$users = [
    ['name'=>'Traveler User','email'=>'traveler@otrs.com','role'=>'passenger'],
    ['name'=>'Business Professional','email'=>'business@otrs.com','role'=>'staff'],
    ['name'=>'Tourist User','email'=>'tourist@otrs.com','role'=>'passenger'],
    ['name'=>'Corporate Travel','email'=>'corporate@otrs.com','role'=>'staff'],
];
foreach ($users as $u) {
    App\Models\User::firstOrCreate(
        ['email' => $u['email']],
        array_merge($u, [
            'password' => bcrypt('password123'),
            'status' => 'active',
            'email_verified_at' => now()
        ])
    );
}
echo App\Models\User::count() . " users total\n";

// Delete old schedules and reseed with correct status
App\Models\Schedule::truncate();
echo "Old schedules cleared\n";

$fares = [2500,3200,4800,5500,8000,9500,12000,15000,18000,22000,28000,32000,38000,45000,6500];
$times = [
    ['dep'=>'05:30:00','arr'=>'07:30:00','class'=>'economy'],
    ['dep'=>'08:00:00','arr'=>'10:00:00','class'=>'economy'],
    ['dep'=>'11:00:00','arr'=>'13:00:00','class'=>'business'],
    ['dep'=>'14:30:00','arr'=>'16:30:00','class'=>'economy'],
    ['dep'=>'18:00:00','arr'=>'20:00:00','class'=>'business'],
];
$dates = ['2026-06-01','2026-06-02','2026-06-03','2026-06-05','2026-06-07'];

foreach (App\Models\Trip::all() as $i => $trip) {
    foreach ($dates as $date) {
        $t = $times[$i % count($times)];
        App\Models\Schedule::create([
            'trip_id'         => $trip->id,
            'departure_at'    => $date . ' ' . $t['dep'],
            'arrival_at'      => $date . ' ' . $t['arr'],
            'capacity'        => 230,
            'available_seats' => 210,
            'fare_class'      => $t['class'],
            'base_fare'       => $fares[$i % count($fares)],
            'status'          => 'scheduled',
        ]);
    }
}
echo App\Models\Schedule::count() . " schedules created\n";
echo "ALL DONE!\n";