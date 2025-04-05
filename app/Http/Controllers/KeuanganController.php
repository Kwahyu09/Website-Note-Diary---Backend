<?php

namespace App\Http\Controllers;

use App\Http\Requests\KeuanganRequest;
use App\Models\Keuangan;
class KeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Keuangan::with(['kategori'])->get();

        $mapped = $data->map(function ($item) {
            return [
                'id' => $item->id,
                'tanggal' => $item->tanggal,
                'kategori' => $item->kategori->name ." - ". $item->kategori->jenis,
                'jumlah' => $item->jumlah,
                'keterangan' => $item->keterangan,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        });

        return response()->json([
            'status_code' => 200,
            'message' => "Data Keuangan Masuk & Keluar",
            'data' => $mapped
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KeuanganRequest $request)
    {
        $keuangan = Keuangan::create($request->validated());

        return response()->json([
            'status_code' => 201,
            'message' => 'Data keuangan berhasil ditambahkan.',
            'data' => $keuangan
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $keuangan = Keuangan::with(['kategori'])->find($id);

        //Cek data
        if(empty($keuangan)){
            return response()->json([
                'status_code' => 200,
                'message' => 'Data Keuangan tidak ditemukan!'
            ], 200);
        }

        $data = [
            'id' => $keuangan->id,
            'tanggal' => $keuangan->tanggal,
            'kategori' => $keuangan->kategori->name ." - ". $keuangan->kategori->jenis,
            'jumlah' => $keuangan->jumlah,
            'keterangan' => $keuangan->keterangan,
            'created_at' => $keuangan->created_at,
            'updated_at' => $keuangan->updated_at,
        ];

        return response()->json([
            'status_code' => 200,
            'message' => "Data Keuangan Masuk & Keluar",
            'data' => $data
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KeuanganRequest $request, $id)
    {
        $keuangan = Keuangan::find($id);

        //Cek data
        if(empty($keuangan)){
            return response()->json([
                'status_code' => 200,
                'message' => 'Data Keuangan tidak ditemukan!'
            ], 200);
        }

        $keuangan->update($request->validated());

        return response()->json([
            'status_code' => 200,
            'message' => "Data Keuangan berhasil diperbarui",
            'data' => $keuangan
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $keuangan = Keuangan::find($id);
        if (!$keuangan) {
            return response()->json([
                'status_code' => 404,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $keuangan->delete();
        return response()->json([
            'status_code' => 200,
            'message' => 'Data keuangan berhasil dihapus.'
        ],200);
    }
}
