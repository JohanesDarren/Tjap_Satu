<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customer,email',
            'password' => 'required|string|min:6|confirmed',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $customer = Customer::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'is_admin' => false,
        ]);

        $token = $customer->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Registration successful',
            'data' => [
                'user' => [
                    'id' => $customer->id_cust,
                    'nama_lengkap' => $customer->nama_lengkap,
                    'email' => $customer->email,
                    'no_telp' => $customer->no_telp,
                    'alamat' => $customer->alamat,
                    'foto' => $customer->foto ? url('storage/' . $customer->foto) : null,
                ],
                'token' => $token,
            ]
        ], 201);
    }

    /**
     * Login user
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer || !Hash::check($request->password, $customer->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        // Delete old tokens
        $customer->tokens()->delete();

        $token = $customer->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => [
                    'id' => $customer->id_cust,
                    'nama_lengkap' => $customer->nama_lengkap,
                    'email' => $customer->email,
                    'no_telp' => $customer->no_telp,
                    'alamat' => $customer->alamat,
                    'foto' => $customer->foto ? url('storage/' . $customer->foto) : null,
                ],
                'token' => $token,
            ]
        ], 200);
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout successful'
        ], 200);
    }

    /**
     * Get authenticated user
     */
    public function user(Request $request)
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
            ]
        ], 200);
    }
}
