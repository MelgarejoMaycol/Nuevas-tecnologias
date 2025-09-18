<!DOCTYPE html>
<html>

<head lang="es">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Admin Dashboard - Sistema de Tickets</title>

    <!-- Bootstrap y FontAwesome -->
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/lib/bootstrap/bootstrap.min.css">

    <!-- Estilos propios -->
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/main.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/dashboard-styles.css">
    <style>
        /* ===== Variables CSS ===== */
        :root {
            --primary: #6c6efc;
            --primary-dark: #5a5cd8;
            --secondary: #6fa8fd;
            --success: #4caf50;
            --warning: #ff9800;
            --danger: #f44336;
            --info: #2196f3;
            --dark: #343a40;
            --light: #f8f9fa;
            --gray-100: #f5f7fa;
            --gray-200: #e9ecef;
            --gray-300: #dee2e6;
            --gray-600: #6c757d;
            --gray-800: #343a40;
            --border-radius: 12px;
            --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        /* ===== Estilos Generales ===== */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--gray-100);
            color: var(--gray-800);
            line-height: 1.6;
        }

        .dashboard-container {
            padding: 20px;
        }

        /* ===== Header del Dashboard ===== */
        .dashboard-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 25px;
            border: none;
            overflow: hidden;
            position: relative;
        }

        .dashboard-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
            transform: rotate(30deg);
        }

        .dashboard-header .dashboard-title {
            font-weight: 700;
            font-size: 1.75rem;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .user-badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 0.9rem;
            color: #fff;
            font-weight: 500;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            transition: var(--transition);
        }

        .user-badge:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        .logout-btn {
            display: inline-flex;
            align-items: center;
            color: #fff;
            font-weight: 500;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            transition: var(--transition);
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            color: #fff;
            text-decoration: none;
            transform: translateY(-2px);
        }

        /* ===== Tarjetas de Estadísticas ===== */
        .stats-card {
            background: #fff;
            padding: 24px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            border: none;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .stats-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stats-card:hover::after {
            transform: scaleX(1);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 8px;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.95rem;
            color: var(--gray-600);
            font-weight: 500;
        }

        /* ===== Tarjetas de Contenido ===== */
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 24px;
            transition: var(--transition);
        }

        .card:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid var(--gray-200);
            padding: 16px 20px;
            font-weight: 600;
            font-size: 1.25rem;
            border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
            display: flex;
            align-items: center;
        }

        .card-header h4 {
            margin: 0;
            font-weight: 600;
        }

        .card-header i {
            margin-right: 10px;
            font-size: 1.1em;
        }

        .card-body {
            padding: 20px;
        }

        /* ===== Tablas ===== */
        .table {
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }

        .table thead {
            background: var(--dark);
            color: #fff;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table thead th {
            border: none;
            padding: 12px 15px;
            font-weight: 600;
            vertical-align: middle;
        }

        .table tbody td {
            padding: 16px 15px;
            vertical-align: middle;
            border-bottom: 1px solid var(--gray-200);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table-hover tbody tr {
            transition: var(--transition);
        }

        .table-hover tbody tr:hover {
            background: rgba(108, 110, 252, 0.05);
            transform: scale(1.005);
        }

        .badge {
            font-size: 0.8rem;
            padding: 6px 12px;
            border-radius: 30px;
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        /* ===== Botones ===== */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 8px 16px;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn i {
            margin-right: 5px;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 0.875rem;
        }

        .btn-group .btn {
            border-radius: 8px;
            margin-right: 5px;
        }

        .btn-group .btn:last-child {
            margin-right: 0;
        }

        /* ===== Modales ===== */
        .modal-content {
            border-radius: var(--border-radius);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            border: none;
        }

        .modal-header {
            border-bottom: 1px solid var(--gray-200);
            background: #fff;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            padding: 20px;
        }

        .modal-header .close {
            padding: 0;
            margin: 0;
        }

        .modal-body {
            padding: 25px;
        }

        .modal-footer {
            border-top: 1px solid var(--gray-200);
            padding: 15px 25px;
        }

        /* ===== Alertas ===== */
        .alert {
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            border: none;
            padding: 12px 20px;
        }

        .alert-dismissible .close {
            padding: 0.75rem 1.25rem;
        }

        /* ===== Animaciones ===== */
        .fade-in-up {
            animation: fadeInUp 0.6s ease both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== Utilidades ===== */
        .text-primary { color: var(--primary) !important; }
        .text-info { color: var(--info) !important; }
        .text-warning { color: var(--warning) !important; }
        .text-danger { color: var(--danger) !important; }
        .text-success { color: var(--success) !important; }

        .badge-primary { background-color: var(--primary); }
        .badge-info { background-color: var(--info); }
        .badge-warning { background-color: var(--warning); }
        .badge-danger { background-color: var(--danger); }
        .badge-success { background-color: var(--success); }
        .badge-secondary { background-color: var(--gray-600); }

        .bg-primary { background-color: var(--primary) !important; }
        .bg-info { background-color: var(--info) !important; }
        .bg-warning { background-color: var(--warning) !important; }
        .bg-danger { background-color: var(--danger) !important; }
        .bg-success { background-color: var(--success) !important; }
        .bg-secondary { background-color: var(--gray-600) !important; }

        /* ===== Responsive ===== */
        @media (max-width: 768px) {
            .dashboard-header .d-flex {
                flex-direction: column;
                gap: 15px;
            }
            
            .table-responsive {
                border-radius: var(--border-radius);
                overflow: hidden;
            }
            
            .stats-card {
                padding: 20px 15px;
            }
            
            .stat-number {
                font-size: 2rem;
            }
            
            .btn-group {
                display: flex;
                flex-wrap: wrap;
                gap: 5px;
            }
            
            .card-header h4 {
                font-size: 1.1rem;
            }
        }

        /* ===== Estados de Tickets ===== */
        .ticket-table {
            font-size: 0.95rem;
        }
        
        .ticket-table th {
            background: var(--gray-200);
            color: var(--gray-800);
        }
        
        .ticket-table .badge {
            font-size: 0.75rem;
            padding: 5px 10px;
        }
        
        /* ===== Efectos de enfoque ===== */
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(108, 110, 252, 0.25);
        }
        
        /* ===== Scroll personalizado ===== */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--gray-200);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <div class="container-fluid">
            <!-- Header -->
            <div class="row fade-in-up">
                <div class="col-12">
                    <div class="card dashboard-header">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="user-info">
                                    <span class="user-badge">
                                        <i class="fa fa-user-shield"></i> Bienvenido, <?= $_SESSION['user_name'] ?>
                                    </span>
                                </div>
                                <div class="text-center flex-grow-1">
                                    <h2 class="dashboard-title mb-0">
                                        <i class="fa fa-shield"></i> Panel de Administración
                                    </h2>
                                </div>
                                <div class="user-info">
                                    <a href="<?= APP_URL ?>/?c=Auth&a=logout" class="logout-btn">
                                        <i class="fa fa-sign-out"></i> Cerrar Sesión
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mensajes -->
            <?php if (isset($_GET['success'])): ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success alert-dismissible fade show">
                            <?= htmlspecialchars($_GET['success']) ?>
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?= htmlspecialchars($_GET['error']) ?>
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Estadísticas -->
            <div class="row fade-in-up" style="animation-delay: 0.1s;">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card text-center">
                        <div class="stat-number text-primary"><?= $stats['total_users'] ?? 0 ?></div>
                        <div class="stat-label">Usuarios Totales</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card text-center">
                        <div class="stat-number text-info"><?= $stats['clientes'] ?? 0 ?></div>
                        <div class="stat-label">Clientes</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card text-center">
                        <div class="stat-number text-warning"><?= $stats['tecnicos'] ?? 0 ?></div>
                        <div class="stat-label">Técnicos</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card text-center">
                        <div class="stat-number text-danger"><?= $stats['administradores'] ?? 0 ?></div>
                        <div class="stat-label">Administradores</div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Usuarios -->
            <div class="row fade-in-up" style="animation-delay: 0.2s;">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fa fa-users"></i> Gestión de Usuarios</h4>
                        </div>
                        <div class="card-body">
                            <!-- Filtro por rol -->
                            <form method="get" class="form-inline mb-3">
                                <input type="hidden" name="c" value="Admin">
                                <input type="hidden" name="a" value="dashboard">
                                <label for="filtro_rol" class="mr-2">Filtrar por rol:</label>
                                <select name="filtro_rol" id="filtro_rol" class="form-control mr-2">
                                    <option value="">Todos</option>
                                    <option value="cliente" <?= (isset($_GET['filtro_rol']) && $_GET['filtro_rol'] === 'cliente') ? 'selected' : '' ?>>Cliente</option>
                                    <option value="tecnico" <?= (isset($_GET['filtro_rol']) && $_GET['filtro_rol'] === 'tecnico') ? 'selected' : '' ?>>Técnico</option>
                                    <option value="administrador" <?= (isset($_GET['filtro_rol']) && $_GET['filtro_rol'] === 'administrador') ? 'selected' : '' ?>>Administrador</option>
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Rol</th>
                                            <th>Fecha Registro</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($usuarios)): ?>
                                            <tr>
                                                <td colspan="6" class="text-center py-4">
                                                    <i class="fa fa-info-circle mr-2"></i> No hay usuarios registrados
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($usuarios as $usuario): ?>
                                                <tr>
                                                    <td><?= $usuario['id'] ?></td>
                                                    <td><?= htmlspecialchars($usuario['name']) ?></td>
                                                    <td><?= htmlspecialchars($usuario['email']) ?></td>
                                                    <td>
                                                        <span class="badge badge-<?=
                                                            $usuario['role'] === 'administrador' ? 'danger' :
                                                            ($usuario['role'] === 'tecnico' ? 'warning' : 'primary')
                                                            ?>">
                                                            <i class="fa fa-<?=
                                                                $usuario['role'] === 'administrador' ? 'shield' :
                                                                ($usuario['role'] === 'tecnico' ? 'wrench' : 'user')
                                                                ?>"></i>
                                                            <?= ucfirst($usuario['role']) ?>
                                                        </span>
                                                    </td>
                                                    <td><?= date('d/m/Y H:i', strtotime($usuario['created_at'])) ?></td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <!-- Cambiar Rol -->
                                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                                data-toggle="modal" data-target="#cambiarRolModal"
                                                                data-user-id="<?= $usuario['id'] ?>"
                                                                data-user-name="<?= htmlspecialchars($usuario['name']) ?>"
                                                                data-current-role="<?= $usuario['role'] ?>">
                                                                <i class="fa fa-edit"></i> Rol
                                                            </button>

                                                            <?php if ($usuario['id'] != $_SESSION['user_id']): ?>
                                                                <!-- Eliminar Usuario -->
                                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                                    data-toggle="modal" data-target="#eliminarUsuarioModal"
                                                                    data-user-id="<?= $usuario['id'] ?>"
                                                                    data-user-name="<?= htmlspecialchars($usuario['name']) ?>">
                                                                    <i class="fa fa-trash"></i> Eliminar
                                                                </button>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tickets Por Asignar -->
            <div class="row fade-in-up mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <h4><i class="fa fa-hourglass-half"></i> Tickets Por Asignar</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover ticket-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Título</th>
                                            <th>Cliente</th>
                                            <th>Estado</th>
                                            <th>Fecha</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($ticketsPorAsignar)): ?>
                                            <tr>
                                                <td colspan="6" class="text-center py-4">No hay tickets por asignar</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($ticketsPorAsignar as $ticket): ?>
                                                <tr>
                                                    <td><?= $ticket['id'] ?></td>
                                                    <td><?= htmlspecialchars($ticket['titulo']) ?></td>
                                                    <td><?= htmlspecialchars($ticket['cliente_nombre']) ?></td>
                                                    <td><span class="badge badge-secondary">Por Asignar</span></td>
                                                    <td><?= date('d/m/Y H:i', strtotime($ticket['fecha_creacion'])) ?></td>
                                                    <td>
                                                        <a href="<?= APP_URL ?>/?c=Admin&a=asignarTicket&id=<?= $ticket['id'] ?>" class="btn btn-primary btn-sm" title="Asignar Técnico">
                                                            <i class="fa fa-user-plus"></i> Asignar
                                                        </a>
                                                        <a href="<?= APP_URL ?>/?c=Admin&a=verTicket&id=<?= $ticket['id'] ?>" class="btn btn-info btn-sm">
                                                            <i class="fa fa-eye"></i> Ver
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tickets Abiertos -->
            <div class="row fade-in-up mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4><i class="fa fa-folder-open"></i> Tickets Abiertos</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover ticket-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Título</th>
                                            <th>Descripción</th>
                                            <th>Cliente</th>
                                            <th>Técnico</th>
                                            <th>Estado</th>
                                            <th>Fecha</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($ticketsAbiertos)): ?>
                                            <tr>
                                                <td colspan="7" class="text-center py-4">No hay tickets abiertos</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($ticketsAbiertos as $ticket): ?>
                                                <tr>
                                                    <td><?= $ticket['id'] ?></td>
                                                    <td><?= htmlspecialchars($ticket['titulo']) ?></td>
                                                    <td><?= htmlspecialchars(substr($ticket['descripcion'], 0, 50)) ?>...</td>
                                                    <td><?= htmlspecialchars($ticket['cliente_nombre']) ?></td>
                                                    <td><?= htmlspecialchars($ticket['tecnico_nombre']) ?></td>
                                                    <td><span class="badge badge-primary">Abierto</span></td>
                                                    <td><?= date('d/m/Y H:i', strtotime($ticket['fecha_creacion'])) ?></td>
                                                    <td>
                                                        <a href="<?= APP_URL ?>/?c=Admin&a=verTicket&id=<?= $ticket['id'] ?>" class="btn btn-info btn-sm">
                                                            <i class="fa fa-eye"></i> Ver
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tickets Cerrados -->
            <div class="row fade-in-up mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h4><i class="fa fa-check"></i> Tickets Cerrados</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover ticket-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Título</th>
                                            <th>Descripción</th>
                                            <th>Cliente</th>
                                            <th>Técnico</th>
                                            <th>Estado</th>
                                            <th>Fecha</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($ticketsCerrados)): ?>
                                            <tr>
                                                <td colspan="8" class="text-center py-4">No hay tickets cerrados</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($ticketsCerrados as $ticket): ?>
                                                <tr>
                                                    <td><?= $ticket['id'] ?></td>
                                                    <td><?= htmlspecialchars($ticket['titulo']) ?></td>
                                                    <td><?= htmlspecialchars(substr($ticket['descripcion'], 0, 50)) ?>...</td>
                                                    <td><?= htmlspecialchars($ticket['cliente_nombre']) ?></td>
                                                    <td><?= htmlspecialchars($ticket['tecnico_nombre']) ?></td>
                                                    <td><span class="badge badge-success">Cerrado</span></td>
                                                    <td><?= date('d/m/Y H:i', strtotime($ticket['fecha_creacion'])) ?></td>
                                                    <td>
                                                        <a href="<?= APP_URL ?>/?c=Admin&a=cambiarEstadoTicket&id=<?= $ticket['id'] ?>&estado=abierto" class="btn btn-warning btn-sm" title="Reabrir Ticket">
                                                            <i class="fa fa-undo"></i> Reabrir
                                                        </a>
                                                        <a href="<?= APP_URL ?>/?c=Admin&a=verTicket&id=<?= $ticket['id'] ?>" class="btn btn-info btn-sm">
                                                            <i class="fa fa-eye"></i> Ver
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botón para abrir el modal de nuevo técnico -->
            <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#nuevoTecnicoModal">
                <i class="fa fa-user-plus"></i> Nuevo Técnico
            </button>

            <!-- Modal para crear técnico -->
            <div class="modal fade" id="nuevoTecnicoModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="<?= APP_URL ?>/?c=Admin&a=crearTecnico">
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="fa fa-user-plus"></i> Crear Nuevo Técnico</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="tecnico_nombre">Nombre</label>
                                    <input type="text" class="form-control" id="tecnico_nombre" name="nombre" required>
                                </div>
                                <div class="form-group">
                                    <label for="tecnico_email">Email</label>
                                    <input type="email" class="form-control" id="tecnico_email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="tecnico_password">Contraseña</label>
                                    <input type="password" class="form-control" id="tecnico_password" name="password" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success">Crear Técnico</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cambiar Rol -->
    <div class="modal fade" id="cambiarRolModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-edit"></i> Cambiar Rol de Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="POST" action="<?= APP_URL ?>/?c=Admin&a=cambiarRol">
                    <div class="modal-body">
                        <input type="hidden" name="user_id" id="cambiarRol_userId">
                        <p>¿Estás seguro de cambiar el rol del usuario <strong id="cambiarRol_userName"></strong>?</p>

                        <div class="form-group">
                            <label>Rol Actual:</label>
                            <span id="cambiarRol_currentRole" class="badge"></span>
                        </div>

                        <div class="form-group">
                            <label for="new_role">Nuevo Rol:</label>
                            <select name="new_role" id="new_role" class="form-control" required>
                                <option value="cliente">Cliente</option>
                                <option value="tecnico">Técnico</option>
                                <option value="administrador">Administrador</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Cambiar Rol</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Eliminar Usuario -->
    <div class="modal fade" id="eliminarUsuarioModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-trash"></i> Eliminar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="POST" action="<?= APP_URL ?>/?c=Admin&a=eliminarUsuario">
                    <div class="modal-body">
                        <input type="hidden" name="user_id" id="eliminar_userId">
                        <div class="alert alert-danger">
                            <i class="fa fa-warning"></i>
                            <strong>¡Atención!</strong> Esta acción no se puede deshacer.
                        </div>
                        <p>¿Estás seguro de eliminar al usuario <strong id="eliminar_userName"></strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Eliminar Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="<?= APP_URL ?>/public/js/lib/jquery/jquery.min.js"></script>
    <script src="<?= APP_URL ?>/public/js/lib/bootstrap/bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {
            // Modal Cambiar Rol
            $('#cambiarRolModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var userId = button.data('user-id');
                var userName = button.data('user-name');
                var currentRole = button.data('current-role');

                $('#cambiarRol_userId').val(userId);
                $('#cambiarRol_userName').text(userName);
                $('#cambiarRol_currentRole').text(currentRole.charAt(0).toUpperCase() + currentRole.slice(1))
                    .removeClass('badge-primary badge-warning badge-danger')
                    .addClass(currentRole === 'administrador' ? 'badge-danger' :
                        (currentRole === 'tecnico' ? 'badge-warning' : 'badge-primary'));
                $('#new_role').val(currentRole);
            });

            // Modal Eliminar Usuario
            $('#eliminarUsuarioModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var userId = button.data('user-id');
                var userName = button.data('user-name');

                $('#eliminar_userId').val(userId);
                $('#eliminar_userName').text(userName);
            });

            // Auto-hide alerts
            $('.alert-dismissible').delay(5000).fadeOut();
        });
    </script>
</body>

</html>