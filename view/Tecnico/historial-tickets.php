<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Tickets Cerrados</title>
    <style>
        /* Estilos generales */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }
        
        .container {
            max-width: 1400px;
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
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
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
            font-size: 24px;
            display: flex;
            align-items: center;
        }
        
        .card-title::before {
            content: "📋";
            margin-right: 10px;
            font-size: 28px;
        }
        
        /* Estilos de botones */
        .btn {
            display: inline-block;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .btn-secondary {
            background-color: #6c757d;
            color: white;
            margin-top: 20px;
        }
        
        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
        
        /* Estilos de tabla */
        .table-container {
            overflow-x: auto;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        
        th, td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid #eaeaea;
        }
        
        th {
            background-color: #2c3e50;
            color: white;
            font-weight: 600;
            position: sticky;
            top: 0;
        }
        
        tr {
            transition: background-color 0.2s;
        }
        
        tr:hover {
            background-color: #f8f9fa;
        }
        
        /* Badge para estado cerrado */
        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .badge-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        /* Descripción con truncado */
        .descripcion {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .descripcion:hover {
            white-space: normal;
            overflow: visible;
            position: absolute;
            background: white;
            padding: 12px;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 10;
            max-width: 400px;
        }
        
        /* Mensaje de tabla vacía */
        .text-center {
            text-align: center;
        }
        
        .no-tickets {
            padding: 40px 20px;
            text-align: center;
            color: #6c757d;
            font-style: italic;
            background-color: #f8f9fa;
            border-radius: 8px;
        }
        
        .no-tickets::before {
            content: "😊";
            font-size: 40px;
            display: block;
            margin-bottom: 15px;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .container {
                padding: 10px;
            }
            
            .card-body {
                padding: 20px;
            }
            
            th, td {
                padding: 12px 10px;
            }
            
            .descripcion {
                max-width: 200px;
            }
        }
        
        @media (max-width: 768px) {
            table {
                font-size: 14px;
            }
            
            th, td {
                padding: 10px 8px;
            }
            
            .card-title {
                font-size: 20px;
            }
            
            .btn {
                width: 100%;
                margin-bottom: 10px;
            }
            
            .descripcion {
                max-width: 150px;
            }
        }
        
        @media (max-width: 576px) {
            body {
                padding: 10px;
            }
            
            .card-body {
                padding: 15px;
            }
            
            th, td {
                display: block;
                width: 100%;
                box-sizing: border-box;
            }
            
            thead {
                display: none;
            }
            
            tr {
                display: block;
                margin-bottom: 15px;
                border: 1px solid #eaeaea;
                border-radius: 8px;
                padding: 10px;
            }
            
            td {
                padding: 8px;
                border: none;
                position: relative;
                padding-left: 40%;
            }
            
            td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                width: 35%;
                padding-right: 10px;
                white-space: nowrap;
                font-weight: 600;
                color: #2c3e50;
            }
            
            .descripcion {
                max-width: none;
                white-space: normal;
            }
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="card fade-in-up">
        <div class="card-body">
            <h3 class="card-title">Historial de Tickets Cerrados</h3>
            
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Fecha de cierre</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (!empty($ticketsCerrados)):
                        foreach ($ticketsCerrados as $ticket): ?>
                            <tr>
                                <td data-label="ID"><?= $ticket['id'] ?></td>
                                <td data-label="Título"><?= htmlspecialchars($ticket['titulo']) ?></td>
                                <td data-label="Descripción" class="descripcion"><?= htmlspecialchars($ticket['descripcion']) ?></td>
                                <td data-label="Estado"><span class="badge badge-success">Cerrado</span></td>
                                <td data-label="Fecha de cierre"><?= date('d/m/Y H:i', strtotime($ticket['fecha_creacion'])) ?></td>
                            </tr>
                        <?php endforeach;
                    else: ?>
                        <tr>
                            <td colspan="5">
                                <div class="no-tickets">No tienes tickets cerrados en tu historial.</div>
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

<script>
    // Mejora para la visualización de descripciones largas
    document.addEventListener('DOMContentLoaded', function() {
        const descripciones = document.querySelectorAll('.descripcion');
        
        descripciones.forEach(desc => {
            // Solo aplicar si el texto es largo
            if (desc.textContent.length > 50) {
                desc.title = 'Haga clic para ver la descripción completa';
                
                desc.addEventListener('click', function() {
                    this.classList.toggle('expanded');
                });
            }
        });
    });
</script>
</body>
</html>