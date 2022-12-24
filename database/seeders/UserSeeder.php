<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'test',
            'email' => 'user@gmail.com',
            'password' => Hash::make('awdasd'),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'manager',
            'email' => 'manager@gmail.com',
            'password' => Hash::make('awdasd'),
            'remember_token' => Str::random(10),
        ]);
    }
}
