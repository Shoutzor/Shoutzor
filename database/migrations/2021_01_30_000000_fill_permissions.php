<?php

use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class FillPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
         * Create roles (if not existing)
         */
        $guest =    $this->createRole('guest', 'this role is applied to unauthenticated users', true);
        $user =     $this->createRole('user', 'this is the default role for regular users');
        $admin =    $this->createRole('admin', 'this is a special role for administrators');

        /*
         * Create permissions (if not existing)
         */

        $this->createPermission(
            'website.access',
            '(dis)allows visiting the website (ie: require login)',
            [$guest, $user, $admin]
        );

        $this->createPermission(
            'website.search',
            '(dis)allows searching',
            [$guest, $user, $admin]
        );

        $this->createPermission('website.upload',
            '(dis)allows uploading media',
            [$user, $admin]
        );

        $this->createPermission('website.request',
            '(dis)allows requests',
            [$user, $admin]
        );

        $this->createPermission('admin.access',
            '(dis)allows accessing the admin panel and sub-pages',
            [$admin]
        );

        $this->createPermission('admin.packages',
            '(dis)allows managing shoutzor packages',
            [$admin]
        );

        $this->createPermission('admin.permissions.permission.get',
            '(dis)allows managing shoutzor permissions',
            [$admin]
        );

        $this->createPermission('admin.permissions.role.get',
            '(dis)allows managing shoutzor roles',
            [$admin]
        );

        $user = User::where('username', 'admin')->first();
        $user->assignRole('user');
        $user->assignRole('admin');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableNames = config('permission.table_names');

        DB::table($tableNames['permissions'])->delete();
        DB::table($tableNames['roles'])->delete();
    }

    /**
     * Create a permission if it doesn't exist yet.
     * @param string $name the name of the permission
     * @param array $roles the roles to assign this permission to by default
     */
    private function createPermission(string $name, string $description, array $roles = []) {
        try {
            $perm = Permission::create(['name' => $name, 'description' => $description]);

            //Assign the permission for the provided roles
            foreach($roles as $role) {
                $role->givePermissionTo($perm);
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
    private function createRole(string $name, string $description, bool $protected = false) {
        try {
            return Role::create(['name' => $name, 'description' => $description, 'protected' => $protected]);
        }
        catch(RoleAlreadyExists $e) {
            //Ignore
        }

        return Role::findByName($name);
    }
}
