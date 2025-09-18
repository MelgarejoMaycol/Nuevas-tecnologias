<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets Asignados</title>
    <style>
        /* Estilos generales */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7f9;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        /* Animación fade-in-up */
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
        
        .fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }
        
        /* Estilos de la tarjeta */
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin-bottom: 30px;
        }
        
        .card-body {
            padding: 30px;
        }
        
        .card-title {
            color: #2c3e50;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
            font-weight: 600;
        }
        
        /* Estilos de botones */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .btn-secondary {
            background-color: #95a5a6;
            color: white;
        }
        
        .btn-secondary:hover {
            background-color: #7f8c8d;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .btn-warning {
            background-color: #f39c12;
            color: white;
            padding: 8px 16px;
            font-size: 14px;
            margin-right: 5px;
        }
        
        .btn-warning:hover {
            background-color: #e67e22;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .btn-success {
            background-color: #27ae60;
            color: white;
            padding: 8px 16px;
            font-size: 14px;
        }
        
        .btn-success:hover {
            background-color: #2ecc71;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .btn-info {
            background-color: #3498db;
            color: white;
            padding: 8px 16px;
            font-size: 14px;
        }
        
        .btn-info:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        /* Estilos de tabla */
        .table-container {
            overflow-x: auto;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eaeaea;
        }
        
        th {
            background-color: #f8f9fa;
            color: #2c3e50;
            font-weight: 600;
            position: sticky;
            top: 0;
        }
        
        tr:hover {
            background-color: #f8f9fa;
        }
        
        /* Badges para estados */
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .estado-abierto {
            background-color: #ffeaa7;
            color: #d35400;
        }
        
        .estado-en-progreso {
            background-color: #81ecec;
            color: #00b894;
        }
        
        .estado-cerrado {
            background-color: #d4edda;
            color: #155724;
        }
        
        /* Mensaje de tabla vacía */
        .text-center {
            text-align: center;
        }
        
        .no-tickets {
            padding: 30px;
            text-align: center;
            color: #7f8c8d;
            font-style: italic;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .card-body {
                padding: 20px;
            }
            
            th, td {
                padding: 10px;
            }
            
            .btn {
                width: 100%;
                margin-bottom: 10px;
            }
            
            table {
                font-size: 14px;
            }
            
            .actions-cell {
                display: flex;
                flex-direction: column;
            }
            
            .btn-warning, .btn-success {
                margin-right: 0;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="card fade-in-up">
        <div class="card-body">
            <h3 class="card-title">Tickets Asignados</h3>
            
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Importante</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (!empty($ticketsAsignados)):
                        $n = 1;
                        foreach ($ticketsAsignados as $ticket): ?>
                            <tr>
                                <td><?= $n++ ?></td>
                                <td><?= htmlspecialchars($ticket['titulo']) ?></td>
                                <td><?= htmlspecialchars($ticket['descripcion']) ?></td>
                                <td>
                                    <?php if (!empty($ticket['importante'])): ?>
                                        <span class="badge badge-danger" style="background:#e74c3c;color:#fff;">¡Sí!</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary" style="background:#bbb;color:#fff;">No</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                    $estadoClass = '';
                                    switch(strtolower($ticket['estado'])) {
                                        case 'abierto':
                                            $estadoClass = 'estado-abierto';
                                            break;
                                        case 'en progreso':
                                            $estadoClass = 'estado-en-progreso';
                                            break;
                                        case 'cerrado':
                                            $estadoClass = 'estado-cerrado';
                                            break;
                                        default:
                                            $estadoClass = 'estado-abierto';
                                    }
                                    ?>
                                    <span class="badge <?= $estadoClass ?>"><?= ucfirst($ticket['estado']) ?></span>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($ticket['fecha_creacion'])) ?></td>
                                <td class="actions-cell">
                                    <?php if ($ticket['estado'] !== 'cerrado'): ?>
                                        <a href="<?= APP_URL ?>/?c=Tecnico&a=cambiarEstado&id=<?= $ticket['id'] ?>&estado=cerrado" class="btn btn-success">Cerrar Ticket</a>
                                    <?php else: ?>
                                        <span class="badge badge-success">Cerrado</span>
                                    <?php endif; ?>
                                    <a href="<?= APP_URL ?>/?c=Tecnico&a=ver_ticket&id=<?= $ticket['id'] ?>" class="btn btn-info">Ver</a>
                                </td>
                            </tr>
                        <?php endforeach;
                    else: ?>
                        <tr>
                            <td colspan="7">
                                <div class="no-tickets">No tienes tickets asignados.</div>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <a href="<?= APP_URL ?>/?c=Tecnico&a=dashboard" class="btn btn-secondary">Volver al Dashboard</a>
        </div>
    </div>
</div>
</body>
</html>