<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // INVITED SUPPLIER CATEGORIES
        Schema::create('invited_supplier_categories', function (Blueprint $table) {
            $table->increments('id_invited_supplier');              // id_invited_supplier INT AUTO_INCREMENT PRIMARY KEY
            $table->unsignedInteger('id_supplier')->nullable();
            $table->unsignedInteger('id_batch_category')->nullable();
            $table->timestamp('invited_at')->useCurrent();
            $table->string('status', 50)->nullable()->default('invited');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            $table->foreign('id_supplier')
                  ->references('id')
                  ->on('suppliers')
                  ->onDelete('cascade');

            $table->foreign('id_batch_category')
                  ->references('id_batch_category')
                  ->on('batch_categories')
                  ->onDelete('cascade');
        });

        // 9️⃣ QUOTATIONS
        Schema::create('quotations', function (Blueprint $table) {
            $table->increments('id_quotation');                     // id_quotation INT AUTO_INCREMENT PRIMARY KEY
            $table->unsignedInteger('id_invited_supplier')->nullable();
            $table->string('file_name', 255)->nullable();
            $table->string('file_path', 255)->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->decimal('total_price', 15, 2)->nullable();
            $table->string('status', 50)->nullable()->default('submitted');
            $table->text('note')->nullable();
            $table->string('po_file_path', 255)->nullable();       // path PDF PO yang didownload supplier
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            $table->foreign('id_invited_supplier')
                  ->references('id_invited_supplier')
                  ->on('invited_supplier_categories')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotations');
        Schema::dropIfExists('invited_supplier_categories');
    }
};