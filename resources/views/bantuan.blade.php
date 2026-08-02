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
                Chat dengan SatBot — asisten virtual kami. Pilih topik pertanyaanmu dan dapatkan jawaban instan, tanpa antri!
            </p>
        </div>
        {{-- Decorative circles --}}
        <div class="absolute right-0 bottom-0 top-0 w-1/3 opacity-15 hidden md:block">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-72 h-72 rounded-full border border-white/30"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 rounded-full border border-red-500/20"></div>
        </div>
    </div>

    {{-- ─────────────────────────────────────────────────────────────────── --}}
    {{-- CHATBOT WINDOW                                                       --}}
    {{-- ─────────────────────────────────────────────────────────────────── --}}
    <div
        id="chatbot-window"
        x-data="satbot()"
        x-init="init()"
        class="bg-white rounded-3xl border border-slate-100 shadow-lg overflow-hidden flex flex-col"
        style="height: 560px; min-height: 420px;"
    >

        {{-- ── Chat Header ── --}}
        <div class="flex items-center gap-3 px-5 py-4 bg-gradient-to-r from-slate-900 to-red-950 text-white shrink-0">
            <div class="relative">
                <div class="h-10 w-10 rounded-full bg-telkom-red/80 border-2 border-red-400/60 flex items-center justify-center text-lg shadow-md">
                    🤖
                </div>
                <span class="absolute bottom-0 right-0 h-2.5 w-2.5 rounded-full bg-green-400 border-2 border-slate-900 shadow"></span>
            </div>
            <div class="flex-1 leading-tight">
                <p class="text-sm font-bold">SatBot</p>
                <p class="text-[11px] text-slate-300 font-light">Asisten Virtual Satgas AI FIF</p>
            </div>
            {{-- Tombol reset percakapan --}}
            <button
                @click="resetChat()"
                title="Mulai percakapan baru"
                class="flex items-center gap-1.5 text-[11px] font-semibold text-slate-300 hover:text-white bg-white/5 hover:bg-white/15 px-3 py-1.5 rounded-full transition-all"
            >
                <i data-lucide="refresh-cw" class="h-3 w-3"></i>
                <span class="hidden sm:inline">Reset Chat</span>
            </button>
        </div>

        {{-- ── Chat Messages Area ── --}}
        <div
            id="chat-messages"
            x-ref="messageContainer"
            class="flex-1 overflow-y-auto px-4 py-5 space-y-4 bg-slate-50/60"
            style="scroll-behavior: smooth;"
        >

            {{-- Render messages --}}
            <template x-for="(msg, idx) in messages" :key="idx">
                <div>

                    {{-- Bot message --}}
                    <div x-show="msg.role === 'bot'" class="flex items-end gap-2.5 max-w-[90%] sm:max-w-[75%]">
                        <div class="h-7 w-7 rounded-full bg-telkom-red/10 border border-red-100 flex items-center justify-center text-sm shrink-0 mb-0.5">🤖</div>
                        <div class="space-y-1 flex-1">
                            {{-- Typing indicator --}}
                            <div x-show="msg.typing" class="bg-white border border-slate-100 rounded-2xl rounded-bl-sm px-4 py-3 shadow-xs inline-block">
                                <div class="flex items-center gap-1">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-400 animate-bounce" style="animation-delay: 0ms;"></span>
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-400 animate-bounce" style="animation-delay: 100ms;"></span>
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-400 animate-bounce" style="animation-delay: 200ms;"></span>
                                </div>
                            </div>
                            {{-- Actual message --}}
                            <div x-show="!msg.typing" class="bg-white border border-slate-100 rounded-2xl rounded-bl-sm px-4 py-3 shadow-xs">
                                <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-line" x-html="formatMessage(msg.text)"></p>
                                {{-- Links opsional --}}
                                <template x-if="msg.links && msg.links.length > 0">
                                    <div class="mt-3 pt-3 border-t border-slate-100 space-y-1.5">
                                        <template x-for="(link, li) in msg.links" :key="li">
                                            <a :href="link.url" target="_blank" rel="noopener"
                                               class="flex items-center gap-1.5 text-xs text-telkom-red font-semibold hover:underline">
                                                <i data-lucide="external-link" class="h-3 w-3 shrink-0"></i>
                                                <span x-text="link.label"></span>
                                            </a>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    {{-- User message --}}
                    <div x-show="msg.role === 'user'" class="flex items-end gap-2.5 max-w-[90%] sm:max-w-[75%] ml-auto flex-row-reverse">
                        <div class="h-7 w-7 rounded-full bg-telkom-red flex items-center justify-center text-white text-[11px] font-black shrink-0 mb-0.5 shadow">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="bg-telkom-red text-white rounded-2xl rounded-br-sm px-4 py-3 shadow-sm">
                            <p class="text-sm leading-relaxed" x-text="msg.text"></p>
                        </div>
                    </div>

                </div>
            </template>

            {{-- Spacer untuk scroll --}}
            <div x-ref="scrollAnchor" class="h-1"></div>
        </div>

        {{-- ── Action Area (Pilihan Topik / Tombol Kembali) ── --}}
        <div class="px-4 py-4 bg-white border-t border-slate-100 shrink-0">

            {{-- State: tampilkan daftar topik --}}
            <div x-show="step === 'menu' && !isTyping" x-cloak>
                <p class="text-[11px] text-slate-400 font-semibold mb-2.5 uppercase tracking-widest">Pilih topik pertanyaanmu:</p>
                <div class="flex flex-wrap gap-2">
                    <template x-for="topic in currentTopics" :key="topic.id">
                        <button
                            @click="selectTopic(topic)"
                            class="px-3.5 py-2 text-xs font-semibold rounded-xl border border-slate-200 text-slate-700 bg-slate-50 hover:bg-red-50 hover:border-red-200 hover:text-telkom-red transition-all duration-150 text-left"
                            x-text="topic.question"
                        ></button>
                    </template>
                </div>
            </div>

            {{-- State: setelah jawaban — tampilkan opsi lanjut --}}
            <div x-show="step === 'answered' && !isTyping" x-cloak class="space-y-3">

                {{-- Submenu (followUp) jika ada --}}
                <template x-if="followUpTopics.length > 0">
                    <div>
                        <p class="text-[11px] text-slate-400 font-semibold mb-2 uppercase tracking-widest">Pertanyaan lanjutan:</p>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="topic in followUpTopics" :key="topic.id">
                                <button
                                    @click="selectTopic(topic)"
                                    class="px-3.5 py-2 text-xs font-semibold rounded-xl border border-slate-200 text-slate-700 bg-slate-50 hover:bg-red-50 hover:border-red-200 hover:text-telkom-red transition-all duration-150 text-left"
                                    x-text="topic.question"
                                ></button>
                            </template>
                        </div>
                    </div>
                </template>

                {{-- Tombol kembali ke menu utama --}}
                <button
                    @click="goBackToMenu()"
                    class="flex items-center gap-2 px-4 py-2.5 text-xs font-bold rounded-xl border-2 border-slate-200 text-slate-600 hover:border-telkom-red hover:text-telkom-red hover:bg-red-50 transition-all duration-150"
                >
                    <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i>
                    Ganti Pertanyaan / Kembali ke Menu Utama
                </button>
            </div>

            {{-- Loading state saat bot sedang "mengetik" --}}
            <div x-show="isTyping" x-cloak class="text-[11px] text-slate-400 italic">
                SatBot sedang membalas...
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

{{-- ─── Load data FAQ dari file konfigurasi terpisah (output: window.SATBOT_FAQ) ─── --}}
@include('partials.faq-data')

<script>
/**
 * ─────────────────────────────────────────────────────────────────────────────
 *  SATBOT — Alpine.js Component
 *  Rule-based chatbot (no AI/LLM, no API call)
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
        messages:       [],       // array riwayat chat: { role, text, links, typing }
        step:           'menu',   // 'menu' | 'answered'
        currentTopics:  [],       // topik yang sedang ditampilkan di action area
        followUpTopics: [],       // submenu setelah bot menjawab
        isTyping:       false,    // apakah bot sedang "mengetik"

        // ── Init ─────────────────────────────────────────────────────────
        init() {
            // Tampilkan semua topik pada menu utama
            this.currentTopics = faqData;
            // Kirim pesan pembuka dari bot (dengan sedikit delay biar natural)
            setTimeout(() => {
                this.addBotMessage(botGreeting, [], 0);
            }, 200);
        },

        // ── Fungsi: user memilih topik ───────────────────────────────────
        selectTopic(topic) {
            if (this.isTyping) return;

            // Tambah bubble user
            this.messages.push({
                role: 'user',
                text: topic.question,
                links: [],
                typing: false,
            });
            this.scrollToBottom();

            // Siapkan follow-up topics
            const followUpIds = topic.followUp || [];
            this.followUpTopics = followUpIds
                .map(id => faqMap[id])
                .filter(Boolean);

            // Kirim jawaban bot (dengan typing indicator)
            this.addBotMessage(topic.answer, topic.links || [], 600);
            this.step = 'answered';
        },

        // ── Fungsi: tambah pesan bot dengan opsional typing indicator ─────
        addBotMessage(text, links, delay) {
            // Tampilkan typing indicator dulu
            this.isTyping = true;
            const typingMsg = {
                role: 'bot',
                text: '',
                links: [],
                typing: true,
            };
            this.messages.push(typingMsg);
            this.scrollToBottom();

            // Setelah delay, ganti dengan pesan asli
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
                // Re-init icons karena DOM berubah
                setTimeout(() => { if (window.lucide) lucide.createIcons(); }, 50);
            }, delay + 400);
        },

        // ── Fungsi: kembali ke menu utama ────────────────────────────────
        goBackToMenu() {
            this.step = 'menu';
            this.currentTopics = faqData;
            this.followUpTopics = [];
            // Tambah pesan sistem: kembali ke menu
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

        // ── Fungsi: format markdown sederhana (bold **text**) ────────────
        formatMessage(text) {
            if (!text) return '';
            // **bold**
            let html = text.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
            // Baris baru
            html = html.replace(/\n/g, '<br>');
            return html;
        },
    };
}
</script>

@endsection
