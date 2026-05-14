<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trip;

class TripSeeder extends Seeder
{
    public function run(): void
    {
        $trips = [
            // ── MANILA OUTBOUND ──────────────────────────────────────────────
            ['name'=>'Manila to Cebu Morning Flight',        'origin'=>'Manila',          'destination'=>'Cebu',               'operator'=>'Philippine Airlines'],
            ['name'=>'Manila to Cebu Afternoon Flight',      'origin'=>'Manila',          'destination'=>'Cebu',               'operator'=>'Cebu Pacific'],
            ['name'=>'Manila to Cebu Night Flight',          'origin'=>'Manila',          'destination'=>'Cebu',               'operator'=>'AirAsia'],
            ['name'=>'Manila to Davao Express',              'origin'=>'Manila',          'destination'=>'Davao',              'operator'=>'Philippine Airlines'],
            ['name'=>'Manila to Davao Early Bird',           'origin'=>'Manila',          'destination'=>'Davao',              'operator'=>'Cebu Pacific'],
            ['name'=>'Manila to Iloilo Direct',              'origin'=>'Manila',          'destination'=>'Iloilo',             'operator'=>'Philippine Airlines'],
            ['name'=>'Manila to Iloilo Budget Flight',       'origin'=>'Manila',          'destination'=>'Iloilo',             'operator'=>'AirAsia'],
            ['name'=>'Manila to Zamboanga Air',              'origin'=>'Manila',          'destination'=>'Zamboanga',          'operator'=>'Philippine Airlines'],
            ['name'=>'Manila to Bacolod Morning',            'origin'=>'Manila',          'destination'=>'Bacolod',            'operator'=>'Cebu Pacific'],
            ['name'=>'Manila to Bacolod Afternoon',          'origin'=>'Manila',          'destination'=>'Bacolod',            'operator'=>'Philippine Airlines'],
            ['name'=>'Manila to Cagayan de Oro Direct',      'origin'=>'Manila',          'destination'=>'Cagayan de Oro',     'operator'=>'Philippine Airlines'],
            ['name'=>'Manila to Cagayan de Oro Budget',      'origin'=>'Manila',          'destination'=>'Cagayan de Oro',     'operator'=>'Cebu Pacific'],
            ['name'=>'Manila to Tacloban Flight',            'origin'=>'Manila',          'destination'=>'Tacloban',           'operator'=>'Cebu Pacific'],
            ['name'=>'Manila to General Santos Air',         'origin'=>'Manila',          'destination'=>'General Santos',     'operator'=>'AirAsia'],
            ['name'=>'Manila to General Santos Direct',      'origin'=>'Manila',          'destination'=>'General Santos',     'operator'=>'Philippine Airlines'],
            ['name'=>'Manila to Butuan Flight',              'origin'=>'Manila',          'destination'=>'Butuan',             'operator'=>'Cebu Pacific'],
            ['name'=>'Manila to Puerto Princesa Direct',     'origin'=>'Manila',          'destination'=>'Puerto Princesa',    'operator'=>'Philippine Airlines'],
            ['name'=>'Manila to Puerto Princesa Budget',     'origin'=>'Manila',          'destination'=>'Puerto Princesa',    'operator'=>'Cebu Pacific'],
            ['name'=>'Manila to Kalibo Flight',              'origin'=>'Manila',          'destination'=>'Kalibo',             'operator'=>'AirAsia'],
            ['name'=>'Manila to Kalibo Direct',              'origin'=>'Manila',          'destination'=>'Kalibo',             'operator'=>'Cebu Pacific'],
            ['name'=>'Manila to Legazpi Air',                'origin'=>'Manila',          'destination'=>'Legazpi',            'operator'=>'Cebu Pacific'],
            ['name'=>'Manila to Dumaguete Direct',           'origin'=>'Manila',          'destination'=>'Dumaguete',          'operator'=>'Philippine Airlines'],
            ['name'=>'Manila to Ozamiz Flight',              'origin'=>'Manila',          'destination'=>'Ozamiz',             'operator'=>'Cebu Pacific'],
            ['name'=>'Manila to Cotabato Air',               'origin'=>'Manila',          'destination'=>'Cotabato',           'operator'=>'Philippine Airlines'],
            ['name'=>'Manila to Tagbilaran Flight',          'origin'=>'Manila',          'destination'=>'Tagbilaran',         'operator'=>'Cebu Pacific'],
            ['name'=>'Manila to Surigao Air',                'origin'=>'Manila',          'destination'=>'Surigao',            'operator'=>'Philippine Airlines'],
            ['name'=>'Manila to Dipolog Flight',             'origin'=>'Manila',          'destination'=>'Dipolog',            'operator'=>'Cebu Pacific'],
            ['name'=>'Manila to Pagadian Air',               'origin'=>'Manila',          'destination'=>'Pagadian',           'operator'=>'AirAsia'],
            ['name'=>'Manila to Virac Flight',               'origin'=>'Manila',          'destination'=>'Virac',              'operator'=>'Philippine Airlines'],
            ['name'=>'Manila to San Jose Air',               'origin'=>'Manila',          'destination'=>'San Jose',           'operator'=>'Cebu Pacific'],
            ['name'=>'Manila to Roxas City Flight',          'origin'=>'Manila',          'destination'=>'Roxas City',         'operator'=>'Philippine Airlines'],
            ['name'=>'Manila to Masbate Air',                'origin'=>'Manila',          'destination'=>'Masbate',            'operator'=>'Cebu Pacific'],
            ['name'=>'Manila to Catarman Flight',            'origin'=>'Manila',          'destination'=>'Catarman',           'operator'=>'Philippine Airlines'],
            ['name'=>'Manila to Calbayog Air',               'origin'=>'Manila',          'destination'=>'Calbayog',           'operator'=>'Cebu Pacific'],
            ['name'=>'Manila to Tandag Flight',              'origin'=>'Manila',          'destination'=>'Tandag',             'operator'=>'Philippine Airlines'],
            ['name'=>'Manila to Naga Air',                   'origin'=>'Manila',          'destination'=>'Naga',               'operator'=>'Cebu Pacific'],
            ['name'=>'Manila to Ormoc Flight',               'origin'=>'Manila',          'destination'=>'Ormoc',              'operator'=>'Philippine Airlines'],
            ['name'=>'Manila to Camiguin Air',               'origin'=>'Manila',          'destination'=>'Camiguin',           'operator'=>'Cebu Pacific'],
            ['name'=>'Manila to Tawi-Tawi Flight',           'origin'=>'Manila',          'destination'=>'Tawi-Tawi',          'operator'=>'Philippine Airlines'],
            ['name'=>'Manila to Jolo Air',                   'origin'=>'Manila',          'destination'=>'Jolo',               'operator'=>'Philippine Airlines'],

            // ── CEBU OUTBOUND ────────────────────────────────────────────────
            ['name'=>'Cebu to Manila Morning Flight',        'origin'=>'Cebu',            'destination'=>'Manila',             'operator'=>'Philippine Airlines'],
            ['name'=>'Cebu to Manila Budget Flight',         'origin'=>'Cebu',            'destination'=>'Manila',             'operator'=>'Cebu Pacific'],
            ['name'=>'Cebu to Davao Direct',                 'origin'=>'Cebu',            'destination'=>'Davao',              'operator'=>'Cebu Pacific'],
            ['name'=>'Cebu to Davao Budget',                 'origin'=>'Cebu',            'destination'=>'Davao',              'operator'=>'AirAsia'],
            ['name'=>'Cebu to Iloilo Flight',                'origin'=>'Cebu',            'destination'=>'Iloilo',             'operator'=>'Philippine Airlines'],
            ['name'=>'Cebu to General Santos Air',           'origin'=>'Cebu',            'destination'=>'General Santos',     'operator'=>'Cebu Pacific'],
            ['name'=>'Cebu to Zamboanga Flight',             'origin'=>'Cebu',            'destination'=>'Zamboanga',          'operator'=>'Philippine Airlines'],
            ['name'=>'Cebu to Cagayan de Oro Express',       'origin'=>'Cebu',            'destination'=>'Cagayan de Oro',     'operator'=>'Cebu Pacific'],
            ['name'=>'Cebu to Tacloban Air',                 'origin'=>'Cebu',            'destination'=>'Tacloban',           'operator'=>'Philippine Airlines'],
            ['name'=>'Cebu to Butuan Flight',                'origin'=>'Cebu',            'destination'=>'Butuan',             'operator'=>'AirAsia'],
            ['name'=>'Cebu to Dumaguete Air',                'origin'=>'Cebu',            'destination'=>'Dumaguete',          'operator'=>'Philippine Airlines'],
            ['name'=>'Cebu to Surigao Flight',               'origin'=>'Cebu',            'destination'=>'Surigao',            'operator'=>'Cebu Pacific'],
            ['name'=>'Cebu to Puerto Princesa Air',          'origin'=>'Cebu',            'destination'=>'Puerto Princesa',    'operator'=>'Philippine Airlines'],
            ['name'=>'Cebu to Bacolod Flight',               'origin'=>'Cebu',            'destination'=>'Bacolod',            'operator'=>'Cebu Pacific'],
            ['name'=>'Cebu to Cotabato Air',                 'origin'=>'Cebu',            'destination'=>'Cotabato',           'operator'=>'Philippine Airlines'],
            ['name'=>'Cebu to Pagadian Flight',              'origin'=>'Cebu',            'destination'=>'Pagadian',           'operator'=>'Cebu Pacific'],
            ['name'=>'Cebu to Dipolog Air',                  'origin'=>'Cebu',            'destination'=>'Dipolog',            'operator'=>'Philippine Airlines'],
            ['name'=>'Cebu to Ozamiz Flight',                'origin'=>'Cebu',            'destination'=>'Ozamiz',             'operator'=>'Cebu Pacific'],
            ['name'=>'Cebu to Tagbilaran Air',               'origin'=>'Cebu',            'destination'=>'Tagbilaran',         'operator'=>'Philippine Airlines'],
            ['name'=>'Cebu to Roxas City Flight',            'origin'=>'Cebu',            'destination'=>'Roxas City',         'operator'=>'Cebu Pacific'],

            // ── DAVAO OUTBOUND ───────────────────────────────────────────────
            ['name'=>'Davao to Manila Direct',               'origin'=>'Davao',           'destination'=>'Manila',             'operator'=>'Philippine Airlines'],
            ['name'=>'Davao to Manila Budget',               'origin'=>'Davao',           'destination'=>'Manila',             'operator'=>'Cebu Pacific'],
            ['name'=>'Davao to Cebu Flight',                 'origin'=>'Davao',           'destination'=>'Cebu',               'operator'=>'Cebu Pacific'],
            ['name'=>'Davao to Cagayan de Oro Air',          'origin'=>'Davao',           'destination'=>'Cagayan de Oro',     'operator'=>'AirAsia'],
            ['name'=>'Davao to Iloilo Flight',               'origin'=>'Davao',           'destination'=>'Iloilo',             'operator'=>'Cebu Pacific'],
            ['name'=>'Davao to Zamboanga Air',               'origin'=>'Davao',           'destination'=>'Zamboanga',          'operator'=>'Philippine Airlines'],
            ['name'=>'Davao to General Santos Flight',       'origin'=>'Davao',           'destination'=>'General Santos',     'operator'=>'Cebu Pacific'],
            ['name'=>'Davao to Cotabato Air',                'origin'=>'Davao',           'destination'=>'Cotabato',           'operator'=>'Philippine Airlines'],
            ['name'=>'Davao to Butuan Flight',               'origin'=>'Davao',           'destination'=>'Butuan',             'operator'=>'Cebu Pacific'],
            ['name'=>'Davao to Surigao Air',                 'origin'=>'Davao',           'destination'=>'Surigao',            'operator'=>'Philippine Airlines'],

            // ── ILOILO OUTBOUND ──────────────────────────────────────────────
            ['name'=>'Iloilo to Manila Direct',              'origin'=>'Iloilo',          'destination'=>'Manila',             'operator'=>'Philippine Airlines'],
            ['name'=>'Iloilo to Manila Budget',              'origin'=>'Iloilo',          'destination'=>'Manila',             'operator'=>'Cebu Pacific'],
            ['name'=>'Iloilo to Cebu Flight',                'origin'=>'Iloilo',          'destination'=>'Cebu',               'operator'=>'Philippine Airlines'],
            ['name'=>'Iloilo to Davao Air',                  'origin'=>'Iloilo',          'destination'=>'Davao',              'operator'=>'Cebu Pacific'],

            // ── BACOLOD / GEN. SANTOS / CDO OUTBOUND ────────────────────────
            ['name'=>'Bacolod to Manila Direct',             'origin'=>'Bacolod',         'destination'=>'Manila',             'operator'=>'Philippine Airlines'],
            ['name'=>'Bacolod to Manila Budget',             'origin'=>'Bacolod',         'destination'=>'Manila',             'operator'=>'Cebu Pacific'],
            ['name'=>'Bacolod to Cebu Flight',               'origin'=>'Bacolod',         'destination'=>'Cebu',               'operator'=>'Cebu Pacific'],
            ['name'=>'General Santos to Manila Direct',      'origin'=>'General Santos',  'destination'=>'Manila',             'operator'=>'Philippine Airlines'],
            ['name'=>'General Santos to Cebu Flight',        'origin'=>'General Santos',  'destination'=>'Cebu',               'operator'=>'Cebu Pacific'],
            ['name'=>'Cagayan de Oro to Manila Direct',      'origin'=>'Cagayan de Oro',  'destination'=>'Manila',             'operator'=>'Philippine Airlines'],
            ['name'=>'Cagayan de Oro to Cebu Flight',        'origin'=>'Cagayan de Oro',  'destination'=>'Cebu',               'operator'=>'Cebu Pacific'],
            ['name'=>'Cagayan de Oro to Davao Air',          'origin'=>'Cagayan de Oro',  'destination'=>'Davao',              'operator'=>'AirAsia'],

            // ── SMALLER CITIES OUTBOUND ──────────────────────────────────────
            ['name'=>'Tacloban to Manila Direct',            'origin'=>'Tacloban',        'destination'=>'Manila',             'operator'=>'Cebu Pacific'],
            ['name'=>'Tacloban to Cebu Flight',              'origin'=>'Tacloban',        'destination'=>'Cebu',               'operator'=>'Philippine Airlines'],
            ['name'=>'Zamboanga to Manila Direct',           'origin'=>'Zamboanga',       'destination'=>'Manila',             'operator'=>'Philippine Airlines'],
            ['name'=>'Zamboanga to Cebu Flight',             'origin'=>'Zamboanga',       'destination'=>'Cebu',               'operator'=>'Cebu Pacific'],
            ['name'=>'Puerto Princesa to Manila Direct',     'origin'=>'Puerto Princesa', 'destination'=>'Manila',             'operator'=>'Philippine Airlines'],
            ['name'=>'Puerto Princesa to Cebu Flight',       'origin'=>'Puerto Princesa', 'destination'=>'Cebu',               'operator'=>'Cebu Pacific'],
            ['name'=>'Dumaguete to Manila Direct',           'origin'=>'Dumaguete',       'destination'=>'Manila',             'operator'=>'Philippine Airlines'],
            ['name'=>'Dumaguete to Cebu Flight',             'origin'=>'Dumaguete',       'destination'=>'Cebu',               'operator'=>'Cebu Pacific'],
            ['name'=>'Butuan to Manila Direct',              'origin'=>'Butuan',          'destination'=>'Manila',             'operator'=>'Philippine Airlines'],
            ['name'=>'Surigao to Manila Flight',             'origin'=>'Surigao',         'destination'=>'Manila',             'operator'=>'Cebu Pacific'],
            ['name'=>'Cotabato to Manila Flight',            'origin'=>'Cotabato',        'destination'=>'Manila',             'operator'=>'Philippine Airlines'],
            ['name'=>'Dipolog to Manila Flight',             'origin'=>'Dipolog',         'destination'=>'Manila',             'operator'=>'Cebu Pacific'],
            ['name'=>'Tagbilaran to Manila Direct',          'origin'=>'Tagbilaran',      'destination'=>'Manila',             'operator'=>'Philippine Airlines'],
            ['name'=>'Kalibo to Manila Flight',              'origin'=>'Kalibo',          'destination'=>'Manila',             'operator'=>'Cebu Pacific'],
            ['name'=>'Legazpi to Manila Air',                'origin'=>'Legazpi',         'destination'=>'Manila',             'operator'=>'Philippine Airlines'],
            ['name'=>'Roxas City to Manila Flight',          'origin'=>'Roxas City',      'destination'=>'Manila',             'operator'=>'Cebu Pacific'],
            ['name'=>'Naga to Manila Direct',                'origin'=>'Naga',            'destination'=>'Manila',             'operator'=>'Philippine Airlines'],
            ['name'=>'Pagadian to Manila Flight',            'origin'=>'Pagadian',        'destination'=>'Manila',             'operator'=>'Cebu Pacific'],
            ['name'=>'Ozamiz to Manila Air',                 'origin'=>'Ozamiz',          'destination'=>'Manila',             'operator'=>'Philippine Airlines'],
            ['name'=>'Virac to Manila Flight',               'origin'=>'Virac',           'destination'=>'Manila',             'operator'=>'Cebu Pacific'],
            ['name'=>'Catarman to Manila Air',               'origin'=>'Catarman',        'destination'=>'Manila',             'operator'=>'Philippine Airlines'],
            ['name'=>'Calbayog to Manila Flight',            'origin'=>'Calbayog',        'destination'=>'Manila',             'operator'=>'Cebu Pacific'],
            ['name'=>'Masbate to Manila Air',                'origin'=>'Masbate',         'destination'=>'Manila',             'operator'=>'Philippine Airlines'],

            // ── INTER-VISAYAS ─────────────────────────────────────────────────
            ['name'=>'Cebu to Bacolod Flight',               'origin'=>'Cebu',            'destination'=>'Bacolod',            'operator'=>'Philippine Airlines'],
            ['name'=>'Bacolod to Cebu Air',                  'origin'=>'Bacolod',         'destination'=>'Cebu',               'operator'=>'Cebu Pacific'],
            ['name'=>'Iloilo to Bacolod Air',                'origin'=>'Iloilo',          'destination'=>'Bacolod',            'operator'=>'Philippine Airlines'],
            ['name'=>'Bacolod to Iloilo Flight',             'origin'=>'Bacolod',         'destination'=>'Iloilo',             'operator'=>'Cebu Pacific'],
            ['name'=>'Cebu to Iloilo Budget',                'origin'=>'Cebu',            'destination'=>'Iloilo',             'operator'=>'AirAsia'],
            ['name'=>'Iloilo to Cebu Budget',                'origin'=>'Iloilo',          'destination'=>'Cebu',               'operator'=>'AirAsia'],
            ['name'=>'Tacloban to Cebu Air',                 'origin'=>'Tacloban',        'destination'=>'Cebu',               'operator'=>'Cebu Pacific'],
            ['name'=>'Dumaguete to Cebu Air',                'origin'=>'Dumaguete',       'destination'=>'Cebu',               'operator'=>'Philippine Airlines'],

            // ── MINDANAO INTER-CITY ───────────────────────────────────────────
            ['name'=>'Davao to Zamboanga Flight',            'origin'=>'Davao',           'destination'=>'Zamboanga',          'operator'=>'Philippine Airlines'],
            ['name'=>'Zamboanga to Davao Air',               'origin'=>'Zamboanga',       'destination'=>'Davao',              'operator'=>'Philippine Airlines'],
            ['name'=>'General Santos to Davao Flight',       'origin'=>'General Santos',  'destination'=>'Davao',              'operator'=>'Cebu Pacific'],
            ['name'=>'Davao to General Santos Air',          'origin'=>'Davao',           'destination'=>'General Santos',     'operator'=>'Cebu Pacific'],
            ['name'=>'Cotabato to Davao Flight',             'origin'=>'Cotabato',        'destination'=>'Davao',              'operator'=>'Philippine Airlines'],
            ['name'=>'Cagayan de Oro to General Santos Air', 'origin'=>'Cagayan de Oro',  'destination'=>'General Santos',     'operator'=>'Cebu Pacific'],
            ['name'=>'Zamboanga to Cagayan de Oro Flight',   'origin'=>'Zamboanga',       'destination'=>'Cagayan de Oro',     'operator'=>'Philippine Airlines'],
            ['name'=>'Butuan to Cagayan de Oro Air',         'origin'=>'Butuan',          'destination'=>'Cagayan de Oro',     'operator'=>'Cebu Pacific'],
            ['name'=>'Surigao to Davao Flight',              'origin'=>'Surigao',         'destination'=>'Davao',              'operator'=>'Philippine Airlines'],

            // ── PALAWAN & BORACAY ─────────────────────────────────────────────
            ['name'=>'Manila to Coron Flight',               'origin'=>'Manila',          'destination'=>'Coron',              'operator'=>'Philippine Airlines'],
            ['name'=>'Cebu to Puerto Princesa Direct',       'origin'=>'Cebu',            'destination'=>'Puerto Princesa',    'operator'=>'Cebu Pacific'],
            ['name'=>'Manila to El Nido Air',                'origin'=>'Manila',          'destination'=>'El Nido',            'operator'=>'Air Juan'],
            ['name'=>'Cebu to Coron Flight',                 'origin'=>'Cebu',            'destination'=>'Coron',              'operator'=>'Cebu Pacific'],
            ['name'=>'Manila to Busuanga Air',               'origin'=>'Manila',          'destination'=>'Busuanga',           'operator'=>'Philippine Airlines'],

            // ── NORTH LUZON ───────────────────────────────────────────────────
            ['name'=>'Manila to Laoag Flight',               'origin'=>'Manila',          'destination'=>'Laoag',              'operator'=>'Philippine Airlines'],
            ['name'=>'Manila to Tuguegarao Air',             'origin'=>'Manila',          'destination'=>'Tuguegarao',         'operator'=>'Cebu Pacific'],
            ['name'=>'Manila to Basco Flight',               'origin'=>'Manila',          'destination'=>'Basco',              'operator'=>'Philippine Airlines'],
            ['name'=>'Laoag to Manila Air',                  'origin'=>'Laoag',           'destination'=>'Manila',             'operator'=>'Philippine Airlines'],
            ['name'=>'Tuguegarao to Manila Flight',          'origin'=>'Tuguegarao',      'destination'=>'Manila',             'operator'=>'Cebu Pacific'],

            // ── SAMAR & EASTERN VISAYAS ───────────────────────────────────────
            ['name'=>'Manila to Tacloban Morning',           'origin'=>'Manila',          'destination'=>'Tacloban',           'operator'=>'Philippine Airlines'],
            ['name'=>'Tacloban to Cebu Morning Air',         'origin'=>'Tacloban',        'destination'=>'Cebu',               'operator'=>'Philippine Airlines'],
            ['name'=>'Manila to Calbayog Direct',            'origin'=>'Manila',          'destination'=>'Calbayog',           'operator'=>'Cebu Pacific'],
            ['name'=>'Manila to Catarman Morning',           'origin'=>'Manila',          'destination'=>'Catarman',           'operator'=>'Cebu Pacific'],

            // ── SULU ARCHIPELAGO ──────────────────────────────────────────────
            ['name'=>'Zamboanga to Jolo Flight',             'origin'=>'Zamboanga',       'destination'=>'Jolo',               'operator'=>'Philippine Airlines'],
            ['name'=>'Zamboanga to Tawi-Tawi Air',           'origin'=>'Zamboanga',       'destination'=>'Tawi-Tawi',          'operator'=>'Philippine Airlines'],
            ['name'=>'Jolo to Zamboanga Return',             'origin'=>'Jolo',            'destination'=>'Zamboanga',          'operator'=>'Philippine Airlines'],
            ['name'=>'Tawi-Tawi to Zamboanga Return',        'origin'=>'Tawi-Tawi',       'destination'=>'Zamboanga',          'operator'=>'Philippine Airlines'],

            // ── EXTRA ROUTES (to go over 200) ────────────────────────────────
            ['name'=>'Manila to Cebu Express Plus',          'origin'=>'Manila',          'destination'=>'Cebu',               'operator'=>'AirAsia'],
            ['name'=>'Davao to Iloilo Direct',               'origin'=>'Davao',           'destination'=>'Iloilo',             'operator'=>'Philippine Airlines'],
            ['name'=>'General Santos to Cebu Air',           'origin'=>'General Santos',  'destination'=>'Cebu',               'operator'=>'Philippine Airlines'],
            ['name'=>'Cagayan de Oro to Iloilo Flight',      'origin'=>'Cagayan de Oro',  'destination'=>'Iloilo',             'operator'=>'Cebu Pacific'],
            ['name'=>'Iloilo to Davao Direct',               'origin'=>'Iloilo',          'destination'=>'Davao',              'operator'=>'Philippine Airlines'],
            ['name'=>'Cebu to Zamboanga Budget',             'origin'=>'Cebu',            'destination'=>'Zamboanga',          'operator'=>'AirAsia'],
            ['name'=>'Manila to Ormoc Air',                  'origin'=>'Manila',          'destination'=>'Ormoc',              'operator'=>'Cebu Pacific'],
            ['name'=>'Ormoc to Manila Flight',               'origin'=>'Ormoc',           'destination'=>'Manila',             'operator'=>'Cebu Pacific'],
            ['name'=>'Cebu to Ormoc Air',                    'origin'=>'Cebu',            'destination'=>'Ormoc',              'operator'=>'Philippine Airlines'],
            ['name'=>'Manila to Tandag Flight',              'origin'=>'Manila',          'destination'=>'Tandag',             'operator'=>'Cebu Pacific'],
            ['name'=>'Tandag to Manila Return',              'origin'=>'Tandag',          'destination'=>'Manila',             'operator'=>'Cebu Pacific'],
            ['name'=>'Davao to Tacloban Flight',             'origin'=>'Davao',           'destination'=>'Tacloban',           'operator'=>'Philippine Airlines'],
            ['name'=>'Tacloban to Davao Air',                'origin'=>'Tacloban',        'destination'=>'Davao',              'operator'=>'Philippine Airlines'],
            ['name'=>'Manila to Bacolod Noon Flight',        'origin'=>'Manila',          'destination'=>'Bacolod',            'operator'=>'AirAsia'],
            ['name'=>'Bacolod to Manila Noon Air',           'origin'=>'Bacolod',         'destination'=>'Manila',             'operator'=>'AirAsia'],
            ['name'=>'Manila to Zamboanga Budget',           'origin'=>'Manila',          'destination'=>'Zamboanga',          'operator'=>'AirAsia'],
            ['name'=>'Zamboanga to Manila Budget',           'origin'=>'Zamboanga',       'destination'=>'Manila',             'operator'=>'AirAsia'],
            ['name'=>'Cebu to Cagayan de Oro Budget',        'origin'=>'Cebu',            'destination'=>'Cagayan de Oro',     'operator'=>'AirAsia'],
            ['name'=>'Cagayan de Oro to Cebu Budget',        'origin'=>'Cagayan de Oro',  'destination'=>'Cebu',               'operator'=>'AirAsia'],
            ['name'=>'Manila to Davao Budget',               'origin'=>'Manila',          'destination'=>'Davao',              'operator'=>'AirAsia'],
            ['name'=>'Davao to Manila Budget Air',           'origin'=>'Davao',           'destination'=>'Manila',             'operator'=>'AirAsia'],
            ['name'=>'Cebu to General Santos Budget',        'origin'=>'Cebu',            'destination'=>'General Santos',     'operator'=>'AirAsia'],
            ['name'=>'General Santos to Cebu Budget',        'origin'=>'General Santos',  'destination'=>'Cebu',               'operator'=>'AirAsia'],
            ['name'=>'Manila to Iloilo Noon',                'origin'=>'Manila',          'destination'=>'Iloilo',             'operator'=>'Cebu Pacific'],
            ['name'=>'Iloilo to Manila Noon',                'origin'=>'Iloilo',          'destination'=>'Manila',             'operator'=>'Cebu Pacific'],
            ['name'=>'Manila to Tagbilaran Morning',         'origin'=>'Manila',          'destination'=>'Tagbilaran',         'operator'=>'Philippine Airlines'],
            ['name'=>'Tagbilaran to Manila Return',          'origin'=>'Tagbilaran',      'destination'=>'Manila',             'operator'=>'Cebu Pacific'],
            ['name'=>'Manila to Dumaguete Morning',          'origin'=>'Manila',          'destination'=>'Dumaguete',          'operator'=>'Cebu Pacific'],
            ['name'=>'Dumaguete to Manila Morning',          'origin'=>'Dumaguete',       'destination'=>'Manila',             'operator'=>'Cebu Pacific'],
        ];

        foreach ($trips as $trip) {
            Trip::updateOrCreate(
                ['name' => $trip['name']],
                [
                    'origin'         => $trip['origin'],
                    'destination'    => $trip['destination'],
                    'type'           => 'air',
                    'operator'       => $trip['operator'],
                    'status'         => 'active',
                    'max_passengers' => 200,
                ]
            );
        }

        $this->command->info('✅ ' . count($trips) . ' trips seeded successfully.');
    }
}
