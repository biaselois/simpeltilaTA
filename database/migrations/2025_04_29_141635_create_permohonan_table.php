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
    Schema::create('permohonans', function (Blueprint $table) {
        $table->id();
        $table->string('nomordokumen')->unique();
        $table->string('nama_wp');
        $table->string('alamat_wp');
        $table->string('nop');
        $table->string('alamat_objek');
        $table->string('tujuan');
        $table->text('dokumen'); // File upload
        $table->enum('status', ['Menunggu', 'Dijadwalkan'])->default('Menunggu');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonans');
    }
};
