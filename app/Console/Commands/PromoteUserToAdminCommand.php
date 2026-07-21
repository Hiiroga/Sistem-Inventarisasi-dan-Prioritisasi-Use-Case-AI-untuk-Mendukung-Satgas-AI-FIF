<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class PromoteUserToAdminCommand extends Command
{
    protected $signature = 'user:promote-admin {email}';

    protected $description = 'Mengangkat akun user yang sudah terdaftar menjadi administrator';

    public function handle(): int
    {
        $user = User::where('email', $this->argument('email'))->first();

        if (! $user) {
            $this->error('User dengan email tersebut tidak ditemukan.');

            return self::FAILURE;
        }

        $user->update(['role' => 'admin']);
        $this->info($user->email.' sekarang memiliki akses administrator.');

        return self::SUCCESS;
    }
}
