<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel untuk menyimpan detail isi file Excel quotation dari supplier.
     * Relasi: quotation_items.id_quotation → quotations.id_quotation
     *
     * Kolom sesuai header Excel:
     * Coll No. | RFQ No. | Vendor | No. Item | Material No. | Description |
     * Qty | UoM | Currency | Net Price | Incoterm | Destination |
     * Remark 1 | Remark 2 | Lead Time(Weeks) | Payment Term | Quotation Date
     */
    public function up(): void
    {
        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id();

            // FK ke tabel quotations
            $table->unsignedInteger('id_quotation');

            // Kolom sesuai Excel
            $table->string('coll_no')->nullable();
            $table->string('rfq_no')->nullable();
            $table->string('vendor')->nullable();
            $table->string('no_item')->nullable();
            $table->string('material_no')->nullable();
            $table->text('description')->nullable();
            $table->decimal('qty', 15, 2)->nullable();
            $table->string('uom')->nullable();          // Unit of Measure
            $table->string('currency')->nullable();
            $table->decimal('net_price', 15, 2)->nullable();
            $table->string('incoterm')->nullable();
            $table->string('destination')->nullable();
            $table->text('remark_1')->nullable();
            $table->text('remark_2')->nullable();
            $table->string('lead_time_weeks')->nullable();
            $table->string('payment_term')->nullable();
            $table->string('quotation_date')->nullable();

            $table->timestamps();

            $table->foreign('id_quotation')
          ->references('id_quotation')
          ->on('quotations')
          ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotation_items');
    }
};