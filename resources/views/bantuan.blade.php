@extends('layouts.main')
@section('title', 'Pusat Bantuan')

@section('content')
<div class="space-y-6 ui-stagger">

    {{-- ── Hero ── --}}
    <section class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-brand-900 text-white rounded-3xl p-6 md:p-9 overflow-hidden shadow-lift">
        <div class="relative z-10 max-w-2xl space-y-3.5">
            <h1 class="text-2xl md:text-[2rem] font-black tracking-tight leading-tight">Ada yang bisa kami bantu? 🤖</h1>
            <p class="text-slate-300 text-sm leading-relaxed font-light">
                Ngobrol dengan SatBot — asisten virtual kami. Pilih topik pertanyaanmu dan dapatkan jawaban instan.
            </p>
        </div>
        <div class="absolute right-0 bottom-0 top-0 w-1/3 opacity-[0.15] hidden md:block" aria-hidden="true">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-72 h-72 rounded-full border border-white/30"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 rounded-full border border-brand-500/30"></div>
        </div>
    </section>

    {{-- ─────────────────────────────────────────────────────────────────── --}}
    {{-- JENDELA CHATBOT                                                     --}}
    {{-- ─────────────────────────────────────────────────────────────────── --}}
    <div id="chatbot-window"
         x-data="satbot()"
         x-init="init()"
         class="ui-card overflow-hidden flex flex-col h-[min(72vh,600px)] min-h-[26rem]">

        {{-- ── Header chat ── --}}
        <div class="flex items-center gap-3 px-5 py-3.5 bg-gradient-to-r from-slate-900 to-brand-900 text-white shrink-0">
            <div class="relative shrink-0">
                <div class="h-10 w-10 rounded-full bg-telkom-red/80 border-2 border-brand-400/60 flex items-center justify-center text-lg shadow-md">
                    🤖
                </div>
                <span class="absolute bottom-0 right-0 h-2.5 w-2.5 rounded-full bg-emerald-400 border-2 border-slate-900"></span>
            </div>
            <div class="flex-1 leading-tight min-w-0">
                <p class="text-sm font-bold">SatBot</p>
                <p class="text-[11px] text-slate-300 font-light flex items-center gap-1.5">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span> Online — Asisten Virtual Satgas AI FIF
                </p>
            </div>
            <button @click="resetChat()" title="Mulai percakapan baru"
                    class="shrink-0 flex items-center gap-1.5 text-[11px] font-semibold text-slate-300 hover:text-white bg-white/5 hover:bg-white/15 px-3 py-1.5 rounded-full transition-colors">
                <i data-lucide="refresh-cw" class="h-3 w-3"></i>
                <span class="hidden sm:inline">Reset Chat</span>
            </button>
        </div>

        {{-- ── Area pesan ── --}}
        <div id="chat-messages"
             x-ref="messageContainer"
             role="log" aria-live="polite" aria-label="Riwayat percakapan dengan SatBot"
             class="flex-1 overflow-y-auto ui-scroll px-4 sm:px-5 py-5 space-y-4 bg-slate-50/60"
             style="scroll-behavior: smooth;">

            <template x-for="(msg, idx) in messages" :key="idx">
                <div>
                    {{-- Pesan bot --}}
                    <div x-show="msg.role === 'bot'" class="flex items-end gap-2.5 max-w-[92%] sm:max-w-[78%]">
                        <div class="h-7 w-7 rounded-full bg-brand-50 border border-brand-100 flex items-center justify-center text-sm shrink-0 mb-0.5">🤖</div>
                        <div class="space-y-1 flex-1 min-w-0">
                            {{-- Indikator mengetik --}}
                            <div x-show="msg.typing" class="bg-white border border-slate-100 rounded-2xl rounded-bl-md px-4 py-3 shadow-xs inline-block">
                                <div class="flex items-center gap-1">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-400 animate-bounce" style="animation-delay: 0ms;"></span>
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-400 animate-bounce" style="animation-delay: 120ms;"></span>
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-400 animate-bounce" style="animation-delay: 240ms;"></span>
                                </div>
                            </div>
                            {{-- Isi pesan --}}
                            <div x-show="!msg.typing" class="bg-white border border-slate-100 rounded-2xl rounded-bl-md px-4 py-3 shadow-xs">
                                <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-line" x-html="formatMessage(msg.text)"></p>
                                <template x-if="msg.links && msg.links.length > 0">
                                    <div class="mt-3 pt-3 border-t border-slate-100 space-y-1.5">
                                        <template x-for="(link, li) in msg.links" :key="li">
                                            <a :href="link.url" target="_blank" rel="noopener noreferrer"
                                               class="flex items-start gap-1.5 text-xs text-telkom-red font-semibold hover:underline underline-offset-2">
                                                <i data-lucide="external-link" class="h-3 w-3 shrink-0 mt-0.5"></i>
                                                <span x-text="link.label"></span>
                                            </a>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    {{-- Pesan pengguna --}}
                    <div x-show="msg.role === 'user'" class="flex items-end gap-2.5 max-w-[92%] sm:max-w-[78%] ml-auto flex-row-reverse">
                        <div class="h-7 w-7 rounded-full bg-gradient-to-br from-brand-500 to-telkom-maroon flex items-center justify-center text-white text-[11px] font-black shrink-0 mb-0.5 shadow">
                            {{ strtoupper(mb_substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="bg-telkom-red text-white rounded-2xl rounded-br-md px-4 py-3 shadow-sm">
                            <p class="text-sm leading-relaxed" x-text="msg.text"></p>
                        </div>
                    </div>
                </div>
            </template>

            <div x-ref="scrollAnchor" class="h-1"></div>
        </div>

        {{-- ── Area aksi (pilihan topik) ── --}}
        <div class="px-4 sm:px-5 py-4 bg-white border-t border-slate-100 shrink-0 max-h-[45%] overflow-y-auto ui-scroll">

            {{-- Daftar topik utama --}}
            <div x-show="step === 'menu' && !isTyping" x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <p class="text-[10px] text-slate-400 font-bold mb-2.5 uppercase tracking-[0.12em]">Pilih topik pertanyaanmu</p>
                <div class="flex flex-wrap gap-2">
                    <template x-for="topic in currentTopics" :key="topic.id">
                        <button @click="selectTopic(topic)"
                                class="group flex items-center gap-2 px-3.5 py-2.5 text-xs font-semibold rounded-xl border border-slate-200 text-slate-600 bg-white hover:bg-brand-50 hover:border-brand-200 hover:text-telkom-red transition-colors duration-150 text-left">
                            <i data-lucide="help-circle" class="h-3.5 w-3.5 shrink-0 text-slate-300 group-hover:text-telkom-red transition-colors"></i>
                            <span x-text="topic.question"></span>
                        </button>
                    </template>
                </div>
            </div>

            {{-- Setelah bot menjawab --}}
            <div x-show="step === 'answered' && !isTyping" x-cloak class="space-y-3.5"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0">

                <template x-if="followUpTopics.length > 0">
                    <div>
                        <p class="text-[10px] text-slate-400 font-bold mb-2 uppercase tracking-[0.12em]">Pertanyaan lanjutan</p>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="topic in followUpTopics" :key="topic.id">
                                <button @click="selectTopic(topic)"
                                        class="group flex items-center gap-2 px-3.5 py-2.5 text-xs font-semibold rounded-xl border border-slate-200 text-slate-600 bg-white hover:bg-brand-50 hover:border-brand-200 hover:text-telkom-red transition-colors duration-150 text-left">
                                    <i data-lucide="corner-down-right" class="h-3.5 w-3.5 shrink-0 text-slate-300 group-hover:text-telkom-red transition-colors"></i>
                                    <span x-text="topic.question"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </template>

                <button @click="goBackToMenu()"
                        class="flex items-center gap-2 px-4 py-2.5 text-xs font-bold rounded-xl border border-slate-200 text-slate-600 hover:border-telkom-red hover:text-telkom-red hover:bg-brand-50 transition-colors duration-150">
                    <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i>
                    Ganti Pertanyaan / Kembali ke Menu Utama
                </button>
            </div>

            {{-- Bot sedang mengetik --}}
            <div x-show="isTyping" x-cloak class="flex items-center gap-2 text-[11px] text-slate-400 italic py-1.5">
                <span class="flex gap-0.5">
                    <span class="h-1 w-1 rounded-full bg-slate-300 animate-bounce" style="animation-delay: 0ms;"></span>
                    <span class="h-1 w-1 rounded-full bg-slate-300 animate-bounce" style="animation-delay: 120ms;"></span>
                    <span class="h-1 w-1 rounded-full bg-slate-300 animate-bounce" style="animation-delay: 240ms;"></span>
                </span>
                SatBot sedang membalas…
            </div>
        </div>
    </div>

    {{-- ── Kartu kontak ── --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-brand-50 to-white border border-brand-100 rounded-2xl p-5 flex flex-col sm:flex-row items-start sm:items-center gap-4">
        <span class="h-11 w-11 shrink-0 grid place-items-center rounded-2xl bg-white border border-brand-100 text-telkom-red">
            <i data-lucide="headphones" class="h-5 w-5"></i>
        </span>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-bold text-slate-800">Masih punya pertanyaan lain?</p>
            <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Tim Satgas AI siap membantu. Hubungi kami melalui email resmi berikut.</p>
        </div>
        <a href="mailto:satgasai@telkomuniversity.ac.id"
           class="shrink-0 inline-flex items-center gap-1.5 px-5 py-2.5 bg-telkom-red hover:bg-brand-600 text-white rounded-xl text-xs font-bold shadow-brand transition-all duration-200 hover:-translate-y-px">
            <i data-lucide="mail" class="h-4 w-4"></i> Hubungi Kami
        </a>
    </div>
</div>

{{-- ─── Data FAQ dari file konfigurasi terpisah (output: window.SATBOT_FAQ) ─── --}}
@include('partials.faq-data')

<script>
/**
 * ─────────────────────────────────────────────────────────────────────────────
 *  SATBOT — Komponen Alpine.js
 *  Chatbot berbasis aturan (tanpa AI/LLM, tanpa panggilan API).
 *  Semua logika ada di sini; DATA ada di partials/faq-data.blade.php
 * ─────────────────────────────────────────────────────────────────────────────
 */
function satbot() {
    // ── Data FAQ dari JS global (di-set oleh partials/faq-data.blade.php) ──────
    const faqData     = window.SATBOT_FAQ || [];
    const botGreeting = window.SATBOT_GREETING || 'Halo! Pilih topik pertanyaanmu:';

    // Buat lookup map berdasarkan ID untuk akses cepat
    const faqMap = {};
    faqData.forEach(item => { faqMap[item.id] = item; });

    return {
        // ── State ────────────────────────────────────────────────────────
        messages:       [],       // riwayat chat: { role, text, links, typing }
        step:           'menu',   // 'menu' | 'answered'
        currentTopics:  [],       // topik yang tampil di area aksi
        followUpTopics: [],       // submenu setelah bot menjawab
        isTyping:       false,    // apakah bot sedang "mengetik"

        // ── Init ─────────────────────────────────────────────────────────
        init() {
            this.currentTopics = faqData;
            setTimeout(() => {
                this.addBotMessage(botGreeting, [], 0);
            }, 200);
        },

        // ── Fungsi: user memilih topik ───────────────────────────────────
        selectTopic(topic) {
            if (this.isTyping) return;

            this.messages.push({
                role: 'user',
                text: topic.question,
                links: [],
                typing: false,
            });
            this.scrollToBottom();

            const followUpIds = topic.followUp || [];
            this.followUpTopics = followUpIds
                .map(id => faqMap[id])
                .filter(Boolean);

            this.addBotMessage(topic.answer, topic.links || [], 600);
            this.step = 'answered';
        },

        // ── Fungsi: tambah pesan bot dengan indikator mengetik ────────────
        addBotMessage(text, links, delay) {
            this.isTyping = true;
            const typingMsg = {
                role: 'bot',
                text: '',
                links: [],
                typing: true,
            };
            this.messages.push(typingMsg);
            this.scrollToBottom();

            setTimeout(() => {
                const idx = this.messages.indexOf(typingMsg);
                if (idx !== -1) {
                    this.messages.splice(idx, 1, {
                        role: 'bot',
                        text: text,
                        links: links,
                        typing: false,
                    });
                }
                this.isTyping = false;
                this.scrollToBottom();
                // Ikon dibuat ulang karena DOM berubah.
                setTimeout(() => { if (window.lucide) lucide.createIcons(); }, 50);
            }, delay + 400);
        },

        // ── Fungsi: kembali ke menu utama ────────────────────────────────
        goBackToMenu() {
            this.step = 'menu';
            this.currentTopics = faqData;
            this.followUpTopics = [];
            this.addBotMessage('Tentu! Silakan pilih topik lain yang ingin kamu tanyakan 😊', [], 0);
        },

        // ── Fungsi: reset seluruh percakapan ─────────────────────────────
        resetChat() {
            this.messages = [];
            this.step = 'menu';
            this.currentTopics = faqData;
            this.followUpTopics = [];
            this.isTyping = false;
            setTimeout(() => {
                this.addBotMessage(botGreeting, [], 0);
            }, 150);
        },

        // ── Fungsi: scroll otomatis ke bawah ─────────────────────────────
        scrollToBottom() {
            this.$nextTick(() => {
                const container = this.$refs.messageContainer;
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            });
        },

        // ── Fungsi: format markdown sederhana (**bold**) ─────────────────
        formatMessage(text) {
            if (!text) return '';
            let html = text.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
            html = html.replace(/\n/g, '<br>');
            return html;
        },
    };
}
</script>
@endsection
