<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian_prioritas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('use_case_id')->unique()->constrained('use_cases')->cascadeOnDelete();
            $table->unsignedTinyInteger('dampak')->nullable();
            $table->unsignedTinyInteger('kelayakan')->nullable();
            $table->unsignedTinyInteger('ketersediaan_data')->nullable();
            $table->unsignedTinyInteger('kesiapan_sdm')->nullable();
            $table->unsignedTinyInteger('kesiapan_infrastruktur')->nullable();
            $table->unsignedTinyInteger('urgensi')->nullable();
            $table->unsignedTinyInteger('risiko_etika_skor')->nullable();
            $table->unsignedTinyInteger('kompleksitas_teknis')->nullable();
            $table->string('estimasi_waktu', 20)->nullable();
            $table->string('estimasi_biaya', 20)->nullable();
            $table->integer('skor_prioritas')->nullable();
            $table->string('level_prioritas', 10)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian_prioritas');
    }
};