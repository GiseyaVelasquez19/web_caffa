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
        $this->createAdmin();
    }

    private function createPermissions(): void
    {
        $modules = ['users', 'roles', 'permissions', 'modules', 'categories', 'products', 'orders'];
        $actions = ['view', 'create', 'edit', 'delete'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "$module $action",
                    'guard_name' => 'web',
                ]);
            }
        }
    }

    private function createRoles(): void
    {
        $allPermissions = Permission::pluck('name')->toArray();

        $roles = [
            'Administrador' => $allPermissions,
            'Vendedor' => [
                'orders view', 'orders edit',
                'categories view', 'categories create', 'categories edit',
                'products view', 'products create', 'products edit', 'products delete',
            ],
            'Cliente' => [
                'products view',
            ],
        ];

        foreach ($roles as $roleName => $permissions) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);
            $role->syncPermissions($permissions);
        }
    }

    private function createAdmin(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@caffa.com'],
            [
                'name' => 'Administrador',
                'password' => 'password',
                'is_superadmin' => true,
            ]
        );

        $admin->assignRole('Administrador');
    }
}
