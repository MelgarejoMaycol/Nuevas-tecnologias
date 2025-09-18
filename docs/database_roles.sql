-- Script SQL para configurar la tabla de usuarios con roles
-- Ejecuta este script en tu base de datos

-- Si la tabla users ya existe, agrega la columna role
ALTER TABLE users ADD COLUMN role ENUM('cliente', 'tecnico', 'administrador') DEFAULT 'cliente';

-- Si necesitas crear la tabla desde cero, usa este script:
/*
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    phone VARCHAR(20),
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('cliente', 'tecnico', 'administrador') DEFAULT 'cliente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
*/

-- Crear un usuario administrador por defecto (opcional)
-- Cambia la contraseña por una segura
INSERT INTO users (name, email, phone, password_hash, role) VALUES 
('Administrador', 'admin@sistema.com', '', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'administrador');
-- La contraseña es: password

-- Crear un usuario técnico de ejemplo (opcional)
INSERT INTO users (name, email, phone, password_hash, role) VALUES 
('Técnico Sistema', 'tecnico@sistema.com', '', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'tecnico');
-- La contraseña es: password
