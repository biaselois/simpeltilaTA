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
        Schema::create('berita_acaras', function (Blueprint $table) {
                $table->id();
                $table->foreignId('jadwal_id')->constrained()->onDelete('cascade');
                // $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->date('tanggal');
                $table->string('Nama_WP');
                $table->text('Alamat_WP');
                $table->string('NOP');
                $table->string('Alamat_OP');
                $table->string('Tujuan');
                $table->text('Hasil');
                $table->text('Rekomendasi');
                $table->string('dokumentasi');
                $table->string('Signature_WP');
                $table->enum('Validasi_Kasi', ['menunggu', 'validasi'])->default('menunggu');
                $table->enum('Validasi_Kabid', ['menunggu', 'validasi'])->default('menunggu');
                $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita_acaras');
    }
};
