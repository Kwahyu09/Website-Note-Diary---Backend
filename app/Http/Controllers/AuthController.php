<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //login  menghasilkan token
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status_code' => 401,
                'message' => 'Email atau password salah'
            ], 401);
        }

        // Cek apakah email sudah diverifikasi
        if (!$user->email_verified_at) {
            return response()->json([
                'status_code' => 403,
                'message' => 'Silakan verifikasi email Anda terlebih dahulu'
            ], 403);
        }

        //buat token
        $token = $user->createToken('namaapk-gfdkla-391hfashdfaklfhkajshfkasdfa', ['*'], now()->addDay())->plainTextToken;

        return response()->json([
            'status_code' => 200,
            'message' => 'Login berhasil',
            'token' => $token
        ], 200);
    }

    // LOGOUT -> Menghapus Token
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status_code' => 200,
            'message' => 'Logout berhasil'
        ], 200);
    }
}
