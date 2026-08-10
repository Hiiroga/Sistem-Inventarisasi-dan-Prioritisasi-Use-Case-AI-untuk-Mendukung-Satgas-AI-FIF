{{--
    Tema tampilan bersama (font, konfigurasi Tailwind CDN, dan gaya dasar).
    Di-include di <head> oleh layouts/main.blade.php, auth/portal-login.blade.php,
    dan pages/auth/register.blade.php agar seluruh halaman memakai token visual
    yang sama. Konfigurasi Tailwind harus berada di <head> — sebelum markup
    dirender — supaya warna kustom seperti `telkom-red` benar-benar aktif.
--}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        // Aplikasi ini bertema terang. Tanpa baris ini Tailwind memakai
        // darkMode 'media', sehingga kelas dark: pada view pihak ketiga
        // (mis. pagination bawaan Laravel) ikut aktif saat OS bermode gelap.
        darkMode: 'class',
        theme: {
            extend: {
                fontFamily: {
                    sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                },
                colors: {
                    telkom: {
                        red: '#E52521',
                        maroon: '#C8102E',
                        grey: '#717476',
                        dark: '#1E293B',
                    },
                    // Skala turunan dari merah Telkom, untuk tint & shade yang konsisten.
                    brand: {
                        50: '#FFF5F5',
                        100: '#FFE6E5',
                        200: '#FFCCCA',
                        300: '#FFA6A2',
                        400: '#F97169',
                        500: '#E52521',
                        600: '#C8102E',
                        700: '#A00D24',
                        800: '#7C0A1C',
                        900: '#5A0714',
                    },
                },
                boxShadow: {
                    xs: '0 1px 2px 0 rgba(15, 23, 42, 0.05)',
                    card: '0 1px 2px rgba(15, 23, 42, 0.04), 0 12px 32px -20px rgba(15, 23, 42, 0.28)',
                    lift: '0 4px 10px rgba(15, 23, 42, 0.05), 0 24px 48px -28px rgba(15, 23, 42, 0.45)',
                    brand: '0 8px 20px -10px rgba(229, 37, 33, 0.65)',
                },
                spacing: {
                    '4.5': '1.125rem',
                    '18': '4.5rem',
                },
                borderRadius: {
                    '4xl': '2rem',
                },
                keyframes: {
                    floatY: {
                        '0%, 100%': { transform: 'translateY(0)' },
                        '50%': { transform: 'translateY(-8px)' },
                    },
                    fadeUp: {
                        from: { opacity: '0', transform: 'translateY(10px)' },
                        to: { opacity: '1', transform: 'none' },
                    },
                    shimmer: {
                        '100%': { transform: 'translateX(100%)' },
                    },
                },
                animation: {
                    floatY: 'floatY 6s ease-in-out infinite',
                    fadeUp: 'fadeUp .45s cubic-bezier(.22,1,.36,1) both',
                },
            },
        },
    };
</script>

<style>
    [x-cloak] { display: none !important; }

    /*
       Sidebar tidak boleh ikut disembunyikan oleh [x-cloak]; ia hanya perlu
       tetap tergeser keluar layar sampai Alpine mengambil alih :class-nya.
       Selektor ini lebih spesifik sehingga menang atas aturan di atas.
    */
    .sidebar-shell[x-cloak] { display: flex !important; transform: translateX(-100%); }
    @media (min-width: 1024px) {
        .sidebar-shell[x-cloak] { transform: none; }
    }

    :root {
        --brand: #E52521;
        --brand-dark: #C8102E;
        --ring: rgba(229, 37, 33, 0.14);
    }

    html { -webkit-tap-highlight-color: transparent; }

    body {
        font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        font-feature-settings: 'cv02', 'cv03', 'cv04', 'ss01';
    }

    ::selection { background: rgba(229, 37, 33, 0.16); color: #7C0A1C; }

    /* Angka sejajar rapi pada tabel & kartu statistik. */
    .tnum { font-variant-numeric: tabular-nums; }

    /* ── Scrollbar halus ───────────────────────────────────────────────── */
    .ui-scroll { scrollbar-width: thin; scrollbar-color: #CBD5E1 transparent; }
    .ui-scroll::-webkit-scrollbar { width: 8px; height: 8px; }
    .ui-scroll::-webkit-scrollbar-track { background: transparent; }
    .ui-scroll::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 9999px; }
    .ui-scroll:hover::-webkit-scrollbar-thumb { background: #CBD5E1; }

    /* ── Fokus keyboard yang konsisten & terlihat ──────────────────────── */
    :where(a, button, [role="button"], summary, [tabindex]):focus-visible {
        outline: 2px solid var(--brand);
        outline-offset: 2px;
        border-radius: 0.625rem;
    }

    /* ── Field form ────────────────────────────────────────────────────── */
    .ui-label {
        display: block;
        font-size: 0.6875rem;
        font-weight: 700;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        color: #64748B;
    }

    .ui-field {
        width: 100%;
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 0.75rem;
        padding: 0.625rem 0.875rem;
        font-size: 0.875rem;
        line-height: 1.5;
        color: #1E293B;
        transition: background-color .15s ease, border-color .15s ease, box-shadow .15s ease;
    }
    .ui-field::placeholder { color: #94A3B8; }
    .ui-field:hover:not(:focus):not(:disabled) { border-color: #CBD5E1; }
    .ui-field:focus {
        outline: none;
        background: #FFFFFF;
        border-color: var(--brand);
        box-shadow: 0 0 0 4px var(--ring);
    }
    .ui-field:disabled { background: #F1F5F9; color: #94A3B8; cursor: not-allowed; }
    .ui-field[aria-invalid="true"] { border-color: #EF4444; background: #FEF2F2; }
    .ui-field[aria-invalid="true"]:focus { box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.14); }

    textarea.ui-field { resize: vertical; min-height: 5rem; }

    select.ui-field {
        appearance: none;
        -webkit-appearance: none;
        padding-right: 2.25rem;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2394A3B8' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1rem;
        cursor: pointer;
    }

    /* Checkbox & radio mengikuti warna merek. */
    .ui-check {
        accent-color: var(--brand);
        width: 1rem;
        height: 1rem;
        cursor: pointer;
    }

    /* ── Kartu ─────────────────────────────────────────────────────────── */
    .ui-card {
        background: #FFFFFF;
        border: 1px solid #EEF2F7;
        border-radius: 1.25rem;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04), 0 12px 32px -24px rgba(15, 23, 42, 0.35);
    }

    /* ── Animasi masuk bertahap untuk isi halaman ──────────────────────── */
    .ui-stagger > * { animation: fadeUp .5s cubic-bezier(.22, 1, .36, 1) both; }
    .ui-stagger > *:nth-child(1) { animation-delay: .02s; }
    .ui-stagger > *:nth-child(2) { animation-delay: .06s; }
    .ui-stagger > *:nth-child(3) { animation-delay: .10s; }
    .ui-stagger > *:nth-child(4) { animation-delay: .14s; }
    .ui-stagger > *:nth-child(5) { animation-delay: .18s; }
    .ui-stagger > *:nth-child(6) { animation-delay: .22s; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: none; }
    }
    @keyframes floatY {
        0%, 100% { transform: translateY(0); }
        50%      { transform: translateY(-8px); }
    }

    /* Hormati preferensi pengguna yang mengurangi animasi. */
    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after {
            animation-duration: .01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: .01ms !important;
            scroll-behavior: auto !important;
        }
    }

    /* Sembunyikan elemen hanya secara visual, tetap terbaca screen reader. */
    .sr-only {
        position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px;
        overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0;
    }

    @media print {
        .no-print { display: none !important; }
    }
</style>
