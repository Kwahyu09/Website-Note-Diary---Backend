<?php

namespace App\Http\Controllers;

use App\Http\Requests\TanggalRequest;
use App\Models\Keuangan;
use App\Models\RekapBulanan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RekapBulananController extends Controller
{
    // Hitung rekap berdasarkan input tanggal (bulan-tahun)
    public function hitungRekap(TanggalRequest $request)
    {
        $carbon = Carbon::parse($request->tanggal);
        $bulanTahun = $carbon->format('Y-m');

        // Ambil semua data keuangan di bulan & tahun tersebut
        $dataBulanIni = Keuangan::whereMonth('tanggal', $carbon->month)
                                ->whereYear('tanggal', $carbon->year)
                                ->with('kategori')
                                ->get();

        // Hitung total pemasukan dan pengeluaran bulan tersebut
        $totalMasuk = $dataBulanIni->filter(fn($item) => $item->kategori->jenis === 'masuk')->sum('jumlah');
        $totalKeluar = $dataBulanIni->filter(fn($item) => $item->kategori->jenis === 'keluar')->sum('jumlah');

        // Hitung saldo akhir dari seluruh data keuangan (bukan hanya bulan tersebut)
        $allData = Keuangan::with('kategori')->get();
        $totalMasukAll = $allData->filter(fn($item) => $item->kategori->jenis === 'masuk')->sum('jumlah');
        $totalKeluarAll = $allData->filter(fn($item) => $item->kategori->jenis === 'keluar')->sum('jumlah');
        $saldoAkhir = $totalMasukAll - $totalKeluarAll;

        // Simpan atau update ke rekap bulanan
        $rekap = RekapBulanan::updateOrCreate(
            ['bulantahun' => $bulanTahun],
            [
                'total_masuk' => $totalMasuk,
                'total_keluar' => $totalKeluar,
                'saldo_akhir' => $saldoAkhir,
            ]
        );

        return response()->json([
            'status_code' => 200,
            'message' => 'Rekap berhasil disimpan atau diperbarui.',
            'data' => $rekap,
        ],200);
    }

    //grafik kategori
    public function grafikKategori(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $query = DB::table('keuangan')
            ->join('kategori_keuangan', 'keuangan.kategori_id', '=', 'kategori_keuangan.id')
            ->select('kategori_keuangan.name as kategori', 'kategori_keuangan.jenis', DB::raw('SUM(keuangan.jumlah) as total'))
            ->groupBy('kategori_keuangan.name', 'kategori_keuangan.jenis');

        if ($bulan && $tahun) {
            $query->whereMonth('keuangan.tanggal', $bulan)
                ->whereYear('keuangan.tanggal', $tahun);
        }

        $data = $query->get();

        $grouped = [
            'masuk' => [],
            'keluar' => []
        ];

        foreach ($data as $item) {
            $grouped[$item->jenis][] = [
                'kategori' => $item->kategori,
                'total' => $item->total
            ];
        }

        return response()->json([
            'status_code' => 200,
            'message' => 'Rekap berhasil disimpan atau diperbarui.',
            'data' => $grouped
        ],200);
    }

    public function getRingkasanKeuangan()
    {
        // Ambil semua data keuangan dengan relasi ke kategori
        $data = Keuangan::with('kategori')->get();

        // Hitung total pemasukan dan pengeluaran
        $totalMasuk = $data->filter(fn($item) => $item->kategori->jenis === 'masuk')->sum('jumlah');
        $totalKeluar = $data->filter(fn($item) => $item->kategori->jenis === 'keluar')->sum('jumlah');

        // Hitung selisih saldo
        $saldo = $totalMasuk - $totalKeluar;

        return response()->json([
            'status_code' => 200,
            'message' => 'Ringkasan keuangan berhasil dihitung.',
            'data' => [
                'total_masuk' => $totalMasuk,
                'total_keluar' => $totalKeluar,
                'saldo' => $saldo,
            ]
        ]);
    }
}