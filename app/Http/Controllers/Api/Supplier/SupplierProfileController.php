<?php

namespace App\Http\Controllers\Api\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SupplierProfileController extends Controller
{
    public function show()
    {
        $user     = Auth::user();
        $supplier = Supplier::where('user_id', $user->id)->firstOrFail();

        return response()->json([
            'success'  => true,
            'supplier' => $supplier,  
            'user'     => [
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
            'name'           => 'required|string|max:255',
            'company_name'   => 'required|string|max:255',
            'phone'          => ['required', 'string', 'max:20', Rule::unique('suppliers', 'phone')->ignore($supplier->id)],
            'npwp'           => ['nullable', 'string', 'max:30', Rule::unique('suppliers', 'npwp')->ignore($supplier->id)],
            'address'        => 'nullable|string',
            'business_field' => 'nullable|string|max:150', 
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8';
        }

        $request->validate($rules, [
            'phone.unique' => 'Nomor HP sudah digunakan oleh akun lain.',
            'npwp.unique'  => 'NPWP sudah terdaftar atas supplier lain.',
        ]);

        // Update nama (dan password jika diisi)
        $userUpdate = ['name' => $request->name];
        if ($request->filled('password')) {
            $userUpdate['password'] = Hash::make($request->password);
        }
        User::where('id', $user->id)->update($userUpdate);

        $supplier->update([
            'company_name'   => $request->company_name,
            'phone'          => $request->phone,
            'npwp'           => $request->npwp,
            'address'        => $request->address,
            'business_field' => $request->business_field, 
        ]);

        $freshUser     = User::find($user->id);
        $freshSupplier = $supplier->fresh();

        return response()->json([
            'success'  => true,
            'message'  => 'Profil berhasil diperbarui.',
            'supplier' => $freshSupplier,
            'user'     => [
                'id'        => $freshUser->id,
                'name'      => $freshUser->name,
                'email'     => $freshUser->email,
                'is_active' => (int) $freshUser->is_active,
            ],
            'is_active' => (int) $freshUser->is_active,
        ]);
    }
}