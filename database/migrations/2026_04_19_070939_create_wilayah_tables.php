<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // provinsi
Schema::create('provinsi', function (Blueprint $table) {
    $table->id('id_provinsi');  // auto-increment BIGINT
    $table->string('kode', 10)->unique();  // kode dari API (35, 11, dll)
    $table->string('nama_provinsi', 50);
    $table->timestamps();
});

// kabupaten
Schema::create('kabupaten', function (Blueprint $table) {
    $table->id('id_kabupaten');  // auto-increment
    $table->string('kode', 20)->unique();  // kode dari API (35.01, 11.05)
    $table->string('nama_kabupaten', 50);
    $table->unsignedBigInteger('provinsi_id');  // foreign key ke provinsi
    $table->timestamps();

    $table->foreign('provinsi_id')
          ->references('id_provinsi')
          ->on('provinsi')
          ->onDelete('cascade');
});

// kecamatan
Schema::create('kecamatan', function (Blueprint $table) {
    $table->id('id_kecamatan');  // auto-increment
    $table->string('kode', 20)->unique();  // kode dari API (35.01.01)
    $table->string('nama_kecamatan', 50);
    $table->unsignedBigInteger('kabupaten_id');  // foreign key ke kabupaten
    $table->timestamps();

    $table->foreign('kabupaten_id')
          ->references('id_kabupaten')
          ->on('kabupaten')
          ->onDelete('cascade');
});
    }

    public function down(): void
    {
        Schema::dropIfExists('kecamatan');
        Schema::dropIfExists('kabupaten');
        Schema::dropIfExists('provinsi');
    }
};
