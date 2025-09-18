<?php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../models/Ticket.php';

class TecnicoController {

    public function dashboard()
    {
        session_start();
        $tecnico_id = $_SESSION['user_id'];

        // Resumen de tickets asignados al técnico
        $totalTickets = Ticket::countByTecnico($tecnico_id);
        $ticketsAbiertos = Ticket::countByTecnicoAndStatus($tecnico_id, 'abierto');
        $ticketsCerrados = Ticket::countByTecnicoAndStatus($tecnico_id, 'cerrado');

        require './view/Tecnico/dashboard.php';
    }

    public function perfil() {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'tecnico') {
            header('Location: '.APP_URL.'/?error=Acceso+denegado');
            exit;
        }
        require __DIR__ . '/../view/Tecnico/perfil.php';
    }

    public function ticketsAsignados() {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'tecnico') {
            header('Location: '.APP_URL.'/?error=Acceso+denegado');
            exit;
        }

        require_once __DIR__ . '/../models/Ticket.php';
        $tecnico_id = $_SESSION['user_id'];
        $ticketsAsignados = Ticket::listarPorTecnicoSinCerrados($tecnico_id);

        require './view/Tecnico/tickets-asignados.php';
    }

    public function cambiarEstado() {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'tecnico') {
            header('Location: '.APP_URL.'/?error=Acceso+denegado');
            exit;
        }

        $ticketId = $_GET['id'] ?? null;
        $nuevoEstado = $_GET['estado'] ?? null;

        if ($ticketId && $nuevoEstado) {
            global $pdo;
            $stmt = $pdo->prepare("UPDATE tickets SET estado = ? WHERE id = ? AND tecnico_id = ?");
            $stmt->execute([$nuevoEstado, $ticketId, $_SESSION['user_id']]);
            header('Location: ' . APP_URL . '/?c=Tecnico&a=ticketsAsignados&msg=Estado+actualizado');
            exit;
        } else {
            header('Location: ' . APP_URL . '/?c=Tecnico&a=ticketsAsignados&error=Datos+faltantes');
            exit;
        }
    }

    public function historialTickets() {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'tecnico') {
            header('Location: '.APP_URL.'/?error=Acceso+denegado');
            exit;
        }

        require_once __DIR__ . '/../models/Ticket.php';
        $tecnico_id = $_SESSION['user_id'];
        $ticketsCerrados = Ticket::listarCerradosPorTecnico($tecnico_id);

        require './view/Tecnico/historial-tickets.php';
    }

    public function ver_ticket()
    {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'tecnico') {
            header('Location: '.APP_URL.'/?error=Acceso+denegado');
            exit;
        }

        $id = $_GET['id'] ?? 0;
        // Asegúrate de que este método obtiene el ticket solo si pertenece al técnico
        $ticket = Ticket::obtenerPorIdSimple($id);

        if (!$ticket) {
            // Puedes mostrar un mensaje de error o redirigir
            echo "<div style='color:red;text-align:center;margin-top:40px;'>Ticket no encontrado o no autorizado.</div>";
            exit;
        }

        require './view/Tecnico/ver_ticket.php';
    }
}
