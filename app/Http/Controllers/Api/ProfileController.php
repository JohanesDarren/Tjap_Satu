<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Get user profile
     */
    public function show(Request $request)
    {
        $customer = $request->user();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $customer->id_cust,
                'nama_lengkap' => $customer->nama_lengkap,
                'email' => $customer->email,
                'no_telp' => $customer->no_telp,
                'alamat' => $customer->alamat,
                'foto' => $customer->foto ? url('storage/' . $customer->foto) : null,
                'created_at' => $customer->created_at?->toISOString(),
            ]
        ], 200);
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        $customer = $request->user();

        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:customer,email,' . $customer->id_cust . ',id_cust',
            'no_telp' => 'sometimes|string|max:20',
            'alamat' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $customer->update($request->only(['nama_lengkap', 'email', 'no_telp', 'alamat']));

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => [
                'id' => $customer->id_cust,
                'nama_lengkap' => $customer->nama_lengkap,
                'email' => $customer->email,
                'no_telp' => $customer->no_telp,
                'alamat' => $customer->alamat,
                'foto' => $customer->foto ? url('storage/' . $customer->foto) : null,
            ]
        ], 200);
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $customer = $request->user();

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        if (!Hash::check($request->current_password, $customer->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect'
            ], 400);
        }

        $customer->password = Hash::make($request->new_password);
        $customer->save();

        // Revoke all tokens
        $customer->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully. Please login again.'
        ], 200);
    }

    /**
     * Update profile photo
     */
    public function updatePhoto(Request $request)
    {
        $customer = $request->user();

        $validator = Validator::make($request->all(), [
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Delete old photo if exists
            if ($customer->foto) {
                \Storage::disk('public')->delete($customer->foto);
            }

            $file = $request->file('foto');
            $filename = 'profile_' . $customer->id_cust . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profiles', $filename, 'public');

            $customer->foto = $path;
            $customer->save();

            return response()->json([
                'success' => true,
                'message' => 'Photo updated successfully',
                'data' => [
                    'foto' => url('storage/' . $path)
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload photo',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
