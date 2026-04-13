<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');                               // INT AUTO_INCREMENT PRIMARY KEY
            $table->string('name', 100)->nullable();
            $table->string('email', 100)->unique()->nullable();
            $table->string('password', 255)->nullable();
            $table->enum('role', ['admin', 'supplier'])->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};