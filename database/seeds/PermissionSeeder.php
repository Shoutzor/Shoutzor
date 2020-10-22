<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Create roles (if not existing)
         */
        $guest =    $this->createRole('guest');
        $user =     $this->createRole('user');
        $admin =    $this->createRole('admin');

        /*
         * Create permissions (if not existing)
         */

        //(dis)allows visiting the website (ie: require login)
        $this->createPermission('view website', [$guest, $user, $admin]);

        //(dis)allows searching
        $this->createPermission('search', [$guest, $user, $admin]);

        //(dis)allows uploading media
        $this->createPermission('upload', [$user, $admin]);

        //(dis)allows requests
        $this->createPermission('request', [$user, $admin]);

        //(dis)allows accessing the admin panel and sub-pages
        $this->createPermission('view admin', [$admin]);

        //(dis)allows managing shoutzor packages
        $this->createPermission('manage packages', [$admin]);
    }

    /**
     * Create a permission if it doesn't exist yet.
     * @param string $name the name of the permission
     * @param array $roles the roles to assign this permission to by default
     */
    private function createPermission(string $name, array $roles = []) {
        try {
            $perm = Permission::create(['name' => $name]);

            //Assign the permission for the provided roles
            foreach($roles as $role) {
                $role->assignPermission($perm);
            }
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
            return Role::create(['name' => $name]);
        }
        catch(RoleAlreadyExists $e) {
            //Ignore
        }

        return Role::findByName($name);
    }
}
