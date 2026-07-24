<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Satgas AI Telkom University - Manajemen Use Case')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        telkom: { red: '#E52521', maroon: '#C8102E', grey: '#717476', dark: '#1E293B' }
                    }
                }
            }
        }
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak]{display:none!important;}
        body{font-family:'Inter',sans-serif;}
        @keyframes floatY {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen antialiased" x-data="{ sidebarOpen: false }" x-cloak>

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
@endphp

    <div class="flex min-h-screen">
        <!-- overlay mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen=false" class="fixed inset-0 bg-black/40 z-30 lg:hidden"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
               class="fixed lg:sticky top-0 left-0 h-screen w-64 bg-white border-r border-slate-100 z-40 flex flex-col transition-transform duration-300 shrink-0">

            <div class="flex items-center gap-2.5 px-5 py-5 border-b border-slate-100">
                <img src="https://upload.wikimedia.org/wikipedia/commons/0/03/Logo_Telkom_University_potrait.png" alt="Telkom University" class="h-9 w-9 object-contain shrink-0">
                <div class="leading-tight">
                    <p class="text-sm font-black text-slate-800">Telkom University</p>
                    <p class="text-[10px] font-bold text-telkom-red uppercase tracking-wider">Satgas AI</p>
                </div>
                <button @click="sidebarOpen=false" class="ml-auto lg:hidden text-slate-400">
                    <i data-lucide="x" class="h-5 w-5"></i>
                </button>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                @if($isAdminGuard)
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-300 px-3 mb-2">Main Menu</p>
                <a href="{{ route('dashboard.usecase') }}"
                   class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('dashboard.usecase') ? 'bg-red-50 text-telkom-red' : 'text-slate-600 hover:bg-slate-50 hover:text-telkom-red' }}">
                    <i data-lucide="layout-dashboard" class="h-4 w-4"></i> Dashboard
                </a>
                <a href="{{ route('use-cases.index') }}"
                   class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('use-cases.index') ? 'bg-red-50 text-telkom-red' : 'text-slate-600 hover:bg-slate-50 hover:text-telkom-red' }}">
                    <i data-lucide="list" class="h-4 w-4"></i> Daftar Use Case
                </a>
                <a href="{{ route('use-cases.create') }}"
                   class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('use-cases.create') ? 'bg-red-50 text-telkom-red' : 'text-slate-600 hover:bg-slate-50 hover:text-telkom-red' }}">
                    <i data-lucide="plus-circle" class="h-4 w-4"></i> Tambah Use Case
                </a>
                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.users.*') ? 'bg-red-50 text-telkom-red' : 'text-slate-600 hover:bg-slate-50 hover:text-telkom-red' }}">
                    <i data-lucide="users" class="h-4 w-4"></i> Kelola User
                </a>

                <!-- Dekoratif saja, tidak terhubung database -->
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-300 px-3 mb-2 mt-6">Simulated Modules</p>
                <div class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm text-slate-400 cursor-not-allowed">
                    <i data-lucide="sliders" class="h-4 w-4"></i> Analisis Risiko Etika
                    <span class="ml-auto text-[9px] font-bold bg-slate-100 text-slate-400 px-1.5 py-0.5 rounded">Sim</span>
                </div>
                <div class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm text-slate-400 cursor-not-allowed">
                    <i data-lucide="trending-up" class="h-4 w-4"></i> Kalkulator Prioritas
                    <span class="ml-auto text-[9px] font-bold bg-slate-100 text-slate-400 px-1.5 py-0.5 rounded">Sim</span>
                </div>
                <div class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm text-slate-400 cursor-not-allowed">
                    <i data-lucide="file-text" class="h-4 w-4"></i> Dokumentasi Regulasi
                    <span class="ml-auto text-[9px] font-bold bg-slate-100 text-slate-400 px-1.5 py-0.5 rounded">Sim</span>
                </div>
                @else
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-300 px-3 mb-2">Main Menu</p>
                <a href="{{ route('user.dashboard') }}"
                   class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('user.dashboard') ? 'bg-red-50 text-telkom-red' : 'text-slate-600 hover:bg-slate-50 hover:text-telkom-red' }}">
                    <i data-lucide="layout-dashboard" class="h-4 w-4"></i> Dashboard Saya
                </a>
                <a href="{{ route('user.create') }}"
                   class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('user.create') ? 'bg-red-50 text-telkom-red' : 'text-slate-600 hover:bg-slate-50 hover:text-telkom-red' }}">
                    <i data-lucide="plus-circle" class="h-4 w-4"></i> Usulkan Use Case
                </a>
                @endif
            </nav>

            <div class="p-3">
                <div class="bg-gradient-to-br from-red-50/70 to-white p-4 rounded-xl border border-red-50 text-left">
                    <span class="text-xs font-bold text-telkom-red block mb-1">Satgas AI Telkom U 2026</span>
                    <p class="text-[11px] text-slate-500 leading-relaxed font-light">
                        Platform penjamin mutu, kepatuhan, & penilaian prioritas use case AI di lingkungan internal Telkom University.
                    </p>
                </div>
            </div>
        </aside>

        <!-- Main -->
        <div class="flex-1 min-w-0 flex flex-col">
            <header class="bg-white border-b border-slate-100 sticky top-0 z-20">
                <div class="h-16 px-4 sm:px-6 flex items-center gap-3">
                    <button @click="sidebarOpen=true" class="lg:hidden text-slate-600">
                        <i data-lucide="menu" class="h-6 w-6"></i>
                    </button>
                    <form action="{{ $isAdminGuard ? route('use-cases.index') : route('user.dashboard') }}" method="GET" class="relative flex-1 max-w-md">
                        <i data-lucide="search" class="absolute left-3 top-2.5 h-4 w-4 text-slate-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari use case, teknologi, pengusul..."
                               class="w-full bg-slate-50 border border-slate-100 rounded-xl pl-9 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-telkom-red">
                    </form>
                    <div class="ml-auto flex items-center gap-3">
                        <div class="relative" x-data="{ notifOpen: false }">
                            <button @click="notifOpen = !notifOpen" class="relative text-slate-500 hover:text-telkom-red">
                                <i data-lucide="bell" class="h-5 w-5"></i>
                                @if($notifikasi->count() > 0)
                                <span class="absolute -top-0.5 -right-0.5 h-2 w-2 rounded-full bg-telkom-red"></span>
                                @endif
                            </button>
                            <div x-show="notifOpen" @click.away="notifOpen = false" x-cloak
                                 class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-lg border border-slate-100 py-2 z-50 max-h-96 overflow-y-auto">
                                <div class="px-4 py-2.5 border-b border-slate-50">
                                    <p class="text-xs font-bold text-slate-700">Notifikasi</p>
                                </div>
                                @forelse($notifikasi as $notif)
                                <div class="px-4 py-3 border-b border-slate-50 last:border-0 hover:bg-slate-50">
                                    <p class="text-xs font-semibold text-slate-700 leading-snug">{{ $notif['judul'] }}</p>
                                    <p class="text-[11px] text-slate-400 mt-0.5">{{ $notif['sub'] }}</p>
                                    <p class="text-[10px] text-telkom-red font-bold mt-1">
                                        {{ $notif['waktu']->translatedFormat('d M Y') }} • {{ $notif['waktu']->format('H:i') }}
                                    </p>
                                </div>
                                @empty
                                <div class="px-4 py-8 text-center text-slate-400 text-xs">Belum ada notifikasi.</div>
                                @endforelse
                            </div>
                        </div>
                        <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>
                        @if($currentUser)
                        <div class="text-right hidden sm:block leading-tight">
                            <p class="text-sm font-bold text-slate-700">{{ $currentUser->name }}</p>
                            <p class="text-[11px] text-slate-400">{{ $isAdminGuard ? 'Administrator' : 'Pengusul' }}</p>
                        </div>
                        <div class="relative" x-data="{ userMenuOpen: false }">
                            <button @click="userMenuOpen = !userMenuOpen" class="h-9 w-9 rounded-full bg-red-50 border-2 border-red-100 text-telkom-red flex items-center justify-center text-xs font-bold shrink-0">
                                {{ strtoupper(substr($currentUser->name, 0, 2)) }}
                            </button>
                            <div x-show="userMenuOpen" @click.away="userMenuOpen = false" x-cloak
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 py-2 z-50">
                                <div class="px-4 py-2 border-b border-slate-50">
                                    <p class="text-xs font-bold text-slate-700">{{ $currentUser->name }}</p>
                                    <p class="text-[11px] text-slate-400">{{ $currentUser->email }}</p>
                                </div>
                                <form method="POST" action="{{ route('portal.logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        Log out
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </header>

            <main class="flex-1 px-4 sm:px-6 py-6 max-w-7xl w-full mx-auto">
                @yield('content')
            </main>
        </div>
    </div>


    {{-- ─── Floating Bot Button ─── --}}
    <a href="{{ route('bantuan') }}"
       id="botButton"
       title="Pusat Bantuan"
       class="fixed bottom-5 left-5 z-50 group flex items-center gap-0 hover:gap-2.5 overflow-hidden
              bg-telkom-red text-white rounded-full shadow-xl hover:shadow-2xl
              transition-all duration-300 ease-in-out
              px-3.5 py-3.5 hover:px-5 hover:py-3.5"
       style="max-width: 3.5rem; hover:max-width: 12rem;"
    >
        {{-- Bot icon --}}
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="h-5 w-5 shrink-0">
            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
            <path d="M12 2a3 3 0 0 1 3 3v6H9V5a3 3 0 0 1 3-3z"></path>
            <line x1="8" y1="15" x2="8" y2="18"></line>
            <line x1="16" y1="15" x2="16" y2="18"></line>
            <circle cx="9" cy="14" r="0.5" fill="currentColor"></circle>
            <circle cx="15" cy="14" r="0.5" fill="currentColor"></circle>
        </svg>
        {{-- Label muncul saat hover --}}
        <span class="text-xs font-bold whitespace-nowrap max-w-0 opacity-0 group-hover:max-w-xs group-hover:opacity-100 transition-all duration-300 overflow-hidden">
            Pusat Bantuan
        </span>
    </a>

    {{-- Toast notification --}}
    @if(session('success'))
    <div id="toastNotif" class="fixed bottom-5 right-5 z-50 bg-slate-900 text-white px-5 py-3 rounded-2xl shadow-xl flex items-center gap-2.5 max-w-sm border border-slate-800">
        <div class="h-2 w-2 rounded-full bg-green-400"></div>
        <span class="text-xs font-semibold">{{ session('success') }}</span>
    </div>
    <script>
        setTimeout(() => {
            const t = document.getElementById('toastNotif');
            if (t) { t.style.transition = 'opacity .3s'; t.style.opacity = '0'; setTimeout(() => t.remove(), 300); }
        }, 4000);
    </script>
    @endif

    <script>document.addEventListener('DOMContentLoaded', () => lucide.createIcons());</script>
    @stack('scripts')
</body>
</html>
