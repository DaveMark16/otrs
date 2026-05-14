<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('promo_trip');
        Schema::dropIfExists('trips');

        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('origin')->nullable();
            $table->string('destination')->nullable();
            $table->string('origin_country')->nullable();
            $table->string('destination_country')->nullable();
            $table->enum('type', ['air', 'land', 'sea'])->default('air');
            $table->string('operator')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedInteger('max_passengers')->default(50);
            $table->datetime('departure_time')->nullable();
            $table->datetime('arrival_time')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->integer('capacity')->nullable();
            $table->integer('available_seats')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promo_trip');
        Schema::dropIfExists('trips');
    }
};
