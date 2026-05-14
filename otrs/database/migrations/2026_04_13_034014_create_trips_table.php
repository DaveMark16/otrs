<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Drop dependent pivot table first if it exists
        Schema::dropIfExists('promo_trip');
        Schema::dropIfExists('trips');

        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('origin_country');
            $table->string('destination_country');
            $table->enum('type', ['air', 'land', 'sea'])->default('air');
            $table->string('operator')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedInteger('max_passengers')->default(50);
            $table->timestamps();
        });

        // Recreate pivot table
        Schema::create('promo_trip', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promo_id')->constrained()->onDelete('cascade');
            $table->foreignId('trip_id')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promo_trip');
        Schema::dropIfExists('trips');
    }
};
