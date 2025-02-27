<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PenjualanSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = DB::table('users')->pluck('id')->toArray();

        // Cek apakah ada user sebelum memasukkan data
        if (empty($userIds)) {
            echo "Seeder PenjualanSeeder dihentikan: Tidak ada data user di tabel users.\n";
            return;
        }

        $data = [];
        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'user_id' => $userIds[array_rand($userIds)], // Pilih user_id yang valid
                'pembeli' => "Pembeli {$i}",
                'penjualan_kode' => "PJ" . str_pad($i, 3, '0', STR_PAD_LEFT),
                'penjualan_tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('t_penjualan')->insert($data);
    }
}
