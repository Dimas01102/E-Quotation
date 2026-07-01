<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah unique constraint ke kolom phone dan npwp pada tabel suppliers.
     */
    public function up(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->unique('phone', 'suppliers_phone_unique');
            $table->unique('npwp', 'suppliers_npwp_unique');
        });
    }

    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropUnique('suppliers_phone_unique');
            $table->dropUnique('suppliers_npwp_unique');
        });
    }
};