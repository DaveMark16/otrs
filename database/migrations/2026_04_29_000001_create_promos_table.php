<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('discount_type', ['percentage', 'fixed']);
            $table->decimal('discount_value', 10, 2);
            $table->string('promo_code')->unique();
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('applies_to_all')->default(true);
            $table->timestamps();
        });

        // Pivot table for promo <-> trip relationship
        if (!Schema::hasTable('promo_trip')) {
            Schema::create('promo_trip', function (Blueprint $table) {
                $table->id();
                $table->foreignId('promo_id')->constrained()->onDelete('cascade');
                $table->foreignId('trip_id')->constrained()->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('promo_trip');
        Schema::dropIfExists('promos');
    }
};
