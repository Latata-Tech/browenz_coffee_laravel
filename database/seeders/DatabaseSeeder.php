<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::factory()->create([
             'name' => 'admin',
             'email' => 'admin@browenz.com',
             'address' => '-',
             'phone_number' => '-',
             'birth_date' => '2022-01-01',
             'status' => true
         ]);
    }
}
