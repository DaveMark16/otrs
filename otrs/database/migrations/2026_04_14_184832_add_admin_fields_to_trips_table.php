<?php
// database/migrations/2025_01_01_000005_add_admin_fields_to_trips_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('trips', function (Blueprint $table) {
            // Add only if columns don't exist
            if (!Schema::hasColumn('trips', 'origin')) {
                $table->string('origin')->after('name');
            }
            if (!Schema::hasColumn('trips', 'destination')) {
                $table->string('destination')->after('origin');
            }
            if (!Schema::hasColumn('trips', 'departure_time')) {
                $table->datetime('departure_time')->nullable()->after('destination');
            }
            if (!Schema::hasColumn('trips', 'arrival_time')) {
                $table->datetime('arrival_time')->nullable()->after('departure_time');
            }
            if (!Schema::hasColumn('trips', 'price')) {
                $table->decimal('price', 10, 2)->nullable()->after('arrival_time');
            }
            if (!Schema::hasColumn('trips', 'capacity')) {
                $table->integer('capacity')->nullable()->after('price');
            }
            if (!Schema::hasColumn('trips', 'available_seats')) {
                $table->integer('available_seats')->nullable()->after('capacity');
            }
        });
    }

    public function down()
    {
        Schema::table('trips', function (Blueprint $table) {
            $columns = ['origin', 'destination', 'departure_time', 'arrival_time', 'price', 'capacity', 'available_seats'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('trips', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};