<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'email' => 'admin@admin.lv',
            'password' => Hash::make('admin123'),
            'type' => 'admin',
        ]);
    }
}
