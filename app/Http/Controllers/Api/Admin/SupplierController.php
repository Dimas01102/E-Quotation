<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\User;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SupplierController extends Controller
{
    public function index()
    {
        // Load relasi user agar is_active bisa diakses
        $suppliers = Supplier::with('user')
            ->orderByDesc('created_at')
            ->get();

        return response()->json(['suppliers' => $suppliers]);
    }

    public function show($id)
    {
        $supplier = Supplier::with('user')->findOrFail($id);
        return response()->json(['supplier' => $supplier]);
    }

    public function toggleStatus(Request $request, $id)
    {
        $supplier = Supplier::with('user')->findOrFail($id);

        $request->validate(['is_active' => 'required|in:0,1']);

        $user = User::findOrFail($supplier->user_id);

        $user->update(['is_active' => (int) $request->is_active]);

        if ((int) $request->is_active === 1) {
            try {
                $mail = new MailService();
                $mail->sendSupplierActivated($user->email, $user->name);
            } catch (\Exception $e) {
                Log::warning('Email aktivasi gagal: ' . $e->getMessage());
            }
        }

        return response()->json([
            'message'   => $request->is_active == 1 ? 'Supplier diaktifkan.' : 'Supplier dinonaktifkan.',
            'is_active' => (int) $request->is_active,
        ]);
    }
}