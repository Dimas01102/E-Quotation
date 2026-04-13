<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

// ── Public ────────────────────────────────────────────────────────────
Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::get('/register', [PageController::class, 'register'])->name('register');

// ── Admin ─────────────────────────────────────────────────────────────
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard',             [PageController::class, 'adminDashboard'])->name('dashboard');
        Route::get('/suppliers',             [PageController::class, 'adminSuppliers'])->name('suppliers');
        Route::get('/master-data',           [PageController::class, 'adminMasterData'])->name('master-data');
        Route::get('/batches',               [PageController::class, 'adminBatches'])->name('batches');
        Route::get('/batches/{id}',          [PageController::class, 'adminBatchDetail'])->name('batch-detail');
        Route::get('/quotations',            [PageController::class, 'adminQuotations'])->name('quotations');
        Route::get('/batches/{id}/compare',  [PageController::class, 'adminCompare'])->name('compare');
        Route::get('/reports',               [PageController::class, 'adminReports'])->name('reports');
    });

// ── Supplier ──────────────────────────────────────────────────────────
Route::middleware(['auth', \App\Http\Middleware\SupplierMiddleware::class])
    ->prefix('supplier')
    ->name('supplier.')
    ->group(function () {
        Route::get('/dashboard',      [PageController::class, 'supplierDashboard'])->name('dashboard');
        Route::get('/profile',        [PageController::class, 'supplierProfile'])->name('profile');
        Route::get('/rfq',            [PageController::class, 'supplierRfq'])->name('rfq');
        Route::get('/rfq/{id}',       [PageController::class, 'supplierRfqDetail'])->name('rfq-detail');
        Route::get('/quotations',     [PageController::class, 'supplierQuotations'])->name('quotations');
        Route::get('/purchase-orders',[PageController::class, 'supplierPO'])->name('po');
    });