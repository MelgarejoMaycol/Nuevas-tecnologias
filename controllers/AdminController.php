<?php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/Ticket.php';

class AdminController {
  
  public function dashboard() {
    session_start();
    
    // Verificar que el usuario esté logueado y sea administrador
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'administrador') {
      header('Location: '.APP_URL.'/?error=Acceso+denegado');
      exit;
    }
    
    // Obtener datos para el dashboard
    $userModel = new UserModel($GLOBALS['pdo']);
    $filtroRol = $_GET['filtro_rol'] ?? '';
    if ($filtroRol) {
        $usuarios = $userModel->getUsersByRole($filtroRol);
    } else {
        $usuarios = $userModel->getAllUsers();
    }
    $stats = $userModel->getUserStats();
    
    // Tickets en progreso
    $ticketsEnProgreso = Ticket::listarPorEstado('en progreso');

    // Tickets cerrados
    $ticketsCerrados = Ticket::listarPorEstado('cerrado');

    // Tickets abiertos y en progreso
    $ticketsAbiertos = Ticket::listarAbiertosYEnProgreso();

    // Tickets por asignar
    $ticketsPorAsignar = Ticket::listarPorEstado('por asignar');

    require __DIR__ . '/../view/Admin/dashboard.php';
  }
  
  public function usuarios() {
    session_start();
    
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'administrador') {
      header('Location: '.APP_URL.'/?error=Acceso+denegado');
      exit;
    }
    
    require __DIR__ . '/../view/Admin/usuarios.php';
  }
  
  public function tickets() {
    session_start();
    
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'administrador') {
      header('Location: '.APP_URL.'/?error=Acceso+denegado');
      exit;
    }
    
    require __DIR__ . '/../view/Admin/tickets.php';
  }
  
  public function reportes() {
    session_start();
    
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'administrador') {
      header('Location: '.APP_URL.'/?error=Acceso+denegado');
      exit;
    }
    
    require __DIR__ . '/../view/Admin/reportes.php';
  }

  public function cambiarRol() {
    session_start();
    
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'administrador') {
      header('Location: '.APP_URL.'/?error=Acceso+denegado');
      exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $userId = $_POST['user_id'] ?? '';
      $newRole = $_POST['new_role'] ?? '';
      
      if ($userId && in_array($newRole, ['cliente', 'tecnico', 'administrador'])) {
        $userModel = new UserModel($GLOBALS['pdo']);
        
        if ($userModel->updateUserRole($userId, $newRole)) {
          header('Location: '.APP_URL.'/?c=Admin&a=dashboard&success=Rol+actualizado+correctamente');
        } else {
          header('Location: '.APP_URL.'/?c=Admin&a=dashboard&error=Error+al+actualizar+rol');
        }
      } else {
        header('Location: '.APP_URL.'/?c=Admin&a=dashboard&error=Datos+inválidos');
      }
    } else {
      header('Location: '.APP_URL.'/?c=Admin&a=dashboard');
    }
    exit;
  }

  public function eliminarUsuario() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userId = $_POST['user_id'] ?? null;
        if ($userId) {
            require_once __DIR__ . '/../models/UserModel.php';
            require_once __DIR__ . '/../models/Ticket.php';
            global $pdo;

            // Obtener el usuario y su rol
            $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario) {
                if ($usuario['role'] === 'cliente') {
                    // Eliminar solo los tickets NO cerrados del cliente
                    $stmt = $pdo->prepare("DELETE FROM tickets WHERE usuario_id = ? AND estado != 'cerrado'");
                    $stmt->execute([$userId]);
                } elseif ($usuario['role'] === 'tecnico') {
                    // Solo tickets NO cerrados pasan a por asignar y tecnico_id a NULL
                    $stmt = $pdo->prepare("UPDATE tickets SET estado = 'por asignar', tecnico_id = NULL WHERE tecnico_id = ? AND estado != 'cerrado'");
                    $stmt->execute([$userId]);
                }
                // Marcar el usuario como inactivo (estado = 0)
                $stmt = $pdo->prepare("UPDATE users SET estado = 0 WHERE id = ?");
                $stmt->execute([$userId]);

                header('Location: ' . APP_URL . '/?c=Admin&a=dashboard&success=Usuario+marcado+como+inactivo+y+tickets+actualizados');
                exit;
            }
        }
    }
    header('Location: ' . APP_URL . '/?c=Admin&a=dashboard&error=No+se+pudo+eliminar+el+usuario');
    exit;
  }

  public function cambiarEstadoTicket() {
    session_start();
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'administrador') {
        header('Location: '.APP_URL.'/?error=Acceso+denegado');
        exit;
    }

    $ticket_id = $_GET['id'] ?? null;
    $nuevo_estado = $_GET['estado'] ?? null;

    // Validar estados permitidos y que los parámetros no estén vacíos
    $estados_validos = ['abierto', 'en progreso', 'cerrado', 'por asignar'];
    if ($ticket_id && in_array($nuevo_estado, $estados_validos)) {
        require_once __DIR__ . '/../models/Ticket.php';
        
        // Llamar directamente al método que actualiza el estado en el modelo
        if (Ticket::actualizarEstado($ticket_id, $nuevo_estado)) {
            $mensaje = 'Estado del ticket actualizado a ' . htmlspecialchars($nuevo_estado);
            header('Location: '.APP_URL.'/?c=Admin&a=dashboard&success=' . urlencode($mensaje));
        } else {
            header('Location: '.APP_URL.'/?c=Admin&a=dashboard&error=No+se+pudo+actualizar+el+estado+del+ticket.');
        }
    } else {
        header('Location: '.APP_URL.'/?c=Admin&a=dashboard&error=Datos+inválidos+para+el+cambio+de+estado.');
    }
    exit;
}

public function asignarTicket() {
    session_start();
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'administrador') {
        header('Location: '.APP_URL.'/?error=Acceso+denegado');
        exit;
    }

    $ticketId = $_GET['id'] ?? null;
    if (!$ticketId) {
        header('Location: ' . APP_URL . '/?c=Admin&a=dashboard&error=Ticket+no+especificado');
        exit;
    }

    // Instanciar los modelos correctamente
    $userModel = new UserModel($GLOBALS['pdo']);
    $tecnicos = $userModel->getTecnicos(); // Debe existir este método en UserModel

    $ticket = Ticket::getById($ticketId); // Debe existir este método estático en Ticket

    require __DIR__ . '/../view/Admin/asignar_ticket.php';
}

public function crearTecnico() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        if ($nombre && $email && $password) {
            require_once __DIR__ . '/../models/UserModel.php';
            $userModel = new UserModel($GLOBALS['pdo']);
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $GLOBALS['pdo']->prepare("INSERT INTO users (name, email, password_hash, role, created_at) VALUES (?, ?, ?, 'tecnico', NOW())");
            $stmt->execute([$nombre, $email, $hash]);
            header('Location: ' . APP_URL . '/?c=Admin&a=dashboard&success=Técnico+creado+correctamente');
            exit;
        }
    }
    header('Location: ' . APP_URL . '/?c=Admin&a=dashboard&error=Faltan+datos');
    exit;
}

public function verTicket() {
    session_start();
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'administrador') {
        header('Location: '.APP_URL.'/?error=Acceso+denegado');
        exit;
    }
    $id = $_GET['id'] ?? 0;
    require_once __DIR__ . '/../models/Ticket.php';
    $ticket = Ticket::obtenerPorIdSimple($id);
    require './view/Admin/ver_ticket.php';
}
}
