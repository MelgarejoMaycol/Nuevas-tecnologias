<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Tickets</title>
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
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
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
        
        .btn-primary {
            background-color: #3498db;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
        
        .btn-info {
            background-color: #17a2b8;
            color: white;
            padding: 6px 12px;
            font-size: 14px;
        }
        
        .btn-info:hover {
            background-color: #138496;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .mb-3 {
            margin-bottom: 1rem;
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
        .estado-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .estado-pendiente {
            background-color: #ffeaa7;
            color: #d35400;
        }
        
        .estado-procesando {
            background-color: #81ecec;
            color: #00b894;
        }
        
        .estado-completado {
            background-color: #55efc4;
            color: #00b894;
        }
        
        .estado-cerrado {
            background-color: #dfe6e9;
            color: #636e72;
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
            
            .card-title {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .card-title .btn {
                margin-top: 10px;
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
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="card fade-in-up">
        <div class="card-body">
            <h3 class="card-title">
                Mis Tickets
                <a href="<?= APP_URL ?>/?c=Ticket&a=nuevo" class="btn btn-primary">Nuevo Ticket</a>
            </h3>
            
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Estado</th>
                            <th>Importante</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $n = 1; foreach ($tickets as $ticket): ?>
                        <tr>
                            <td><?= $n++ ?></td>
                            <td><?= htmlspecialchars($ticket['titulo']) ?></td>
                            <td>
                                <?php
                                $estadoClass = '';
                                switch(strtolower($ticket['estado'])) {
                                    case 'pendiente':
                                        $estadoClass = 'estado-pendiente';
                                        break;
                                    case 'procesando':
                                        $estadoClass = 'estado-procesando';
                                        break;
                                    case 'completado':
                                        $estadoClass = 'estado-completado';
                                        break;
                                    case 'cerrado':
                                        $estadoClass = 'estado-cerrado';
                                        break;
                                    default:
                                        $estadoClass = 'estado-pendiente';
                                }
                                ?>
                                <span class="estado-badge <?= $estadoClass ?>"><?= ucfirst($ticket['estado']) ?></span>
                            </td>
                            <td>
                                <?php if ($ticket['importante']): ?>
                                    <span class="estado-badge estado-completado">Sí</span>
                                <?php else: ?>
                                    <span class="estado-badge estado-pendiente">No</span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($ticket['fecha_creacion'])) ?></td>
                            <td class="actions-cell">
                                <a href="<?= APP_URL ?>/?c=Ticket&a=ver&id=<?= $ticket['id'] ?>" class="btn btn-info">Ver</a>
                                <a href="<?= APP_URL ?>/?c=Ticket&a=eliminar&id=<?= $ticket['id'] ?>" class="btn btn-secondary" onclick="return confirm('¿Seguro que deseas eliminar este ticket?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($tickets)): ?>
                        <tr>
                            <td colspan="6">
                                <div class="no-tickets">No tienes tickets.</div>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <a href="<?= APP_URL ?>/?c=Cliente&a=dashboard" class="btn btn-secondary">Volver al Dashboard</a>
        </div>
    </div>
</div>
</body>
</html>