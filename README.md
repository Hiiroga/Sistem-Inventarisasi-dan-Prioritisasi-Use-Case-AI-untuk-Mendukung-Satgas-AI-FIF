<div align="center">

# Sistem Inventarisasi & Prioritisasi Use Case AI

### Satgas AI — Fakultas Ilmu Informatika, Telkom University

<br/>

[![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net)
[![Livewire](https://img.shields.io/badge/Livewire-4.x-FB70A9?style=for-the-badge&logo=livewire&logoColor=white)](https://livewire.laravel.com)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-4.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)

<br/>

Aplikasi web untuk menginventarisasi, menilai, dan memprioritaskan use case AI di lingkungan Fakultas Ilmu Informatika Telkom University. Dibangun sebagai proyek Kerja Praktek untuk mendukung Satgas AI dalam mengelola dan mengatur adopsi AI di institusi.

</div>

---

## Fitur Utama

- **Manajemen Use Case** — CRUD lengkap untuk mengajukan dan mengelola proposal use case AI, dengan kode unik otomatis (`UC001`, `UC002`, ...)
- **Penilaian Prioritas** — Penilaian berbasis skor dari 8 parameter berbobot, dengan kalkulasi otomatis level prioritas (Tinggi / Sedang / Rendah)
- **Auto-Analysis Engine** — Sugesti skor awal berbasis analisis kata kunci dari nama, deskripsi, latar belakang, dan tujuan use case
- **Penilaian Risiko Etika** — Profil risiko etika lengkap: privasi, bias, ketergantungan AI, dan risiko kesalahan output
- **Riwayat Status** — Audit trail otomatis setiap perubahan status, lengkap dengan catatan dan timestamp
- **Analytics Dashboard** — Grafik interaktif (bar & pie) distribusi kategori, status, dan level prioritas; top 5 use case prioritas tertinggi
- **Ekspor Excel** — Unduh seluruh data use case beserta skor penilaian ke file `.xlsx` berformat rapi
- **Role-Based Access** — Alur terpisah untuk Admin (Satgas AI) dan User (Pengusul)
- **Notifikasi In-App** — Bell notifikasi untuk proposal masuk (Admin) dan use case yang sudah dinilai (User)
- **SatBot** — Chatbot FAQ berbasis aturan di halaman Pusat Bantuan, dengan navigasi tombol topik dan saran tindak lanjut
- **Passkey Support** — Autentikasi tanpa kata sandi via `@laravel/passkeys`

---

## Tech Stack

| Layer | Teknologi |
|---|---|
| Backend | Laravel 13.x (PHP 8.3+) |
| Frontend Reactivity | Livewire 4.x + Alpine.js 3.x |
| UI Components | Flux (`livewire/flux`) + Blaze (`livewire/blaze`) |
| CSS | Tailwind CSS 4.x |
| Build Tool | Vite 8.x |
| Database | MySQL 8.x (Eloquent ORM) |
| Excel Export | Maatwebsite Excel 3.1 (PhpSpreadsheet) |
| Autentikasi | Laravel Fortify + Passkeys |
| Grafik | Chart.js 4.x |
| Static Analysis | Larastan 3.x / PHPStan |
| Code Style | Laravel Pint |
| Testing | PHPUnit 12.x |

---

## Instalasi

### Prasyarat

- PHP `>= 8.3, < 8.5`
- Composer
- Node.js & npm
- MySQL 8.x
- XAMPP / Laragon / Laravel Herd (atau setara)

### Langkah-langkah

**1. Clone repositori**
```bash
git clone https://github.com/YOUR_USERNAME/YOUR_REPO_NAME.git
cd YOUR_REPO_NAME
```

**2. Install dependensi PHP dan konfigurasi environment**
```bash
composer install
cp .env.example .env
php artisan key:generate
```

**3. Konfigurasi database**

Edit `.env` dan sesuaikan kredensial database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_usecase_ai
DB_USERNAME=root
DB_PASSWORD=
```

**4. Jalankan migrasi dan seeder**
```bash
php artisan migrate
php artisan db:seed
```

> Untuk seeder individual: `php artisan db:seed --class=KategoriSeeder`

**5. Install dependensi Node.js dan build aset**
```bash
npm install
npm run dev   # development dengan hot reload
# npm run build  # production build
```

**6. Jalankan server**
```bash
php artisan serve
# atau
composer dev   # menjalankan server, queue worker, dan Vite sekaligus
```

Buka browser dan navigasi ke `http://127.0.0.1:8000`.

---

## Akun Default

Setelah seeding, akun berikut tersedia untuk pengujian:

| Role | Email | Password |
|---|---|---|
| Admin | `admin@admin.com` | `admin123` |
| User | `jeffsatur@student.telkomuniversity.ac.id` | `password123` |
| User | `leeteuk@student.telkomuniversity.ac.id` | `password123` |

> 12 akun dummy user tersedia, semua dengan password `password123`.

---

## Formula Penilaian Prioritas

Skor prioritas dihitung otomatis oleh `PriorityScoreCalculator` setiap kali penilaian disimpan:

```
Skor Prioritas = Dampak
               + Kelayakan
               + Ketersediaan Data
               + Kesiapan SDM
               + Kesiapan Infrastruktur
               + Urgensi
               − Risiko Etika
               − Kompleksitas Teknis
```

Setiap parameter dinilai pada skala **1–5**.

| Skor | Level |
|---|---|
| `>= 8` | Tinggi |
| `4 – 7` | Sedang |
| `< 4` | Rendah |

---

## Struktur Aplikasi

```
app/
├── Exports/UseCaseExport.php          # Kelas ekspor Excel
├── Http/
│   ├── Controllers/
│   │   ├── DashboardController.php    # Analytics dashboard (Admin)
│   │   ├── PortalLoginController.php  # Login terpadu Admin/User
│   │   ├── UseCaseController.php      # CRUD use case + auto-analysis
│   │   ├── UserDashboardController.php
│   │   └── AdminUserController.php    # Manajemen user
│   └── Middleware/EnsureUserIsAdmin.php
├── Models/
│   ├── UseCase.php
│   ├── PenilaianPrioritas.php
│   ├── RisikoEtikaDetail.php
│   ├── UseCaseStatusHistory.php
│   └── Kategori.php
└── Services/PriorityScoreCalculator.php  # Logika scoring inti
```

---

## Rute Utama

| Method | URI | Akses | Keterangan |
|---|---|---|---|
| GET | `/masuk` | Publik | Halaman login terpadu |
| GET | `/user/dashboard` | Auth | Dashboard personal pengusul |
| GET | `/user/usulkan` | Auth | Form pengajuan use case |
| GET | `/dashboard-usecase` | Admin | Analytics dashboard |
| GET | `/use-cases` | Admin | Daftar semua use case |
| GET | `/use-cases/{id}` | Admin | Detail use case |
| GET | `/use-cases-export` | Admin | Unduh Excel |
| POST | `/use-cases/{id}/analisis-otomatis` | Admin | Trigger auto-analysis |
| GET | `/admin/users` | Admin | Manajemen user |
| GET | `/bantuan` | Auth | Pusat Bantuan / SatBot |

---

## Kategori Use Case

8 kategori sudah di-seed ke database:

| Kategori | Contoh Use Case |
|---|---|
| Pembelajaran | AI Teaching Assistant, question generator |
| Riset | Research mapping, literature mining |
| Administrasi | Surat otomatis, academic service chatbot |
| Layanan Mahasiswa | Chatbot akademik, rekomendasi topik skripsi |
| Kurikulum | Analisis CPL, evaluasi RPS |
| Pengabdian Masyarakat | AI literacy untuk sekolah |
| Tata Kelola | AI readiness dashboard, monitoring Satgas AI |
| Publikasi | AI disclosure checker, paper assistant |

---

## Development

```bash
# Lint & code style (Laravel Pint)
composer lint
composer lint:check   # cek saja tanpa perbaiki

# Static analysis (PHPStan via Larastan)
composer types:check

# Jalankan test suite
php artisan test
# atau
composer test
```

---

## Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

<div align="center">

**Satgas AI FIF — Telkom University · 2026**

</div>
