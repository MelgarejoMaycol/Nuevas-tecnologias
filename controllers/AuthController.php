<?php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../models/UserModel.php';

class AuthController {
  public function loginView() {
    require __DIR__ . '/../view/Home/index.php'; 
  }

  public function login() {
    session_start();
    $identifier = trim($_POST['identifier'] ?? '');
    $password   = $_POST['password'] ?? '';
    if ($identifier === '' || $password === '') {
      header('Location: '.APP_URL.'/?error=Campos+requeridos'); exit;
    }

    $user = (new UserModel($GLOBALS['pdo']))->findByEmailOrPhone($identifier);
    if (!$user || !password_verify($password, $user['password_hash'])) {
      header('Location: '.APP_URL.'/?error=Credenciales+inválidas'); exit;
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_role'] = $user['role'] ?? 'cliente'; // Si no existe 'role', usar 'cliente' por defecto
    
    // Redirigir según el rol del usuario
    switch ($_SESSION['user_role']) {
      case 'administrador':
        header('Location: '.APP_URL.'/?c=Admin&a=dashboard');
        break;
      case 'tecnico':
        header('Location: '.APP_URL.'/?c=Tecnico&a=dashboard');
        break;
      case 'cliente':
      default:
        header('Location: '.APP_URL.'/?c=Cliente&a=dashboard');
        break;
    }
    exit;
  }

  public function logout() {
    session_start();
    $_SESSION = []; session_destroy();
    header('Location: '.APP_URL.'/');
  }

  public function register() {
    require __DIR__ . '/../view/Registro/index.php';
  }

  public function processRegister() {
    session_start();
    
    // Obtener datos del formulario
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validaciones básicas
    if (empty($email) || empty($password) || empty($confirm_password)) {
      header('Location: '.APP_URL.'/?c=Auth&a=register&error=Todos+los+campos+son+requeridos');
      exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      header('Location: '.APP_URL.'/?c=Auth&a=register&error=Formato+de+email+inválido');
      exit;
    }

    if ($password !== $confirm_password) {
      header('Location: '.APP_URL.'/?c=Auth&a=register&error=Las+contraseñas+no+coinciden');
      exit;
    }

    if (strlen($password) < 6) {
      header('Location: '.APP_URL.'/?c=Auth&a=register&error=La+contraseña+debe+tener+al+menos+6+caracteres');
      exit;
    }

    try {
      $userModel = new UserModel($GLOBALS['pdo']);
      
      // Verificar si el email ya existe
      $existingUser = $userModel->findByEmail($email);
      if ($existingUser) {
        header('Location: '.APP_URL.'/?c=Auth&a=register&error=El+email+ya+está+registrado');
        exit;
      }

      // Crear el usuario con email como nombre por defecto
      $userId = $userModel->create(
        $email, // usar email como nombre
        $email,
        $password
      );

      if ($userId) {
        header('Location: '.APP_URL.'/?c=Auth&a=register&success=Usuario+registrado+exitosamente.+Puedes+iniciar+sesión');
      } else {
        header('Location: '.APP_URL.'/?c=Auth&a=register&error=Error+al+registrar+usuario');
      }
    } catch (Exception $e) {
      header('Location: '.APP_URL.'/?c=Auth&a=register&error=Error+del+sistema:+' . urlencode($e->getMessage()));
    }
    exit;
  }
}
