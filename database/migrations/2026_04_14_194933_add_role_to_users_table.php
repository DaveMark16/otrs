<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// The 'role' column is already defined in 0001_01_01_000000_create_users_table.php
// with the full enum including 'admin'. This migration is a safe no-op.
return new class extends Migration
{
    public function up(): void {}
    public function down(): void {}
};
