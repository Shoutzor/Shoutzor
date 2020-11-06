<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Create the admin user
         */
        DB::table('users')->insert([
            'username' => "admin",
            'email' => "admin-user@example.org",
            'password' => Hash::make('admin'),
        ]);
    }
}
