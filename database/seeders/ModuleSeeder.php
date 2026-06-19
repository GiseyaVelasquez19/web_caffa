<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class ModuleSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $modules = [
            [
                'nombre' => 'Usuarios',
                'slug' => 'users',
                'icono' => '👥',
                'descripcion' => 'Gestión de usuarios del sistema',
                'activo' => true,
                'orden' => 1,
            ],
            [
                'nombre' => 'Roles',
                'slug' => 'roles',
                'icono' => '🎭',
                'descripcion' => 'Gestión de roles y permisos',
                'activo' => true,
                'orden' => 2,
            ],
            [
                'nombre' => 'Permisos',
                'slug' => 'permissions',
                'icono' => '🔐',
                'descripcion' => 'Gestión de permisos del sistema',
                'activo' => true,
                'orden' => 3,
            ],
            [
                'nombre' => 'Módulos',
                'slug' => 'modules',
                'icono' => '📦',
                'descripcion' => 'Crear y gestionar módulos parametrizados',
                'activo' => true,
                'orden' => 4,
            ],
            [
                'nombre' => 'Categorías',
                'slug' => 'categories',
                'icono' => '🏷️',
                'descripcion' => 'Gestión de categorías de productos',
                'activo' => true,
                'orden' => 5,
            ],
            [
                'nombre' => 'Productos',
                'slug' => 'products',
                'icono' => '☕',
                'descripcion' => 'Gestión de productos de café',
                'activo' => true,
                'orden' => 6,
            ],
        ];

        foreach ($modules as $module) {
            Module::firstOrCreate(
                ['slug' => $module['slug']],
                $module
            );

            $this->createModulePermissions($module['slug']);
        }
    }

    private function createModulePermissions(string $slug): void
    {
        $actions = ['view', 'create', 'edit', 'delete', 'manage'];

        foreach ($actions as $action) {
            Permission::firstOrCreate(
                ['name' => "{$slug} {$action}"],
                ['guard_name' => 'web']
            );
        }
    }
}
