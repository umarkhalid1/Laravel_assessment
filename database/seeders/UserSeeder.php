<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $password = Hash::make('password');

        User::create([
            'name' => 'Umar',
            "email" => 'umar@gmail.com',
            'password' => $password
        ]);
    }
}
