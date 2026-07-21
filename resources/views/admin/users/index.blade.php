@extends('layouts.main')
@section('title', 'Kelola Akun')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-slate-800">Kelola Akun</h1>
            <p class="text-slate-400 text-xs mt-0.5">Akun User terdaftar otomatis lewat SSO kampus. Admin bisa mengangkat User menjadi Admin.</p>
        </div>
        <form method="GET" class="relative w-full md:max-w-xs">
            <i data-lucide="search" class="absolute left-3 top-2.5 h-4 w-4 text-slate-400"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
                   class="w-full bg-white border border-slate-200 rounded-xl pl-9 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-telkom-red">
        </form>
    </div>

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 text-slate-700 text-xs px-4 py-3 rounded-xl">{{ session('error') }}</div>
    @endif

    <div class="bg-white rounded-3xl border border-slate-100 shadow-xs overflow-hidden">
        <div class="p-4 border-b border-slate-50">
            <h3 class="text-sm font-extrabold text-slate-800">🛡️ Admin Aktif ({{ $admins->count() }})</h3>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-400">
                <tr>
                    <th class="text-left py-3 px-4">Nama</th>
                    <th class="text-left py-3 px-4">Email</th>
                    <th class="text-left py-3 px-4">Diangkat</th>
                    <th class="text-left py-3 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($admins as $admin)
                <tr class="hover:bg-slate-50">
                    <td class="py-3 px-4 font-semibold text-slate-700">{{ $admin->name }}</td>
                    <td class="py-3 px-4 text-slate-500">{{ $admin->email }}</td>
                    <td class="py-3 px-4 text-slate-400 text-xs">{{ $admin->created_at->format('d M Y') }}</td>
                    <td class="py-3 px-4">
                        <form action="{{ route('admin.users.demote', $admin) }}" method="POST" onsubmit="return confirm('Cabut status Admin dari akun ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs font-bold text-red-500 hover:underline">Cabut Status Admin</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-slate-400 py-6">Tidak ada Admin yang cocok.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-xs overflow-hidden">
        <div class="p-4 border-b border-slate-50">
            <h3 class="text-sm font-extrabold text-slate-800">👤 Akun User Terdaftar ({{ $users->count() }})</h3>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-400">
                <tr>
                    <th class="text-left py-3 px-4">Nama</th>
                    <th class="text-left py-3 px-4">Email Kampus</th>
                    <th class="text-left py-3 px-4">Terdaftar</th>
                    <th class="text-left py-3 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($users as $user)
                <tr class="hover:bg-slate-50">
                    <td class="py-3 px-4 font-semibold text-slate-700">{{ $user->name }}</td>
                    <td class="py-3 px-4 text-slate-500">{{ $user->email }}</td>
                    <td class="py-3 px-4 text-slate-400 text-xs">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="py-3 px-4 flex gap-2">
                        <form action="{{ route('admin.users.promote', $user) }}" method="POST" onsubmit="return confirm('Jadikan {{ $user->name }} sebagai Admin?')">
                            @csrf
                            <button type="submit" class="text-xs font-bold text-telkom-red hover:underline">Jadikan Admin</button>
                        </form>
                        <form action="{{ route('admin.users.destroy-user', $user) }}" method="POST" onsubmit="return confirm('Hapus akun ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs font-bold text-slate-400 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-slate-400 py-10">Tidak ada User yang cocok.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
