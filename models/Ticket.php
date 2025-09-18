<?php
require_once __DIR__ . '/../config/config.php';

class Ticket
{
    public static function crear($titulo, $descripcion, $usuario_id, $importante = 0)
    {
        $db = Database::getConnection();

        // No asignar técnico al crear, ni buscar técnico
        $stmt = $db->prepare("INSERT INTO tickets (titulo, descripcion, usuario_id, tecnico_id, estado, fecha_creacion, importante) VALUES (?, ?, ?, NULL, 'por asignar', NOW(), ?)");
        return $stmt->execute([$titulo, $descripcion, $usuario_id, $importante]);
    }

    public static function listarPorUsuario($usuario_id)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT * FROM tickets 
            WHERE usuario_id = ? 
            ORDER BY 
                FIELD(estado, 'por asignar', 'abierto', 'cerrado'),
                importante DESC,
                fecha_creacion DESC
        ");
        $stmt->execute([$usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerPorId($id, $usuario_id)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM tickets WHERE id = ? AND usuario_id = ?");
        $stmt->execute([$id, $usuario_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function obtenerPorIdSimple($id)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT t.*, 
                u1.name AS cliente_nombre, 
                u2.name AS tecnico_nombre
            FROM tickets t
            LEFT JOIN users u1 ON t.usuario_id = u1.id
            LEFT JOIN users u2 ON t.tecnico_id = u2.id
            WHERE t.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function countByUser($usuario_id)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM tickets WHERE usuario_id = ?");
        $stmt->execute([$usuario_id]);
        return $stmt->fetchColumn();
    }

    public static function countByUserAndStatus($usuario_id, $estado)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM tickets WHERE usuario_id = ? AND estado = ?");
        $stmt->execute([$usuario_id, $estado]);
        return $stmt->fetchColumn();
    }

    public static function listarTodos()
    {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM tickets ORDER BY fecha_creacion DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listarPorTecnico($tecnico_id)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT * FROM tickets 
            WHERE tecnico_id = ? 
            ORDER BY importante DESC, fecha_creacion DESC
        ");
        $stmt->execute([$tecnico_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listarPorTecnicoSinCerrados($tecnico_id)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM tickets WHERE tecnico_id = ? AND estado != 'cerrado' ORDER BY fecha_creacion DESC");
        $stmt->execute([$tecnico_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listarCerradosPorTecnico($tecnico_id)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM tickets WHERE tecnico_id = ? AND estado = 'cerrado' ORDER BY fecha_creacion DESC");
        $stmt->execute([$tecnico_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listarPrioritarios()
    {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM tickets WHERE prioridad = 'alta' AND estado = 'abierto' ORDER BY fecha_creacion DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function countByTecnico($tecnico_id)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM tickets WHERE tecnico_id = ?");
        $stmt->execute([$tecnico_id]);
        return $stmt->fetchColumn();
    }

    public static function countByTecnicoAndStatus($tecnico_id, $estado)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM tickets WHERE tecnico_id = ? AND estado = ?");
        $stmt->execute([$tecnico_id, $estado]);
        return $stmt->fetchColumn();
    }

    public static function actualizarEstado($ticket_id, $estado)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE tickets SET estado = ? WHERE id = ?");
        return $stmt->execute([$estado, $ticket_id]);
    }

    public static function listarPorEstado($estado)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT t.*, 
                   c.email AS cliente_nombre, 
                   tec.email AS tecnico_nombre
            FROM tickets t
            LEFT JOIN users c ON t.usuario_id = c.id
            LEFT JOIN users tec ON t.tecnico_id = tec.id
            WHERE t.estado = ?
            ORDER BY t.fecha_creacion DESC
        ");
        $stmt->execute([$estado]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listarAbiertosYEnProgreso()
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT t.*, 
                   c.email AS cliente_nombre, 
                   tec.email AS tecnico_nombre
            FROM tickets t
            LEFT JOIN users c ON t.usuario_id = c.id
            LEFT JOIN users tec ON t.tecnico_id = tec.id
            WHERE t.estado IN ('abierto', 'en progreso')
            ORDER BY t.fecha_creacion DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM tickets WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function listarPorAsignar()
    {
        $db = Database::getConnection();
        $stmt = $db->query("
            SELECT t.*, u1.name AS cliente_nombre
            FROM tickets t
            LEFT JOIN users u1 ON t.usuario_id = u1.id
            WHERE t.estado = 'por asignar'
            ORDER BY t.fecha_creacion DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}