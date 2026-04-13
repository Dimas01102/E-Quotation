<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // MASTER CATEGORY
        Schema::create('master_category', function (Blueprint $table) {
            $table->increments('id_master_category');               // id_master_category INT AUTO_INCREMENT PRIMARY KEY
            $table->string('name', 150)->nullable();
            $table->text('description')->nullable();
        });

        // MASTER ITEMS
        Schema::create('master_items', function (Blueprint $table) {
            $table->increments('id_item');                          // id_item INT AUTO_INCREMENT PRIMARY KEY
            $table->unsignedInteger('id_category')->nullable();
            $table->string('item_code', 50)->nullable();
            $table->string('item_name', 150)->nullable();
            $table->string('unit', 50)->nullable();
            $table->text('description')->nullable();

            $table->foreign('id_category')
                  ->references('id_master_category')
                  ->on('master_category')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_items');
        Schema::dropIfExists('master_category');
    }
};