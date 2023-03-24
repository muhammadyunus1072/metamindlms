<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            "email" => "member@gmail.com",
            "password" => Hash::make('secret'),
            "name" => "Member",
            "role" => "member",
        ]);

        for ($i = 1; $i < 10; $i++) {
            User::create([
                "email" => "member$i@gmail.com",
                "password" => Hash::make('secret'),
                "name" => "Member $i",
                "role" => "member",
            ]);
        }

        User::create([
            "email" => "admin@gmail.com",
            "password" => Hash::make('secret'),
            "name" => "Admin",
            "role" => "admin",
        ]);
    }
}
