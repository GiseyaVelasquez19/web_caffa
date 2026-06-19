<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class Module extends Model
{
    use HasFactory;

    protected $table = 'modulos';

    protected $fillable = ['nombre', 'slug', 'icono', 'descripcion', 'activo', 'orden'];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }

    public function permissions()
    {
        $actions = ['view', 'create', 'edit', 'delete', 'manage'];

        return Permission::whereIn('name', array_map(
            fn ($action) => "{$this->slug} {$action}",
            $actions
        ))->get();
    }

    public static function getActiveModules()
    {
        return self::where('activo', true)->orderBy('orden')->get();
    }

    public function hasPermission(string $action): bool
    {
        return Permission::where('name', $this->slug.' '.$action)->exists();
    }
}
