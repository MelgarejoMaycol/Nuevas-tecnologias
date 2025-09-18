# Sistema de Roles - Documentación

## Roles Implementados

El sistema cuenta con 3 tipos de roles:

### 1. **Cliente** (Por defecto)
- **Rol:** `cliente`
- **Dashboard:** `/view/Cliente/dashboard.php`
- **Permisos:**
  - Crear nuevos tickets
  - Ver sus propios tickets
  - Actualizar su perfil
  - Comunicarse con soporte

### 2. **Técnico**
- **Rol:** `tecnico`
- **Dashboard:** `/view/Tecnico/dashboard.php`
- **Permisos:**
  - Ver tickets asignados
  - Resolver tickets
  - Actualizar estado de tickets
  - Comunicarse con clientes

### 3. **Administrador**
- **Rol:** `administrador`
- **Dashboard:** `/view/Admin/dashboard.php`
- **Permisos:**
  - Gestión completa de usuarios
  - Ver todos los tickets
  - Asignar tickets a técnicos
  - Generar reportes
  - Configurar sistema

## Base de Datos

### Estructura de la tabla `users`:
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('cliente', 'tecnico', 'administrador') DEFAULT 'cliente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

## Flujo de Autenticación

1. **Registro:** Todos los usuarios se registran como "cliente" por defecto
2. **Login:** El sistema verifica credenciales y lee el rol del usuario
3. **Redirección:** Según el rol, redirige a:
   - `Cliente` → `/?c=Cliente&a=dashboard`
   - `Técnico` → `/?c=Tecnico&a=dashboard`
   - `Administrador` → `/?c=Admin&a=dashboard`

## Controladores Creados

- **`ClienteController.php`** - Maneja funciones de cliente
- **`TecnicoController.php`** - Maneja funciones de técnico
- **`AdminController.php`** - Maneja funciones de administrador

## Funciones Helper

En `/config/auth_helpers.php`:
- `verificarSesion()` - Verifica que el usuario esté logueado
- `verificarRol($roles)` - Verifica permisos específicos
- `esAdministrador()`, `esTecnico()`, `esCliente()` - Verificaciones rápidas
- `redireccionar_por_rol()` - Redirección automática según rol

## Uso en las Vistas

```php
// En cualquier vista, verificar el rol:
<?php if (esAdministrador()): ?>
    <div>Contenido solo para administradores</div>
<?php endif; ?>

// Verificar sesión y rol específico:
<?php 
verificarRol(['administrador', 'tecnico']); 
// Solo administradores y técnicos pueden continuar
?>
```

## Seguridad

- Cada controlador verifica la sesión y el rol antes de mostrar contenido
- Las redirecciones incluyen mensajes de error apropiados
- Los roles se almacenan en la sesión para verificación rápida
- El rol por defecto es "cliente" para nuevos registros

## Usuarios de Prueba

Puedes crear usuarios de prueba ejecutando el SQL en `/docs/database_roles.sql`:
- **Admin:** admin@sistema.com / password
- **Técnico:** tecnico@sistema.com / password
