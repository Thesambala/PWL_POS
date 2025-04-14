<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];

        $userIds = DB::table('m_user')->pluck('user_id')->toArray(); // Ambil user_id yang valid
        $supplierIds = DB::table('m_supplier')->pluck('supplier_id')->toArray(); // Ambil supplier_id yang valid

        for ($i = 1; $i <= 15; $i++) {
            $data[] = [
                'supplier_id' => rand(1,3) , // Ambil supplier yang ada
                'barang_id' => $i,
                'user_id' => rand(1,3), // Ambil user yang ada
                'stok_tanggal' => now(),
                'stok_jumlah' => rand(50, 200),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('t_stok')->insert($data);
    }
}