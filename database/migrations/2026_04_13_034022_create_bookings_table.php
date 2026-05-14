<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade')
                  ->name('fk_bookings_user_id');          // ← unique name
            $table->foreignId('schedule_id')
                  ->constrained('schedules')
                  ->onDelete('cascade')
                  ->name('fk_bookings_schedule_id');      // ← unique name
            $table->string('reference_no', 20)->unique();
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'ticketed', 'rejected', 'expired'])->default('pending');
            $table->decimal('total_amount', 10, 2);
            $table->integer('passenger_count');
            $table->string('contact_email');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};