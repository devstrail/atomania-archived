<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         User::factory(50)->create();
         User::factory(1)->withCredentials('Vendor', 'vendor@mail.com', 'password')->create();
         User::factory(1)->withCredentials('Admin', 'admin@mail.com', 'password')->create();
         User::factory(1)->withCredentials('Farmer', 'farmer@mail.com', 'password')->create();
         User::factory(1)->withCredentials('Guest', 'guest@mail.com', 'password')->create();
    }
}
