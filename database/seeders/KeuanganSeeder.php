<?php

namespace Database\Seeders;

use App\Models\Kategorikeuangan;
use App\Models\Keuangan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class KeuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = Kategorikeuangan::all();

        foreach (range(1, 30) as $i) {
            $kategoriDipilih = $kategori->random();

            $bulan = rand(1, 2);
            $tahun = 2025;
            $tanggal = Carbon::createFromDate($tahun, $bulan, rand(1, 28))->format('Y-m-d');

            Keuangan::create([
                'tanggal' => $tanggal,
                'kategori_id' => $kategoriDipilih->id,
                'jumlah' => rand(50000, 1000000),
                'keterangan' => fake()->sentence(),
            ]);
        }
    }
}
