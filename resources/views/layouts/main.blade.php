<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#E52521">
    <title>@yield('title', 'Manajemen Use Case') — Satgas AI Telkom University</title>

    @include('partials.theme')

    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen antialiased"
      x-data="{ sidebarOpen: false }"
      x-bind:class="sidebarOpen ? 'overflow-hidden lg:overflow-auto' : ''">

@php
    $currentUser = auth()->user();
    $isAdminGuard = $currentUser?->isAdmin() ?? false;

    $notifikasi = collect();
    if ($currentUser) {
        if ($isAdminGuard) {
            $notifikasi = \App\Models\UseCase::with('kategori')
                ->latest()
                ->take(6)
                ->get()
                ->map(fn($uc) => [
                    'judul' => 'Usulan baru: ' . $uc->nama_use_case,
                    'sub' => 'Diusulkan oleh ' . $uc->pengusul,
                    'waktu' => $uc->created_at,
                ]);
        } else {
            $notifikasi = \App\Models\UseCase::with('penilaianPrioritas')
                ->where('user_id', $currentUser->id)
                ->whereHas('penilaianPrioritas')
                ->latest('updated_at')
                ->take(6)
                ->get()
                ->map(fn($uc) => [
                    'judul' => 'Usulanmu telah dinilai: ' . $uc->nama_use_case,
                    'sub' => 'Skor: ' . ($uc->penilaianPrioritas->skor_prioritas ?? '-') . ' (' . ($uc->penilaianPrioritas->level_prioritas ?? '-') . ')',
                    'waktu' => $uc->updated_at,
                ]);
        }
    }

    // Kelas dasar untuk item navigasi sidebar, dipakai ulang di bawah.
    $navBase = 'group relative flex items-center gap-3 pl-3 pr-3 py-2.5 rounded-xl text-sm font-semibold transition-colors duration-150';
    $navIdle = 'text-slate-500 hover:bg-slate-50 hover:text-telkom-red';
    $navActive = 'bg-brand-50 text-telkom-red';
@endphp

    <a href="#konten-utama"
       class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-[60] focus:bg-white focus:text-telkom-red focus:px-4 focus:py-2.5 focus:rounded-xl focus:shadow-lift focus:text-sm focus:font-bold">
        Lewati ke konten utama
    </a>

    <div class="flex min-h-screen">
        {{-- Lapisan gelap saat sidebar terbuka di layar kecil --}}
        <div x-show="sidebarOpen" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-slate-900/50 backdrop-blur-[2px] z-30 lg:hidden"
             aria-hidden="true"></div>

        {{-- ─────────────────────────── Sidebar ─────────────────────────── --}}
        {{-- x-cloak menahan sidebar tetap tertutup di layar kecil sampai Alpine siap (lihat .sidebar-shell di partials/theme). --}}
        <aside x-cloak
               :class="sidebarOpen ? 'translate-x-0 shadow-lift' : '-translate-x-full lg:translate-x-0'"
               class="sidebar-shell fixed lg:sticky top-0 left-0 h-screen w-[17rem] bg-white border-r border-slate-100 z-40 flex flex-col transition-transform duration-300 ease-out shrink-0"
               aria-label="Navigasi utama">

            <div class="flex items-center gap-3 px-5 h-16 border-b border-slate-100 shrink-0">
                <img src="https://upload.wikimedia.org/wikipedia/commons/0/03/Logo_Telkom_University_potrait.png"
                     alt="" class="h-9 w-9 object-contain shrink-0">
                <div class="leading-tight min-w-0">
                    <p class="text-sm font-extrabold text-slate-800 truncate">Telkom University</p>
                    <p class="text-[10px] font-bold text-telkom-red uppercase tracking-[0.14em]">Satgas AI</p>
                </div>
                <button @click="sidebarOpen = false"
                        class="ml-auto lg:hidden h-8 w-8 -mr-1 grid place-items-center rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors">
                    <i data-lucide="x" class="h-5 w-5"></i>
                    <span class="sr-only">Tutup menu</span>
                </button>
            </div>

            <nav class="flex-1 px-3 py-5 space-y-1 overflow-y-auto ui-scroll">
                <p class="text-[10px] font-bold uppercase tracking-[0.14em] text-slate-400 px-3 mb-2">Menu Utama</p>

                @if($isAdminGuard)
                    @php
                        $adminMenu = [
                            ['route' => 'dashboard.usecase', 'active' => 'dashboard.usecase', 'icon' => 'layout-dashboard', 'label' => 'Dashboard'],
                            ['route' => 'use-cases.index', 'active' => 'use-cases.index', 'icon' => 'list', 'label' => 'Daftar Use Case'],
                            ['route' => 'use-cases.create', 'active' => 'use-cases.create', 'icon' => 'plus-circle', 'label' => 'Tambah Use Case'],
                            ['route' => 'admin.users.index', 'active' => 'admin.users.*', 'icon' => 'users', 'label' => 'Kelola User'],
                        ];
                    @endphp

                    @foreach($adminMenu as $item)
                        @php $isActive = request()->routeIs($item['active']); @endphp
                        <a href="{{ route($item['route']) }}"
                           @if($isActive) aria-current="page" @endif
                           class="{{ $navBase }} {{ $isActive ? $navActive : $navIdle }}">
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 rounded-r-full bg-telkom-red transition-all duration-200 {{ $isActive ? 'h-6' : 'h-0 group-hover:h-3' }}"></span>
                            <i data-lucide="{{ $item['icon'] }}" class="h-4.5 w-4.5 shrink-0"></i>
                            {{ $item['label'] }}
                        </a>
                    @endforeach

                @else
                    @php
                        $userMenu = [
                            ['route' => 'user.dashboard', 'active' => 'user.dashboard', 'icon' => 'layout-dashboard', 'label' => 'Dashboard Saya'],
                            ['route' => 'user.create', 'active' => 'user.create', 'icon' => 'plus-circle', 'label' => 'Usulkan Use Case'],
                        ];
                    @endphp

                    @foreach($userMenu as $item)
                        @php $isActive = request()->routeIs($item['active']); @endphp
                        <a href="{{ route($item['route']) }}"
                           @if($isActive) aria-current="page" @endif
                           class="{{ $navBase }} {{ $isActive ? $navActive : $navIdle }}">
                            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 rounded-r-full bg-telkom-red transition-all duration-200 {{ $isActive ? 'h-6' : 'h-0 group-hover:h-3' }}"></span>
                            <i data-lucide="{{ $item['icon'] }}" class="h-4.5 w-4.5 shrink-0"></i>
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                @endif
            </nav>

            <div class="p-3 shrink-0">
                <div class="relative overflow-hidden bg-gradient-to-br from-brand-50 via-white to-white p-4 rounded-2xl border border-brand-100/70">
                    <div class="absolute -right-6 -top-6 h-16 w-16 rounded-full bg-brand-100/50"></div>
                    <div class="relative">
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-telkom-red mb-1.5">
                            <i data-lucide="shield-check" class="h-3.5 w-3.5"></i>
                            Satgas AI Telkom U 2026
                        </span>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Platform penjamin mutu, kepatuhan, &amp; penilaian prioritas use case AI di lingkungan internal Telkom University.
                        </p>
                    </div>
                </div>
            </div>
        </aside>

        {{-- ──────────────────────────── Konten ─────────────────────────── --}}
        <div class="flex-1 min-w-0 flex flex-col">
            <header class="bg-white/85 backdrop-blur-md border-b border-slate-100 sticky top-0 z-20">
                <div class="h-16 px-4 sm:px-6 flex items-center gap-3">
                    <button @click="sidebarOpen = true"
                            class="lg:hidden h-9 w-9 -ml-1 grid place-items-center rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">
                        <i data-lucide="menu" class="h-5 w-5"></i>
                        <span class="sr-only">Buka menu navigasi</span>
                    </button>

                    <form action="{{ $isAdminGuard ? route('use-cases.index') : route('user.dashboard') }}"
                          method="GET" role="search" class="relative flex-1 max-w-md">
                        <label for="header-search" class="sr-only">Cari use case</label>
                        <i data-lucide="search" class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                        <input id="header-search" type="search" name="search" value="{{ request('search') }}"
                               placeholder="Cari use case, teknologi, pengusul…"
                               class="ui-field !pl-10 !py-2 !rounded-xl text-sm">
                    </form>

                    <div class="ml-auto flex items-center gap-2 sm:gap-3">
                        {{-- Notifikasi --}}
                        <div class="relative" x-data="{ notifOpen: false }" @keydown.escape.window="notifOpen = false">
                            <button @click="notifOpen = !notifOpen"
                                    :aria-expanded="notifOpen.toString()"
                                    class="relative h-9 w-9 grid place-items-center rounded-xl text-slate-500 hover:text-telkom-red hover:bg-brand-50 transition-colors">
                                <i data-lucide="bell" class="h-5 w-5"></i>
                                @if($notifikasi->count() > 0)
                                    <span class="absolute top-1.5 right-1.5 flex h-2.5 w-2.5">
                                        <span class="absolute inline-flex h-full w-full rounded-full bg-telkom-red opacity-60 animate-ping"></span>
                                        <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-telkom-red ring-2 ring-white"></span>
                                    </span>
                                @endif
                                <span class="sr-only">Notifikasi ({{ $notifikasi->count() }})</span>
                            </button>

                            <div x-show="notifOpen" @click.away="notifOpen = false" x-cloak
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 -translate-y-1 scale-95"
                                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-[19rem] sm:w-80 origin-top-right bg-white rounded-2xl shadow-lift border border-slate-100 overflow-hidden z-50">
                                <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between bg-slate-50/60">
                                    <p class="text-xs font-bold text-slate-700">Notifikasi</p>
                                    @if($notifikasi->count() > 0)
                                        <span class="text-[10px] font-bold text-telkom-red bg-brand-50 px-2 py-0.5 rounded-full">{{ $notifikasi->count() }} baru</span>
                                    @endif
                                </div>
                                <div class="max-h-80 overflow-y-auto ui-scroll">
                                    @forelse($notifikasi as $notif)
                                        <div class="px-4 py-3 border-b border-slate-50 last:border-0 hover:bg-slate-50/70 transition-colors">
                                            <div class="flex gap-3">
                                                <span class="mt-0.5 h-7 w-7 shrink-0 grid place-items-center rounded-lg bg-brand-50 text-telkom-red">
                                                    <i data-lucide="{{ $isAdminGuard ? 'inbox' : 'badge-check' }}" class="h-3.5 w-3.5"></i>
                                                </span>
                                                <div class="min-w-0">
                                                    <p class="text-xs font-semibold text-slate-700 leading-snug">{{ $notif['judul'] }}</p>
                                                    <p class="text-[11px] text-slate-400 mt-0.5">{{ $notif['sub'] }}</p>
                                                    <p class="text-[10px] text-slate-400 mt-1 tnum">
                                                        {{ $notif['waktu']->translatedFormat('d M Y') }} · {{ $notif['waktu']->format('H:i') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="px-4 py-10 text-center">
                                            <span class="mx-auto mb-2 h-10 w-10 grid place-items-center rounded-full bg-slate-50 text-slate-300">
                                                <i data-lucide="bell-off" class="h-5 w-5"></i>
                                            </span>
                                            <p class="text-xs text-slate-400">Belum ada notifikasi.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>

                        @if($currentUser)
                            <div class="text-right hidden sm:block leading-tight">
                                <p class="text-sm font-bold text-slate-700 max-w-[12rem] truncate">{{ $currentUser->name }}</p>
                                <p class="text-[11px] text-slate-400">{{ $isAdminGuard ? 'Administrator' : 'Pengusul' }}</p>
                            </div>

                            <div class="relative" x-data="{ userMenuOpen: false }" @keydown.escape.window="userMenuOpen = false">
                                <button @click="userMenuOpen = !userMenuOpen"
                                        :aria-expanded="userMenuOpen.toString()"
                                        class="h-9 w-9 rounded-full bg-gradient-to-br from-brand-500 to-telkom-maroon text-white flex items-center justify-center text-xs font-bold shrink-0 ring-2 ring-white shadow-brand transition-transform hover:scale-105">
                                    {{ strtoupper(mb_substr($currentUser->name, 0, 2)) }}
                                    <span class="sr-only">Menu akun</span>
                                </button>

                                <div x-show="userMenuOpen" @click.away="userMenuOpen = false" x-cloak
                                     x-transition:enter="transition ease-out duration-150"
                                     x-transition:enter-start="opacity-0 -translate-y-1 scale-95"
                                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                     x-transition:leave="transition ease-in duration-100"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="absolute right-0 mt-2 w-60 origin-top-right bg-white rounded-2xl shadow-lift border border-slate-100 overflow-hidden z-50">
                                    <div class="px-4 py-3 border-b border-slate-100 bg-slate-50/60">
                                        <p class="text-xs font-bold text-slate-700 truncate">{{ $currentUser->name }}</p>
                                        <p class="text-[11px] text-slate-400 truncate">{{ $currentUser->email }}</p>
                                        <span class="mt-2 inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full {{ $isAdminGuard ? 'bg-slate-800 text-white' : 'bg-brand-50 text-telkom-red' }}">
                                            {{ $isAdminGuard ? 'Administrator' : 'Pengusul' }}
                                        </span>
                                    </div>
                                    <form method="POST" action="{{ route('portal.logout') }}" class="p-1.5">
                                        @csrf
                                        <button type="submit"
                                                class="w-full flex items-center gap-2.5 text-left px-3 py-2.5 rounded-xl text-sm font-semibold text-red-600 hover:bg-red-50 transition-colors">
                                            <i data-lucide="log-out" class="h-4 w-4"></i>
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </header>

            <main id="konten-utama" class="flex-1 px-4 sm:px-6 py-6 sm:py-8 max-w-7xl w-full mx-auto animate-fadeUp">
                @yield('content')
            </main>

            <footer class="px-4 sm:px-6 py-5 border-t border-slate-100 bg-white/60">
                <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-1.5 text-[11px] text-slate-400">
                    <p>© {{ now()->year }} Satgas AI — Fakultas Ilmu Informatika, Telkom University.</p>
                    <p>Inventarisasi &amp; Prioritisasi Use Case AI</p>
                </div>
            </footer>
        </div>
    </div>

    {{-- ─── Tombol mengambang Pusat Bantuan (kanan bawah) ─── --}}
    {{-- Label ditaruh sebelum ikon agar pil melebar ke kiri, menjauhi tepi layar. --}}
    <a href="{{ route('bantuan') }}"
       title="Pusat Bantuan"
       class="no-print group fixed bottom-5 right-5 z-50 flex items-center gap-0 hover:gap-2.5
              bg-telkom-red hover:bg-brand-600 text-white rounded-full shadow-brand hover:shadow-lift
              px-3.5 py-3.5 transition-all duration-300 ease-out">
        <span class="text-xs font-bold whitespace-nowrap max-w-0 opacity-0 group-hover:max-w-[10rem] group-hover:opacity-100 transition-all duration-300 overflow-hidden">
            Pusat Bantuan
        </span>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="h-5 w-5 shrink-0 transition-transform duration-300 group-hover:-rotate-6" aria-hidden="true">
            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
            <path d="M12 2a3 3 0 0 1 3 3v6H9V5a3 3 0 0 1 3-3z"></path>
            <line x1="8" y1="15" x2="8" y2="18"></line>
            <line x1="16" y1="15" x2="16" y2="18"></line>
            <circle cx="9" cy="14" r="0.5" fill="currentColor"></circle>
            <circle cx="15" cy="14" r="0.5" fill="currentColor"></circle>
        </svg>
    </a>

    {{-- ─── Toast ─── --}}
    @if(session('success') || session('error'))
        @php $isError = (bool) session('error'); @endphp
        <div x-data="{ show: false }"
             x-init="$nextTick(() => show = true); setTimeout(() => show = false, 5000)"
             x-show="show" x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-3"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-3"
             role="status" aria-live="polite"
             {{--
                Tombol Pusat Bantuan ada di kanan bawah. Di layar kecil toast
                ditumpuk di atasnya; mulai sm toast cukup digeser ke kiri.
             --}}
             class="no-print fixed z-50 flex items-start gap-3 bottom-24 left-5 right-5 sm:bottom-5 sm:right-auto sm:max-w-sm bg-slate-900 text-white pl-4 pr-3 py-3.5 rounded-2xl shadow-lift border border-slate-700/60">
            <span class="mt-0.5 h-5 w-5 shrink-0 grid place-items-center rounded-full {{ $isError ? 'bg-red-500/20 text-red-300' : 'bg-emerald-500/20 text-emerald-300' }}">
                <i data-lucide="{{ $isError ? 'alert-circle' : 'check' }}" class="h-3.5 w-3.5"></i>
            </span>
            <span class="text-xs font-semibold leading-relaxed flex-1">{{ session('error') ?: session('success') }}</span>
            <button @click="show = false" class="shrink-0 text-slate-400 hover:text-white transition-colors">
                <i data-lucide="x" class="h-4 w-4"></i>
                <span class="sr-only">Tutup notifikasi</span>
            </button>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
        // Alpine merender ulang sebagian DOM (dropdown, toast), jadi ikon dibuat ulang.
        document.addEventListener('alpine:initialized', () => lucide.createIcons());
    </script>
    @stack('scripts')
</body>
</html>
