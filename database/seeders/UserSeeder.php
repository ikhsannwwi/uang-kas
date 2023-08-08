<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $existingUser = User::where('kode', 'K000')->first();
        if ($existingUser) {
            $existingUser->delete();
        }
        User::create([
            'kode' => 'K000',
            'name' => 'ikhsan',
            'email' => 'dev@gmail.com',
            'password' => Hash::make('qwerty99'),
            'foto' => 'default.jpg',
            'remember_token' => Str::random(60),
        ]);
    }
}
