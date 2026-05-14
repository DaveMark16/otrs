<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
    $table->id();
    $table->foreignId('trip_id')->constrained()->onDelete('cascade');
    $table->datetime('departure_at');
    $table->datetime('arrival_at');
    $table->integer('capacity');
    $table->integer('available_seats');
    $table->enum('fare_class', ['economy', 'business', 'first']);
    $table->decimal('base_fare', 10, 2);
    $table->enum('status', ['scheduled', 'cancelled', 'completed'])->default('scheduled');
    $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
