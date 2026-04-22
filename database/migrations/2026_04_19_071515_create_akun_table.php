<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('akun', function (Blueprint $table) {
            $table->id('id_akun');
            $table->string('nama_lengkap', 50);
            $table->string('email', 50)->unique();
            $table->string('password', 255)->nullable();
            $table->string('no_telp', 13)->nullable();
            $table->string('alamat', 50)->nullable(); 
            $table->char('is_admin', 1)->default('0');

            // KOLOM UNTUK GOOGLE OAUTH
            $table->string('google_id')->nullable()->unique();
            $table->string('google_token')->nullable();
            $table->string('google_refresh_token')->nullable();
            $table->string('avatar')->nullable();

            $table->unsignedBigInteger('kecamatan_id')->nullable();
            $table->timestamps();

            $table->foreign('kecamatan_id')
                  ->references('id_kecamatan')
                  ->on('kecamatan')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('akun');
    }
};
