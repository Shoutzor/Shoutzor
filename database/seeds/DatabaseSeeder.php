<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
         * Create permissions (if not existing)
         */
        $this->createPermission('request media');       //(dis)allows requests
        $this->createPermission('upload media');        //(dis)allows uploading of media
        $this->createPermission('admin panel');         //(dis)allows accessing the admin panel and sub-pages
        $this->createPermission('configure package');   //(dis)allows (un)install & enable/disable packages
        $this->createPermission('update package');      //(dis)allows updating packages

        /*
         * Create roles
         */
        $this->createRole('guest');
        $this->createRole('user');
        $this->createRole('admin');

        /*
         * Create the admin user
         */
        DB::table('users')->insert([
            'username' => "admin",
            'email' => "admin-user@example.org",
            'password' => Hash::make('admin'),
        ]);
    }

    /**
     * Create a permission if it doesn't exist yet.
     * @param string $name the name of the permission
     */
    private function createPermission(string $name) {
        try {
            Permission::create(['name' => $name]);
        }
        catch(PermissionAlreadyExists $e) {
            //Ignore
        }
    }

    /**
     * Create a role if it doesn't exist yet
     * @param string $name the name of the role
     */
    private function createRole(string $name) {
        try {
            Role::create(['name' => $name]);
        }
        catch(RoleAlreadyExists $e) {
            //Ignore
        }
    }
}
