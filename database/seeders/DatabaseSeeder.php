<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call(ModuleSeeder::class);
        $this->createPermissions();
        $this->createRoles();
        $this->createSuperAdmin();
    }

    private function createPermissions(): void
    {
        $permissions = [
            'view users',
            'create users',
            'edit users',
            'delete users',
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',
            'assign permissions',
            'view modules',
            'create modules',
            'edit modules',
            'delete modules',
            'manage modules',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }
    }

    private function createRoles(): void
    {
        $superAdminPermissions = [
            'view users', 'create users', 'edit users', 'delete users',
            'view roles', 'create roles', 'edit roles', 'delete roles',
            'view permissions', 'create permissions', 'edit permissions', 'delete permissions', 'assign permissions',
            'view modules', 'create modules', 'edit modules', 'delete modules', 'manage modules',
            'users view', 'users create', 'users edit', 'users delete',
            'roles view', 'roles create', 'roles edit', 'roles delete',
            'permissions view', 'permissions create', 'permissions edit', 'permissions delete',
            'modules view', 'modules create', 'modules edit', 'modules delete',
        ];

        $roles = [
            'Super Admin' => $superAdminPermissions,
            'Admin' => ['view users', 'create users', 'edit users', 'view roles', 'view permissions', 'view modules', 'users view', 'users create', 'users edit', 'roles view', 'permissions view', 'modules view'],
            'Manager' => ['view users', 'view modules', 'users view', 'modules view'],
            'User' => ['view modules', 'modules view'],
        ];

        foreach ($roles as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $role->syncPermissions($permissions);
        }
    }

    private function createSuperAdmin(): void
    {
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@caffa.com'],
            [
                'name' => 'Super Administrador',
                'password' => bcrypt('password'),
                'is_superadmin' => true,
            ]
        );

        $superAdmin->assignRole('Super Admin');
    }
}
