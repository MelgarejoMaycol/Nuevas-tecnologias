<?php
require_once __DIR__ . '/../config/conexion.php'; 
require_once './models/Ticket.php';

class TicketController
{
    public function nuevo()
    {
        require './view/Cliente/nuevo_ticket.php';
    }

    public function guardar()
    {
        session_start();
        $usuario_id = $_SESSION['user_id'];
        $titulo = $_POST['titulo'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $importante = isset($_POST['importante']) && $_POST['importante'] == '1' ? 1 : 0;

        require_once __DIR__ . '/../models/Ticket.php';
        $exito = Ticket::crear($titulo, $descripcion, $usuario_id, $importante);

        if ($exito) {
            header('Location: '.APP_URL.'/?c=Cliente&a=dashboard');
        } else {
            $error = "No se pudo crear el ticket.";
            require './view/Cliente/nuevo_ticket.php';
        }
    }

    public function misTickets()
    {
        session_start();
        $usuario_id = $_SESSION['user_id'];
        $tickets = Ticket::listarPorUsuario($usuario_id);
        require './view/Cliente/mis_tickets.php';
    }

    public function ver()
    {
        session_start();
        $usuario_id = $_SESSION['user_id'];
        $id = $_GET['id'] ?? 0;
        $ticket = Ticket::obtenerPorId($id, $usuario_id);
        require './view/Cliente/ver_ticket.php';
    }

    public function dashboard()
    {
        $ticketsPorAsignar = Ticket::listarPorEstado('por asignar');
        $ticketsAbiertos = Ticket::listarPorEstado('abierto');
        $ticketsCerrados = Ticket::listarPorEstado('cerrado');
        require './view/Cliente/dashboard.php';
    }

    public function asignar()
    {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'administrador') {
            header('Location: '.APP_URL.'/?error=Acceso+denegado');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ticketId = $_POST['ticket_id'] ?? null;
            $tecnicoId = $_POST['tecnico_id'] ?? null;

            if ($ticketId && $tecnicoId) {
                // Actualiza el ticket: asigna técnico y cambia estado a 'abierto'
                global $pdo;
                $stmt = $pdo->prepare("UPDATE tickets SET tecnico_id = ?, estado = 'abierto' WHERE id = ?");
                $stmt->execute([$tecnicoId, $ticketId]);
                header('Location: ' . APP_URL . '/?c=Admin&a=dashboard&msg=Ticket+asignado');
                exit;
            } else {
                header('Location: ' . APP_URL . '/?c=Admin&a=dashboard&error=Datos+faltantes');
                exit;
            }
        }
        header('Location: ' . APP_URL . '/?c=Admin&a=dashboard');
        exit;
    }

    public function eliminar()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . APP_URL . '/?error=Acceso+denegado');
            exit;
        }

        $ticketId = $_GET['id'] ?? null;
        $usuarioId = $_SESSION['user_id'];

        if ($ticketId) {
            require_once __DIR__ . '/../models/Ticket.php';
            // Solo elimina si el ticket pertenece al usuario
            $ticket = Ticket::obtenerPorIdSimple($ticketId);
            if ($ticket && $ticket['usuario_id'] == $usuarioId) {
                $db = Database::getConnection();
                $stmt = $db->prepare("DELETE FROM tickets WHERE id = ?");
                $stmt->execute([$ticketId]);
                header('Location: ' . APP_URL . '/?c=Ticket&a=misTickets&msg=Ticket+eliminado');
                exit;
            }
        }
        header('Location: ' . APP_URL . '/?c=Ticket&a=misTickets&error=No+autorizado');
        exit;
    }
}