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
        Schema::create('payments', function (Blueprint $table) {
           // payments
$table->id(); $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
$table->enum('method',['card','corporate','bank_transfer','wallet']);
$table->decimal('amount',10,2); $table->string('currency',5)->default('PHP');
$table->enum('status',['pending','paid','failed','refunded'])->default('pending');
$table->tinyInteger('attempts')->default(0);
$table->string('transaction_ref',100)->nullable();
$table->timestamp('paid_at')->nullable();
$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
