<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id('id_produk');
            $table->string('nama_produk', 30);
            $table->text('deskripsi')->nullable();
            $table->integer('harga');
            $table->integer('stok');
            $table->string('foto_produk', 200)->nullable();
            $table->timestamps();
            $table->char('is_deleted', 1)->default('0');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
