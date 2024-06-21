<?php

namespace Database\Seeders;

use App\Models\Jabatan_Model;
use Illuminate\Database\Seeder;

class tb_JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatanList = [
            ['CEO 1', 1],
            ['CTO 1', 2],
            ['CFO 1', null],
            ['WP Pemasaran 1', null],
            ['CMO 1', null],
            ['COO 1', null],
            ['OFFICE BOY 1', null],
        ];
        foreach ($jabatanList as $jabatan) {
            $model = new Jabatan_Model();
            $model->na_jabatan = $jabatan[0];
            $model->id_karyawan = $jabatan[1];
            $model->save();
        }

    }
}
