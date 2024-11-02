<?php

namespace Database\Seeders;
use App\Models\Municipality;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::where('email', 'penroadmin@gmail.com')->exists()) {

            User::create([
                'name' => env('ADMIN_NAME', 'Admin'),
                'email' => env('ADMIN_EMAIL', 'penroadmin@gmail.com'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'capstone')),
                'email_verified_at' => now(),
                'isAdmin' => true,
            ]);


        }


    }
}
