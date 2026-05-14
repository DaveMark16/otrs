<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Trip;

class SeedTrips extends Command
{
    protected $signature   = 'seed:trips {--fresh : Truncate trips and schedules first}';
    protected $description = 'Seed 200+ country-to-country air trips';

    public function handle()
    {
        if ($this->option('fresh')) {
            \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            \App\Models\Schedule::truncate();
            Trip::truncate();
            \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            $this->info('Tables cleared.');
        }

        $trips = [
            // ── Philippines → Japan ──────────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Japan','operator'=>'Philippine Airlines','max_passengers'=>300],
            ['origin_country'=>'Philippines','destination_country'=>'Japan','operator'=>'ANA','max_passengers'=>300],
            ['origin_country'=>'Philippines','destination_country'=>'Japan','operator'=>'Cebu Pacific','max_passengers'=>220],
            ['origin_country'=>'Philippines','destination_country'=>'Japan','operator'=>'Japan Airlines','max_passengers'=>220],
            ['origin_country'=>'Philippines','destination_country'=>'Japan','operator'=>'AirAsia Japan','max_passengers'=>180],

            // ── Philippines → South Korea ────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'South Korea','operator'=>'Korean Air','max_passengers'=>270],
            ['origin_country'=>'Philippines','destination_country'=>'South Korea','operator'=>'Asiana Airlines','max_passengers'=>250],
            ['origin_country'=>'Philippines','destination_country'=>'South Korea','operator'=>'Cebu Pacific','max_passengers'=>189],
            ['origin_country'=>'Philippines','destination_country'=>'South Korea','operator'=>'Jin Air','max_passengers'=>189],

            // ── Philippines → China ──────────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'China','operator'=>'Air China','max_passengers'=>300],
            ['origin_country'=>'Philippines','destination_country'=>'China','operator'=>'China Eastern','max_passengers'=>300],
            ['origin_country'=>'Philippines','destination_country'=>'China','operator'=>'China Southern','max_passengers'=>300],
            ['origin_country'=>'Philippines','destination_country'=>'China','operator'=>'Philippine Airlines','max_passengers'=>220],
            ['origin_country'=>'Philippines','destination_country'=>'China','operator'=>'Xiamen Air','max_passengers'=>180],

            // ── Philippines → Hong Kong ──────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Hong Kong','operator'=>'Cathay Pacific','max_passengers'=>220],
            ['origin_country'=>'Philippines','destination_country'=>'Hong Kong','operator'=>'Hong Kong Airlines','max_passengers'=>220],
            ['origin_country'=>'Philippines','destination_country'=>'Hong Kong','operator'=>'Cebu Pacific','max_passengers'=>180],

            // ── Philippines → Taiwan ─────────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Taiwan','operator'=>'China Airlines','max_passengers'=>250],
            ['origin_country'=>'Philippines','destination_country'=>'Taiwan','operator'=>'EVA Air','max_passengers'=>250],
            ['origin_country'=>'Philippines','destination_country'=>'Taiwan','operator'=>'Philippine Airlines','max_passengers'=>180],

            // ── Philippines → Singapore ──────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Singapore','operator'=>'Singapore Airlines','max_passengers'=>250],
            ['origin_country'=>'Philippines','destination_country'=>'Singapore','operator'=>'Scoot','max_passengers'=>400],
            ['origin_country'=>'Philippines','destination_country'=>'Singapore','operator'=>'Cebu Pacific','max_passengers'=>220],
            ['origin_country'=>'Philippines','destination_country'=>'Singapore','operator'=>'Philippine Airlines','max_passengers'=>220],

            // ── Philippines → Malaysia ───────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Malaysia','operator'=>'AirAsia','max_passengers'=>200],
            ['origin_country'=>'Philippines','destination_country'=>'Malaysia','operator'=>'Malaysia Airlines','max_passengers'=>220],
            ['origin_country'=>'Philippines','destination_country'=>'Malaysia','operator'=>'Cebu Pacific','max_passengers'=>180],

            // ── Philippines → Thailand ───────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Thailand','operator'=>'Thai Airways','max_passengers'=>250],
            ['origin_country'=>'Philippines','destination_country'=>'Thailand','operator'=>'Thai AirAsia','max_passengers'=>180],
            ['origin_country'=>'Philippines','destination_country'=>'Thailand','operator'=>'Cebu Pacific','max_passengers'=>180],

            // ── Philippines → Indonesia ──────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Indonesia','operator'=>'Garuda Indonesia','max_passengers'=>220],
            ['origin_country'=>'Philippines','destination_country'=>'Indonesia','operator'=>'Cebu Pacific','max_passengers'=>220],
            ['origin_country'=>'Philippines','destination_country'=>'Indonesia','operator'=>'Lion Air','max_passengers'=>180],

            // ── Philippines → Vietnam ────────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Vietnam','operator'=>'Vietnam Airlines','max_passengers'=>180],
            ['origin_country'=>'Philippines','destination_country'=>'Vietnam','operator'=>'VietJet Air','max_passengers'=>180],
            ['origin_country'=>'Philippines','destination_country'=>'Vietnam','operator'=>'Philippine Airlines','max_passengers'=>180],

            // ── Philippines → Cambodia ───────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Cambodia','operator'=>'Philippine Airlines','max_passengers'=>150],
            ['origin_country'=>'Philippines','destination_country'=>'Cambodia','operator'=>'Cambodia Airways','max_passengers'=>150],

            // ── Philippines → Myanmar ────────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Myanmar','operator'=>'Myanmar Airways','max_passengers'=>150],

            // ── Philippines → UAE ────────────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'United Arab Emirates','operator'=>'Emirates','max_passengers'=>350],
            ['origin_country'=>'Philippines','destination_country'=>'United Arab Emirates','operator'=>'Etihad Airways','max_passengers'=>300],
            ['origin_country'=>'Philippines','destination_country'=>'United Arab Emirates','operator'=>'flydubai','max_passengers'=>180],
            ['origin_country'=>'Philippines','destination_country'=>'United Arab Emirates','operator'=>'Philippine Airlines','max_passengers'=>280],

            // ── Philippines → Saudi Arabia ───────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Saudi Arabia','operator'=>'Saudia','max_passengers'=>300],
            ['origin_country'=>'Philippines','destination_country'=>'Saudi Arabia','operator'=>'Philippine Airlines','max_passengers'=>300],
            ['origin_country'=>'Philippines','destination_country'=>'Saudi Arabia','operator'=>'Flyadeal','max_passengers'=>180],

            // ── Philippines → Qatar ──────────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Qatar','operator'=>'Qatar Airways','max_passengers'=>320],
            ['origin_country'=>'Philippines','destination_country'=>'Qatar','operator'=>'Philippine Airlines','max_passengers'=>250],

            // ── Philippines → Kuwait ─────────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Kuwait','operator'=>'Kuwait Airways','max_passengers'=>250],
            ['origin_country'=>'Philippines','destination_country'=>'Kuwait','operator'=>'Jazeera Airways','max_passengers'=>180],

            // ── Philippines → Oman ───────────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Oman','operator'=>'Oman Air','max_passengers'=>220],

            // ── Philippines → Bahrain ────────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Bahrain','operator'=>'Gulf Air','max_passengers'=>220],

            // ── Philippines → India ──────────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'India','operator'=>'Air India','max_passengers'=>250],
            ['origin_country'=>'Philippines','destination_country'=>'India','operator'=>'IndiGo','max_passengers'=>220],
            ['origin_country'=>'Philippines','destination_country'=>'India','operator'=>'Philippine Airlines','max_passengers'=>180],

            // ── Philippines → Sri Lanka ──────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Sri Lanka','operator'=>'SriLankan Airlines','max_passengers'=>180],

            // ── Philippines → Bangladesh ─────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Bangladesh','operator'=>'Biman Bangladesh','max_passengers'=>180],

            // ── Philippines → Nepal ──────────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Nepal','operator'=>'Nepal Airlines','max_passengers'=>150],

            // ── Philippines → United Kingdom ─────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'United Kingdom','operator'=>'British Airways','max_passengers'=>380],
            ['origin_country'=>'Philippines','destination_country'=>'United Kingdom','operator'=>'Philippine Airlines','max_passengers'=>350],

            // ── Philippines → Germany ────────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Germany','operator'=>'Lufthansa','max_passengers'=>360],

            // ── Philippines → Netherlands ────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Netherlands','operator'=>'KLM','max_passengers'=>350],

            // ── Philippines → France ─────────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'France','operator'=>'Air France','max_passengers'=>370],

            // ── Philippines → Italy ──────────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Italy','operator'=>'ITA Airways','max_passengers'=>280],

            // ── Philippines → Spain ──────────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Spain','operator'=>'Iberia','max_passengers'=>280],

            // ── Philippines → Switzerland ────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Switzerland','operator'=>'Swiss International Air Lines','max_passengers'=>250],

            // ── Philippines → Finland ────────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Finland','operator'=>'Finnair','max_passengers'=>280],

            // ── Philippines → Turkey ─────────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Turkey','operator'=>'Turkish Airlines','max_passengers'=>350],

            // ── Philippines → Russia ─────────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Russia','operator'=>'Aeroflot','max_passengers'=>300],

            // ── Philippines → United States ──────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'United States','operator'=>'Philippine Airlines','max_passengers'=>400],
            ['origin_country'=>'Philippines','destination_country'=>'United States','operator'=>'United Airlines','max_passengers'=>380],
            ['origin_country'=>'Philippines','destination_country'=>'United States','operator'=>'Delta Air Lines','max_passengers'=>350],
            ['origin_country'=>'Philippines','destination_country'=>'United States','operator'=>'American Airlines','max_passengers'=>350],

            // ── Philippines → Canada ─────────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Canada','operator'=>'Air Canada','max_passengers'=>350],
            ['origin_country'=>'Philippines','destination_country'=>'Canada','operator'=>'Philippine Airlines','max_passengers'=>300],

            // ── Philippines → Australia ──────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Australia','operator'=>'Qantas','max_passengers'=>300],
            ['origin_country'=>'Philippines','destination_country'=>'Australia','operator'=>'Philippine Airlines','max_passengers'=>280],
            ['origin_country'=>'Philippines','destination_country'=>'Australia','operator'=>'Cebu Pacific','max_passengers'=>250],

            // ── Philippines → New Zealand ────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'New Zealand','operator'=>'Air New Zealand','max_passengers'=>250],

            // ── Philippines → South Africa ───────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'South Africa','operator'=>'Qatar Airways','max_passengers'=>350],

            // ── Philippines → Kenya ──────────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Kenya','operator'=>'Emirates','max_passengers'=>300],

            // ── Philippines → Nigeria ────────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Nigeria','operator'=>'Ethiopian Airlines','max_passengers'=>250],

            // ── Philippines → Egypt ──────────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Egypt','operator'=>'EgyptAir','max_passengers'=>220],

            // ── Philippines → Israel ─────────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Israel','operator'=>'El Al','max_passengers'=>220],

            // ── Philippines → Jordan ─────────────────────────────────
            ['origin_country'=>'Philippines','destination_country'=>'Jordan','operator'=>'Royal Jordanian','max_passengers'=>180],

            // ── Singapore → (Outbound) ───────────────────────────────
            ['origin_country'=>'Singapore','destination_country'=>'Japan','operator'=>'Singapore Airlines','max_passengers'=>300],
            ['origin_country'=>'Singapore','destination_country'=>'South Korea','operator'=>'Singapore Airlines','max_passengers'=>280],
            ['origin_country'=>'Singapore','destination_country'=>'Thailand','operator'=>'Thai Airways','max_passengers'=>250],
            ['origin_country'=>'Singapore','destination_country'=>'Malaysia','operator'=>'AirAsia','max_passengers'=>180],
            ['origin_country'=>'Singapore','destination_country'=>'Hong Kong','operator'=>'Cathay Pacific','max_passengers'=>250],
            ['origin_country'=>'Singapore','destination_country'=>'Australia','operator'=>'Qantas','max_passengers'=>300],
            ['origin_country'=>'Singapore','destination_country'=>'United Kingdom','operator'=>'Singapore Airlines','max_passengers'=>380],
            ['origin_country'=>'Singapore','destination_country'=>'United States','operator'=>'Singapore Airlines','max_passengers'=>350],
            ['origin_country'=>'Singapore','destination_country'=>'India','operator'=>'IndiGo','max_passengers'=>220],
            ['origin_country'=>'Singapore','destination_country'=>'Indonesia','operator'=>'Garuda Indonesia','max_passengers'=>220],

            // ── Japan → (Outbound) ───────────────────────────────────
            ['origin_country'=>'Japan','destination_country'=>'South Korea','operator'=>'ANA','max_passengers'=>250],
            ['origin_country'=>'Japan','destination_country'=>'China','operator'=>'Air China','max_passengers'=>280],
            ['origin_country'=>'Japan','destination_country'=>'Hong Kong','operator'=>'Cathay Pacific','max_passengers'=>250],
            ['origin_country'=>'Japan','destination_country'=>'Thailand','operator'=>'Thai Airways','max_passengers'=>250],
            ['origin_country'=>'Japan','destination_country'=>'United States','operator'=>'Japan Airlines','max_passengers'=>380],
            ['origin_country'=>'Japan','destination_country'=>'United Kingdom','operator'=>'British Airways','max_passengers'=>380],
            ['origin_country'=>'Japan','destination_country'=>'Australia','operator'=>'Qantas','max_passengers'=>300],
            ['origin_country'=>'Japan','destination_country'=>'Singapore','operator'=>'Singapore Airlines','max_passengers'=>280],
            ['origin_country'=>'Japan','destination_country'=>'France','operator'=>'Air France','max_passengers'=>350],
            ['origin_country'=>'Japan','destination_country'=>'Germany','operator'=>'Lufthansa','max_passengers'=>330],

            // ── South Korea → (Outbound) ─────────────────────────────
            ['origin_country'=>'South Korea','destination_country'=>'China','operator'=>'Korean Air','max_passengers'=>280],
            ['origin_country'=>'South Korea','destination_country'=>'Japan','operator'=>'Asiana Airlines','max_passengers'=>250],
            ['origin_country'=>'South Korea','destination_country'=>'Thailand','operator'=>'Korean Air','max_passengers'=>220],
            ['origin_country'=>'South Korea','destination_country'=>'United States','operator'=>'Korean Air','max_passengers'=>380],
            ['origin_country'=>'South Korea','destination_country'=>'United Kingdom','operator'=>'Asiana Airlines','max_passengers'=>300],
            ['origin_country'=>'South Korea','destination_country'=>'Singapore','operator'=>'Singapore Airlines','max_passengers'=>250],
            ['origin_country'=>'South Korea','destination_country'=>'Australia','operator'=>'Qantas','max_passengers'=>280],

            // ── United Arab Emirates → (Outbound) ────────────────────
            ['origin_country'=>'United Arab Emirates','destination_country'=>'United Kingdom','operator'=>'Emirates','max_passengers'=>500],
            ['origin_country'=>'United Arab Emirates','destination_country'=>'United States','operator'=>'Emirates','max_passengers'=>500],
            ['origin_country'=>'United Arab Emirates','destination_country'=>'Australia','operator'=>'Emirates','max_passengers'=>450],
            ['origin_country'=>'United Arab Emirates','destination_country'=>'Singapore','operator'=>'Emirates','max_passengers'=>380],
            ['origin_country'=>'United Arab Emirates','destination_country'=>'Thailand','operator'=>'flydubai','max_passengers'=>180],
            ['origin_country'=>'United Arab Emirates','destination_country'=>'India','operator'=>'Air India','max_passengers'=>300],
            ['origin_country'=>'United Arab Emirates','destination_country'=>'France','operator'=>'Emirates','max_passengers'=>400],
            ['origin_country'=>'United Arab Emirates','destination_country'=>'Germany','operator'=>'Lufthansa','max_passengers'=>350],

            // ── Qatar → (Outbound) ───────────────────────────────────
            ['origin_country'=>'Qatar','destination_country'=>'United Kingdom','operator'=>'Qatar Airways','max_passengers'=>450],
            ['origin_country'=>'Qatar','destination_country'=>'United States','operator'=>'Qatar Airways','max_passengers'=>450],
            ['origin_country'=>'Qatar','destination_country'=>'Australia','operator'=>'Qatar Airways','max_passengers'=>380],
            ['origin_country'=>'Qatar','destination_country'=>'Japan','operator'=>'Qatar Airways','max_passengers'=>350],
            ['origin_country'=>'Qatar','destination_country'=>'Singapore','operator'=>'Qatar Airways','max_passengers'=>320],

            // ── Thailand → (Outbound) ────────────────────────────────
            ['origin_country'=>'Thailand','destination_country'=>'South Korea','operator'=>'Thai AirAsia','max_passengers'=>180],
            ['origin_country'=>'Thailand','destination_country'=>'Japan','operator'=>'Thai Airways','max_passengers'=>300],
            ['origin_country'=>'Thailand','destination_country'=>'United Kingdom','operator'=>'Thai Airways','max_passengers'=>380],
            ['origin_country'=>'Thailand','destination_country'=>'China','operator'=>'China Southern','max_passengers'=>280],
            ['origin_country'=>'Thailand','destination_country'=>'Australia','operator'=>'Qantas','max_passengers'=>280],
            ['origin_country'=>'Thailand','destination_country'=>'Singapore','operator'=>'Singapore Airlines','max_passengers'=>220],

            // ── Malaysia → (Outbound) ────────────────────────────────
            ['origin_country'=>'Malaysia','destination_country'=>'United Kingdom','operator'=>'Malaysia Airlines','max_passengers'=>380],
            ['origin_country'=>'Malaysia','destination_country'=>'Japan','operator'=>'AirAsia X','max_passengers'=>350],
            ['origin_country'=>'Malaysia','destination_country'=>'Australia','operator'=>'Malaysia Airlines','max_passengers'=>300],
            ['origin_country'=>'Malaysia','destination_country'=>'China','operator'=>'AirAsia','max_passengers'=>250],

            // ── United States → (Outbound) ───────────────────────────
            ['origin_country'=>'United States','destination_country'=>'Japan','operator'=>'United Airlines','max_passengers'=>380],
            ['origin_country'=>'United States','destination_country'=>'South Korea','operator'=>'Korean Air','max_passengers'=>380],
            ['origin_country'=>'United States','destination_country'=>'Australia','operator'=>'Qantas','max_passengers'=>380],
            ['origin_country'=>'United States','destination_country'=>'United Kingdom','operator'=>'British Airways','max_passengers'=>380],
            ['origin_country'=>'United States','destination_country'=>'France','operator'=>'Air France','max_passengers'=>380],
            ['origin_country'=>'United States','destination_country'=>'Germany','operator'=>'Lufthansa','max_passengers'=>380],
            ['origin_country'=>'United States','destination_country'=>'United Arab Emirates','operator'=>'Emirates','max_passengers'=>500],
            ['origin_country'=>'United States','destination_country'=>'Singapore','operator'=>'Singapore Airlines','max_passengers'=>350],
            ['origin_country'=>'United States','destination_country'=>'China','operator'=>'Air China','max_passengers'=>380],

            // ── Canada → (Outbound) ──────────────────────────────────
            ['origin_country'=>'Canada','destination_country'=>'Japan','operator'=>'Air Canada','max_passengers'=>300],
            ['origin_country'=>'Canada','destination_country'=>'United Kingdom','operator'=>'Air Canada','max_passengers'=>380],
            ['origin_country'=>'Canada','destination_country'=>'China','operator'=>'Air China','max_passengers'=>300],
            ['origin_country'=>'Canada','destination_country'=>'Australia','operator'=>'Air Canada','max_passengers'=>280],

            // ── United Kingdom → (Outbound) ──────────────────────────
            ['origin_country'=>'United Kingdom','destination_country'=>'France','operator'=>'British Airways','max_passengers'=>180],
            ['origin_country'=>'United Kingdom','destination_country'=>'Netherlands','operator'=>'KLM','max_passengers'=>180],
            ['origin_country'=>'United Kingdom','destination_country'=>'Germany','operator'=>'Lufthansa','max_passengers'=>180],
            ['origin_country'=>'United Kingdom','destination_country'=>'United Arab Emirates','operator'=>'Emirates','max_passengers'=>380],
            ['origin_country'=>'United Kingdom','destination_country'=>'Australia','operator'=>'Qantas','max_passengers'=>380],
            ['origin_country'=>'United Kingdom','destination_country'=>'Japan','operator'=>'British Airways','max_passengers'=>350],
            ['origin_country'=>'United Kingdom','destination_country'=>'Singapore','operator'=>'Singapore Airlines','max_passengers'=>350],
            ['origin_country'=>'United Kingdom','destination_country'=>'India','operator'=>'British Airways','max_passengers'=>300],
            ['origin_country'=>'United Kingdom','destination_country'=>'South Africa','operator'=>'South African Airways','max_passengers'=>280],

            // ── France → (Outbound) ──────────────────────────────────
            ['origin_country'=>'France','destination_country'=>'United Arab Emirates','operator'=>'Emirates','max_passengers'=>380],
            ['origin_country'=>'France','destination_country'=>'Japan','operator'=>'Air France','max_passengers'=>350],
            ['origin_country'=>'France','destination_country'=>'United States','operator'=>'Air France','max_passengers'=>380],
            ['origin_country'=>'France','destination_country'=>'Singapore','operator'=>'Air France','max_passengers'=>320],

            // ── Germany → (Outbound) ─────────────────────────────────
            ['origin_country'=>'Germany','destination_country'=>'Singapore','operator'=>'Singapore Airlines','max_passengers'=>380],
            ['origin_country'=>'Germany','destination_country'=>'Japan','operator'=>'Lufthansa','max_passengers'=>350],
            ['origin_country'=>'Germany','destination_country'=>'United States','operator'=>'Lufthansa','max_passengers'=>380],

            // ── Turkey → (Outbound) ──────────────────────────────────
            ['origin_country'=>'Turkey','destination_country'=>'United Kingdom','operator'=>'Turkish Airlines','max_passengers'=>350],
            ['origin_country'=>'Turkey','destination_country'=>'United States','operator'=>'Turkish Airlines','max_passengers'=>380],
            ['origin_country'=>'Turkey','destination_country'=>'Japan','operator'=>'Turkish Airlines','max_passengers'=>320],
            ['origin_country'=>'Turkey','destination_country'=>'Singapore','operator'=>'Turkish Airlines','max_passengers'=>300],

            // ── Australia → (Outbound) ───────────────────────────────
            ['origin_country'=>'Australia','destination_country'=>'New Zealand','operator'=>'Air New Zealand','max_passengers'=>220],
            ['origin_country'=>'Australia','destination_country'=>'Japan','operator'=>'Qantas','max_passengers'=>280],
            ['origin_country'=>'Australia','destination_country'=>'United Kingdom','operator'=>'Qantas','max_passengers'=>380],
            ['origin_country'=>'Australia','destination_country'=>'United States','operator'=>'Qantas','max_passengers'=>350],
            ['origin_country'=>'Australia','destination_country'=>'Singapore','operator'=>'Singapore Airlines','max_passengers'=>300],
            ['origin_country'=>'Australia','destination_country'=>'United Arab Emirates','operator'=>'Emirates','max_passengers'=>380],

            // ── New Zealand → (Outbound) ─────────────────────────────
            ['origin_country'=>'New Zealand','destination_country'=>'Australia','operator'=>'Air New Zealand','max_passengers'=>220],
            ['origin_country'=>'New Zealand','destination_country'=>'United Kingdom','operator'=>'Air New Zealand','max_passengers'=>300],
            ['origin_country'=>'New Zealand','destination_country'=>'United States','operator'=>'Air New Zealand','max_passengers'=>280],

            // ── India → (Outbound) ───────────────────────────────────
            ['origin_country'=>'India','destination_country'=>'United Arab Emirates','operator'=>'IndiGo','max_passengers'=>220],
            ['origin_country'=>'India','destination_country'=>'United Kingdom','operator'=>'British Airways','max_passengers'=>300],
            ['origin_country'=>'India','destination_country'=>'Singapore','operator'=>'Singapore Airlines','max_passengers'=>250],
            ['origin_country'=>'India','destination_country'=>'United States','operator'=>'Air India','max_passengers'=>300],
            ['origin_country'=>'India','destination_country'=>'Australia','operator'=>'Qantas','max_passengers'=>250],

            // ── China → (Outbound) ───────────────────────────────────
            ['origin_country'=>'China','destination_country'=>'United States','operator'=>'Air China','max_passengers'=>380],
            ['origin_country'=>'China','destination_country'=>'United Kingdom','operator'=>'China Eastern','max_passengers'=>350],
            ['origin_country'=>'China','destination_country'=>'Australia','operator'=>'China Southern','max_passengers'=>300],
            ['origin_country'=>'China','destination_country'=>'Japan','operator'=>'All Nippon Airways','max_passengers'=>280],
            ['origin_country'=>'China','destination_country'=>'Germany','operator'=>'Lufthansa','max_passengers'=>350],

            // ── Hong Kong → (Outbound) ───────────────────────────────
            ['origin_country'=>'Hong Kong','destination_country'=>'United Kingdom','operator'=>'Cathay Pacific','max_passengers'=>380],
            ['origin_country'=>'Hong Kong','destination_country'=>'Australia','operator'=>'Qantas','max_passengers'=>300],
            ['origin_country'=>'Hong Kong','destination_country'=>'United States','operator'=>'Cathay Pacific','max_passengers'=>380],
            ['origin_country'=>'Hong Kong','destination_country'=>'Japan','operator'=>'Cathay Pacific','max_passengers'=>280],
        ];

        // Deduplicate by origin+destination+operator
        $existing = Trip::pluck('operator', \DB::raw('CONCAT(origin_country, destination_country, operator)'))->keys()->toArray();

        $bar = $this->output->createProgressBar(count($trips));
        $bar->start();
        $inserted = 0;

        foreach ($trips as $trip) {
            $key = $trip['origin_country'] . $trip['destination_country'] . $trip['operator'];
            if (!in_array($key, $existing)) {
                Trip::create(array_merge($trip, [
                    'type'        => 'air',
                    'status'      => 'active',
                    'name'        => $trip['origin_country'] . ' → ' . $trip['destination_country'],
                    'origin'      => $trip['origin_country'],
                    'destination' => $trip['destination_country'],
                ]));
                $inserted++;
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("✅ {$inserted} new air trips inserted (skipped duplicates). Total in DB: " . Trip::count());
    }
}