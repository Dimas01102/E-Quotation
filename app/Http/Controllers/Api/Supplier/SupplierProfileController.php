<?php

namespace App\Http\Controllers\Api\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SupplierProfileController extends Controller
{
    public function show()
    {
        $user     = Auth::user();
        $supplier = Supplier::where('user_id', $user->id)->firstOrFail();

        return response()->json([
            'success'   => true,
            'supplier'  => $supplier,
            'user'      => [
                'id'        => $user->id,
                'name'      => $user->name,
                'email'     => $user->email,
                'is_active' => (int) $user->is_active,
                'role'      => $user->role,
            ],
            'is_active' => (int) $user->is_active,
        ]);
    }

    public function update(Request $request)
    {
        $user     = Auth::user();
        $supplier = Supplier::where('user_id', $user->id)->firstOrFail();

        $rules = [
            'name'         => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'phone'        => 'required|string|max:20',
            'npwp'         => 'nullable|string|max:30',
            'address'      => 'nullable|string',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8';
        }

        $request->validate($rules);

        // Update nama user
        $userUpdate = ['name' => $request->name];

        if ($request->filled('password')) {
            $userUpdate['password'] = Hash::make($request->password);
        }

        User::where('id', $user->id)->update($userUpdate);

        // Update supplier data
        $supplier->update([
            'company_name' => $request->company_name,
            'phone'        => $request->phone,
            'npwp'         => $request->npwp,
            'address'      => $request->address,
        ]);

        // Re-fetch data terbaru
        $freshUser     = User::find($user->id);
        $freshSupplier = $supplier->fresh();

        return response()->json([
            'success'   => true,
            'message'   => 'Profil berhasil diperbarui.',
            'supplier'  => $freshSupplier,
            'user'      => [
                'id'        => $freshUser->id,
                'name'      => $freshUser->name,
                'email'     => $freshUser->email,
                'is_active' => (int) $freshUser->is_active,
            ],
            'is_active' => (int) $freshUser->is_active,
        ]);
    }
}