@extends('layouts.main')
@section('title', 'Kelola Akun')

@section('content')
<div class="space-y-6 ui-stagger">

    {{-- ── Judul halaman ── --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900">Kelola Akun</h1>
            <p class="text-slate-400 text-xs mt-1 max-w-xl leading-relaxed">
                Akun User terdaftar otomatis lewat SSO kampus. Admin dapat mengangkat User menjadi Admin.
            </p>
        </div>
        <form method="GET" role="search" class="w-full md:max-w-xs">
            <label for="cari-akun" class="sr-only">Cari akun</label>
            <div class="relative">
                <i data-lucide="search" class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                <input id="cari-akun" type="search" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama atau email…" class="ui-field !pl-10">
            </div>
        </form>
    </div>

    @if(session('error'))
        <div role="alert" class="flex items-start gap-2.5 bg-red-50 border border-red-100 text-slate-700 text-xs px-4 py-3.5 rounded-2xl">
            <i data-lucide="alert-circle" class="h-4 w-4 text-red-500 shrink-0 mt-px"></i>
            <span class="leading-relaxed">{{ session('error') }}</span>
        </div>
    @endif

    {{-- ── Admin aktif ── --}}
    <section class="ui-card overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-3">
            <span class="h-9 w-9 shrink-0 grid place-items-center rounded-xl bg-slate-900 text-white">
                <i data-lucide="shield-check" class="h-4.5 w-4.5"></i>
            </span>
            <div>
                <h2 class="text-sm font-extrabold text-slate-800">Admin Aktif</h2>
                <p class="text-[11px] text-slate-400">{{ $admins->count() }} akun dengan akses penuh</p>
            </div>
        </div>

        <div class="overflow-x-auto ui-scroll">
            <table class="w-full text-sm min-w-[40rem]">
                <thead class="bg-slate-50/80 text-[10px] uppercase tracking-wider text-slate-400">
                    <tr>
                        <th scope="col" class="text-left py-3 px-4">Nama</th>
                        <th scope="col" class="text-left py-3 px-4">Email</th>
                        <th scope="col" class="text-left py-3 px-4">Diangkat</th>
                        <th scope="col" class="text-right py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($admins as $admin)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <span class="h-8 w-8 shrink-0 grid place-items-center rounded-full bg-slate-900 text-white text-[11px] font-bold">
                                        {{ strtoupper(mb_substr($admin->name, 0, 2)) }}
                                    </span>
                                    <span class="font-semibold text-slate-700">{{ $admin->name }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-slate-500 text-xs">{{ $admin->email }}</td>
                            <td class="py-3 px-4 text-slate-400 text-xs tnum whitespace-nowrap">{{ $admin->created_at->translatedFormat('d M Y') }}</td>
                            <td class="py-3 px-4 text-right">
                                <form action="{{ route('admin.users.demote', $admin) }}" method="POST"
                                      onsubmit="return confirm('Cabut status Admin dari akun ini?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-bold text-slate-600 hover:border-red-200 hover:bg-red-50 hover:text-red-600 transition-colors">
                                        <i data-lucide="shield-off" class="h-3.5 w-3.5"></i> Cabut Status Admin
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <x-empty-state compact icon="shield-off" text="Tidak ada Admin yang cocok." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- ── User terdaftar ── --}}
    <section class="ui-card overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-3">
            <span class="h-9 w-9 shrink-0 grid place-items-center rounded-xl bg-brand-50 text-telkom-red">
                <i data-lucide="users" class="h-4.5 w-4.5"></i>
            </span>
            <div>
                <h2 class="text-sm font-extrabold text-slate-800">Akun User Terdaftar</h2>
                <p class="text-[11px] text-slate-400">{{ $users->count() }} akun pengusul</p>
            </div>
        </div>

        <div class="overflow-x-auto ui-scroll">
            <table class="w-full text-sm min-w-[40rem]">
                <thead class="bg-slate-50/80 text-[10px] uppercase tracking-wider text-slate-400">
                    <tr>
                        <th scope="col" class="text-left py-3 px-4">Nama</th>
                        <th scope="col" class="text-left py-3 px-4">Email Kampus</th>
                        <th scope="col" class="text-left py-3 px-4">Terdaftar</th>
                        <th scope="col" class="text-right py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <span class="h-8 w-8 shrink-0 grid place-items-center rounded-full bg-brand-50 text-telkom-red text-[11px] font-bold">
                                        {{ strtoupper(mb_substr($user->name, 0, 2)) }}
                                    </span>
                                    <span class="font-semibold text-slate-700">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-slate-500 text-xs">{{ $user->email }}</td>
                            <td class="py-3 px-4 text-slate-400 text-xs tnum whitespace-nowrap">{{ $user->created_at->translatedFormat('d M Y') }}</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center justify-end gap-2">
                                    <form action="{{ route('admin.users.promote', $user) }}" method="POST"
                                          onsubmit="return confirm('Jadikan {{ $user->name }} sebagai Admin?')">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-bold text-slate-600 hover:border-brand-200 hover:bg-brand-50 hover:text-telkom-red transition-colors">
                                            <i data-lucide="shield-plus" class="h-3.5 w-3.5"></i> Jadikan Admin
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.destroy-user', $user) }}" method="POST"
                                          onsubmit="return confirm('Hapus akun ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="Hapus akun"
                                                class="h-8 w-8 grid place-items-center rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-600 transition-colors">
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                            <span class="sr-only">Hapus akun {{ $user->name }}</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <x-empty-state icon="user-x"
                                               title="Tidak ada User yang cocok"
                                               text="{{ request('search') ? 'Coba kata kunci pencarian yang lain.' : 'Belum ada akun user terdaftar.' }}" />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
