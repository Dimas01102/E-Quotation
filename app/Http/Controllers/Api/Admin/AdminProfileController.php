<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller; 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    public function update(Request $request)
    {   
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'name'                  => 'required|string|max:255',
            'password'              => 'nullable|string|min:8|confirmed',
        ]);

        $data = ['name' => $request->name];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui.',
            'user'    => ['name' => $user->name, 'email' => $user->email],
        ]);
    }
}