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
        User::updateOrCreate([
            'email' => 'ecovera123@gmail.com',
        ], [
            'name' => 'Administrator',
            'uuid' => (string) Uuid::uuid4()->toString(),
            'password' => Hash::make('sims100%'),
            'role' => 'admin',
            'phone' => '085213067944',
            'is_active' => true,
            'avatar' => null,
        ]);

        //Seller
        User::updateOrCreate([
            'email' => 'ahmadfadillah502@gmail.com',
        ], [
            'name' => 'Ahmad Fadillah',
            'uuid' => (string) Uuid::uuid4()->toString(),
            'password' => Hash::make('sims100%'),
            'role' => 'seller',
            'phone' => '085213067944',
            'is_active' => true,
            'avatar' => null,
        ]);

        //Buyer
        User::updateOrCreate([
            'email' => 'wahyusyamsuar8@gmail.com',
        ], [
            'name' => 'Wahyu',
            'uuid' => (string) Uuid::uuid4()->toString(),
            'password' => Hash::make('sims100%'),
            'role' => 'buyer',
            'phone' => '085213067944',
            'is_active' => true,
            'avatar' => null,
        ]);


    }
}
