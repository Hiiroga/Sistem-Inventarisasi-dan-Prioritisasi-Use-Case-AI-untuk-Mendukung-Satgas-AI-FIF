<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('use_cases', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10)->unique();
            $table->string('nama_use_case', 150);
            $table->text('deskripsi');
            $table->text('latar_belakang_masalah')->nullable();
            $table->text('tujuan_use_case')->nullable();
            $table->string('pengusul', 100);
            $table->string('unit_terkait', 100);
            $table->string('target_pengguna', 150)->nullable();
            $table->foreignId('kategori_id')->constrained('kategories')->cascadeOnDelete();
            $table->string('teknologi_ai', 150)->nullable();
            $table->enum('status', ['Ide', 'Direncanakan', 'Prototype', 'Implementasi'])->default('Ide');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('use_cases');
    }
};