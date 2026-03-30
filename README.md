# 🎟️ Sistema de Gestión de Tickets

<div align="center">

![PHP](https://img.shields.io/badge/PHP-8%2B-blue?logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0-orange?logo=mysql)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.x-purple?logo=bootstrap)
![License](https://img.shields.io/badge/License-MIT-green)

Un sistema completo de gestión de tickets con autenticación por roles, desarrollado con **PHP**, **MySQL** y **Bootstrap**.

[Ver Documentación](#-tabla-de-contenidos) • [Características](#-características) • [Instalación](#-instalación)

</div>

---

## 📋 Tabla de Contenidos

- [Acerca de](#-acerca-de)
- [Características](#-características)
- [Roles y Permisos](#-roles-y-permisos)
- [Tecnologías Utilizadas](#-tecnologías-utilizadas)
- [Estructura del Proyecto](#-estructura-del-proyecto)
- [Instalación](#-instalación)
- [Uso](#-uso)
- [Contribuidores](#-contribuidores)

---

## 🎯 Acerca de

Un sistema moderno de gestión de tickets con arquitectura **MVC** que permite a empresas organizar, asignar y dar seguimiento a solicitudes de soporte técnico. El sistema cuenta con control de acceso basado en roles y una interfaz responsive.

---

## 🚀 Características

- ✅ **Autenticación segura** con gestión de sesiones
- ✅ **Control de roles** (Administrador, Técnico, Cliente)
- ✅ **CRUD completo** de tickets con validaciones
- ✅ **Asignación de tickets** a técnicos disponibles
- ✅ **Panel de seguimiento** en tiempo real
- ✅ **Historial de tickets** con auditoría
- ✅ **Interfaz responsive** (mobile-first)
- ✅ **Base de datos normalizada** con MySQL
- ✅ **Validación de datos** en cliente y servidor

---

## 👥 Roles y Permisos

| Rol | Acceso | Permisos |
|-----|--------|----------|
| **Administrador** | Panel Admin | Ver todos los tickets, gestionar usuarios, asignar técnicos, generar reportes |
| **Técnico** | Panel Técnico | Ver tickets asignados, actualizar estado, agregar comentarios |
| **Cliente** | Panel Cliente | Crear tickets, ver estado, comentar, valorar soluciones |

---

## 🛠️ Tecnologías Utilizadas

- **Backend:** PHP 8+, POO
- **Database:** MySQL 8.0+
- **Frontend:** HTML5, CSS3, Bootstrap 5
- **JavaScript:** jQuery, AJAX, DataTables
- **Herramientas:** Docker, Docker Compose, Git
- **CI/CD:** GitHub Actions

---

## 📁 Estructura del Proyecto

```
Nuevas-tecnologias/
├── config/                 # Configuración de base de datos
│   ├── config.php         # Configuración general
│   ├── conexion.php       # Conexión a MySQL
│   └── auth_helpers.php   # Funciones de autenticación
├── controllers/           # Controladores (lógica de negocio)
│   ├── AuthController.php
│   ├── AdminController.php
│   ├── TecnicoController.php
│   ├── ClienteController.php
│   └── TicketController.php
├── models/               # Modelos (interacción con BD)
│   ├── UserModel.php
│   └── Ticket.php
├── view/                 # Vistas (templates HTML)
│   ├── Admin/
│   ├── Tecnico/
│   ├── Cliente/
│   └── Registro/
├── public/               # Assets (CSS, JS, imágenes)
│   ├── css/
│   ├── js/
│   └── img/
├── docker/               # Configuración Docker
│   └── init.sql         # Script de inicialización
├── docs/                 # Documentación
├── docker-compose.yml    # Configuración de servicios
└── index.php            # Punto de entrada
```

---

## ⚙️ Instalación

### Opción 1: Con Docker Compose (Recomendado)

1. **Clona el repositorio:**
   ```bash
   git clone https://github.com/MelgarejoMaycol/Nuevas-tecnologias.git
   cd Nuevas-tecnologias
   ```

2. **Inicia los servicios:**
   ```bash
   docker-compose up -d
   ```

3. **Accede a la aplicación:**
   - URL: `http://localhost:8080`
   - Base de datos: `localhost:3306`

### Opción 2: Instalación Manual con XAMPP

1. **Clona el repositorio en htdocs:**
   ```bash
   cd C:\xampp\htdocs
   git clone https://github.com/MelgarejoMaycol/Nuevas-tecnologias.git
   ```

2. **Inicia XAMPP** (Apache y MySQL)

3. **Crea la base de datos:**
   - Abre phpMyAdmin: `http://localhost/phpmyadmin`
   - Importa el archivo: `docker/init.sql`

4. **Configura las credenciales** en `config/connexion.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASSWORD', '');
   define('DB_NAME', 'tickets_db');
   ```

5. **Accede a la aplicación:**
   - URL: `http://localhost/Nuevas-tecnologias`

---

## 🔐 Uso

### Credenciales de Prueba

| Rol | Usuario | Contraseña |
|-----|---------|-----------|
| Admin | admin@example.com | admin123 |
| Técnico | tecnico@example.com | tecnico123 |
| Cliente | cliente@example.com | cliente123 |

*Nota: Cambia estas credenciales en producción*

### Flujos Principales

**Cliente:**
1. Registrarse o iniciar sesión
2. Crear nuevo ticket con descripción del problema
3. Ver estado de tickets en tiempo real
4. Comunicarse con técnico mediante comentarios

**Técnico:**
1. Iniciar sesión
2. Ver tickets asignados en el panel
3. Actualizar estado del ticket
4. Agregar comentarios y soluciones

**Administrador:**
1. Gestionar usuarios (crear, editar, eliminar)
2. Asignar tickets a técnicos
3. Ver reportes y estadísticas
4. Configurar parámetros del sistema

---

## 👥 Contribuidores

<table>
  <tr>
    <td align="center">
      <img src="https://avatars.githubusercontent.com/u/tu-usuario?v=4" width="100px;" alt=""/>
      <br />
      <sub><b>Maycol Fernando Melgarejo Agudelo</b></sub>
    </td>
    <td align="center">
      <img src="https://avatars.githubusercontent.com/u/otro-usuario?v=4" width="100px;" alt=""/>
      <br />
      <sub><b>Yurley Camila Ojeda Oliveros</b></sub>
    </td>
  </tr>
</table>

---

## 📝 Información Adicional

- **Servidor recomendado:** PHP 8.0+
- **Base de datos:** MySQL 8.0+
- **Navegador:** Chrome, Firefox, Safari, Edge (versiones recientes)
- **Puerto HTTP:** 8080 (Docker) / 80 (XAMPP)
- **Puerto MySQL:** 3306

Para más información, consulta `LOCAL_SETUP.md`

---

## 📄 Licencia

Este proyecto está bajo la Licencia MIT - ver el archivo LICENSE para más detalles.

---

<div align="center">

**⭐ Si te ha sido útil, no olvides dejar una estrella en el repositorio**

</div>
