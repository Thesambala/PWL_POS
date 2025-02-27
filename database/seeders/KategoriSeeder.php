<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kategori_kode' => 'ELEK', 'kategori_nama' => 'Elektronik'],
            ['kategori_kode' => 'PAKA', 'kategori_nama' => 'Pakaian'],
            ['kategori_kode' => 'MAKA', 'kategori_nama' => 'Makanan'],
            ['kategori_kode' => 'MINU', 'kategori_nama' => 'Minuman'],
            ['kategori_kode' => 'PERA', 'kategori_nama' => 'Perabotan'],
        ];

        DB::table('m_kategori')->insert($data);
    }
}