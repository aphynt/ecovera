<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Admin
        User::insert([
            'name' => 'Administrator',
            'email' => 'ecovera123@gmail.com',
            'uuid' => (string) Uuid::uuid4()->toString(),
            'password' => Hash::make('sims100%'),
            'role' => 'admin',
            'phone' => '085213067944',
            'is_active' => true,
        ]);

        //Seller
        User::insert([
            'name' => 'Ahmad Fadillah',
            'email' => 'ahmadfadillah502@gmail.com',
            'uuid' => (string) Uuid::uuid4()->toString(),
            'password' => Hash::make('sims100%'),
            'role' => 'seller',
            'phone' => '085213067944',
            'is_active' => true,
        ]);

        //Buyer
        User::insert([
            'name' => 'Wahyu',
            'email' => 'wahyusyamsuar8@gmail.com',
            'uuid' => (string) Uuid::uuid4()->toString(),
            'password' => Hash::make('sims100%'),
            'role' => 'buyer',
            'phone' => '085213067944',
            'is_active' => true,
        ]);


    }
}
