<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('transaksi_detail')) {
            Schema::create('transaksi_detail', function (Blueprint $table) {
                $table->id();
                $table->foreignId('transaksi_id')->constrained('transaksi')->onDelete('cascade');
                $table->foreignId('barang_id')->constrained('m_barang');
                $table->integer('jumlah');
                $table->integer('subtotal');
                $table->timestamps();
            });
    }
    }

    public function down(): void
    {
    Schema::table('transaksi_detail', function (Blueprint $table) {
        $table->dropForeign(['transaksi_id']);
    });
    
    Schema::dropIfExists('transaksi');
    }
};
