<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('t_penjualan', function (Blueprint $table) {
            $table->id('penjualan_id');
            $table->unsignedBigInteger('user_id')->index();
            $table->string('pembeli', 50)->unique();
            $table->string('penjualan_kode', 20);
            $table->dateTime('penjualan_tanggal');
            $table->timestamps();

            // Foreign Key ke tabel users (sesuaikan dengan tabel yang benar)
            $table->foreign('user_id')->references('user_id')->on('m_user');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_penjualan');
    }
};
