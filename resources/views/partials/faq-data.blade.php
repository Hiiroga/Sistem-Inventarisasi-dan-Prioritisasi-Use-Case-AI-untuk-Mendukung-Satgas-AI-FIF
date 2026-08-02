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
        links: [
            { label: "Panduan Pengisian Use Case — Telkom University", url: "https://telkomuniversity.ac.id" }
        ],
        followUp: ["lama-review", "status-usulan"]
    },

    /* ─── TOPIK: Skor Prioritas ─────────────────────────────────────────── */
    {
        id:       "skor-prioritas",
        question: "Apa itu Skor Prioritas dan cara menghitungnya?",
        answer:   "Skor Prioritas adalah nilai numerik yang menggambarkan seberapa mendesak dan layak sebuah use case AI untuk dikembangkan. Skor dihitung berdasarkan 4 dimensi utama:\n\n• **Dampak Bisnis** — seberapa besar manfaat bagi institusi\n• **Kesiapan Data** — ketersediaan & kualitas data yang dibutuhkan\n• **Risiko Etika** — potensi dampak negatif terhadap privasi & keadilan\n• **Feasibilitas Teknis** — kemampuan teknis untuk mengimplementasikan\n\nSetiap dimensi memiliki bobot yang berbeda. Skor akhir berkisar antara 0–100.",
        links: [
            { label: "Metodologi Penilaian Prioritas AI — Satgas AI FIF", url: "https://telkomuniversity.ac.id" }
        ],
        followUp: ["cara-usulkan", "lama-review"]
    },

    /* ─── TOPIK: Lama Review ─────────────────────────────────────────────── */
    {
        id:       "lama-review",
        question: "Berapa lama proses review usulan saya?",
        answer:   "Proses review oleh tim Satgas AI umumnya membutuhkan waktu **5–10 hari kerja** sejak usulan diterima dan dinyatakan lengkap.\n\nKamu akan mendapatkan notifikasi melalui platform ini ketika status usulanmu diperbarui. Pastikan akun kamu aktif agar tidak melewatkan notifikasi.",
        links: [
            { label: "SLA & Alur Review Use Case — Satgas AI", url: "https://telkomuniversity.ac.id" }
        ],
        followUp: ["status-usulan", "masalah-teknis"]
    },

    /* ─── TOPIK: Status Usulan ───────────────────────────────────────────── */
    {
        id:       "status-usulan",
        question: "Bagaimana cara memantau status usulan saya?",
        answer:   "Kamu bisa memantau status usulanmu melalui halaman **Dashboard Saya**. Di sana terdapat daftar semua use case yang pernah kamu usulkan beserta statusnya:\n\n• 🟡 **Menunggu** — masih dalam antrian review\n• 🔵 **Sedang Dinilai** — tim Satgas sedang memproses\n• 🟢 **Selesai Dinilai** — sudah ada hasil skor prioritas\n• 🔴 **Dikembalikan** — perlu revisi sesuai catatan tim\n\nKamu juga akan menerima notifikasi (ikon 🔔 di header) setiap ada perubahan status.",
        links:    [],
        followUp: ["lama-review", "masalah-teknis"]
    },

    /* ─── TOPIK: Masalah Teknis ──────────────────────────────────────────── */
    {
        id:       "masalah-teknis",
        question: "Siapa yang saya hubungi jika ada masalah teknis?",
        answer:   "Untuk masalah teknis terkait platform (login gagal, data tidak tersimpan, error saat mengisi formulir, dll.), silakan hubungi tim IT Satgas AI melalui:\n\n• **Email:** satgasai@telkomuniversity.ac.id\n• **WhatsApp:** Hubungi nomor support di bawah\n\nSertakan screenshot dan deskripsi masalah agar tim bisa membantu lebih cepat. Waktu respons biasanya **1–2 hari kerja**.",
        links: [
            { label: "Email: satgasai@telkomuniversity.ac.id", url: "mailto:satgasai@telkomuniversity.ac.id" },
            { label: "WhatsApp Support Satgas AI", url: "https://wa.me/6281234567890" }
        ],
        followUp: []
    },

    /* ─── TOPIK: Kebijakan AI ────────────────────────────────────────────── */
    {
        id:       "kebijakan-ai",
        question: "Di mana saya bisa membaca kebijakan AI Telkom University?",
        answer:   "Seluruh kebijakan, regulasi, dan panduan etika AI Telkom University telah dipublikasikan secara resmi dan dapat diakses oleh sivitas akademika. Dokumen mencakup:\n\n• Kebijakan penggunaan AI dalam proses akademik\n• Panduan etika & privasi data\n• Regulasi tata kelola AI internal kampus\n• Pedoman penilaian risiko etika use case AI",
        links: [
            { label: "Kebijakan AI Telkom University (Official)", url: "https://telkomuniversity.ac.id" },
            { label: "Panduan Etika Penggunaan AI — Satgas AI FIF", url: "https://telkomuniversity.ac.id" }
        ],
        followUp: ["skor-prioritas"]
    },

    /* ─── TOPIK: Kriteria Use Case ───────────────────────────────────────── */
    {
        id:       "kriteria-usecase",
        question: "Apa saja kriteria use case yang bisa diusulkan?",
        answer:   "Use case AI yang dapat diusulkan harus memenuhi kriteria berikut:\n\n✅ **Relevan** — berkaitan langsung dengan kegiatan akademik/operasional Telkom University\n✅ **Berbasis Data** — tersedia data yang memadai untuk pelatihan/pengujian model AI\n✅ **Etis** — tidak melanggar privasi, keadilan, atau hak individu\n✅ **Feasible** — teknologi yang dibutuhkan sudah tersedia atau dalam jangkauan\n\n❌ Use case yang bersifat spekulatif, melanggar regulasi, atau tidak memiliki data sama sekali kemungkinan akan dikembalikan untuk revisi.",
        links:    [],
        followUp: ["cara-usulkan", "skor-prioritas"]
    },

]; /* ← Tambahkan topik baru di atas baris ini */
</script>
