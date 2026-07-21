<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummyUserSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name' => 'Jeff Satur', 'email' => 'jeffsatur@student.telkomuniversity.ac.id'],
            ['name' => 'Leeteuk', 'email' => 'leeteuk@student.telkomuniversity.ac.id'],
            ['name' => 'Heechul', 'email' => 'heechul@student.telkomuniversity.ac.id'],
            ['name' => 'Yesung', 'email' => 'yesung@student.telkomuniversity.ac.id'],
            ['name' => 'Kangin', 'email' => 'kangin@student.telkomuniversity.ac.id'],
            ['name' => 'Shindong', 'email' => 'shindong@student.telkomuniversity.ac.id'],
            ['name' => 'Sungmin', 'email' => 'sungmin@student.telkomuniversity.ac.id'],
            ['name' => 'Eunhyuk', 'email' => 'eunhyuk@student.telkomuniversity.ac.id'],
            ['name' => 'Donghae', 'email' => 'donghae@student.telkomuniversity.ac.id'],
            ['name' => 'Siwon', 'email' => 'siwon@student.telkomuniversity.ac.id'],
            ['name' => 'Ryeowook', 'email' => 'ryeowook@student.telkomuniversity.ac.id'],
            ['name' => 'Kyuhyun', 'email' => 'kyuhyun@student.telkomuniversity.ac.id'],
        ];

        foreach ($data as $item) {
            User::firstOrCreate(
                ['email' => $item['email']],
                [
                    'name' => $item['name'],
                    'password' => Hash::make('password123'),
                ]
            );
        }

        $this->command->info(count($data).' akun User dummy berhasil dibuat (password: password123).');
    }
}
