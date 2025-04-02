<?php

namespace Database\Seeders;

use App\Models\Kategorikeuangan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategorikeuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Gaji', 'jenis' => 'masuk'],
            ['name' => 'Bonus', 'jenis' => 'masuk'],
            ['name' => 'Freelance', 'jenis' => 'masuk'],
            ['name' => 'Makan', 'jenis' => 'keluar'],
            ['name' => 'Minum', 'jenis' => 'keluar'],
            ['name' => 'Transportasi', 'jenis' => 'keluar'],
            ['name' => 'Internet', 'jenis' => 'keluar'],
            ['name' => 'Listrik', 'jenis' => 'keluar'],
            ['name' => 'Keperluan Lainnya', 'jenis' => 'keluar'],
        ];

        foreach ($data as $item) {
            Kategorikeuangan::create($item);
        }
    }
}
