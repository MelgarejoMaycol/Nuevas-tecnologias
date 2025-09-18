<?php
require_once __DIR__ . '/../config/conexion.php';

class ClienteController {
  
  public function dashboard()
  {
      session_start();
      $usuario_id = $_SESSION['user_id'];

      require_once __DIR__ . '/../models/Ticket.php';

      $totalTickets = Ticket::countByUser($usuario_id);
      $ticketsAbiertos = Ticket::countByUserAndStatus($usuario_id, 'abierto');
      $ticketsCerrados = Ticket::countByUserAndStatus($usuario_id, 'cerrado');

      require './view/Cliente/dashboard.php';
  }
  
  public function perfil() {
    session_start();
    
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'cliente') {
      header('Location: '.APP_URL.'/?error=Acceso+denegado');
      exit;
    }
    
    require __DIR__ . '/../view/Cliente/perfil.php';
  }
  
  public function tickets() {
    session_start();
    
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'cliente') {
      header('Location: '.APP_URL.'/?error=Acceso+denegado');
      exit;
    }
    
    require __DIR__ . '/../view/Cliente/tickets.php';
  }
}
