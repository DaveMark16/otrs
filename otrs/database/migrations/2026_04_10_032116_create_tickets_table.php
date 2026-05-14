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
        Schema::create('tickets', function (Blueprint $table) {
            // tickets
$table->id(); $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
$table->string('ticket_no',20)->unique();
$table->string('passenger_name');
$table->string('seat_no',10)->nullable();
$table->enum('fare_class',['economy','business','first']);
$table->enum('status',['issued','partially_cancelled','cancelled','refunded'])->default('issued');
$table->timestamp('issued_at')->nullable();
$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
