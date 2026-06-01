# ☕ Web Caffa - Sistema de Gestión de Café en Grano

Plantilla base completa de Laravel 13 con sistema de autenticación, gestión de usuarios, roles, permisos y módulos parametrizados.

## 🚀 Instalación Rápida

### Requisitos
- PHP 8.3+
- Composer
- MySQL o SQLite
- Node.js (para Tailwind CSS)

### Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone <tu-repo>
cd web_caffa
```

2. **Instalar dependencias PHP**
```bash
composer install
```

3. **Instalar dependencias Node**
```bash
npm install
```

4. **Crear archivo .env**
```bash
cp .env.example .env
```

5. **Generar clave de aplicación**
```bash
php artisan key:generate
```

6. **Configurar base de datos en .env**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=caffa
DB_USERNAME=root
DB_PASSWORD=
```

7. **Ejecutar migraciones y seeders**
```bash
php artisan migrate:fresh --seed
```

8. **Compilar assets**
```bash
npm run build
```

9. **Iniciar servidor**
```bash
php artisan serve
```

La aplicación estará disponible en: `http://localhost:8000`

## 🔐 Credenciales por Defecto

- **Email:** admin@caffa.com
- **Contraseña:** password
- **Rol:** Super Administrador

## 📦 Módulos Incluidos

- **👥 Usuarios** - Gestión completa de usuarios
- **🎭 Roles** - Crear y asignar roles
- **🔐 Permisos** - Gestionar permisos del sistema
- **📦 Módulos** - Crear módulos parametrizados dinámicamente

## ✨ Características

✅ Autenticación completa (Login/Logout)
✅ Sistema de roles y permisos con Spatie
✅ CRUD para Usuarios, Roles, Permisos
✅ Módulos parametrizados (crear nuevos módulos sin código)
✅ Permisos automáticos por módulo (view, create, edit, delete)
✅ Interfaz responsiva con Tailwind CSS v4
✅ Diseño temático de café
✅ Campo `is_superadmin` en usuarios
✅ Autorización basada en permisos
✅ Footer sticky al final de la página

## 🔧 Comandos Útiles

```bash
# Ver rutas disponibles
php artisan route:list

# Crear nuevo controlador
php artisan make:controller NombreController

# Crear nuevo modelo con migración
php artisan make:model Nombre -m

# Crear test
php artisan make:test NombreTest --pest

# Ejecutar tests
php artisan test

# Limpiar caché
php artisan cache:clear
php artisan config:clear
```

## 📁 Estructura del Proyecto

```
web_caffa/
├── app/
│   ├── Http/Controllers/     # Controladores
│   ├── Models/               # Modelos
│   └── Policies/             # Políticas de autorización
├── database/
│   ├── migrations/           # Migraciones
│   └── seeders/              # Seeders
├── resources/
│   ├── views/                # Vistas Blade
│   │   ├── layouts/          # Layouts base
│   │   ├── auth/             # Vistas de autenticación
│   │   ├── users/            # Vistas de usuarios
│   │   ├── roles/            # Vistas de roles
│   │   ├── permissions/      # Vistas de permisos
│   │   └── modules/          # Vistas de módulos
│   └── css/                  # Estilos Tailwind
├── routes/
│   └── web.php               # Rutas web
└── config/                   # Configuración
```

## 🎯 Cómo Crear un Nuevo Módulo

1. Ve a `/modules` en la aplicación
2. Haz clic en "+ Nuevo Módulo"
3. Completa:
   - **Nombre:** Nombre descriptivo (ej: Productos)
   - **Slug:** Identificador único (ej: products)
   - **Icono:** Selecciona un emoji
   - **Descripción:** Qué hace el módulo
4. Se crearán automáticamente 4 permisos:
   - `products view`
   - `products create`
   - `products edit`
   - `products delete`
5. Asigna estos permisos a los roles que lo necesiten

## 🔐 Sistema de Permisos

Los permisos se verifican de dos formas:

**En Controladores:**
```php
auth()->user()->can('users view') ?: abort(403);
```

**En Vistas:**
```blade
@can('users view')
    <!-- Contenido visible solo para usuarios con permiso -->
@endcan
```

## 🎨 Personalización

### Colores Temáticos
Los colores principales están en Tailwind (amber/café):
- `bg-amber-900` - Marrón oscuro
- `bg-amber-700` - Marrón medio
- `bg-amber-50` - Crema claro

### Modificar Nombre de la Aplicación
Busca "Caffa" en:
- `resources/views/layouts/app.blade.php`
- `resources/views/welcome.blade.php`
- `config/app.php`

## 📝 Notas Importantes

- Los módulos se visualizan dinámicamente según los permisos del usuario
- El Super Admin tiene acceso a todos los módulos
- Los permisos se crean automáticamente al crear un módulo
- La navegación se actualiza automáticamente según los módulos activos

## 🆘 Troubleshooting

**Error: "Route not defined"**
- Ejecuta `php artisan route:list` para ver todas las rutas
- Asegúrate de haber ejecutado `php artisan migrate:fresh --seed`

**Los módulos no aparecen en la navegación**
- Verifica que el usuario tenga el permiso `{slug} view`
- Comprueba que el módulo esté activo en la BD

**Error de permisos**
- Ejecuta `php artisan cache:clear`
- Regenera los permisos con `php artisan migrate:fresh --seed`

## 📞 Soporte

Para reportar bugs o sugerencias, contacta al equipo de Web Caffa.

## 📄 Licencia

Este proyecto está bajo la licencia MIT.
