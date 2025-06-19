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
        Schema::create('submission_lists', function (Blueprint $table) {
            $table->id();
            $table->string('submission_name');
            $table->string('email') ->nullable();
            $table->string('nohp') ->nullable();
            $table->string('namappat') ->nullable();
            $table->string('nosertifikat') ->nullable();
            $table->string('latitude') ->nullable();
            $table->string('longitude') ->nullable();
            $table->string('luastanah') ->nullable();
            $table->string('luasbangunan') ->nullable();
            $table->string('listrik') ->nullable();
            $table->string('tahundibangun') ->nullable();
            $table->string('fotoobjek') ->nullable();
            $table->string('sertifikat') ->nullable();
            $table->string('sppt') ->nullable();
            $table->string('bidang') ->nullable();
            $table->bigInteger('distributed_to') ->nullable();
            $table->enum('status', ['waiting', 'approval', 'rejected'])->default('waiting');
            $table->string('note') ->nullable();
            $table->bigInteger('approve_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submission_lists');
    }
};
