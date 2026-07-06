<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    <div class="relative flex-1 max-w-md">
                        <i data-lucide="search" class="absolute left-3 top-2.5 h-4 w-4 text-slate-400"></i>
                        <input type="text" placeholder="Cari use case, teknologi, pengusul..."
                               class="w-full bg-slate-50 border border-slate-100 rounded-xl pl-9 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-telkom-red">
                    </div>
                    <div class="ml-auto flex items-center gap-3">
                        <button class="relative text-slate-500 hover:text-telkom-red">
                            <i data-lucide="bell" class="h-5 w-5"></i>
                            <span class="absolute -top-0.5 -right-0.5 h-2 w-2 rounded-full bg-telkom-red"></span>
                        </button>
                        <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>
                        <div class="text-right hidden sm:block leading-tight">
                            <p class="text-sm font-bold text-slate-700">Satgas AI Manager</p>
                            <p class="text-[11px] text-slate-400">Administrator Telkom U</p>
                        </div>
                        <div class="h-9 w-9 rounded-full bg-red-50 border-2 border-red-100 text-telkom-red flex items-center justify-center text-xs font-bold shrink-0">SA</div>
                    </div>
                </div>
            </header>

            <main class="flex-1 px-4 sm:px-6 py-6 max-w-7xl w-full mx-auto">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Toast notification -->
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