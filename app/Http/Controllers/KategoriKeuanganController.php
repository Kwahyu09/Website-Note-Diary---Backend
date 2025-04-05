<?php

namespace App\Http\Controllers;

use App\Http\Requests\KategoriKeuanganRequest;
use App\Models\Kategorikeuangan;
use Illuminate\Http\Request;

class KategoriKeuanganController extends Controller
{
    //get all data kategori keuangan
    public function index(Request $request)
    {
        $jenis = $request->query('jenis');

        if ($jenis && in_array($jenis, ['masuk', 'keluar'])) {
            $data = KategoriKeuangan::where('jenis', $jenis)->latest()->get();
        } else {
            $data = Kategorikeuangan::latest()->get();
        }

        if ($data->isEmpty()) {
            return response()->json([
                "status_code" => 200,
                "message" => "Data Kategori Keuangan masih kosong!"
            ], 200);
        }
        return response()->json([
            'status_code' => 200,
            'message' => "Data Kategori Keuangan",
            'data' => $data
        ], 200);
    }

    //insert data kategori keuangan
    public function store(KategoriKeuanganRequest $request)
    {
        $kategori = KategoriKeuangan::create($request->validated());

        return response()->json([
            'status_code' => 201,
            'message' => 'Kategori keuangan berhasil ditambahkan.',
            'data' => $kategori
        ], 201);
    }

    //show data kategori keuangan
    public function show($id)
    {
        $kategori = KategoriKeuangan::find($id);

        //Cek data
        if(empty($kategori)){
            return response()->json([
                'status_code' => 200,
                'message' => 'Data Kategori Keuangan tidak ditemukan!'
            ], 200);
        }
        return response()->json([
            'status_code' => 200,
            'message' => "Data Kategori Keuangan Ditemukan",
            'data' => $kategori
        ], 200);
    }

    //update data kategori keuangan
    public function update(KategoriKeuanganRequest $request, $id)
    {
        $kategori = KategoriKeuangan::find($id);

        if (!$kategori) {
            return response()->json([
                'status_code' => 404,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $kategori->update($request->validated());

        return response()->json([
            'status_code' => 200,
            'message' => 'Kategori keuangan berhasil diperbarui.',
            'data' => $kategori
        ],200);
    }

    //delete data kategori keuangan
    public function destroy($id)
    {
        $kategori = KategoriKeuangan::find($id);
        if (!$kategori) {
            return response()->json([
                'status_code' => 404,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $kategori->delete();
        return response()->json([
            'status_code' => 200,
            'message' => 'Kategori keuangan berhasil dihapus.'
        ],200);
    }
}
