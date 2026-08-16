{{--
 ┌─────────────────────────────────────────────────────────────────────────────┐
 │  FILE KONFIGURASI FAQ — Satgas AI FIF                                       │
 │  Pusat Bantuan / Chatbot Rule-Based                                         │
 ├─────────────────────────────────────────────────────────────────────────────┤
 │  Cara menambah pertanyaan baru:                                             │
 │    Tambahkan objek baru ke array SATBOT_FAQ dengan format:                  │
 │                                                                             │
 │    {                                                                        │
 │      id:       "id-unik-topik",         // string, tanpa spasi              │
 │      question: "Pertanyaan yang tampil",// teks tombol & bubble user        │
 │      answer:   "Jawaban dari bot...",   // mendukung \n & **bold**          │
 │      links: [                           // opsional, link di akhir jawaban  │
 │        { label: "Teks link", url: "https://..." }                           │
 │      ],                                                                     │
 │      followUp: ["id-topik-lain"]        // opsional, submenu setelah jawab  │
 │    },                                                                       │
 │                                                                             │
 │  Cara ubah pesan pembuka bot: edit SATBOT_GREETING di bawah.                │
 └─────────────────────────────────────────────────────────────────────────────┘
--}}
<script>
/* ═══════════════════════════════════════════════════════════════════════════
   KONFIGURASI SATBOT — Edit bagian ini untuk mengubah isi chatbot FAQ
   ═══════════════════════════════════════════════════════════════════════════ */

window.SATBOT_GREETING = "Halo! Saya **SatBot**, asisten virtual Satgas AI FIF. 👋\n\nSilakan pilih topik yang ingin kamu tanyakan:";

window.SATBOT_FAQ = [

    /* ─── TOPIK: Mengusulkan Use Case ──────────────────────────────────── */
    {
        id:       "cara-usulkan",
        question: "Bagaimana cara mengusulkan Use Case AI baru?",
        answer:   "Untuk mengusulkan use case AI baru, kamu bisa:\n\n1. Masuk ke halaman **Usulkan Use Case** melalui menu navigasi di sisi kiri.\n2. Isi seluruh formulir dengan data yang lengkap dan akurat.\n3. Klik tombol **Simpan Usulan** untuk mengirimkan.\n\nPastikan semua field wajib sudah terisi sebelum menyimpan. Usulanmu akan langsung masuk ke antrian review tim Satgas AI.",
        links:    [],
        followUp: ["lama-review", "status-usulan"]
    },

    /* ─── TOPIK: Skor Prioritas ─────────────────────────────────────────── */
    {
        id:       "skor-prioritas",
        question: "Apa itu Skor Prioritas dan cara menghitungnya?",
        answer:   "Skor Prioritas adalah nilai numerik yang menggambarkan seberapa mendesak dan layak sebuah use case AI untuk dikembangkan. Skor dihitung berdasarkan 4 dimensi utama:\n\n• **Dampak Bisnis** — seberapa besar manfaat bagi institusi\n• **Kesiapan Data** — ketersediaan & kualitas data yang dibutuhkan\n• **Risiko Etika** — potensi dampak negatif terhadap privasi & keadilan\n• **Feasibilitas Teknis** — kemampuan teknis untuk mengimplementasikan\n\nSetiap dimensi memiliki bobot yang berbeda. Skor akhir berkisar antara 0–100.",
        links: [
            { label: "Kebijakan AI Telkom University (Official)", url: "https://bpa.telkomuniversity.ac.id/repositori-dokumen-akademik/pembelajaran/panduan-penggunaan-artificial-intelligence-ai-untuk-pembelajaran-dan-pengajaran" }
        ],
        followUp: ["cara-usulkan", "lama-review"]
    },

    /* ─── TOPIK: Lama Review ─────────────────────────────────────────────── */
    {
        id:       "lama-review",
        question: "Berapa lama proses review usulan saya?",
        answer:   "Proses review oleh tim Satgas AI umumnya membutuhkan waktu **3–7 hari kerja** sejak usulan diterima dan dinyatakan lengkap.\n\nKamu akan mendapatkan notifikasi melalui platform ini ketika status usulanmu diperbarui. Pastikan akun kamu aktif agar tidak melewatkan notifikasi.",
        links:    [],
        followUp: ["status-usulan", "masalah-teknis"]
    },

    /* ─── TOPIK: Status Usulan ───────────────────────────────────────────── */
    {
        id:       "status-usulan",
        question: "Bagaimana cara memantau status usulan saya?",
        answer:   "Kamu bisa memantau status usulanmu melalui halaman **Dashboard Saya**. Di sana terdapat daftar semua use case yang pernah kamu usulkan beserta statusnya:\n\n• Menunggu — masih dalam antrian review\n• Sedang Dinilai — tim Satgas sedang memproses\n• Selesai Dinilai — sudah ada hasil skor prioritas\n• Dikembalikan — perlu revisi sesuai catatan tim\n\nKamu juga akan menerima notifikasi (ikon bell di header) setiap ada perubahan status.",
        links:    [],
        followUp: ["lama-review", "masalah-teknis"]
    },

    /* ─── TOPIK: Masalah Teknis ──────────────────────────────────────────── */
    {
        id:       "masalah-teknis",
        question: "Siapa yang saya hubungi jika ada masalah teknis?",
        answer:   "Untuk masalah teknis terkait platform (login gagal, data tidak tersimpan, error saat mengisi formulir, dll.), silakan hubungi tim IT Satgas AI melalui:\n\n• **Email:** satgasai@telkomuniversity.ac.id\n• **Telegram:** Hubungi bot layanan di bawah\n\nSertakan screenshot dan deskripsi masalah agar tim bisa membantu lebih cepat. Waktu respons biasanya **1–2 hari kerja**.",
        links: [
            { label: "Email: satgasai@telkomuniversity.ac.id", url: "mailto:satgasai@telkomuniversity.ac.id" },
            { label: "Bot Telegram LAAK FIF", url: "https://t.me/LAAKFIF" }
        ],
        followUp: ["kontak-akademik"]
    },

    /* ─── TOPIK: Kebijakan AI ────────────────────────────────────────────── */
    {
        id:       "kebijakan-ai",
        question: "Di mana saya bisa membaca kebijakan AI Telkom University?",
        answer:   "Seluruh kebijakan, regulasi, dan panduan etika AI Telkom University telah dipublikasikan secara resmi dan dapat diakses oleh sivitas akademika. Dokumen mencakup:\n\n• Kebijakan penggunaan AI dalam proses akademik\n• Panduan etika & privasi data\n• Regulasi tata kelola AI internal kampus\n• Pedoman penilaian risiko etika use case AI",
        links: [
            { label: "Kebijakan AI Telkom University (Official)", url: "https://bpa.telkomuniversity.ac.id/repositori-dokumen-akademik/pembelajaran/panduan-penggunaan-artificial-intelligence-ai-untuk-pembelajaran-dan-pengajaran" }
        ],
        followUp: ["skor-prioritas"]
    },

    /* ─── TOPIK: Kriteria Use Case ───────────────────────────────────────── */
    {
        id:       "kriteria-usecase",
        question: "Apa saja kriteria use case yang bisa diusulkan?",
        answer:   "Use case AI yang dapat diusulkan harus memenuhi kriteria berikut:\n\nRelevan — berkaitan langsung dengan kegiatan akademik/operasional Telkom University\nBerbasis Data — tersedia data yang memadai untuk pelatihan/pengujian model AI\nEtis — tidak melanggar privasi, keadilan, atau hak individu\nFeasible — teknologi yang dibutuhkan sudah tersedia atau dalam jangkauan\n\nUse case yang bersifat spekulatif, melanggar regulasi, atau tidak memiliki data sama sekali kemungkinan akan dikembalikan untuk revisi.",
        links:    [],
        followUp: ["cara-usulkan", "skor-prioritas"]
    },

    /* ─── TOPIK: Kalender Akademik ───────────────────────────────────────── */
    {
        id:       "kalender-akademik",
        question: "Di mana saya bisa melihat kalender akademik?",
        answer:   "Kalender akademik Telkom University dapat diakses secara resmi melalui portal Bagian Administrasi Akademik (BAA). Di sana tersedia informasi lengkap mengenai:\n\n• Jadwal perkuliahan & UTS/UAS\n• Masa pengisian KRS\n• Hari libur akademik\n• Deadline pengumpulan nilai",
        links: [
            { label: "Kalender Akademik Telkom University", url: "https://baa.telkomuniversity.ac.id/kalender-akademik-2-2/" }
        ],
        followUp: ["kontak-akademik", "bot-telegram"]
    },

    /* ─── TOPIK: Kontak Layanan Akademik ─────────────────────────────────── */
    {
        id:       "kontak-akademik",
        question: "Bagaimana cara menghubungi layanan akademik?",
        answer:   "Kamu bisa menghubungi layanan akademik Telkom University melalui kontak resmi yang tersedia. Layanan akademik menangani berbagai keperluan seperti:\n\n• Informasi perkuliahan & jadwal\n• Pengurusan administrasi akademik\n• Konsultasi terkait kurikulum\n• Pengaduan layanan akademik",
        links: [
            { label: "Kontak Layanan Akademik (Direktori Resmi)", url: "https://telkomuniversityofficial-my.sharepoint.com/:x:/g/personal/laaksoc_365_telkomuniversity_ac_id/IQAnniWrqGwZSLb83oSJV12rAQDco_AKqPZ37VXDMk9FPUY?e=4hgBNE" }
        ],
        followUp: ["bot-telegram", "kalender-akademik"]
    },

    /* ─── TOPIK: Bot Telegram ────────────────────────────────────────────── */
    {
        id:       "bot-telegram",
        question: "Apakah ada bot Telegram untuk layanan Telkom University?",
        answer:   "Ya! Telkom University menyediakan bot Telegram resmi melalui LAAK FIF yang dapat membantu kamu mendapatkan informasi dan layanan akademik secara cepat dan mudah langsung dari Telegram.\n\nBot ini dapat membantu:\n• Informasi akademik terkini\n• Pengumuman penting\n• Panduan layanan mahasiswa",
        links: [
            { label: "Bot Telegram LAAK FIF - @LAAKFIF", url: "https://t.me/LAAKFIF" }
        ],
        followUp: ["kontak-akademik", "kalender-akademik"]
    },

    /* ─── TOPIK: Panduan TAK ─────────────────────────────────────────────── */
    {
        id:       "panduan-tak",
        question: "Di mana saya bisa mengakses panduan TAK?",
        answer:   "Panduan TAK (Transkrip Aktivitas Kemahasiswaan) Telkom University dapat diakses melalui tautan resmi yang tersedia. Panduan ini berisi:\n\n• Ketentuan dan syarat TAK\n• Cara pengajuan & verifikasi poin TAK\n• Daftar kegiatan yang dapat dikonversi ke poin TAK\n• Prosedur pengumpulan bukti aktivitas",
        links: [
            { label: "Panduan TAK Telkom University", url: "https://linktr.ee/panduanTAK" }
        ],
        followUp: ["layanan-konseling", "kontak-akademik"]
    },

    /* ─── TOPIK: Layanan Pusat Konseling ─────────────────────────────────── */
    {
        id:       "layanan-konseling",
        question: "Bagaimana cara mengakses layanan pusat konseling?",
        answer:   "Layanan pusat konseling Telkom University tersedia melalui Direktorat Kemahasiswaan (Ditmawa). Layanan ini mencakup:\n\n• Konseling psikologis & akademik\n• Bimbingan karir & pengembangan diri\n• Layanan kesehatan mental mahasiswa\n• Konsultasi masalah sosial & personal\n\nLayanan ini bersifat **rahasia dan aman** untuk digunakan oleh seluruh mahasiswa Telkom University.",
        links: [
            { label: "Layanan Pusat Konseling - Ditmawa Telkom University", url: "https://linktr.ee/ditmawa_univtelkom" }
        ],
        followUp: ["bot-telegram", "kontak-akademik"]
    },

]; /* <- Tambahkan topik baru di atas baris ini */
</script>