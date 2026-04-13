<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // BATCH CATEGORIES
        Schema::create('batch_categories', function (Blueprint $table) {
            $table->increments('id_batch_category');                // id_batch_category INT AUTO_INCREMENT PRIMARY KEY
            $table->unsignedInteger('id_batch')->nullable();
            $table->unsignedInteger('id_master_category')->nullable();

            $table->foreign('id_batch')
                  ->references('id_batch')
                  ->on('batches')
                  ->onDelete('cascade');

            $table->foreign('id_master_category')
                  ->references('id_master_category')
                  ->on('master_category')
                  ->onDelete('cascade');
        });

        // 7️⃣ ITEMS BATCH CATEGORIES
        Schema::create('items_batch_categories', function (Blueprint $table) {
            $table->increments('id_item_batch_category');           // id_item_batch_category INT AUTO_INCREMENT PRIMARY KEY
            $table->unsignedInteger('id_item')->nullable();
            $table->unsignedInteger('id_batch_category')->nullable();
            $table->integer('quantity')->nullable();

            $table->foreign('id_item')
                  ->references('id_item')
                  ->on('master_items')
                  ->onDelete('cascade');

            $table->foreign('id_batch_category')
                  ->references('id_batch_category')
                  ->on('batch_categories')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items_batch_categories');
        Schema::dropIfExists('batch_categories');
    }
};