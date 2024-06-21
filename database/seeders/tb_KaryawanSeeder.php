<?php

namespace Database\Seeders;

use App\Models\Karyawan_Model;
use Illuminate\Database\Seeder;

class tb_KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $karyawanList = [
            [
                'na_karyawan' => 'Seli',
                'tlah_karyawan' => 'City',
                'tglah_karyawan' => '1990-05-05',
                'agama_karyawan' => 'Islam',
                'alamat_karyawan' => '123 Main St',
                'notelp_karyawan' => '123456789',
                'foto_karyawan' => null
            ],
            [
                'na_karyawan' => 'Jane Smith',
                'tlah_karyawan' => 'Town',
                'tglah_karyawan' => '1992-05-10',
                'agama_karyawan' => 'Christian',
                'alamat_karyawan' => '456 Elm St',
                'notelp_karyawan' => '987654321',
                'foto_karyawan' => null
            ],
        ]; // Example karyawan values

        foreach ($karyawanList as $karyawan) {
            Karyawan_Model::create($karyawan);
        }
    }
}
