<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'refund_date')) {
                $table->timestamp('refund_date')->nullable()->after('paid_at');
            }
            if (!Schema::hasColumn('payments', 'refund_reason')) {
                $table->string('refund_reason')->nullable()->after('refund_date');
            }
            if (!Schema::hasColumn('payments', 'refund_ref')) {
                $table->string('refund_ref')->nullable()->after('refund_reason');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['refund_date', 'refund_reason', 'refund_ref']);
        });
    }
};
