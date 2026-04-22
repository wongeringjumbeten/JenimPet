<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        //provinsi
        Schema::create('provinsi', function (Blueprint $table) {
            $table->id('id_provinsi');
            $table->string('nama_provinsi', 50);
            $table->timestamps();
        });

        //kabupaten
        Schema::create('kabupaten', function (Blueprint $table) {
            $table->id('id_kabupaten');
            $table->string('nama_kabupaten', 20);
            $table->unsignedBigInteger('provinsi_id');
            $table->timestamps();

            $table->foreign('provinsi_id')
                  ->references('id_provinsi')
                  ->on('provinsi')
                  ->onDelete('cascade');
        });

        //kecamatan
        Schema::create('kecamatan', function (Blueprint $table) {
            $table->id('id_kecamatan');
            $table->string('nama_kecamatan', 20);
            $table->unsignedBigInteger('kabupaten_id');
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
