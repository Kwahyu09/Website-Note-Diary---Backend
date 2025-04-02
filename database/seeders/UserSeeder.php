<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Dinas',
            'email' => 'admindinas@gmail.com',
            'password' => bcrypt('admindinas@2025#')
        ])->assignRole('admin');

        User::create([
            'name' => 'Staff Dinas',
            'email' => 'stafdinas@gmail.com',
            'password' => bcrypt('admindinas@2025#')
        ])->assignRole('staf');

        User::create([
            'name' => 'Krisna Wahyudi',
            'email' => 'krisnawahyudi2017@gmail.com',
            'password' => bcrypt('admindinas@2025#')
        ])->assignRole('pegawai');
    }
}
