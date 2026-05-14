<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            // schedules
$table->id(); $table->foreignId('trip_id')->constrained()->cascadeOnDelete();
$table->dateTime('departure_at'); $table->dateTime('arrival_at');
$table->integer('capacity'); $table->integer('available_seats');
$table->enum('fare_class',['economy','business','first']);
$table->decimal('base_fare',10,2);
$table->enum('status',['scheduled','closed','cancelled','completed'])->default('scheduled');
$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
