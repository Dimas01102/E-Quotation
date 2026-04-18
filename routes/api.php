<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\AdminProfileController;
use App\Http\Controllers\Api\Admin\SupplierController;
use App\Http\Controllers\Api\Admin\MasterCategoryController;
use App\Http\Controllers\Api\Admin\MasterItemController;
use App\Http\Controllers\Api\Admin\BatchController;
use App\Http\Controllers\Api\Admin\QuotationController;
use App\Http\Controllers\Api\Admin\ReportController;
use App\Http\Controllers\Api\Admin\RfqTemplateController;
use App\Http\Controllers\Api\Supplier\SupplierDashboardController;
use App\Http\Controllers\Api\Supplier\SupplierProfileController;
use App\Http\Controllers\Api\Supplier\SupplierRfqController;
use App\Http\Controllers\Api\Supplier\SupplierQuotationController;
use App\Http\Controllers\Api\Supplier\SupplierPurchaseOrderController;
use App\Http\Controllers\Api\Supplier\SupplierRfqTemplateController;

// ── Public ────────────────────────────────────────────────────────────
Route::post('/login',    [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// ── Authenticated ─────────────────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    // ── ADMIN ─────────────────────────────────────────────────────
    Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->prefix('admin')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index']);
        Route::put('/profile', [AdminProfileController::class, 'update']);

        // Supplier
        Route::get('/suppliers',                    [SupplierController::class, 'index']);
        Route::get('/suppliers/{id}',               [SupplierController::class, 'show']);
        Route::put('/suppliers/{id}/toggle-status', [SupplierController::class, 'toggleStatus']);

        // Master Category
        Route::get('/master-categories',            [MasterCategoryController::class, 'index']);
        Route::post('/master-categories',           [MasterCategoryController::class, 'store']);
        Route::put('/master-categories/{id}',       [MasterCategoryController::class, 'update']);
        Route::delete('/master-categories/{id}',    [MasterCategoryController::class, 'destroy']);

        // Master Items
        Route::get('/master-items',                 [MasterItemController::class, 'index']);
        Route::post('/master-items',                [MasterItemController::class, 'store']);
        Route::put('/master-items/{id}',            [MasterItemController::class, 'update']);
        Route::delete('/master-items/{id}',         [MasterItemController::class, 'destroy']);

        // RFQ Templates
        Route::get('/rfq-templates',                [RfqTemplateController::class, 'index']);
        Route::post('/rfq-templates',               [RfqTemplateController::class, 'store']);
        Route::post('/rfq-templates/{id}',          [RfqTemplateController::class, 'update']);
        Route::delete('/rfq-templates/{id}',        [RfqTemplateController::class, 'destroy']);

        // Batch (RFQ)
        Route::get('/batches',                                           [BatchController::class, 'index']);
        Route::post('/batches',                                          [BatchController::class, 'store']);
        Route::get('/batches/{id}',                                      [BatchController::class, 'show']);
        Route::put('/batches/{id}',                                      [BatchController::class, 'update']);
        Route::delete('/batches/{id}',                                   [BatchController::class, 'destroy']);

        Route::post('/batches/{id}/categories',                          [BatchController::class, 'addCategory']);
        Route::delete('/batches/{id}/categories/{catId}',                [BatchController::class, 'removeCategory']);
        Route::post('/batches/{id}/categories/{catId}/items',            [BatchController::class, 'addItem']);
        Route::delete('/batches/{id}/categories/{catId}/items/{itemId}', [BatchController::class, 'removeItem']);

        Route::post('/batches/{id}/invite',                              [BatchController::class, 'inviteSupplier']);
        Route::get('/batches/{id}/compare',                              [BatchController::class, 'compare']);
        Route::post('/batches/{id}/send-reminder',                       [BatchController::class, 'sendWinnerReminder']);

        // Quotation 
        Route::get('/quotations',                       [QuotationController::class, 'index']);
        Route::get('/quotations/compare/{batchId}',     [QuotationController::class, 'compare']);   // ← DIPINDAH KE ATAS
        Route::get('/quotations/{id}',                  [QuotationController::class, 'show']);       // ← setelah compare
        Route::put('/quotations/{id}/approve',          [QuotationController::class, 'approve']);
        Route::put('/quotations/{id}/reject',           [QuotationController::class, 'reject']);

        // Reports
        Route::get('/reports',                          [ReportController::class, 'index']);
        Route::get('/reports/export-pdf',               [ReportController::class, 'exportPdf']);
    });

    // ── SUPPLIER ──────────────────────────────────────────────────
    Route::middleware(\App\Http\Middleware\SupplierMiddleware::class)->prefix('supplier')->group(function () {

        Route::get('/dashboard',                        [SupplierDashboardController::class, 'index']);

        Route::get('/profile',                          [SupplierProfileController::class, 'show']);
        Route::put('/profile',                          [SupplierProfileController::class, 'update']);

        Route::get('/rfq',                              [SupplierRfqController::class, 'index']);
        Route::get('/rfq/{id}',                         [SupplierRfqController::class, 'show']);
        Route::get('/rfq/{id}/template',                [SupplierRfqController::class, 'downloadTemplate']);

        Route::get('/quotations',                       [SupplierQuotationController::class, 'index']);
        Route::post('/quotations',                      [SupplierQuotationController::class, 'store']);

        Route::get('/purchase-orders',                  [SupplierPurchaseOrderController::class, 'index']);
        Route::get('/purchase-orders/{id}/download',    [SupplierPurchaseOrderController::class, 'download']);

        Route::get('/rfq-templates',                    [SupplierRfqTemplateController::class, 'index']);
        Route::get('/rfq-templates/{id}/download',      [SupplierRfqTemplateController::class, 'download']);
    });
});
