<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //Medapatkan seluruh user
    public function index()
    {
        $user_data = User::with('roles')->latest()->get();
        $user_data = $user_data->map(function($user){
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => optional($user->roles->first())->name ?? 'No Role'
            ];
        });

        return response()->json([
            'status_code' => 200,
            'message' => "Data user",
            'data_user' => $user_data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
         // Buat user dengan data dari request
         $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'email_verified_at' => now()
        ]);

        // Pastikan role yang dipilih ada di database
        $role = Role::find($request->role);

        if ($role) {
            $user->assignRole($role->name);
        }

        // Buat token unik
        // $user->email_verification_token = hash_hmac('sha256', $user->id . now(), env('APP_KEY'));
        // $user->save();
        // // Kirim email verifikasi
        // Mail::to($user->email)->send(new VerifyEmail($user));

        return response()->json([
            'status_code' => 201,
            'message' => 'Registrasi User berhasil',
            'data_user' => $user
        ], 201);   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data_user = User::find($id);

        //Cek data sesuai ID
        if(empty($data_user)){
            return response()->json([
                'status_code' => 404,
                'message' => 'Data user tidak ditemukan!'
            ], 404);
        }

        $data_user = $data_user->where('id', $id)->get();
        $data_user = $data_user->map(function($user){
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->roles->first()->name
            ];
        });

        return response()->json([
            'status_code' => 200,
            'message' => 'Data user berhasil ditemukan',
            'data_user' => $data_user
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Cek apakah user yang sedang login mencoba menghapus dirinya sendiri
        // if ($user->id === auth()->id()) {
        //     return response()->json([
        //         'status_code' => 403,
        //         'message' => 'Anda tidak bisa menghapus akun Anda sendiri'
        //     ], 403);
        // }

        // Cek apakah user yang akan dihapus adalah super-admin
        // if ($user->hasRole('superadmin')) {
        //     return response()->json([
        //         'status_code' => 403,
        //         'message' => 'Super Admin tidak bisa dihapus'
        //     ], 403);
        // }

        // Hapus semua role yang dimiliki user sebelum menghapus user
        $user->roles()->detach();

        // Hapus user
        $user->delete();

        return response()->json([
            'status_code' => 200,
            'message' => 'User berhasil dihapus'
        ],200);
    }
}
