<div align="center">

# 🤖 Sistem Inventarisasi & Prioritisasi Use Case AI
### *Satgas AI — Fakultas Ilmu Informatika, Telkom University*

<br/>

[![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net)
[![Livewire](https://img.shields.io/badge/Livewire-4.x-FB70A9?style=for-the-badge&logo=livewire&logoColor=white)](https://livewire.laravel.com)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-4.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![Vite](https://img.shields.io/badge/Vite-8.x-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev)
[![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)

<br/>

> A comprehensive web-based system for inventorying, assessing, and prioritizing Artificial Intelligence use cases within the Faculty of Informatics (FIF) at Telkom University.  
> Built as a Kerja Praktek (Internship) project to support the AI Task Force (*Satgas AI*) in managing, evaluating, and governing AI adoption across the institution.

</div>

---

## ✨ Features

- ✅ **AI Use Case Management** — Full CRUD for submitting and managing AI use case proposals
- ✅ **Automatic Code Generation** — Sequential unique codes (`UC001`, `UC002`, ...) generated automatically
- ✅ **Priority Assessment** — Score-based prioritization using 8 weighted parameters
- ✅ **Auto-Analysis Engine** — Keyword-based automatic scoring suggestion for all assessment parameters
- ✅ **Ethical Risk Assessment** — Detailed ethical risk profiling including privacy, bias, AI dependency, and output error risks
- ✅ **Status History Tracking** — Full audit trail of status changes with notes and timestamps
- ✅ **Analytics Dashboard** — Interactive charts (bar & pie) for category, status, and priority distribution
- ✅ **Top 5 Priority Ranking** — Leaderboard of highest-scoring use cases
- ✅ **Search & Filtering** — Search by name, proposer, AI technology, or code; filter by category and status
- ✅ **Excel Export** — Export all use case data with assessment scores to a formatted `.xlsx` file
- ✅ **Role-Based Access Control** — Separate flows for Admin (Satgas AI) and regular Users (Proposers)
- ✅ **Notification System** — In-app bell notifications for recent proposals (Admin) and scored use cases (User)
- ✅ **SatBot — AI Chatbot FAQ** — Rule-based chatbot assistant on the Help Center page with interactive topic selection and follow-up suggestions
- ✅ **Responsive Interface** — Mobile-first design with collapsible sidebar
- ✅ **Passkey Support** — Passwordless authentication via `@laravel/passkeys`

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| **Backend Framework** | Laravel 13.x |
| **Language** | PHP 8.3+ |
| **Frontend Reactivity** | Livewire 4.x + Alpine.js 3.x |
| **UI Component Library** | Flux (`livewire/flux`) + Blaze (`livewire/blaze`) |
| **CSS Framework** | Tailwind CSS 4.x |
| **Build Tool** | Vite 8.x |
| **Database** | MySQL 8.x |
| **ORM** | Eloquent (Laravel) |
| **Excel Export** | Maatwebsite Excel 3.1 (PhpSpreadsheet) |
| **Authentication** | Laravel Fortify + Passkeys (`@laravel/passkeys`) |
| **Icons** | Lucide (via CDN) |
| **Charts** | Chart.js 4.x (via CDN) |
| **Type Analysis** | Larastan 3.x (PHPStan for Laravel) |
| **Code Style** | Laravel Pint |
| **Testing** | PHPUnit 12.x |

---

## 📸 Screenshots

| Page | Preview |
|---|---|
| **Login** | `[screenshot-login.png]` |
| **Admin Dashboard** | `[screenshot-dashboard.png]` |
| **Use Case List** | `[screenshot-use-case-list.png]` |
| **Use Case Detail** | `[screenshot-use-case-detail.png]` |
| **Priority Assessment Form** | `[screenshot-assessment-form.png]` |
| **Pusat Bantuan / SatBot** | `[screenshot-bantuan.png]` |
| **User Dashboard** | `[screenshot-user-dashboard.png]` |

---

## 📁 Project Structure

```
KPV1/
├── app/
│   ├── Actions/                    # Fortify action overrides
│   ├── Concerns/
│   │   └── PasswordValidationRules.php
│   ├── Exports/
│   │   └── UseCaseExport.php       # Maatwebsite Excel export class
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminUserController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── PortalLoginController.php
│   │   │   ├── UseCaseController.php
│   │   │   └── UserDashboardController.php
│   │   └── Middleware/
│   │       └── EnsureUserIsAdmin.php
│   ├── Livewire/
│   │   └── Actions/                # Livewire-specific actions
│   ├── Models/
│   │   ├── Kategori.php
│   │   ├── PenilaianPrioritas.php
│   │   ├── RisikoEtikaDetail.php
│   │   ├── UseCase.php
│   │   ├── UseCaseStatusHistory.php
│   │   └── User.php
│   ├── Providers/
│   └── Services/
│       └── PriorityScoreCalculator.php   # Core scoring logic
├── database/
│   ├── migrations/
│   │   ├── create_users_table.php
│   │   ├── create_cache_table.php
│   │   ├── create_jobs_table.php
│   │   ├── create_passkeys_table.php
│   │   ├── add_two_factor_columns_to_users_table.php
│   │   ├── create_kategoris_table.php
│   │   ├── create_use_cases_table.php
│   │   ├── create_penilaian_prioritas_table.php
│   │   ├── create_risiko_etika_details_table.php
│   │   ├── add_role_to_users_table.php
│   │   ├── add_user_id_to_use_cases_table.php
│   │   ├── create_admins_table.php
│   │   ├── merge_admins_into_users_table.php
│   │   └── create_use_case_status_histories_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── KategoriSeeder.php
│       ├── BulkUseCaseSeeder.php
│       ├── DummyUserSeeder.php
│       └── UserDummyUseCaseSeeder.php
├── resources/
│   ├── css/app.css
│   ├── js/
│   │   ├── app.js
│   │   └── passkeys.js
│   └── views/
│       ├── layouts/
│       │   └── main.blade.php       # Global app layout with sidebar & notification bell
│       ├── use-cases/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   ├── show.blade.php
│       │   └── _form.blade.php
│       ├── user/
│       │   ├── dashboard.blade.php  # User's personal dashboard
│       │   └── create.blade.php     # Use case submission/edit form for users
│       ├── admin/
│       │   └── users/
│       │       └── index.blade.php  # Admin user management panel
│       ├── partials/
│       │   ├── faq-data.blade.php   # SatBot FAQ configuration (rule-based chatbot data)
│       │   ├── theme.blade.php      # Global CSS variables & design tokens
│       │   ├── head.blade.php
│       │   └── settings-heading.blade.php
│       ├── dashboard-usecase.blade.php  # Admin analytics dashboard
│       ├── bantuan.blade.php            # Pusat Bantuan / SatBot chatbot page
│       ├── dashboard.blade.php          # Account settings redirect page
│       ├── auth/
│       ├── components/
│       ├── flux/
│       ├── pages/
│       └── vendor/
├── routes/
│   ├── web.php
│   └── settings.php
├── vite.config.js
├── composer.json
└── package.json
```

---

## ⚙️ Installation

### Prerequisites

- PHP `>= 8.3, < 8.5`
- Composer
- Node.js & npm
- MySQL 8.x
- XAMPP / Laragon / Laravel Herd (or equivalent)

### Steps

**1. Clone the repository**
```bash
git clone https://github.com/YOUR_USERNAME/YOUR_REPO_NAME.git
cd YOUR_REPO_NAME
```

**2. Install PHP dependencies**
```bash
composer install
```

**3. Copy environment file**
```bash
cp .env.example .env
```

**4. Generate application key**
```bash
php artisan key:generate
```

**5. Configure your database**

Edit `.env` and set your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_usecase_ai
DB_USERNAME=root
DB_PASSWORD=
```

**6. Run database migrations**
```bash
php artisan migrate
```

**7. Seed the database**
```bash
# Seed all
php artisan db:seed

# Or seed specific seeders
php artisan db:seed --class=KategoriSeeder
php artisan db:seed --class=DummyUserSeeder
php artisan db:seed --class=BulkUseCaseSeeder
```

**8. Install Node.js dependencies**
```bash
npm install
```

**9. Build frontend assets**
```bash
# Development (with hot reload)
npm run dev

# Production build
npm run build
```

**10. Start the development server**
```bash
php artisan serve
```

> Open your browser and navigate to `http://127.0.0.1:8000`

> **Tip:** You can also use `composer dev` to run the Laravel dev server, queue worker, and Vite concurrently in one command.

---

## 🔐 Default Credentials

After seeding, the following test accounts are available:

| Role | Email | Password |
|---|---|---|
| **Admin** | `admin@admin.com` | `admin123` |
| **User** | `jeffsatur@student.telkomuniversity.ac.id` | `password123` |
| **User** | `leeteuk@student.telkomuniversity.ac.id` | `password123` |
| **User** | `heechul@student.telkomuniversity.ac.id` | `password123` |

> All 12 dummy user accounts (Jeff Satur, Leeteuk, Heechul, Yesung, Kangin, Shindong, Sungmin, Eunhyuk, Donghae, Siwon, Ryeowook, Kyuhyun) share the same password: `password123`.

---

## 🌍 Environment Variables

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_usecase_ai
DB_USERNAME=root
DB_PASSWORD=

CACHE_STORE=database
SESSION_DRIVER=database
SESSION_LIFETIME=120

QUEUE_CONNECTION=database

MAIL_MAILER=log
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 🗄️ Database

### Migrations

| Migration | Table | Description |
|---|---|---|
| `create_users_table` | `users` | Base Laravel users table |
| `create_cache_table` | `cache` | Database-backed cache |
| `create_jobs_table` | `jobs` | Queue jobs table |
| `create_passkeys_table` | `passkeys` | Passkey credentials storage |
| `add_two_factor_columns_to_users_table` | `users` | Two-factor auth columns |
| `create_kategoris_table` | `kategories` | Use case categories |
| `create_use_cases_table` | `use_cases` | Core use case proposals |
| `create_penilaian_prioritas_table` | `penilaian_prioritas` | Priority assessment scores |
| `create_risiko_etika_details_table` | `risiko_etika_details` | Ethical risk details |
| `add_role_to_users_table` | `users` | Role column (admin/user) |
| `add_user_id_to_use_cases_table` | `use_cases` | Foreign key to proposer user |
| `create_admins_table` | `admins` | Legacy admins table (migrated) |
| `merge_admins_into_users_table` | `users` | Unified admin/user model migration |
| `create_use_case_status_histories_table` | `use_case_status_histories` | Status change audit log |

### Seeders

| Seeder | Purpose |
|---|---|
| `KategoriSeeder` | Seeds 8 use case categories (Pembelajaran, Riset, Administrasi, etc.) |
| `DummyUserSeeder` | Creates 12 sample student user accounts |
| `BulkUseCaseSeeder` | Generates sample use case data with assessments |
| `UserDummyUseCaseSeeder` | Seeds use cases tied to specific user accounts |

---

## 📊 Priority Assessment Formula

The priority score is calculated automatically by `PriorityScoreCalculator.php` whenever an assessment is saved.

```
Priority Score = Dampak
               + Kelayakan
               + Ketersediaan Data
               + Kesiapan SDM
               + Kesiapan Infrastruktur
               + Urgensi
               − Risiko Etika
               − Kompleksitas Teknis
```

Each parameter is scored on a **scale of 1–5**.

### Priority Levels

| Score | Level |
|---|---|
| `>= 8` | 🟢 **Tinggi** (High) |
| `4 - 7` | 🟡 **Sedang** (Medium) |
| `< 4` | 🔴 **Rendah** (Low) |

### Auto-Analysis Engine

The system includes a keyword-based auto-suggestion engine (`UseCaseController@analisisOtomatis`) that analyzes the use case name, description, background, and objectives to suggest initial scores for each parameter — helping admins get started with the assessment quickly.

---

## 📦 Main Modules

### 🔑 Authentication (`PortalLoginController`)
A unified login portal (`/masuk`) with a toggle between **Admin** and **User** modes. Built on Laravel Fortify with passkey support. Admin access is restricted via the `EnsureUserIsAdmin` middleware (aliased as `admin`).

### 📈 Analytics Dashboard (`DashboardController`)
Admin-only dashboard (`/dashboard-usecase`) displaying:
- Total registered use cases
- Average Impact and Ethical Risk scores
- Interactive bar chart: Use Cases per Category
- Interactive pie charts: Status distribution and Priority Level distribution
- Top 5 Use Cases by Priority Score

### 📋 Use Case Management (`UseCaseController`)
Full CRUD operations for use case proposals (Admin only):
- **Index** (`/use-cases`): Paginated list with search (name, proposer, technology, code) and filters (category, status)
- **Create** (`/use-cases/create`): Submission form for new use case proposals
- **Show** (`/use-cases/{id}`): Detailed view including assessment scores, ethical risk profile, and status history timeline
- **Edit** (`/use-cases/{id}/edit`): Update use case data, assessment scores, and ethical risk details
- **Destroy**: Delete a use case record
- **Export** (`/use-cases-export`): Download all use cases as `.xlsx`
- **Auto-Analysis** (`POST /use-cases/{id}/analisis-otomatis`): Trigger keyword-based score suggestion

### 👤 User Portal (`UserDashboardController`)
Dedicated portal for regular users (proposers):
- **Dashboard** (`/user/dashboard`): Personal overview showing own use cases, KPI cards (Total, Sudah Dinilai, Masih Ide), and a table with status and priority scores
- **Usulkan Use Case** (`/user/usulkan`): Simplified submission form
- **Edit Usulan** (`/user/usulkan/{id}/edit`): Edit own use case *only while status is still "Ide"*

### 🏷️ Category Management (`Kategori` model)
8 predefined use case categories seeded into the database:

| Category | Description |
|---|---|
| Pembelajaran | AI Teaching Assistant, question generator, assignment analysis |
| Riset | Research mapping, collaboration recommendation, literature mining |
| Administrasi | Automated letter drafting, academic service chatbot |
| Layanan Mahasiswa | Academic chatbot, thesis topic recommendation, study progress monitoring |
| Kurikulum | CPL analysis, course material mapping, RPS evaluation |
| Pengabdian Masyarakat | AI literacy for schools, AI4WellBeing initiatives |
| Tata Kelola | AI readiness dashboard, Satgas AI activity monitoring |
| Publikasi | AI disclosure checker, plagiarism support, paper assistant |

### ⚖️ Priority Assessment (`PenilaianPrioritas` model + `PriorityScoreCalculator`)
Scores 8 parameters, auto-calculates `skor_prioritas` and `level_prioritas` on save via Eloquent model events. Includes `estimasi_waktu` (1 bulan / 3 bulan / 6 bulan) and `estimasi_biaya` (Rendah / Sedang / Tinggi).

### 🛡️ Ethical Risk Assessment (`RisikoEtikaDetail` model)
Captures detailed ethical risk information:
- Personal data usage flag
- Types of sensitive data
- Privacy, bias, AI dependency, and output error risk levels (Rendah / Sedang / Tinggi)
- Human validation and user consent requirements
- Mitigation recommendations

### 📜 Status History (`UseCaseStatusHistory` model)
Automatic audit trail triggered by Eloquent model events on create and status change. Stores: previous status, new status, changed by (user), and optional notes.

### 👥 User Management (`AdminUserController`)
Admin panel (`/admin/users`) to promote regular users to Admin, demote Admins back to regular users, and delete user accounts.

### 📤 Excel Export (`UseCaseExport`)
Exports all use cases with full assessment data to a formatted `.xlsx` file using Maatwebsite Excel. Includes styled headers (bold, blue background, white text, auto-sized columns).

### 🤖 SatBot — Pusat Bantuan (`bantuan.blade.php`)
An interactive rule-based chatbot FAQ page accessible to all authenticated users via the sidebar:
- Conversational UI with chat bubbles and typing animation
- Topic-button driven interface (no free-text input required)
- Follow-up suggestions after each answer
- FAQ data is configurable via `partials/faq-data.blade.php` — just add new entries to the `SATBOT_FAQ` JavaScript array
- Reset chat button to restart the conversation

---

## 📊 Dashboard Overview

The admin dashboard (`/dashboard-usecase`) renders the following visualizations using **Chart.js 4.x**:

| Visualization | Type | Description |
|---|---|---|
| Total Use Case | KPI Card | Count of all registered use cases |
| Rata-rata Dampak | KPI Card | Average impact score across all assessments |
| Rata-rata Risiko Etika | KPI Card | Average ethical risk score |
| Use Case per Kategori | Bar Chart | Distribution of use cases across 8 categories |
| Distribusi Status | Pie Chart | Breakdown by status (Ide, Direncanakan, Prototype, Implementasi) |
| Level Prioritas | Pie Chart | Distribution of priority levels (Tinggi, Sedang, Rendah) |
| Top 5 Use Case | Table | Leaderboard sorted by `skor_prioritas` descending |

---

## 🔗 Route Summary

| Method | URI | Name | Access | Description |
|---|---|---|---|---|
| GET | `/` | `home` | Public | Redirects to `/masuk` |
| GET | `/masuk` | `portal.login` | Public | Unified login page |
| POST | `/masuk` | `portal.login.submit` | Public | Login submission |
| POST | `/keluar` | `portal.logout` | Auth | Logout |
| GET | `/bantuan` | `bantuan` | Auth | Help Center / SatBot |
| GET | `/user/dashboard` | `user.dashboard` | Auth | User's personal dashboard |
| GET | `/user/usulkan` | `user.create` | Auth | Use case proposal form |
| POST | `/user/usulkan` | `user.store` | Auth | Submit use case proposal |
| GET | `/user/usulkan/{id}/edit` | `user.edit` | Auth | Edit own use case |
| PUT | `/user/usulkan/{id}` | `user.update` | Auth | Update own use case |
| GET | `/dashboard-usecase` | `dashboard.usecase` | Admin | Analytics dashboard |
| GET | `/use-cases` | `use-cases.index` | Admin | All use cases list |
| GET | `/use-cases/create` | `use-cases.create` | Admin | Create use case form |
| POST | `/use-cases` | `use-cases.store` | Admin | Store new use case |
| GET | `/use-cases/{id}` | `use-cases.show` | Admin | Use case detail view |
| GET | `/use-cases/{id}/edit` | `use-cases.edit` | Admin | Edit use case form |
| PUT/PATCH | `/use-cases/{id}` | `use-cases.update` | Admin | Update use case |
| DELETE | `/use-cases/{id}` | `use-cases.destroy` | Admin | Delete use case |
| GET | `/use-cases-export` | `use-cases.export` | Admin | Download Excel export |
| POST | `/use-cases/{id}/analisis-otomatis` | `use-cases.analisis-otomatis` | Admin | Trigger auto-analysis |
| GET | `/admin/users` | `admin.users.index` | Admin | User management panel |
| POST | `/admin/users/promote/{user}` | `admin.users.promote` | Admin | Promote user to Admin |
| DELETE | `/admin/users/demote/{admin}` | `admin.users.demote` | Admin | Demote Admin to User |
| DELETE | `/admin/users/user/{user}` | `admin.users.destroy-user` | Admin | Delete user account |

---

## 🚀 Future Improvements

| Feature | Description |
|---|---|
| 🤖 **ML Recommendation** | Train a model on historical assessment data to recommend priority scores automatically |
| 📄 **PDF Export** | Generate printable PDF reports for individual use cases and summary reports |
| 🔔 **Email Notifications** | Send email alerts to proposers when their use case status changes |
| 🔑 **Granular Permissions** | Fine-grained role/permission system (e.g., reviewer, viewer, editor roles) |
| 📊 **Advanced Analytics** | Unit-level statistics, trend analysis over time, and AI technology usage breakdown |
| 🌐 **REST API** | JSON API endpoints for integration with external systems or mobile apps |
| 🌙 **Dark Mode** | System-aware dark mode toggle |
| 📦 **Archiving** | Soft-delete and archive functionality for completed or rejected use cases |

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. **Fork** the repository
2. **Create** your feature branch (`git checkout -b feat/your-feature-name`)
3. **Commit** your changes using Conventional Commits (`git commit -m 'feat: add some feature'`)
4. **Push** to the branch (`git push origin feat/your-feature-name`)
5. **Open** a Pull Request

### Code Style

This project uses **Laravel Pint** for PHP code style enforcement:
```bash
# Fix code style
composer lint

# Check without fixing
composer lint:check
```

### Static Analysis

```bash
composer types:check
```

### Running Tests

```bash
php artisan test
# or
composer test
```

---

## 📄 License

This project is open-sourced under the [MIT License](LICENSE).

---

## 👤 Author

**[Your Name]**
- 📧 Email: `your.email@student.telkomuniversity.ac.id`
- 🎓 NIM: `XXXXXXXXXX`
- 🏫 Faculty: Informatika — Telkom University
- 🔗 GitHub: [@your-github-username](https://github.com/your-github-username)
- 💼 LinkedIn: [linkedin.com/in/your-profile](https://linkedin.com/in/your-profile)

**Supervisor / Pembimbing KP**
- **Internal**: [Dosen Pembimbing Internal]
- **External**: [Pembimbing Lapangan — Satgas AI FIF]

---

<div align="center">

**Satgas AI FIF — Telkom University · 2026**

*"Enabling responsible and impactful AI adoption in academia."*

</div>
