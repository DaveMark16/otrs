<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
    $table->id();
    $table->foreignId('booking_id')->constrained()->onDelete('cascade');
    $table->string('ticket_no', 20)->unique();
    $table->string('passenger_name');
    $table->string('seat_no')->nullable();
    $table->enum('fare_class', ['economy', 'business', 'first']);
    $table->enum('status', ['issued', 'used', 'cancelled'])->default('issued');
    $table->timestamp('issued_at')->nullable();
    $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
