<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#E52521">
    <title>Daftar Akun — Satgas AI Telkom University</title>

    @include('partials.theme')

    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen bg-white text-slate-800 antialiased">

    {{-- Pembagian panel 75% (identitas) : 25% (formulir) pada layar lg ke atas. --}}
    <div class="min-h-screen lg:grid lg:grid-cols-[3fr_1fr]"
         x-data="{ showPassword: false, showConfirm: false }">

        {{-- ── Panel kiri: identitas sistem, penuh setinggi layar (desktop) ── --}}
        <div class="relative hidden lg:flex flex-col justify-between p-10 xl:p-14 bg-gradient-to-br from-slate-900 via-slate-800 to-brand-900 text-white overflow-hidden">
            <div class="absolute inset-0 opacity-[0.13]" aria-hidden="true">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[26rem] h-[26rem] rounded-full border border-white/40"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[36rem] h-[36rem] rounded-full border border-brand-400/40"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[46rem] h-[46rem] rounded-full border border-white/20"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[56rem] h-[56rem] rounded-full border border-white/10"></div>
            </div>
            <div class="absolute -bottom-32 -left-24 h-96 w-96 rounded-full bg-brand-600/20 blur-3xl" aria-hidden="true"></div>

            <div class="relative z-10 flex items-center gap-3">
            </div>

            <div class="relative z-10 space-y-6 max-w-2xl">
                <h2 class="text-4xl xl:text-5xl 2xl:text-6xl font-black tracking-tight leading-[1.1]">
                    Punya ide<br>pemanfaatan AI?<br>Usulkan di sini.
                </h2>
                <p class="text-base text-slate-300 leading-relaxed font-light">
                    Buat akun pengusul untuk mendaftarkan ide use case AI kamu dan memantau hasil penilaiannya oleh Satgas AI.
                </p>
                <ul class="space-y-3.5 pt-2">
                    @foreach([
                        ['pen-line', 'Ajukan usulan use case AI'],
                        ['activity', 'Pantau status & skor prioritas'],
                        ['message-circle', 'Bantuan lewat asisten SatBot'],
                    ] as [$icon, $text])
                        <li class="flex items-center gap-3 text-sm text-slate-300">
                            <span class="h-8 w-8 shrink-0 grid place-items-center rounded-xl bg-white/10 border border-white/15">
                                <i data-lucide="{{ $icon }}" class="h-4 w-4"></i>
                            </span>
                            {{ $text }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <p class="relative z-10 text-[11px] text-slate-400">© {{ now()->year }} Satgas AI — Fakultas Ilmu Informatika, Telkom University</p>
        </div>

        {{-- ── Panel kanan: formulir pendaftaran, penuh setinggi layar ── --}}
        {{-- Padding dipersempit mulai lg karena panel ini hanya seperempat lebar layar. --}}
        <div class="relative flex min-h-screen lg:min-h-0 flex-col justify-center px-6 py-10 sm:px-10 lg:px-7 xl:px-9">
            {{-- Aksen lembut khusus tampilan ponsel, karena panel kiri disembunyikan --}}
            <div class="pointer-events-none absolute inset-x-0 top-0 h-64 bg-gradient-to-b from-brand-50/70 to-transparent lg:hidden" aria-hidden="true"></div>

            <div class="relative w-full max-w-md mx-auto">
                <div class="lg:hidden flex items-center gap-2.5 mb-8">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/0/03/Logo_Telkom_University_potrait.png"
                         alt="" class="h-10 w-10 object-contain">
                    <div class="leading-tight">
                        <p class="text-sm font-extrabold text-slate-800">Telkom University</p>
                        <p class="text-[10px] font-bold text-telkom-red uppercase tracking-[0.14em]">Satgas AI FIF</p>
                    </div>
                </div>


                @if(session('status'))
                    <div role="status" class="mb-5 flex items-start gap-2.5 bg-emerald-50 border border-emerald-100 text-slate-700 text-xs px-4 py-3 rounded-xl">
                        <i data-lucide="check-circle-2" class="h-4 w-4 text-emerald-600 shrink-0 mt-px"></i>
                        <span class="leading-relaxed">{{ session('status') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div role="alert" class="mb-5 flex items-start gap-2.5 bg-red-50 border border-red-100 text-slate-700 text-xs px-4 py-3 rounded-xl">
                        <i data-lucide="alert-circle" class="h-4 w-4 text-red-500 shrink-0 mt-px"></i>
                        <div class="leading-relaxed space-y-0.5">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
                    @csrf

                    <div class="space-y-1.5">
                        <label for="name" class="ui-label">Nama Lengkap</label>
                        <div class="relative">
                            <i data-lucide="user" class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                   autocomplete="name" placeholder="Nama sesuai data kampus"
                                   @if($errors->has('name')) aria-invalid="true" @endif
                                   class="ui-field !pl-10">
                        </div>
                        @error('name')
                            <p class="text-[11px] font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label for="email" class="ui-label">Email</label>
                        <div class="relative">
                            <i data-lucide="mail" class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                   autocomplete="email" placeholder="nama@telkomuniversity.ac.id"
                                   @if($errors->has('email')) aria-invalid="true" @endif
                                   class="ui-field !pl-10">
                        </div>
                        @error('email')
                            <p class="text-[11px] font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label for="password" class="ui-label">Kata Sandi</label>
                        <div class="relative">
                            <i data-lucide="lock" class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            <input id="password" name="password" type="password" required autocomplete="new-password" placeholder="••••••••"
                                   :type="showPassword ? 'text' : 'password'"
                                   passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                                   @if($errors->has('password')) aria-invalid="true" @endif
                                   class="ui-field !pl-10 !pr-11">
                            <button type="button" @click="showPassword = !showPassword"
                                    :aria-label="showPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                                    class="absolute right-2.5 top-1/2 -translate-y-1/2 h-7 w-7 grid place-items-center rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
                                <i data-lucide="eye" class="h-4 w-4" x-show="!showPassword"></i>
                                <i data-lucide="eye-off" class="h-4 w-4" x-show="showPassword" x-cloak></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-[11px] font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label for="password_confirmation" class="ui-label">Konfirmasi Kata Sandi</label>
                        <div class="relative">
                            <i data-lucide="lock-keyhole" class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" placeholder="••••••••"
                                   :type="showConfirm ? 'text' : 'password'"
                                   passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                                   class="ui-field !pl-10 !pr-11">
                            <button type="button" @click="showConfirm = !showConfirm"
                                    :aria-label="showConfirm ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                                    class="absolute right-2.5 top-1/2 -translate-y-1/2 h-7 w-7 grid place-items-center rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
                                <i data-lucide="eye" class="h-4 w-4" x-show="!showConfirm"></i>
                                <i data-lucide="eye-off" class="h-4 w-4" x-show="showConfirm" x-cloak></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" data-test="register-user-button"
                            class="w-full py-3 bg-telkom-red hover:bg-brand-600 text-white rounded-xl text-sm font-bold shadow-md transition-all duration-200 flex items-center justify-center gap-2 hover:-translate-y-px active:translate-y-0">
                        Buat Akun
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </button>
                </form>

                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-100"></div></div>
                    <div class="relative flex justify-center"><span class="bg-white px-3 text-[11px] text-slate-400">atau</span></div>
                </div>

                <p class="text-center text-xs text-slate-500">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-telkom-red font-bold hover:underline underline-offset-2">Masuk di sini</a>
                </p>

                <p class="lg:hidden text-center text-[11px] text-slate-300 mt-10">
                    © {{ now()->year }} Satgas AI — Fakultas Ilmu Informatika
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
        document.addEventListener('alpine:initialized', () => lucide.createIcons());
    </script>
</body>
</html>
