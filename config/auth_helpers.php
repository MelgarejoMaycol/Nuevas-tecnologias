<?php
// Funciones helper para el sistema de roles

function verificarSesion() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!isset($_SESSION['user_id'])) {
        header('Location: '.APP_URL.'/?error=Debes+iniciar+sesión');
        exit;
    }
}

function verificarRol($rolesPermitidos = []) {
    verificarSesion();
    
    $rolUsuario = $_SESSION['user_role'] ?? 'cliente';
    
    if (!in_array($rolUsuario, $rolesPermitidos)) {
        header('Location: '.APP_URL.'/?error=No+tienes+permisos+para+acceder+a+esta+página');
        exit;
    }
}

function esAdministrador() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'administrador';
}

function esTecnico() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'tecnico';
}

function esCliente() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'cliente';
}

function obtenerNombreRol($rol) {
    switch ($rol) {
        case 'administrador':
            return 'Administrador';
        case 'tecnico':
            return 'Técnico';
        case 'cliente':
            return 'Cliente';
        default:
            return 'Usuario';
    }
}

function redireccionar_por_rol() {
    if (!isset($_SESSION['user_role'])) {
        return APP_URL.'/?c=Home&a=index';
    }
    
    switch ($_SESSION['user_role']) {
        case 'administrador':
            return APP_URL.'/?c=Admin&a=dashboard';
        case 'tecnico':
            return APP_URL.'/?c=Tecnico&a=dashboard';
        case 'cliente':
        default:
            return APP_URL.'/?c=Cliente&a=dashboard';
    }
}
?>
