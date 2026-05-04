<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('akun', function (Blueprint $table) {
            // Tambah kolom detail alamat
            $table->text('detail_alamat')->nullable()->after('alamat');

            // Opsional: rename kolom alamat jadi jalan (biar ga ambigu)
            // $table->renameColumn('alamat', 'jalan');
        });
    }

    public function down(): void
    {
        Schema::table('akun', function (Blueprint $table) {
            $table->dropColumn('detail_alamat');
            // $table->renameColumn('jalan', 'alamat');
        });
    }
};
