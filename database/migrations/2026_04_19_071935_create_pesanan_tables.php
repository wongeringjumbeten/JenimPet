<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->timestamp('tanggal_pesanan');
            $table->integer('total_pembayaran');

            // ⬇️ TAMBAHKAN DEFAULT VALUE
            $table->enum('status_pesanan', [
                'pengecekan pembayaran',
                'diproses',
                'diantar'
            ])->default('pengecekan pembayaran'); // ⬅️ INI PENTING!

            $table->string('nomor_resi', 50)->nullable();
            $table->text('catatan')->nullable();
            $table->unsignedBigInteger('akun_id');
            $table->timestamps();

            $table->foreign('akun_id')
                  ->references('id_akun')
                  ->on('akun')
                  ->onDelete('cascade');
        });

        Schema::create('detailpesanan', function (Blueprint $table) {
            $table->id('id_detailpesanan');
            $table->integer('kuantitas_pembelian');
            $table->integer('harga_satuan');
            $table->unsignedBigInteger('pesanan_id');
            $table->unsignedBigInteger('produk_id');
            $table->timestamps();

            $table->foreign('pesanan_id')
                  ->references('id_pesanan')
                  ->on('pesanan')
                  ->onDelete('cascade');

            $table->foreign('produk_id')
                  ->references('id_produk')
                  ->on('produk')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detailpesanan');
        Schema::dropIfExists('pesanan');
    }
};
