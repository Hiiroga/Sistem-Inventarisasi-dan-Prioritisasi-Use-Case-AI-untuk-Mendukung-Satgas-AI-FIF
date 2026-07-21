<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('admins')) {
            return;
        }

        DB::table('admins')->orderBy('id')->each(function (object $admin): void {
            $existingUser = DB::table('users')->where('email', $admin->email)->first();

            if ($existingUser) {
                DB::table('users')->where('id', $existingUser->id)->update(['role' => 'admin']);

                return;
            }

            DB::table('users')->insert([
                'name' => $admin->name,
                'email' => $admin->email,
                'role' => 'admin',
                'email_verified_at' => now(),
                'password' => $admin->password,
                'remember_token' => $admin->remember_token,
                'created_at' => $admin->created_at ?? now(),
                'updated_at' => now(),
            ]);
        });

        Schema::drop('admins');
    }

    public function down(): void
    {
        Schema::create('admins', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->where('role', 'admin')->orderBy('id')->each(function (object $user): void {
            DB::table('admins')->insert([
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
                'remember_token' => $user->remember_token,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ]);
        });
    }
};
