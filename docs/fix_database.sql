-- Ejecuta este comando en phpMyAdmin o en la consola de MySQL
-- para agregar la columna 'role' a tu tabla 'users'

USE app_db;

-- Agregar la columna role a la tabla users
ALTER TABLE users ADD COLUMN role ENUM('cliente', 'tecnico', 'administrador') DEFAULT 'cliente';

-- Verificar que se agregó correctamente
DESCRIBE users;

-- Opcional: Crear usuarios de prueba con diferentes roles (sin campo phone)
INSERT INTO users (name, email, password_hash, role) VALUES 
('Administrador Sistema', 'admin@sistema.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'administrador'),
('Técnico Prueba', 'tecnico@sistema.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'tecnico');

-- Contraseña para ambos usuarios: password
