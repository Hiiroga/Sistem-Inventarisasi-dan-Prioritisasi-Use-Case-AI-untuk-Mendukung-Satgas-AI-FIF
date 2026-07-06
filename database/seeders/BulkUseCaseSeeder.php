<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\UseCase;
use App\Models\PenilaianPrioritas;
use App\Models\RisikoEtikaDetail;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BulkUseCaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Pastikan 8 kategori sudah ada
        $kategoriList = [
            'Pembelajaran', 'Riset', 'Administrasi', 'Layanan Mahasiswa',
            'Kurikulum', 'Pengabdian Masyarakat', 'Tata Kelola', 'Publikasi',
        ];
        foreach ($kategoriList as $nama) {
            Kategori::firstOrCreate(['nama_kategori' => $nama]);
        }
        $kategoris = Kategori::all();

        $teknologiList = [
            'Generative AI (RAG)', 'Machine Learning (Random Forest)', 'NLP & Text Mining',
            'Computer Vision', 'Speech Recognition', 'Recommender System',
            'Predictive Analytics', 'Deep Learning (CNN)', 'Chatbot LLM', 'Data Visualization AI',
        ];

        $namaUseCase = [
            'Chatbot Layanan Akademik', 'Sistem Rekomendasi Beasiswa', 'Deteksi Plagiat Otomatis',
            'Prediksi Potensi Drop Out', 'Analisis Sentimen Feedback Mahasiswa', 'Asisten Riset Virtual',
            'Klasifikasi Dokumen Akademik', 'Sistem Penilaian Esai Otomatis', 'Prediksi Nilai Ujian',
            'Rekomendasi Mata Kuliah Pilihan', 'Deteksi Dini Kesulitan Belajar', 'Optimasi Jadwal Kuliah',
            'Analisis Kepuasan Layanan Kampus', 'Sistem Antrian Cerdas', 'Verifikasi Dokumen Otomatis',
            'Asisten Virtual Pendaftaran', 'Prediksi Kebutuhan SDM Fakultas', 'Analisis Tren Publikasi Ilmiah',
            'Deteksi Duplikasi Judul Skripsi', 'Sistem Monitoring Progres Tugas Akhir',
            'Klasifikasi Topik Penelitian', 'Rekomendasi Reviewer Jurnal', 'Deteksi Anomali Keuangan Kampus',
            'Sistem Pengingat Akademik Otomatis', 'Chatbot FAQ Kemahasiswaan',
            'Analisis Kinerja Dosen Berbasis Data', 'Prediksi Minat Karir Mahasiswa',
            'Sistem Deteksi Bullying Online', 'Rekomendasi Program Magang', 'Analisis Employability Lulusan',
        ];

        $unitList = ['FIF', 'Prodi S1 Informatika', 'Prodi S1 Sistem Informasi', 'Biro Akademik', 'Perpustakaan', 'Unit Beasiswa', 'Career Center', 'Humas'];
        $statusList = ['Ide', 'Direncanakan', 'Prototype', 'Implementasi'];

        for ($i = 1; $i <= 50; $i++) {
            $kategori = $kategoris->random();

            $lastId = UseCase::orderByDesc('id')->first();
            $number = $lastId ? ((int) preg_replace('/\D/', '', $lastId->kode)) + 1 : 1;

            $useCase = UseCase::create([
                'kode' => 'UC' . str_pad($number, 3, '0', STR_PAD_LEFT),
                'nama_use_case' => $faker->randomElement($namaUseCase) . ' ' . $faker->randomElement(['v2', 'Kampus', 'Digital', '2026', 'Terpadu', '']),
                'deskripsi' => $faker->sentence(15),
                'latar_belakang_masalah' => $faker->sentence(12),
                'tujuan_use_case' => $faker->sentence(10),
                'pengusul' => $faker->randomElement(['Dosen', 'Mahasiswa', 'Tendik', 'Satgas AI']) . ' ' . $faker->firstName(),
                'unit_terkait' => $faker->randomElement($unitList),
                'target_pengguna' => $faker->randomElement(['Mahasiswa', 'Dosen', 'Tendik', 'Pimpinan Fakultas']),
                'kategori_id' => $kategori->id,
                'teknologi_ai' => $faker->randomElement($teknologiList),
                'status' => $faker->randomElement($statusList),
            ]);

            $dampak = rand(1, 5);
            $kelayakan = rand(1, 5);
            $ketersediaan = rand(1, 5);
            $sdm = rand(1, 5);
            $infra = rand(1, 5);
            $urgensi = rand(1, 5);
            $risiko = rand(1, 5);
            $kompleks = rand(1, 5);

            $skor = $dampak + $kelayakan + $ketersediaan + $sdm + $urgensi - $risiko - $kompleks;
            $level = $skor >= 8 ? 'Tinggi' : ($skor >= 4 ? 'Sedang' : 'Rendah');

            PenilaianPrioritas::create([
                'use_case_id' => $useCase->id,
                'dampak' => $dampak,
                'kelayakan' => $kelayakan,
                'ketersediaan_data' => $ketersediaan,
                'kesiapan_sdm' => $sdm,
                'kesiapan_infrastruktur' => $infra,
                'urgensi' => $urgensi,
                'risiko_etika_skor' => $risiko,
                'kompleksitas_teknis' => $kompleks,
                'estimasi_waktu' => $faker->randomElement(['1 bulan', '3 bulan', '6 bulan']),
                'estimasi_biaya' => $faker->randomElement(['Rendah', 'Sedang', 'Tinggi']),
                'skor_prioritas' => $skor,
                'level_prioritas' => $level,
            ]);

            RisikoEtikaDetail::create([
                'use_case_id' => $useCase->id,
                'menggunakan_data_pribadi' => $faker->boolean(60),
                'jenis_data_sensitif' => $faker->randomElement(['Nilai akademik', 'Data identitas', 'Data kesehatan', '-']),
                'risiko_privasi' => $faker->randomElement(['Rendah', 'Sedang', 'Tinggi']),
                'risiko_bias' => $faker->randomElement(['Rendah', 'Sedang', 'Tinggi']),
                'risiko_ketergantungan_ai' => $faker->randomElement(['Rendah', 'Sedang', 'Tinggi']),
                'risiko_kesalahan_output' => $faker->randomElement(['Rendah', 'Sedang', 'Tinggi']),
                'perlu_validasi_manusia' => $faker->boolean(70),
                'perlu_persetujuan_pengguna' => $faker->boolean(50),
                'rekomendasi_mitigasi' => $faker->sentence(10),
            ]);
        }

        $this->command->info('50 data dummy use case berhasil dibuat!');
    }
}