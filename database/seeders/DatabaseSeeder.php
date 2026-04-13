<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // -------------------------------------------------------
        // USERS
        // -------------------------------------------------------
        $adminId = DB::table('users')->insertGetId([
            'name'       => 'Administrator',
            'email'      => 'admin@rfqsystem.com',
            'password'   => Hash::make('admin123'),
            'role'       => 'admin',
            'is_active'  => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $supplierUserId = DB::table('users')->insertGetId([
            'name'       => 'Budi Santoso',
            'email'      => 'supplier@demo.com',
            'password'   => Hash::make('supplier123'),
            'role'       => 'supplier',
            'is_active'  => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // -------------------------------------------------------
        // SUPPLIERS
        // -------------------------------------------------------
        $supplierId = DB::table('suppliers')->insertGetId([
            'user_id'      => $supplierUserId,
            'company_name' => 'PT Demo Supplier Indonesia',
            'phone'        => '+62 21 5555 1234',
            'address'      => 'Jl. Sudirman No. 88, Jakarta Pusat',
            'npwp'         => '12.345.678.9-012.345',
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        // -------------------------------------------------------
        // MASTER CATEGORY
        // -------------------------------------------------------
        $catIT = DB::table('master_category')->insertGetId([
            'name'        => 'IT Equipment',
            'description' => 'Peralatan teknologi informasi',
        ]);

        $catOffice = DB::table('master_category')->insertGetId([
            'name'        => 'Office Supplies',
            'description' => 'Perlengkapan kantor',
        ]);

        // -------------------------------------------------------
        // MASTER ITEMS
        // -------------------------------------------------------
        $itemLaptop = DB::table('master_items')->insertGetId([
            'id_category' => $catIT,
            'item_code'   => 'IT-001',
            'item_name'   => 'Laptop Core i7 Gen 13',
            'unit'        => 'Unit',
            'description' => 'Laptop untuk kebutuhan kantor',
        ]);

        $itemMonitor = DB::table('master_items')->insertGetId([
            'id_category' => $catIT,
            'item_code'   => 'IT-002',
            'item_name'   => 'Monitor 24 inch FHD',
            'unit'        => 'Unit',
            'description' => 'Monitor LCD 24 inch',
        ]);

        $itemKertas = DB::table('master_items')->insertGetId([
            'id_category' => $catOffice,
            'item_code'   => 'OS-001',
            'item_name'   => 'Kertas A4 80gsm',
            'unit'        => 'Rim',
            'description' => 'Kertas fotokopi A4',
        ]);

        // -------------------------------------------------------
        // BATCH (RFQ)
        // -------------------------------------------------------
        $batchId = DB::table('batches')->insertGetId([
            'batch_number' => 'BATCH-' . now()->format('Ymd') . '-0001',
            'title'        => 'Pengadaan Peralatan IT Q1 2026',
            'description'  => 'Pengadaan laptop dan monitor untuk kantor',
            'deadline'     => now()->addDays(14)->format('Y-m-d'),
            'status'       => 'open',
            'created_by'   => $adminId,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        // -------------------------------------------------------
        // BATCH CATEGORIES
        // -------------------------------------------------------
        $batchCatId = DB::table('batch_categories')->insertGetId([
            'id_batch'            => $batchId,
            'id_master_category'  => $catIT,
        ]);

        // -------------------------------------------------------
        // ITEMS BATCH CATEGORIES
        // -------------------------------------------------------
        DB::table('items_batch_categories')->insert([
            ['id_item' => $itemLaptop,  'id_batch_category' => $batchCatId, 'quantity' => 5],
            ['id_item' => $itemMonitor, 'id_batch_category' => $batchCatId, 'quantity' => 5],
        ]);

        // -------------------------------------------------------
        // INVITED SUPPLIER CATEGORIES
        // -------------------------------------------------------
        DB::table('invited_supplier_categories')->insert([
            'id_supplier'       => $supplierId,
            'id_batch_category' => $batchCatId,
            'invited_at'        => now(),
            'status'            => 'invited',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        $this->command->info('✓ Seeder selesai!');
        $this->command->info('  Admin    : admin@rfqsystem.com  / admin123');
        $this->command->info('  Supplier : supplier@demo.com    / supplier123');
    }
}