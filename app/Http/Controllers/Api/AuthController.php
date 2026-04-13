<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Supplier;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // POST /api/login
    public function login(Request $request): JsonResponse
    {
        $v = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($v->fails()) {
            return response()->json(['success' => false, 'errors' => $v->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Email atau password salah.'], 401);
        }

        if (!$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda belum aktif. Tunggu konfirmasi admin.',
            ], 403);
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return response()->json([
            'success'  => true,
            'message'  => 'Login berhasil.',
            'role'     => $user->role,
            'redirect' => $user->role === 'admin' ? '/admin/dashboard' : '/supplier/dashboard',
        ]);
    }

    // POST /api/register
    public function register(Request $request): JsonResponse
    {
        $v = Validator::make($request->all(), [
            'name'         => 'required|string|max:100',
            'email'        => 'required|email|max:100|unique:users,email',
            'password'     => 'required|string|min:8|confirmed',
            // Kolom suppliers: company_name, phone, address, npwp
            'company_name' => 'required|string|max:150',
            'phone'        => 'required|string|max:50',
            'address'      => 'nullable|string',
            'npwp'         => 'nullable|string|max:50',
        ], [
            'email.unique'       => 'Email sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($v->fails()) {
            return response()->json(['success' => false, 'errors' => $v->errors()], 422);
        }

        try {
            // users.is_active = false → pending verifikasi admin
            $user = new User();
            $user->name      = $request->name;
            $user->email     = $request->email;
            $user->password  = Hash::make($request->password);
            $user->role      = 'supplier';
            $user->is_active = false;
            $user->created_at = now();
            $user->updated_at = now();
            $user->save();

            // suppliers
            $supplier = new Supplier();
            $supplier->user_id      = $user->id;
            $supplier->company_name = $request->company_name;
            $supplier->phone        = $request->phone;
            $supplier->address      = $request->address;
            $supplier->npwp         = $request->npwp;
            $supplier->created_at   = now();
            $supplier->updated_at   = now();
            $supplier->save();

            try {
                app(MailService::class)->sendSupplierRegistered(
                    $user->email, $user->name, $request->company_name
                );
            } catch (\Throwable $e) {
                Log::warning('[Register] Email gagal: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil! Akun Anda sedang diverifikasi oleh admin.',
            ], 201);

        } catch (\Throwable $e) {
            Log::error('[Register] Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    // POST /api/logout
    public function logout(Request $request): JsonResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['success' => true, 'redirect' => '/login']);
    }

    // GET /api/auth/me
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        $data = [
            'id'        => $user->id,
            'name'      => $user->name,
            'email'     => $user->email,
            'role'      => $user->role,
            'is_active' => $user->is_active,
        ];

        if ($user->role === 'supplier' && $user->supplier) {
            $s = $user->supplier;
            $data['supplier'] = [
                'id'           => $s->id,
                'company_name' => $s->company_name,
                'phone'        => $s->phone,
                'address'      => $s->address,
                'npwp'         => $s->npwp,
                'status'       => $user->is_active ? 'active' : 'inactive',
            ];
        }

        return response()->json(['success' => true, 'data' => $data]);
    }
}