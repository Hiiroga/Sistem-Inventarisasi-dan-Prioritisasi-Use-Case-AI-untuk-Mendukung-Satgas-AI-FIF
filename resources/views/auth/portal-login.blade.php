<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Satgas AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>[x-cloak]{display:none!important;} body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-lg border border-slate-100 p-8 w-full max-w-sm"
         x-data="{ loginAs: '{{ old('login_as', 'user') }}' }">

        <div class="text-center mb-6">
            <div class="h-12 w-12 bg-red-600 text-white rounded-xl flex items-center justify-center font-black mx-auto mb-3">UC</div>
            <h1 class="text-lg font-extrabold text-slate-800">Masuk ke Sistem</h1>
            <p class="text-xs text-slate-400">Inventarisasi Use Case AI — Satgas AI FIF</p>
        </div>

        <div class="grid grid-cols-2 gap-2 mb-6 bg-slate-100 p-1 rounded-xl">
            <button type="button" @click="loginAs = 'user'"
                    :class="loginAs === 'user' ? 'bg-white shadow text-telkom-red' : 'text-slate-500'"
                    class="py-2 rounded-lg text-xs font-bold transition-all">
                👤 Login sebagai User
            </button>
            <button type="button" @click="loginAs = 'admin'"
                    :class="loginAs === 'admin' ? 'bg-white shadow text-telkom-red' : 'text-slate-500'"
                    class="py-2 rounded-lg text-xs font-bold transition-all">
                🛡️ Login sebagai Admin
            </button>
        </div>

        @if($errors->any())
            <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-slate-700 text-xs px-4 py-3 rounded-xl">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('portal.login.submit') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="login_as" x-model="loginAs">

            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-500 uppercase">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm">
            </div>
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-500 uppercase">Password</label>
                <input type="password" name="password" required
                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm">
            </div>
            <label class="flex items-center gap-2 text-xs text-slate-500">
                <input type="checkbox" name="remember"> Ingat saya
            </label>

            <button type="submit"
                    class="w-full py-2.5 text-white rounded-xl text-sm font-bold transition-all"
                    :class="loginAs === 'admin' ? 'bg-slate-800 hover:bg-slate-900' : 'bg-telkom-red hover:bg-red-700'"
                    x-text="loginAs === 'admin' ? 'Masuk sebagai Admin' : 'Masuk sebagai User'">
            </button>
        </form>

        <p class="text-center text-xs text-slate-400 mt-5">
            Belum punya akun user? <a href="{{ route('register') }}" class="text-telkom-red font-bold hover:underline">Daftar di sini</a>
        </p>
    </div>

    <script>
        tailwind.config = { theme: { extend: { colors: { 'telkom-red': '#E52521' } } } }
    </script>
</body>
</html>