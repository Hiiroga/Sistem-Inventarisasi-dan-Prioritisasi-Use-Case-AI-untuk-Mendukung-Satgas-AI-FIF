<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $usersQuery = User::where('role', 'user')->latest();
        $adminsQuery = User::where('role', 'admin')->latest();

        if ($request->filled('search')) {
            $keyword = '%'.$request->string('search')->trim()->toString().'%';

            foreach ([$usersQuery, $adminsQuery] as $query) {
                $query->where(function ($query) use ($keyword): void {
                    $query->where('name', 'like', $keyword)
                        ->orWhere('email', 'like', $keyword);
                });
            }
        }

        return view('admin.users.index', [
            'users' => $usersQuery->get(),
            'admins' => $adminsQuery->get(),
        ]);
    }

    public function promote(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Akun ini sudah menjadi Admin.');
        }

        $user->update(['role' => 'admin']);

        return redirect()->route('admin.users.index')
            ->with('success', $user->name.' berhasil diangkat menjadi Admin.');
    }

    public function demote(User $admin)
    {
        abort_unless($admin->isAdmin(), 404);

        if ($admin->is(auth()->user())) {
            return back()->with('error', 'Anda tidak dapat mencabut akses admin sendiri.');
        }

        if (User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'Minimal harus tetap ada satu akun Admin.');
        }

        $admin->update(['role' => 'user']);

        return redirect()->route('admin.users.index')
            ->with('success', 'Status Admin berhasil dicabut.');
    }

    public function destroyUser(User $user)
    {
        if ($user->is(auth()->user()) || $user->isAdmin()) {
            return back()->with('error', 'Akun administrator aktif tidak dapat dihapus dari halaman ini.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Akun User berhasil dihapus.');
    }
}
