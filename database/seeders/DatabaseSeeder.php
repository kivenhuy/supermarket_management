<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //\App\Models\User::factory(10)->create();

        // supper admin
        $admin = new User();
        $admin->name = "Supper Admin";
        $admin->user_type = "super_admin";
        $admin->username = "vonhathuy";
        $admin->email = "admin@farm-angel.com";
        $admin->password = Hash::make('12345678');
        $admin->phone_number = "123456789";
        $admin->email_verified_at = "";
        $admin->save();

        // $this->call([
        //     SeasonsSeeder::class,
        //     CropCategoriesSeeder::class,
        // ]);
    }
}
