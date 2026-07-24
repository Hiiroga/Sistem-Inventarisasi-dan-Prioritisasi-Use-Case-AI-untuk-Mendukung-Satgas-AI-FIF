@extends('layouts.main')
@section('title', 'Pusat Bantuan — Satgas AI FIF')

@section('content')
<div class="space-y-6">

    {{-- Hero Banner --}}
    <div class="relative bg-gradient-to-r from-slate-900 via-slate-800 to-red-950 text-white rounded-3xl p-6 md:p-8 overflow-hidden shadow-xl">
        <div class="relative z-10 max-w-2xl space-y-3">
            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-red-500/20 text-red-300 border border-red-500/30">
                <i data-lucide="message-circle" class="h-3.5 w-3.5"></i> Pusat Bantuan — Satgas AI FIF
            </span>
            <h1 class="text-2xl md:text-3xl font-black tracking-tight">Ada yang bisa kami bantu? 🤖</h1>
            <p class="text-slate-300 text-sm leading-relaxed font-light">
                Temukan jawaban atas pertanyaan umum seputar penggunaan platform, proses usulan use case AI, serta tata kelola Satgas AI di Telkom University.
            </p>
        </div>
        {{-- Decorative circles --}}
        <div class="absolute right-0 bottom-0 top-0 w-1/3 opacity-15 hidden md:block">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-72 h-72 rounded-full border border-white/30"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 rounded-full border border-red-500/20"></div>
        </div>
    </div>

    {{-- FAQ Section --}}
    <div class="grid grid-cols-1 gap-4" x-data="{ active: null }">

        {{-- Card label --}}
        <div class="flex items-center gap-2 px-1">
            <i data-lucide="help-circle" class="h-4 w-4 text-telkom-red"></i>
            <p class="text-sm font-extrabold text-slate-800">Pertanyaan yang Sering Diajukan (FAQ)</p>
        </div>

        {{-- ─── FAQ 1 ─── --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden" id="faq-1">
            <button
                @click="active === 1 ? active = null : active = 1"
                class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-slate-50 transition-colors gap-3"
                aria-expanded="false"
            >
                <div class="flex items-center gap-3">
                    <span class="h-7 w-7 rounded-xl bg-red-50 text-telkom-red flex items-center justify-center text-xs font-black shrink-0">1</span>
                    <span class="text-sm font-semibold text-slate-800">Bagaimana cara mengusulkan Use Case AI baru?</span>
                </div>
                <i data-lucide="chevron-down" class="h-4 w-4 text-slate-400 shrink-0 transition-transform duration-200" :class="active === 1 ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="active === 1" x-collapse x-cloak class="px-5 pb-5 pt-1">
                <div class="pl-10 space-y-2 text-sm text-slate-600 leading-relaxed">
                    <p>
                        Untuk mengusulkan use case AI baru, kamu dapat masuk ke halaman <strong class="text-slate-800">Usulkan Use Case</strong> melalui menu navigasi di sisi kiri.
                        Isi seluruh formulir dengan data yang lengkap dan akurat, lalu klik tombol <strong class="text-slate-800">Simpan Usulan</strong>.
                    </p>
                    <p>Panduan lengkap pengisian formulir tersedia di link berikut:</p>
                    <a href="https://telkomuniversity.ac.id" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-1.5 text-telkom-red font-semibold hover:underline">
                        <i data-lucide="external-link" class="h-3.5 w-3.5"></i>
                        Panduan Pengisian Use Case — Telkom University
                    </a>
                </div>
            </div>
        </div>

        {{-- ─── FAQ 2 ─── --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden" id="faq-2">
            <button
                @click="active === 2 ? active = null : active = 2"
                class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-slate-50 transition-colors gap-3"
            >
                <div class="flex items-center gap-3">
                    <span class="h-7 w-7 rounded-xl bg-red-50 text-telkom-red flex items-center justify-center text-xs font-black shrink-0">2</span>
                    <span class="text-sm font-semibold text-slate-800">Apa itu Skor Prioritas dan bagaimana cara menghitungnya?</span>
                </div>
                <i data-lucide="chevron-down" class="h-4 w-4 text-slate-400 shrink-0 transition-transform duration-200" :class="active === 2 ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="active === 2" x-collapse x-cloak class="px-5 pb-5 pt-1">
                <div class="pl-10 space-y-2 text-sm text-slate-600 leading-relaxed">
                    <p>
                        Skor Prioritas dihitung berdasarkan beberapa dimensi utama yaitu <strong class="text-slate-800">Dampak Bisnis</strong>,
                        <strong class="text-slate-800">Kesiapan Data</strong>, <strong class="text-slate-800">Risiko Etika</strong>,
                        dan <strong class="text-slate-800">Feasibilitas Teknis</strong>. Setiap dimensi memiliki bobot yang berbeda.
                    </p>
                    <p>Baca lebih lanjut tentang metodologi penilaian di:</p>
                    <a href="https://telkomuniversity.ac.id" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-1.5 text-telkom-red font-semibold hover:underline">
                        <i data-lucide="external-link" class="h-3.5 w-3.5"></i>
                        Metodologi Penilaian Prioritas AI — Satgas AI FIF
                    </a>
                </div>
            </div>
        </div>

        {{-- ─── FAQ 3 ─── --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden" id="faq-3">
            <button
                @click="active === 3 ? active = null : active = 3"
                class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-slate-50 transition-colors gap-3"
            >
                <div class="flex items-center gap-3">
                    <span class="h-7 w-7 rounded-xl bg-red-50 text-telkom-red flex items-center justify-center text-xs font-black shrink-0">3</span>
                    <span class="text-sm font-semibold text-slate-800">Berapa lama proses review usulan Use Case saya?</span>
                </div>
                <i data-lucide="chevron-down" class="h-4 w-4 text-slate-400 shrink-0 transition-transform duration-200" :class="active === 3 ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="active === 3" x-collapse x-cloak class="px-5 pb-5 pt-1">
                <div class="pl-10 space-y-2 text-sm text-slate-600 leading-relaxed">
                    <p>
                        Proses review oleh tim Satgas AI umumnya membutuhkan waktu <strong class="text-slate-800">5–10 hari kerja</strong> sejak usulan diterima.
                        Kamu akan mendapatkan notifikasi melalui platform ini ketika status usulanmu diperbarui.
                    </p>
                    <p>Cek SLA dan proses review lengkap di:</p>
                    <a href="https://telkomuniversity.ac.id" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-1.5 text-telkom-red font-semibold hover:underline">
                        <i data-lucide="external-link" class="h-3.5 w-3.5"></i>
                        SLA & Alur Review Use Case — Satgas AI
                    </a>
                </div>
            </div>
        </div>

        {{-- ─── FAQ 4 ─── --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden" id="faq-4">
            <button
                @click="active === 4 ? active = null : active = 4"
                class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-slate-50 transition-colors gap-3"
            >
                <div class="flex items-center gap-3">
                    <span class="h-7 w-7 rounded-xl bg-red-50 text-telkom-red flex items-center justify-center text-xs font-black shrink-0">4</span>
                    <span class="text-sm font-semibold text-slate-800">Siapa yang bisa saya hubungi jika ada masalah teknis?</span>
                </div>
                <i data-lucide="chevron-down" class="h-4 w-4 text-slate-400 shrink-0 transition-transform duration-200" :class="active === 4 ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="active === 4" x-collapse x-cloak class="px-5 pb-5 pt-1">
                <div class="pl-10 space-y-2 text-sm text-slate-600 leading-relaxed">
                    <p>
                        Untuk masalah teknis terkait platform (login gagal, data tidak tersimpan, dll.), silakan hubungi tim IT Satgas AI melalui:
                    </p>
                    <ul class="space-y-1.5 mt-2">
                        <li>
                            <a href="mailto:satgasai@telkomuniversity.ac.id" target="_blank" rel="noopener"
                               class="inline-flex items-center gap-1.5 text-telkom-red font-semibold hover:underline">
                                <i data-lucide="mail" class="h-3.5 w-3.5"></i>
                                satgasai@telkomuniversity.ac.id
                            </a>
                        </li>
                        <li>
                            <a href="https://wa.me/6281234567890" target="_blank" rel="noopener"
                               class="inline-flex items-center gap-1.5 text-telkom-red font-semibold hover:underline">
                                <i data-lucide="message-square" class="h-3.5 w-3.5"></i>
                                WhatsApp Support Satgas AI
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- ─── FAQ 5 ─── --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden" id="faq-5">
            <button
                @click="active === 5 ? active = null : active = 5"
                class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-slate-50 transition-colors gap-3"
            >
                <div class="flex items-center gap-3">
                    <span class="h-7 w-7 rounded-xl bg-red-50 text-telkom-red flex items-center justify-center text-xs font-black shrink-0">5</span>
                    <span class="text-sm font-semibold text-slate-800">Di mana saya bisa mempelajari kebijakan AI Telkom University?</span>
                </div>
                <i data-lucide="chevron-down" class="h-4 w-4 text-slate-400 shrink-0 transition-transform duration-200" :class="active === 5 ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="active === 5" x-collapse x-cloak class="px-5 pb-5 pt-1">
                <div class="pl-10 space-y-2 text-sm text-slate-600 leading-relaxed">
                    <p>
                        Seluruh kebijakan, regulasi, dan panduan etika AI Telkom University telah dipublikasikan secara resmi. Kamu dapat mengaksesnya melalui tautan berikut:
                    </p>
                    <ul class="space-y-1.5 mt-2">
                        <li>
                            <a href="https://telkomuniversity.ac.id" target="_blank" rel="noopener"
                               class="inline-flex items-center gap-1.5 text-telkom-red font-semibold hover:underline">
                                <i data-lucide="book-open" class="h-3.5 w-3.5"></i>
                                Kebijakan AI Telkom University (Official)
                            </a>
                        </li>
                        <li>
                            <a href="https://telkomuniversity.ac.id" target="_blank" rel="noopener"
                               class="inline-flex items-center gap-1.5 text-telkom-red font-semibold hover:underline">
                                <i data-lucide="shield" class="h-3.5 w-3.5"></i>
                                Panduan Etika Penggunaan AI — Satgas AI FIF
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

    {{-- Contact card --}}
    <div class="bg-gradient-to-br from-red-50 to-white border border-red-100 rounded-2xl p-5 flex flex-col sm:flex-row items-start sm:items-center gap-4">
        <div class="h-10 w-10 rounded-xl bg-telkom-red/10 flex items-center justify-center shrink-0">
            <i data-lucide="headphones" class="h-5 w-5 text-telkom-red"></i>
        </div>
        <div class="flex-1">
            <p class="text-sm font-bold text-slate-800">Masih punya pertanyaan lain?</p>
            <p class="text-xs text-slate-500 mt-0.5">Tim Satgas AI siap membantu kamu. Hubungi kami melalui email atau WhatsApp.</p>
        </div>
        <a href="mailto:satgasai@telkomuniversity.ac.id"
           class="px-5 py-2.5 bg-telkom-red hover:bg-red-700 text-white rounded-xl text-xs font-bold shadow-sm transition-all shrink-0">
            Hubungi Kami
        </a>
    </div>

</div>
@endsection
