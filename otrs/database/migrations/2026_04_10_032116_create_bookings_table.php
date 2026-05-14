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
        Schema::create('bookings', function (Blueprint $table) {
           // bookings
$table->id(); $table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('schedule_id')->constrained()->cascadeOnDelete();
$table->string('reference_no',20)->unique();
$table->enum('status',['draft','pending','confirmed','ticketed','completed','cancelled','expired'])->default('draft');
$table->decimal('total_amount',10,2);
$table->integer('passenger_count')->default(1);
$table->string('contact_email');
$table->timestamp('expires_at')->nullable();
$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
