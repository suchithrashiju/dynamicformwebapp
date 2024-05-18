<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Admin::create([
            'name' => 'Admin CP 360', // Replace with the admin's name
            'email' => 'admin@cp360.com', // Replace with the admin's email
            'password' => bcrypt('cp360PWD'), // Replace with a secure password
            // Add any other fields as necessary
        ]);
    }
}
