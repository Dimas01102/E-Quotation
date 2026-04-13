<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    // ─── Public ───────────────────────────────────────────────────────
    public function index()
    {
        return view('pages.index');
    }

    public function login()
    {
        return view('pages.auth.login');
    }

    public function register()
    {
        return view('pages.auth.register');
    }

    // ─── Admin ────────────────────────────────────────────────────────
    public function adminDashboard()
    {
        return view('pages.admin.dashboard');
    }

    public function adminSuppliers()
    {
        return view('pages.admin.suppliers');
    }

    // Master Data: Kategori & Item jadi SATU halaman "Master Data"
    public function adminMasterData()
    {
        return view('pages.admin.master-data');
    }

    // RFQ Management (Batch)
    public function adminBatches()
    {
        return view('pages.admin.batches');
    }

    public function adminBatchDetail($id)
    {
        return view('pages.admin.batch-detail', ['batchId' => $id]);
    }

    // Quotation Management
    public function adminQuotations()
    {
        return view('pages.admin.quotations');
    }

    public function adminCompare($id)
    {
        return view('pages.admin.compare', ['batchId' => $id]);
    }

    // Reports
    public function adminReports()
    {
        return view('pages.admin.reports');
    }

    // ─── Supplier ─────────────────────────────────────────────────────
    public function supplierDashboard()
    {
        return view('pages.supplier.dashboard');
    }

    public function supplierProfile()
    {
        return view('pages.supplier.profile');
    }

    public function supplierRfq()
    {
        return view('pages.supplier.invitations');
    }

    public function supplierRfqDetail($id)
    {
        return view('pages.supplier.invite-detail', ['inviteId' => $id]);
    }

    public function supplierQuotations()
    {
        return view('pages.supplier.quotations');
    }

    public function supplierPO()
    {
        return view('pages.supplier.purchase-orders');
    }
}