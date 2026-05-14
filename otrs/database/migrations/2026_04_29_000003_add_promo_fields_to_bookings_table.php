<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'promo_id')) {
                $table->foreignId('promo_id')->nullable()->constrained('promos')->nullOnDelete()->after('contact_email');
            }
            if (!Schema::hasColumn('bookings', 'original_amount')) {
                $table->decimal('original_amount', 10, 2)->nullable()->after('total_amount');
            }
            if (!Schema::hasColumn('bookings', 'discount_amount')) {
                $table->decimal('discount_amount', 10, 2)->default(0)->after('original_amount');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('promo_id');
            $table->dropColumn(['original_amount', 'discount_amount']);
        });
    }
};
