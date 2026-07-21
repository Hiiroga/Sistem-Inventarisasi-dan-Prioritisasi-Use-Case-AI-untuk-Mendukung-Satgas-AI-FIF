<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('risiko_etika_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('use_case_id')->unique()->constrained('use_cases')->cascadeOnDelete();
            $table->boolean('menggunakan_data_pribadi')->default(false);
            $table->string('jenis_data_sensitif', 150)->nullable();
            $table->enum('risiko_privasi', ['Rendah', 'Sedang', 'Tinggi'])->nullable();
            $table->enum('risiko_bias', ['Rendah', 'Sedang', 'Tinggi'])->nullable();
            $table->enum('risiko_ketergantungan_ai', ['Rendah', 'Sedang', 'Tinggi'])->nullable();
            $table->enum('risiko_kesalahan_output', ['Rendah', 'Sedang', 'Tinggi'])->nullable();
            $table->boolean('perlu_validasi_manusia')->default(false);
            $table->boolean('perlu_persetujuan_pengguna')->default(false);
            $table->text('rekomendasi_mitigasi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('risiko_etika_details');
    }
};
