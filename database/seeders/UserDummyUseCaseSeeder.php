<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\PenilaianPrioritas;
use App\Models\UseCase;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserDummyUseCaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'mahasiswa@test.com')->first();

        if (! $user) {
            $this->command->error('User mahasiswa@test.com tidak ditemukan. Buat dulu akunnya.');

            return;
        }

        $data = [
            [
                'nama_use_case' => 'Chatbot Bimbingan Skripsi',
                'deskripsi' => 'Chatbot untuk membantu mahasiswa mengecek progres bimbingan skripsi dengan dosen.',
                'kategori' => 'Layanan Mahasiswa',
                'status' => 'Ide',
                'sudah_dinilai' => false,
            ],
            [
                'nama_use_case' => 'Rekomendasi Jadwal Belajar Personal',
                'deskripsi' => 'Sistem AI yang menyusun jadwal belajar sesuai gaya belajar dan waktu luang mahasiswa.',
                'kategori' => 'Pembelajaran',
                'status' => 'Direncanakan',
                'sudah_dinilai' => true,
            ],
            [
                'nama_use_case' => 'Deteksi Dini Stres Akademik Mahasiswa',
                'deskripsi' => 'Analisis pola aktivitas mahasiswa untuk mendeteksi tanda-tanda stres akademik secara dini.',
                'kategori' => 'Pengabdian Masyarakat',
                'status' => 'Ide',
                'sudah_dinilai' => false,
            ],
        ];

        foreach ($data as $item) {
            $kategori = Kategori::firstOrCreate(['nama_kategori' => $item['kategori']]);

            $last = UseCase::orderByDesc('id')->first();
            $number = $last ? ((int) preg_replace('/\D/', '', $last->kode)) + 1 : 1;

            $useCase = UseCase::create([
                'user_id' => $user->id,
                'kode' => 'UC'.str_pad((string) $number, 3, '0', STR_PAD_LEFT),
                'nama_use_case' => $item['nama_use_case'],
                'deskripsi' => $item['deskripsi'],
                'latar_belakang_masalah' => 'Berdasarkan pengamatan langsung di lingkungan kampus.',
                'tujuan_use_case' => 'Meningkatkan kualitas layanan dan pengalaman mahasiswa.',
                'pengusul' => $user->name,
                'unit_terkait' => 'Prodi S1 Informatika',
                'target_pengguna' => 'Mahasiswa',
                'kategori_id' => $kategori->id,
                'teknologi_ai' => 'Machine Learning',
                'status' => $item['status'],
            ]);

            if ($item['sudah_dinilai']) {
                PenilaianPrioritas::create([
                    'use_case_id' => $useCase->id,
                    'dampak' => 4,
                    'kelayakan' => 3,
                    'ketersediaan_data' => 3,
                    'kesiapan_sdm' => 3,
                    'kesiapan_infrastruktur' => 3,
                    'urgensi' => 4,
                    'risiko_etika_skor' => 2,
                    'kompleksitas_teknis' => 3,
                    'estimasi_waktu' => '3 bulan',
                    'estimasi_biaya' => 'Sedang',
                    'skor_prioritas' => 12,
                    'level_prioritas' => 'Tinggi',
                ]);
            }
        }

        $this->command->info('3 use case dummy berhasil ditambahkan untuk '.$user->name);
    }
}
