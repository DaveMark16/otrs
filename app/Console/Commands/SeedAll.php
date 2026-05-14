<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Trip;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;

class SeedAll extends Command
{
    protected $signature = 'seed:all';
    protected $description = 'Seed all trips and schedules in one command';

    public function handle()
    {
        // ── CLEAR ────────────────────────────────────────────────
        $this->info('Clearing old data...');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schedule::truncate();
        Trip::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ── TRIPS ────────────────────────────────────────────────
        $this->info('Seeding trips...');

        $trips = [
            // ─── DOMESTIC — Manila Hub ───────────────────────────
            ['name'=>'Manila to Cebu','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Cebu','destination_country'=>'Philippines','operator'=>'Philippine Airlines','max_passengers'=>180],
            ['name'=>'Manila to Davao','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Davao','destination_country'=>'Philippines','operator'=>'Cebu Pacific','max_passengers'=>200],
            ['name'=>'Manila to Iloilo','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Iloilo','destination_country'=>'Philippines','operator'=>'AirAsia Philippines','max_passengers'=>180],
            ['name'=>'Manila to Bacolod','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Bacolod','destination_country'=>'Philippines','operator'=>'Cebu Pacific','max_passengers'=>180],
            ['name'=>'Manila to Zamboanga','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Zamboanga','destination_country'=>'Philippines','operator'=>'Philippine Airlines','max_passengers'=>150],
            ['name'=>'Manila to Cagayan de Oro','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Cagayan de Oro','destination_country'=>'Philippines','operator'=>'Cebu Pacific','max_passengers'=>180],
            ['name'=>'Manila to General Santos','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'General Santos','destination_country'=>'Philippines','operator'=>'Philippine Airlines','max_passengers'=>160],
            ['name'=>'Manila to Tacloban','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Tacloban','destination_country'=>'Philippines','operator'=>'Philippine Airlines','max_passengers'=>150],
            ['name'=>'Manila to Kalibo','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Kalibo','destination_country'=>'Philippines','operator'=>'AirAsia Philippines','max_passengers'=>180],
            ['name'=>'Manila to Puerto Princesa','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Puerto Princesa','destination_country'=>'Philippines','operator'=>'Cebu Pacific','max_passengers'=>180],
            ['name'=>'Manila to Dumaguete','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Dumaguete','destination_country'=>'Philippines','operator'=>'Philippine Airlines','max_passengers'=>150],
            ['name'=>'Manila to Legazpi','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Legazpi','destination_country'=>'Philippines','operator'=>'Cebu Pacific','max_passengers'=>72],
            ['name'=>'Manila to Butuan','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Butuan','destination_country'=>'Philippines','operator'=>'Cebu Pacific','max_passengers'=>180],
            ['name'=>'Manila to Cotabato','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Cotabato','destination_country'=>'Philippines','operator'=>'Philippine Airlines','max_passengers'=>72],
            ['name'=>'Manila to Ozamiz','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Ozamiz','destination_country'=>'Philippines','operator'=>'Cebu Pacific','max_passengers'=>72],
            ['name'=>'Manila to Dipolog','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Dipolog','destination_country'=>'Philippines','operator'=>'Philippine Airlines','max_passengers'=>72],
            ['name'=>'Manila to Pagadian','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Pagadian','destination_country'=>'Philippines','operator'=>'Philippine Airlines','max_passengers'=>72],
            ['name'=>'Manila to Surigao','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Surigao','destination_country'=>'Philippines','operator'=>'Philippine Airlines','max_passengers'=>72],
            ['name'=>'Manila to Laoag','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Laoag','destination_country'=>'Philippines','operator'=>'Philippine Airlines','max_passengers'=>72],
            ['name'=>'Manila to Tuguegarao','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Tuguegarao','destination_country'=>'Philippines','operator'=>'Cebu Pacific','max_passengers'=>72],

            // ─── DOMESTIC — Cebu Hub ─────────────────────────────
            ['name'=>'Cebu to Davao','origin'=>'Cebu','origin_country'=>'Philippines','destination'=>'Davao','destination_country'=>'Philippines','operator'=>'Cebu Pacific','max_passengers'=>180],
            ['name'=>'Cebu to Iloilo','origin'=>'Cebu','origin_country'=>'Philippines','destination'=>'Iloilo','destination_country'=>'Philippines','operator'=>'Philippine Airlines','max_passengers'=>72],
            ['name'=>'Cebu to Zamboanga','origin'=>'Cebu','origin_country'=>'Philippines','destination'=>'Zamboanga','destination_country'=>'Philippines','operator'=>'Cebu Pacific','max_passengers'=>72],
            ['name'=>'Cebu to Cagayan de Oro','origin'=>'Cebu','origin_country'=>'Philippines','destination'=>'Cagayan de Oro','destination_country'=>'Philippines','operator'=>'Cebu Pacific','max_passengers'=>180],
            ['name'=>'Cebu to General Santos','origin'=>'Cebu','origin_country'=>'Philippines','destination'=>'General Santos','destination_country'=>'Philippines','operator'=>'Philippine Airlines','max_passengers'=>72],
            ['name'=>'Cebu to Tacloban','origin'=>'Cebu','origin_country'=>'Philippines','destination'=>'Tacloban','destination_country'=>'Philippines','operator'=>'Cebu Pacific','max_passengers'=>72],
            ['name'=>'Cebu to Kalibo','origin'=>'Cebu','origin_country'=>'Philippines','destination'=>'Kalibo','destination_country'=>'Philippines','operator'=>'AirAsia Philippines','max_passengers'=>180],
            ['name'=>'Cebu to Puerto Princesa','origin'=>'Cebu','origin_country'=>'Philippines','destination'=>'Puerto Princesa','destination_country'=>'Philippines','operator'=>'Cebu Pacific','max_passengers'=>180],
            ['name'=>'Cebu to Butuan','origin'=>'Cebu','origin_country'=>'Philippines','destination'=>'Butuan','destination_country'=>'Philippines','operator'=>'Cebu Pacific','max_passengers'=>72],
            ['name'=>'Cebu to Bacolod','origin'=>'Cebu','origin_country'=>'Philippines','destination'=>'Bacolod','destination_country'=>'Philippines','operator'=>'Philippine Airlines','max_passengers'=>72],

            // ─── PHILIPPINES → JAPAN ─────────────────────────────
            ['name'=>'Manila to Tokyo Narita','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Tokyo','destination_country'=>'Japan','operator'=>'Philippine Airlines','max_passengers'=>300],
            ['name'=>'Manila to Tokyo Haneda','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Tokyo','destination_country'=>'Japan','operator'=>'ANA','max_passengers'=>300],
            ['name'=>'Manila to Osaka','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Osaka','destination_country'=>'Japan','operator'=>'Cebu Pacific','max_passengers'=>220],
            ['name'=>'Manila to Nagoya','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Nagoya','destination_country'=>'Japan','operator'=>'Philippine Airlines','max_passengers'=>220],
            ['name'=>'Manila to Fukuoka','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Fukuoka','destination_country'=>'Japan','operator'=>'Cebu Pacific','max_passengers'=>180],
            ['name'=>'Manila to Sapporo','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Sapporo','destination_country'=>'Japan','operator'=>'Philippine Airlines','max_passengers'=>220],
            ['name'=>'Cebu to Tokyo','origin'=>'Cebu','origin_country'=>'Philippines','destination'=>'Tokyo','destination_country'=>'Japan','operator'=>'Cebu Pacific','max_passengers'=>220],
            ['name'=>'Cebu to Osaka','origin'=>'Cebu','origin_country'=>'Philippines','destination'=>'Osaka','destination_country'=>'Japan','operator'=>'Philippine Airlines','max_passengers'=>220],
            ['name'=>'Cebu to Nagoya','origin'=>'Cebu','origin_country'=>'Philippines','destination'=>'Nagoya','destination_country'=>'Japan','operator'=>'Cebu Pacific','max_passengers'=>180],
            ['name'=>'Davao to Tokyo','origin'=>'Davao','origin_country'=>'Philippines','destination'=>'Tokyo','destination_country'=>'Japan','operator'=>'Philippine Airlines','max_passengers'=>220],

            // ─── PHILIPPINES → SOUTH KOREA ───────────────────────
            ['name'=>'Manila to Seoul Incheon','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Seoul','destination_country'=>'South Korea','operator'=>'Korean Air','max_passengers'=>270],
            ['name'=>'Manila to Seoul Gimpo','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Seoul','destination_country'=>'South Korea','operator'=>'Asiana Airlines','max_passengers'=>250],
            ['name'=>'Manila to Busan','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Busan','destination_country'=>'South Korea','operator'=>'Cebu Pacific','max_passengers'=>180],
            ['name'=>'Cebu to Seoul','origin'=>'Cebu','origin_country'=>'Philippines','destination'=>'Seoul','destination_country'=>'South Korea','operator'=>'Jin Air','max_passengers'=>189],
            ['name'=>'Davao to Seoul','origin'=>'Davao','origin_country'=>'Philippines','destination'=>'Seoul','destination_country'=>'South Korea','operator'=>'Korean Air','max_passengers'=>220],

            // ─── PHILIPPINES → CHINA ─────────────────────────────
            ['name'=>'Manila to Beijing','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Beijing','destination_country'=>'China','operator'=>'Air China','max_passengers'=>300],
            ['name'=>'Manila to Shanghai','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Shanghai','destination_country'=>'China','operator'=>'China Eastern','max_passengers'=>300],
            ['name'=>'Manila to Guangzhou','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Guangzhou','destination_country'=>'China','operator'=>'China Southern','max_passengers'=>300],
            ['name'=>'Manila to Shenzhen','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Shenzhen','destination_country'=>'China','operator'=>'Philippine Airlines','max_passengers'=>220],
            ['name'=>'Manila to Xiamen','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Xiamen','destination_country'=>'China','operator'=>'Xiamen Air','max_passengers'=>180],
            ['name'=>'Manila to Chengdu','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Chengdu','destination_country'=>'China','operator'=>'Air China','max_passengers'=>220],
            ['name'=>'Cebu to Shanghai','origin'=>'Cebu','origin_country'=>'Philippines','destination'=>'Shanghai','destination_country'=>'China','operator'=>'China Eastern','max_passengers'=>220],
            ['name'=>'Cebu to Guangzhou','origin'=>'Cebu','origin_country'=>'Philippines','destination'=>'Guangzhou','destination_country'=>'China','operator'=>'China Southern','max_passengers'=>220],

            // ─── PHILIPPINES → HONG KONG / TAIWAN ───────────────
            ['name'=>'Manila to Hong Kong','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Hong Kong','destination_country'=>'Hong Kong','operator'=>'Cathay Pacific','max_passengers'=>220],
            ['name'=>'Manila to Hong Kong (HX)','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Hong Kong','destination_country'=>'Hong Kong','operator'=>'Hong Kong Airlines','max_passengers'=>220],
            ['name'=>'Cebu to Hong Kong','origin'=>'Cebu','origin_country'=>'Philippines','destination'=>'Hong Kong','destination_country'=>'Hong Kong','operator'=>'Cathay Pacific','max_passengers'=>180],
            ['name'=>'Manila to Taipei','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Taipei','destination_country'=>'Taiwan','operator'=>'China Airlines','max_passengers'=>250],
            ['name'=>'Manila to Taipei (Eva)','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Taipei','destination_country'=>'Taiwan','operator'=>'EVA Air','max_passengers'=>250],
            ['name'=>'Cebu to Taipei','origin'=>'Cebu','origin_country'=>'Philippines','destination'=>'Taipei','destination_country'=>'Taiwan','operator'=>'China Airlines','max_passengers'=>180],
            ['name'=>'Davao to Taipei','origin'=>'Davao','origin_country'=>'Philippines','destination'=>'Taipei','destination_country'=>'Taiwan','operator'=>'EVA Air','max_passengers'=>180],

            // ─── PHILIPPINES → SOUTHEAST ASIA ────────────────────
            ['name'=>'Manila to Singapore','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Singapore','destination_country'=>'Singapore','operator'=>'Singapore Airlines','max_passengers'=>250],
            ['name'=>'Manila to Singapore (SQ2)','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Singapore','destination_country'=>'Singapore','operator'=>'Scoot','max_passengers'=>400],
            ['name'=>'Cebu to Singapore','origin'=>'Cebu','origin_country'=>'Philippines','destination'=>'Singapore','destination_country'=>'Singapore','operator'=>'Cebu Pacific','max_passengers'=>220],
            ['name'=>'Manila to Kuala Lumpur','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Kuala Lumpur','destination_country'=>'Malaysia','operator'=>'AirAsia','max_passengers'=>200],
            ['name'=>'Manila to Kuala Lumpur (MH)','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Kuala Lumpur','destination_country'=>'Malaysia','operator'=>'Malaysia Airlines','max_passengers'=>220],
            ['name'=>'Manila to Kota Kinabalu','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Kota Kinabalu','destination_country'=>'Malaysia','operator'=>'Philippine Airlines','max_passengers'=>150],
            ['name'=>'Manila to Bangkok','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Bangkok','destination_country'=>'Thailand','operator'=>'Thai Airways','max_passengers'=>250],
            ['name'=>'Manila to Bangkok (FD)','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Bangkok','destination_country'=>'Thailand','operator'=>'Thai AirAsia','max_passengers'=>180],
            ['name'=>'Manila to Phuket','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Phuket','destination_country'=>'Thailand','operator'=>'Cebu Pacific','max_passengers'=>180],
            ['name'=>'Manila to Jakarta','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Jakarta','destination_country'=>'Indonesia','operator'=>'Garuda Indonesia','max_passengers'=>220],
            ['name'=>'Manila to Bali','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Bali','destination_country'=>'Indonesia','operator'=>'Cebu Pacific','max_passengers'=>220],
            ['name'=>'Manila to Ho Chi Minh City','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Ho Chi Minh City','destination_country'=>'Vietnam','operator'=>'Vietnam Airlines','max_passengers'=>180],
            ['name'=>'Manila to Hanoi','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Hanoi','destination_country'=>'Vietnam','operator'=>'Philippine Airlines','max_passengers'=>180],
            ['name'=>'Manila to Hanoi (VJ)','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Hanoi','destination_country'=>'Vietnam','operator'=>'VietJet Air','max_passengers'=>180],
            ['name'=>'Manila to Siem Reap','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Siem Reap','destination_country'=>'Cambodia','operator'=>'Philippine Airlines','max_passengers'=>150],
            ['name'=>'Manila to Phnom Penh','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Phnom Penh','destination_country'=>'Cambodia','operator'=>'Cambodia Airways','max_passengers'=>150],
            ['name'=>'Manila to Yangon','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Yangon','destination_country'=>'Myanmar','operator'=>'Myanmar Airways','max_passengers'=>150],
            ['name'=>'Cebu to Kuala Lumpur','origin'=>'Cebu','origin_country'=>'Philippines','destination'=>'Kuala Lumpur','destination_country'=>'Malaysia','operator'=>'AirAsia','max_passengers'=>180],
            ['name'=>'Cebu to Bangkok','origin'=>'Cebu','origin_country'=>'Philippines','destination'=>'Bangkok','destination_country'=>'Thailand','operator'=>'Cebu Pacific','max_passengers'=>180],
            ['name'=>'Davao to Singapore','origin'=>'Davao','origin_country'=>'Philippines','destination'=>'Singapore','destination_country'=>'Singapore','operator'=>'Cebu Pacific','max_passengers'=>180],
            ['name'=>'Davao to Kuala Lumpur','origin'=>'Davao','origin_country'=>'Philippines','destination'=>'Kuala Lumpur','destination_country'=>'Malaysia','operator'=>'AirAsia','max_passengers'=>180],

            // ─── PHILIPPINES → MIDDLE EAST ───────────────────────
            ['name'=>'Manila to Dubai','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Dubai','destination_country'=>'UAE','operator'=>'Emirates','max_passengers'=>350],
            ['name'=>'Manila to Dubai (FZ)','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Dubai','destination_country'=>'UAE','operator'=>'flydubai','max_passengers'=>180],
            ['name'=>'Manila to Abu Dhabi','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Abu Dhabi','destination_country'=>'UAE','operator'=>'Etihad Airways','max_passengers'=>300],
            ['name'=>'Manila to Riyadh','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Riyadh','destination_country'=>'Saudi Arabia','operator'=>'Saudia','max_passengers'=>300],
            ['name'=>'Manila to Jeddah','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Jeddah','destination_country'=>'Saudi Arabia','operator'=>'Philippine Airlines','max_passengers'=>300],
            ['name'=>'Manila to Dammam','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Dammam','destination_country'=>'Saudi Arabia','operator'=>'Saudia','max_passengers'=>250],
            ['name'=>'Manila to Doha','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Doha','destination_country'=>'Qatar','operator'=>'Qatar Airways','max_passengers'=>320],
            ['name'=>'Manila to Kuwait City','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Kuwait City','destination_country'=>'Kuwait','operator'=>'Kuwait Airways','max_passengers'=>250],
            ['name'=>'Manila to Muscat','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Muscat','destination_country'=>'Oman','operator'=>'Oman Air','max_passengers'=>220],
            ['name'=>'Manila to Bahrain','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Bahrain','destination_country'=>'Bahrain','operator'=>'Gulf Air','max_passengers'=>220],
            ['name'=>'Cebu to Dubai','origin'=>'Cebu','origin_country'=>'Philippines','destination'=>'Dubai','destination_country'=>'UAE','operator'=>'Emirates','max_passengers'=>300],
            ['name'=>'Davao to Dubai','origin'=>'Davao','origin_country'=>'Philippines','destination'=>'Dubai','destination_country'=>'UAE','operator'=>'Emirates','max_passengers'=>250],
            ['name'=>'Manila to Tel Aviv','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Tel Aviv','destination_country'=>'Israel','operator'=>'El Al','max_passengers'=>220],
            ['name'=>'Manila to Amman','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Amman','destination_country'=>'Jordan','operator'=>'Royal Jordanian','max_passengers'=>180],

            // ─── PHILIPPINES → INDIA / SOUTH ASIA ───────────────
            ['name'=>'Manila to Mumbai','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Mumbai','destination_country'=>'India','operator'=>'Air India','max_passengers'=>250],
            ['name'=>'Manila to New Delhi','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'New Delhi','destination_country'=>'India','operator'=>'IndiGo','max_passengers'=>220],
            ['name'=>'Manila to Chennai','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Chennai','destination_country'=>'India','operator'=>'Philippine Airlines','max_passengers'=>180],
            ['name'=>'Manila to Colombo','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Colombo','destination_country'=>'Sri Lanka','operator'=>'SriLankan Airlines','max_passengers'=>180],
            ['name'=>'Manila to Dhaka','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Dhaka','destination_country'=>'Bangladesh','operator'=>'Biman Bangladesh','max_passengers'=>180],
            ['name'=>'Manila to Kathmandu','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Kathmandu','destination_country'=>'Nepal','operator'=>'Nepal Airlines','max_passengers'=>150],

            // ─── PHILIPPINES → EUROPE ─────────────────────────────
            ['name'=>'Manila to London Heathrow','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'London','destination_country'=>'United Kingdom','operator'=>'British Airways','max_passengers'=>380],
            ['name'=>'Manila to London Gatwick','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'London','destination_country'=>'United Kingdom','operator'=>'Philippine Airlines','max_passengers'=>350],
            ['name'=>'Manila to Frankfurt','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Frankfurt','destination_country'=>'Germany','operator'=>'Lufthansa','max_passengers'=>360],
            ['name'=>'Manila to Amsterdam','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Amsterdam','destination_country'=>'Netherlands','operator'=>'KLM','max_passengers'=>350],
            ['name'=>'Manila to Paris CDG','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Paris','destination_country'=>'France','operator'=>'Air France','max_passengers'=>370],
            ['name'=>'Manila to Rome','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Rome','destination_country'=>'Italy','operator'=>'ITA Airways','max_passengers'=>280],
            ['name'=>'Manila to Madrid','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Madrid','destination_country'=>'Spain','operator'=>'Iberia','max_passengers'=>280],
            ['name'=>'Manila to Zurich','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Zurich','destination_country'=>'Switzerland','operator'=>'Swiss International','max_passengers'=>250],
            ['name'=>'Manila to Vienna','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Vienna','destination_country'=>'Austria','operator'=>'Austrian Airlines','max_passengers'=>220],
            ['name'=>'Manila to Helsinki','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Helsinki','destination_country'=>'Finland','operator'=>'Finnair','max_passengers'=>280],
            ['name'=>'Manila to Istanbul','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Istanbul','destination_country'=>'Turkey','operator'=>'Turkish Airlines','max_passengers'=>350],
            ['name'=>'Manila to Moscow','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Moscow','destination_country'=>'Russia','operator'=>'Aeroflot','max_passengers'=>300],
            ['name'=>'Manila to Brussels','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Brussels','destination_country'=>'Belgium','operator'=>'Brussels Airlines','max_passengers'=>220],
            ['name'=>'Manila to Copenhagen','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Copenhagen','destination_country'=>'Denmark','operator'=>'SAS','max_passengers'=>220],
            ['name'=>'Manila to Oslo','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Oslo','destination_country'=>'Norway','operator'=>'Norwegian Air','max_passengers'=>180],

            // ─── PHILIPPINES → NORTH AMERICA ─────────────────────
            ['name'=>'Manila to Los Angeles','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Los Angeles','destination_country'=>'United States','operator'=>'Philippine Airlines','max_passengers'=>400],
            ['name'=>'Manila to San Francisco','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'San Francisco','destination_country'=>'United States','operator'=>'United Airlines','max_passengers'=>380],
            ['name'=>'Manila to New York JFK','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'New York','destination_country'=>'United States','operator'=>'Philippine Airlines','max_passengers'=>400],
            ['name'=>'Manila to Honolulu','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Honolulu','destination_country'=>'United States','operator'=>'Philippine Airlines','max_passengers'=>300],
            ['name'=>'Manila to Chicago','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Chicago','destination_country'=>'United States','operator'=>'United Airlines','max_passengers'=>350],
            ['name'=>'Manila to Las Vegas','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Las Vegas','destination_country'=>'United States','operator'=>'Philippine Airlines','max_passengers'=>300],
            ['name'=>'Manila to Seattle','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Seattle','destination_country'=>'United States','operator'=>'Alaska Airlines','max_passengers'=>300],
            ['name'=>'Manila to Dallas','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Dallas','destination_country'=>'United States','operator'=>'American Airlines','max_passengers'=>350],
            ['name'=>'Manila to Vancouver','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Vancouver','destination_country'=>'Canada','operator'=>'Air Canada','max_passengers'=>350],
            ['name'=>'Manila to Toronto','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Toronto','destination_country'=>'Canada','operator'=>'Air Canada','max_passengers'=>350],
            ['name'=>'Manila to Calgary','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Calgary','destination_country'=>'Canada','operator'=>'Philippine Airlines','max_passengers'=>300],
            ['name'=>'Manila to Mexico City','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Mexico City','destination_country'=>'Mexico','operator'=>'Aeromexico','max_passengers'=>300],

            // ─── PHILIPPINES → AUSTRALIA / NZ ────────────────────
            ['name'=>'Manila to Sydney','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Sydney','destination_country'=>'Australia','operator'=>'Qantas','max_passengers'=>300],
            ['name'=>'Manila to Melbourne','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Melbourne','destination_country'=>'Australia','operator'=>'Philippine Airlines','max_passengers'=>280],
            ['name'=>'Manila to Brisbane','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Brisbane','destination_country'=>'Australia','operator'=>'Cebu Pacific','max_passengers'=>250],
            ['name'=>'Manila to Perth','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Perth','destination_country'=>'Australia','operator'=>'Philippine Airlines','max_passengers'=>220],
            ['name'=>'Manila to Auckland','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Auckland','destination_country'=>'New Zealand','operator'=>'Air New Zealand','max_passengers'=>250],
            ['name'=>'Manila to Guam','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Guam','destination_country'=>'United States','operator'=>'United Airlines','max_passengers'=>150],
            ['name'=>'Cebu to Sydney','origin'=>'Cebu','origin_country'=>'Philippines','destination'=>'Sydney','destination_country'=>'Australia','operator'=>'Cebu Pacific','max_passengers'=>250],
            ['name'=>'Cebu to Melbourne','origin'=>'Cebu','origin_country'=>'Philippines','destination'=>'Melbourne','destination_country'=>'Australia','operator'=>'Philippine Airlines','max_passengers'=>220],

            // ─── PHILIPPINES → AFRICA ─────────────────────────────
            ['name'=>'Manila to Johannesburg','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Johannesburg','destination_country'=>'South Africa','operator'=>'Qatar Airways','max_passengers'=>350],
            ['name'=>'Manila to Nairobi','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Nairobi','destination_country'=>'Kenya','operator'=>'Emirates','max_passengers'=>300],
            ['name'=>'Manila to Lagos','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Lagos','destination_country'=>'Nigeria','operator'=>'Ethiopian Airlines','max_passengers'=>250],
            ['name'=>'Manila to Cairo','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Cairo','destination_country'=>'Egypt','operator'=>'EgyptAir','max_passengers'=>220],

            // ─── INTER-ASIA ───────────────────────────────────────
            ['name'=>'Singapore to Tokyo','origin'=>'Singapore','origin_country'=>'Singapore','destination'=>'Tokyo','destination_country'=>'Japan','operator'=>'Singapore Airlines','max_passengers'=>300],
            ['name'=>'Singapore to Seoul','origin'=>'Singapore','origin_country'=>'Singapore','destination'=>'Seoul','destination_country'=>'South Korea','operator'=>'Singapore Airlines','max_passengers'=>280],
            ['name'=>'Singapore to Bangkok','origin'=>'Singapore','origin_country'=>'Singapore','destination'=>'Bangkok','destination_country'=>'Thailand','operator'=>'Thai Airways','max_passengers'=>250],
            ['name'=>'Singapore to Kuala Lumpur','origin'=>'Singapore','origin_country'=>'Singapore','destination'=>'Kuala Lumpur','destination_country'=>'Malaysia','operator'=>'AirAsia','max_passengers'=>180],
            ['name'=>'Singapore to Hong Kong','origin'=>'Singapore','origin_country'=>'Singapore','destination'=>'Hong Kong','destination_country'=>'Hong Kong','operator'=>'Cathay Pacific','max_passengers'=>250],
            ['name'=>'Singapore to Sydney','origin'=>'Singapore','origin_country'=>'Singapore','destination'=>'Sydney','destination_country'=>'Australia','operator'=>'Qantas','max_passengers'=>300],
            ['name'=>'Singapore to London','origin'=>'Singapore','origin_country'=>'Singapore','destination'=>'London','destination_country'=>'United Kingdom','operator'=>'Singapore Airlines','max_passengers'=>380],
            ['name'=>'Singapore to Sydney (SQ)','origin'=>'Singapore','origin_country'=>'Singapore','destination'=>'Sydney','destination_country'=>'Australia','operator'=>'Singapore Airlines','max_passengers'=>380],
            ['name'=>'Tokyo to Seoul','origin'=>'Tokyo','origin_country'=>'Japan','destination'=>'Seoul','destination_country'=>'South Korea','operator'=>'ANA','max_passengers'=>250],
            ['name'=>'Tokyo to Beijing','origin'=>'Tokyo','origin_country'=>'Japan','destination'=>'Beijing','destination_country'=>'China','operator'=>'Air China','max_passengers'=>280],
            ['name'=>'Tokyo to Hong Kong','origin'=>'Tokyo','origin_country'=>'Japan','destination'=>'Hong Kong','destination_country'=>'Hong Kong','operator'=>'Cathay Pacific','max_passengers'=>250],
            ['name'=>'Tokyo to Bangkok','origin'=>'Tokyo','origin_country'=>'Japan','destination'=>'Bangkok','destination_country'=>'Thailand','operator'=>'Thai Airways','max_passengers'=>250],
            ['name'=>'Tokyo to Los Angeles','origin'=>'Tokyo','origin_country'=>'Japan','destination'=>'Los Angeles','destination_country'=>'United States','operator'=>'Japan Airlines','max_passengers'=>380],
            ['name'=>'Tokyo to London','origin'=>'Tokyo','origin_country'=>'Japan','destination'=>'London','destination_country'=>'United Kingdom','operator'=>'British Airways','max_passengers'=>380],
            ['name'=>'Seoul to Beijing','origin'=>'Seoul','origin_country'=>'South Korea','destination'=>'Beijing','destination_country'=>'China','operator'=>'Korean Air','max_passengers'=>280],
            ['name'=>'Seoul to Shanghai','origin'=>'Seoul','origin_country'=>'South Korea','destination'=>'Shanghai','destination_country'=>'China','operator'=>'Asiana Airlines','max_passengers'=>250],
            ['name'=>'Seoul to Bangkok','origin'=>'Seoul','origin_country'=>'South Korea','destination'=>'Bangkok','destination_country'=>'Thailand','operator'=>'Korean Air','max_passengers'=>220],
            ['name'=>'Seoul to Los Angeles','origin'=>'Seoul','origin_country'=>'South Korea','destination'=>'Los Angeles','destination_country'=>'United States','operator'=>'Korean Air','max_passengers'=>380],
            ['name'=>'Hong Kong to London','origin'=>'Hong Kong','origin_country'=>'Hong Kong','destination'=>'London','destination_country'=>'United Kingdom','operator'=>'Cathay Pacific','max_passengers'=>380],
            ['name'=>'Hong Kong to Sydney','origin'=>'Hong Kong','origin_country'=>'Hong Kong','destination'=>'Sydney','destination_country'=>'Australia','operator'=>'Qantas','max_passengers'=>300],
            ['name'=>'Bangkok to Seoul','origin'=>'Bangkok','origin_country'=>'Thailand','destination'=>'Seoul','destination_country'=>'South Korea','operator'=>'Thai AirAsia','max_passengers'=>180],
            ['name'=>'Bangkok to Tokyo','origin'=>'Bangkok','origin_country'=>'Thailand','destination'=>'Tokyo','destination_country'=>'Japan','operator'=>'Thai Airways','max_passengers'=>300],
            ['name'=>'Bangkok to London','origin'=>'Bangkok','origin_country'=>'Thailand','destination'=>'London','destination_country'=>'United Kingdom','operator'=>'Thai Airways','max_passengers'=>380],
            ['name'=>'Kuala Lumpur to London','origin'=>'Kuala Lumpur','origin_country'=>'Malaysia','destination'=>'London','destination_country'=>'United Kingdom','operator'=>'Malaysia Airlines','max_passengers'=>380],
            ['name'=>'Kuala Lumpur to Tokyo','origin'=>'Kuala Lumpur','origin_country'=>'Malaysia','destination'=>'Tokyo','destination_country'=>'Japan','operator'=>'AirAsia X','max_passengers'=>350],

            // ─── MIDDLE EAST HUB ─────────────────────────────────
            ['name'=>'Dubai to London','origin'=>'Dubai','origin_country'=>'UAE','destination'=>'London','destination_country'=>'United Kingdom','operator'=>'Emirates','max_passengers'=>500],
            ['name'=>'Dubai to New York','origin'=>'Dubai','origin_country'=>'UAE','destination'=>'New York','destination_country'=>'United States','operator'=>'Emirates','max_passengers'=>500],
            ['name'=>'Dubai to Sydney','origin'=>'Dubai','origin_country'=>'UAE','destination'=>'Sydney','destination_country'=>'Australia','operator'=>'Emirates','max_passengers'=>450],
            ['name'=>'Dubai to Singapore','origin'=>'Dubai','origin_country'=>'UAE','destination'=>'Singapore','destination_country'=>'Singapore','operator'=>'Emirates','max_passengers'=>380],
            ['name'=>'Dubai to Bangkok','origin'=>'Dubai','origin_country'=>'UAE','destination'=>'Bangkok','destination_country'=>'Thailand','operator'=>'flydubai','max_passengers'=>180],
            ['name'=>'Doha to London','origin'=>'Doha','origin_country'=>'Qatar','destination'=>'London','destination_country'=>'United Kingdom','operator'=>'Qatar Airways','max_passengers'=>450],
            ['name'=>'Doha to New York','origin'=>'Doha','origin_country'=>'Qatar','destination'=>'New York','destination_country'=>'United States','operator'=>'Qatar Airways','max_passengers'=>450],
            ['name'=>'Doha to Sydney','origin'=>'Doha','origin_country'=>'Qatar','destination'=>'Sydney','destination_country'=>'Australia','operator'=>'Qatar Airways','max_passengers'=>380],
            ['name'=>'Abu Dhabi to London','origin'=>'Abu Dhabi','origin_country'=>'UAE','destination'=>'London','destination_country'=>'United Kingdom','operator'=>'Etihad Airways','max_passengers'=>400],

            // ─── TRANS-PACIFIC ────────────────────────────────────
            ['name'=>'Los Angeles to Tokyo','origin'=>'Los Angeles','origin_country'=>'United States','destination'=>'Tokyo','destination_country'=>'Japan','operator'=>'United Airlines','max_passengers'=>380],
            ['name'=>'Los Angeles to Seoul','origin'=>'Los Angeles','origin_country'=>'United States','destination'=>'Seoul','destination_country'=>'South Korea','operator'=>'Korean Air','max_passengers'=>380],
            ['name'=>'Los Angeles to Sydney','origin'=>'Los Angeles','origin_country'=>'United States','destination'=>'Sydney','destination_country'=>'Australia','operator'=>'Qantas','max_passengers'=>380],
            ['name'=>'New York to London','origin'=>'New York','origin_country'=>'United States','destination'=>'London','destination_country'=>'United Kingdom','operator'=>'British Airways','max_passengers'=>380],
            ['name'=>'New York to Paris','origin'=>'New York','origin_country'=>'United States','destination'=>'Paris','destination_country'=>'France','operator'=>'Air France','max_passengers'=>380],
            ['name'=>'New York to Frankfurt','origin'=>'New York','origin_country'=>'United States','destination'=>'Frankfurt','destination_country'=>'Germany','operator'=>'Lufthansa','max_passengers'=>380],
            ['name'=>'New York to Dubai','origin'=>'New York','origin_country'=>'United States','destination'=>'Dubai','destination_country'=>'UAE','operator'=>'Emirates','max_passengers'=>500],
            ['name'=>'New York to Tokyo','origin'=>'New York','origin_country'=>'United States','destination'=>'Tokyo','destination_country'=>'Japan','operator'=>'Japan Airlines','max_passengers'=>380],
            ['name'=>'Chicago to London','origin'=>'Chicago','origin_country'=>'United States','destination'=>'London','destination_country'=>'United Kingdom','operator'=>'United Airlines','max_passengers'=>380],
            ['name'=>'San Francisco to Tokyo','origin'=>'San Francisco','origin_country'=>'United States','destination'=>'Tokyo','destination_country'=>'Japan','operator'=>'United Airlines','max_passengers'=>380],
            ['name'=>'Vancouver to Tokyo','origin'=>'Vancouver','origin_country'=>'Canada','destination'=>'Tokyo','destination_country'=>'Japan','operator'=>'Air Canada','max_passengers'=>300],
            ['name'=>'Toronto to London','origin'=>'Toronto','origin_country'=>'Canada','destination'=>'London','destination_country'=>'United Kingdom','operator'=>'Air Canada','max_passengers'=>380],

            // ─── EUROPE INTRA ─────────────────────────────────────
            ['name'=>'London to Paris','origin'=>'London','origin_country'=>'United Kingdom','destination'=>'Paris','destination_country'=>'France','operator'=>'British Airways','max_passengers'=>180],
            ['name'=>'London to Amsterdam','origin'=>'London','origin_country'=>'United Kingdom','destination'=>'Amsterdam','destination_country'=>'Netherlands','operator'=>'KLM','max_passengers'=>180],
            ['name'=>'London to Frankfurt','origin'=>'London','origin_country'=>'United Kingdom','destination'=>'Frankfurt','destination_country'=>'Germany','operator'=>'Lufthansa','max_passengers'=>180],
            ['name'=>'London to Dubai','origin'=>'London','origin_country'=>'United Kingdom','destination'=>'Dubai','destination_country'=>'UAE','operator'=>'Emirates','max_passengers'=>380],
            ['name'=>'London to Sydney','origin'=>'London','origin_country'=>'United Kingdom','destination'=>'Sydney','destination_country'=>'Australia','operator'=>'Qantas','max_passengers'=>380],
            ['name'=>'Paris to Dubai','origin'=>'Paris','origin_country'=>'France','destination'=>'Dubai','destination_country'=>'UAE','operator'=>'Emirates','max_passengers'=>380],
            ['name'=>'Frankfurt to Singapore','origin'=>'Frankfurt','origin_country'=>'Germany','destination'=>'Singapore','destination_country'=>'Singapore','operator'=>'Singapore Airlines','max_passengers'=>380],
            ['name'=>'Amsterdam to Singapore','origin'=>'Amsterdam','origin_country'=>'Netherlands','destination'=>'Singapore','destination_country'=>'Singapore','operator'=>'KLM','max_passengers'=>350],
            ['name'=>'Istanbul to London','origin'=>'Istanbul','origin_country'=>'Turkey','destination'=>'London','destination_country'=>'United Kingdom','operator'=>'Turkish Airlines','max_passengers'=>350],
            ['name'=>'Istanbul to New York','origin'=>'Istanbul','origin_country'=>'Turkey','destination'=>'New York','destination_country'=>'United States','operator'=>'Turkish Airlines','max_passengers'=>380],

            // ─── AUSTRALIA INTRA ──────────────────────────────────
            ['name'=>'Sydney to Melbourne','origin'=>'Sydney','origin_country'=>'Australia','destination'=>'Melbourne','destination_country'=>'Australia','operator'=>'Qantas','max_passengers'=>180],
            ['name'=>'Sydney to Brisbane','origin'=>'Sydney','origin_country'=>'Australia','destination'=>'Brisbane','destination_country'=>'Australia','operator'=>'Virgin Australia','max_passengers'=>180],
            ['name'=>'Sydney to Auckland','origin'=>'Sydney','origin_country'=>'Australia','destination'=>'Auckland','destination_country'=>'New Zealand','operator'=>'Air New Zealand','max_passengers'=>220],
            ['name'=>'Melbourne to Perth','origin'=>'Melbourne','origin_country'=>'Australia','destination'=>'Perth','destination_country'=>'Australia','operator'=>'Qantas','max_passengers'=>180],
            ['name'=>'Auckland to Sydney','origin'=>'Auckland','origin_country'=>'New Zealand','destination'=>'Sydney','destination_country'=>'Australia','operator'=>'Air New Zealand','max_passengers'=>220],
            ['name'=>'Manila to Macau','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Macau','destination_country'=>'Macau','operator'=>'Air Macau','max_passengers'=>150],
            ['name'=>'Manila to Brunei','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Bandar Seri Begawan','destination_country'=>'Brunei','operator'=>'Royal Brunei Airlines','max_passengers'=>130],
            ['name'=>'Manila to Almaty','origin'=>'Manila','origin_country'=>'Philippines','destination'=>'Almaty','destination_country'=>'Kazakhstan','operator'=>'Air Astana','max_passengers'=>180],
        ];

        $tripBar = $this->output->createProgressBar(count($trips));
        $tripBar->start();

        $insertedTrips = [];
        foreach ($trips as $trip) {
            $model = Trip::create(array_merge($trip, [
                'type'   => 'air',
                'status' => 'active',
            ]));
            $insertedTrips[] = $model;
            $tripBar->advance();
        }

        $tripBar->finish();
        $this->newLine();
        $this->info('✅ ' . count($insertedTrips) . ' trips seeded.');

        // ── SCHEDULES ────────────────────────────────────────────
        $this->info('Seeding schedules...');

        $fareMap = function ($maxPax) {
            if ($maxPax >= 380) return 25000;
            if ($maxPax >= 300) return 18000;
            if ($maxPax >= 220) return 12000;
            if ($maxPax >= 180) return 8000;
            return 5000;
        };

        $slots = [
            ['hour' => 6,  'days' => 1],
            ['hour' => 10, 'days' => 2],
            ['hour' => 14, 'days' => 5],
            ['hour' => 18, 'days' => 7],
            ['hour' => 21, 'days' => 14],
        ];

        $schedBar = $this->output->createProgressBar(count($insertedTrips));
        $schedBar->start();

        $schedCount = 0;
        foreach ($insertedTrips as $trip) {
            $fare     = $fareMap($trip->max_passengers ?? 180);
            $capacity = $trip->max_passengers ?? 180;

            foreach ($slots as $slot) {
                $departure = now()->addDays($slot['days'])->setHour($slot['hour'])->setMinute(0)->setSecond(0);
                $arrival   = (clone $departure)->addHours(rand(1, 14));

                Schedule::create([
                    'trip_id'         => $trip->id,
                    'departure_at'    => $departure,
                    'arrival_at'      => $arrival,
                    'capacity'        => $capacity,
                    'available_seats' => $capacity,
                    'fare_class'      => 'Economy',
                    'base_fare'       => $fare,
                    'status'          => 'scheduled',
                ]);

                $schedCount++;
            }

            $schedBar->advance();
        }

        $schedBar->finish();
        $this->newLine();
        $this->info("✅ {$schedCount} schedules seeded ({$schedCount} entries in booking dropdown)!");

        $this->newLine();
        $this->table(
            ['', 'Count'],
            [
                ['Total Trips',     count($insertedTrips)],
                ['Total Schedules', $schedCount],
                ['Schedules/Trip',  count($slots)],
            ]
        );
    }
}