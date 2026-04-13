<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel untuk menyimpan template Excel RFQ yang diupload admin.
     * Template ini BEBAS, tidak terikat ke batch tertentu.
     * Semua supplier aktif bisa melihat & download template ini.
     * Relasi: TIDAK ada FK ke tabel lain (standalone).
     */
    public function up(): void
    {
        Schema::create('rfq_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title');               // Judul template
            $table->text('description')->nullable();
            $table->string('file_name');           // Nama file asli
            $table->string('file_path');           // Path di storage/public
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('uploaded_by'); // FK ke users
            $table->timestamps();

            $table->foreign('uploaded_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rfq_templates');
    }
};