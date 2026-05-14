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
        Schema::create('trips', function (Blueprint $table) {
            // trips
$table->id(); $table->string('name');
$table->string('origin'); $table->string('destination');
$table->enum('type',['bus','flight','ferry']);
$table->string('operator')->nullable();
$table->enum('status',['active','inactive'])->default('active');
$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
