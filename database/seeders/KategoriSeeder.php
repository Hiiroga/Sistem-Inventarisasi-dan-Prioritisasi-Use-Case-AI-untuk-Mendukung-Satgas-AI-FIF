<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            [
                'nama_kategori' => 'Pembelajaran',
                'deskripsi' => 'AI Teaching Assistant, generator soal, analisis tugas',
            ],
            [
                'nama_kategori' => 'Riset',
                'deskripsi' => 'Pemetaan riset dosen, rekomendasi kolaborasi, literature mining',
            ],
            [
                'nama_kategori' => 'Administrasi',
                'deskripsi' => 'Draft surat otomatis, chatbot layanan akademik',
            ],
            [
                'nama_kategori' => 'Layanan Mahasiswa',
                'deskripsi' => 'Chatbot akademik, rekomendasi topik TA, monitoring progres studi',
            ],
            [
                'nama_kategori' => 'Kurikulum',
                'deskripsi' => 'Analisis CPL, pemetaan bahan kajian, evaluasi RPS',
            ],
            [
                'nama_kategori' => 'Pengabdian Masyarakat',
                'deskripsi' => 'AI literacy untuk sekolah, AI4WellBeing',
            ],
            [
                'nama_kategori' => 'Tata Kelola',
                'deskripsi' => 'Dashboard AI readiness, monitoring aktivitas Satgas AI',
            ],
            [
                'nama_kategori' => 'Publikasi',
                'deskripsi' => 'AI disclosure checker, plagiarism support, paper assistant',
            ],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}
