<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Userseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Egy Gynanjar',
            'email' => 'egygynanjar96@gmail.com',
            'password' => Hash::make('Egy123dicoba'),
        ]);
    }
}
