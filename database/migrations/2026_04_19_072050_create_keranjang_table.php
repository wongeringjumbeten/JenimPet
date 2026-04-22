<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keranjang', function (Blueprint $table) {
            $table->id('id_keranjang');
            $table->integer('kuantitas');
            $table->char('is_selected', 1)->default('0');
            $table->unsignedBigInteger('akun_id_akun');
            $table->unsignedBigInteger('produk_id_produk');
            $table->timestamps();

            $table->foreign('akun_id_akun')
                  ->references('id_akun')
                  ->on('akun')
                  ->onDelete('cascade');

            $table->foreign('produk_id_produk')
                  ->references('id_produk')
                  ->on('produk')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keranjang');
    }
};
