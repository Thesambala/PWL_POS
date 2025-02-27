<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];

        for ($i = 1; $i <= 3; $i++) { // 3 kategori
            for ($j = 1; $j <= 5; $j++) { // 5 barang per kategori
                $data[] = [
                    'kategori_id' => $i, 
                    'barang_kode' => Str::random(8), 
                    'barang_nama' => "Barang {$i}{$j}",
                    'harga_beli' => rand(5000, 25000), 
                    'harga_jual' => rand(30000, 50000), 
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('m_barang')->insert($data);
    }
}