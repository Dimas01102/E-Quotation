<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->increments('id_batch');                         // id_batch INT AUTO_INCREMENT PRIMARY KEY
            $table->string('batch_number', 100)->nullable();
            $table->string('title', 200)->nullable();
            $table->text('description')->nullable();
            $table->date('deadline')->nullable();
            $table->string('status', 50)->nullable()->default('draft');
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};