<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil daftar penjualan_id dan barang_id dari database agar valid
        $penjualanIds = DB::table('t_penjualan')->pluck('penjualan_id')->toArray();
        $barangIds = DB::table('m_barang')->pluck('barang_id')->toArray();

        // Cek apakah tabel terkait memiliki data
        if (empty($penjualanIds) || empty($barangIds)) {
            echo "Seeder dihentikan: Data tidak ditemukan di t_penjualan atau m_barang.\n";
            return;
        }

        $data = [];

        foreach ($penjualanIds as $penjualan_id) {
            for ($j = 1; $j <= 3; $j++) { // 3 barang per transaksi
                $barang_id = $barangIds[array_rand($barangIds)]; // Ambil barang_id yang valid

                $data[] = [
                    'penjualan_id' => $penjualan_id,
                    'barang_id' => $barang_id,
                    'harga' => rand(5000, 50000),
                    'jumlah' => rand(1, 5),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('t_penjualan_detail')->insert($data);
    }
}