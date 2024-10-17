<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       User::factory()->create([
        'username' => 'Raju',
        'fullname' => 'Raju',
        'lastname' => 'Rastogi',
        'email' => 'raju@gmail.com',
        'password' => '12345678',
        'is_active' => true
       ]);
        


        
    }
}
