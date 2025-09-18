<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del Ticket</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f7f9; color: #333; }
        .container { max-width: 500px; margin: 40px auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #0001; padding: 32px; }
        .label { font-weight: bold; }
        .valor { margin-bottom: 16px; }
        .badge { display: inline-block; padding: 4px 10px; border-radius: 8px; font-size: 0.9em; }
        .badge-importante { background: #e74c3c; color: #fff; }
        .badge-normal { background: #bbb; color: #fff; }
        .badge-estado { background: #3498db; color: #fff; }
        .badge-cerrado { background: #27ae60; color: #fff; }
        .badge-abierto { background: #f39c12; color: #fff; }
        .badge-porasignar { background: #7f8c8d; color: #fff; }
        .btn { display: inline-block; margin-top: 20px; padding: 8px 18px; background: #3498db; color: #fff; border: none; border-radius: 6px; text-decoration: none; }
        .btn:hover { background: #217dbb; }
    </style>
</head>
<body>
<div class="container">
    <h2>Detalle del Ticket</h2>
    <?php if (!$ticket): ?>
        <div style="color:red;text-align:center;margin-top:40px;">Ticket no encontrado.</div>
    <?php else: ?>
        <div class="valor">
            <span class="label">Título:</span> <?= htmlspecialchars($ticket['titulo']) ?>
        </div>
        <div class="valor">
            <span class="label">Descripción:</span> <?= nl2br(htmlspecialchars($ticket['descripcion'])) ?>
        </div>
        <div class="valor">
            <span class="label">Importancia:</span>
            <?php if (!empty($ticket['importante'])): ?>
                <span class="badge badge-importante">Importante</span>
            <?php else: ?>
                <span class="badge badge-normal">Normal</span>
            <?php endif; ?>
        </div>
        <div class="valor">
            <span class="label">Estado:</span>
            <?php
                $estado = strtolower($ticket['estado']);
                $badgeClass = 'badge-estado';
                if ($estado === 'cerrado') $badgeClass = 'badge-cerrado';
                elseif ($estado === 'abierto') $badgeClass = 'badge-abierto';
                elseif ($estado === 'por asignar') $badgeClass = 'badge-porasignar';
            ?>
            <span class="badge <?= $badgeClass ?>"><?= ucfirst($ticket['estado']) ?></span>
        </div>
        <div class="valor">
            <span class="label">Fecha de creación:</span>
            <?= date('d/m/Y H:i', strtotime($ticket['fecha_creacion'])) ?>
        </div>
        <div class="valor">
            <span class="label">Tiempo transcurrido:</span>
            <?php
                $fechaCreacion = new DateTime($ticket['fecha_creacion']);
                $ahora = new DateTime();
                $intervalo = $fechaCreacion->diff($ahora);
                if ($intervalo->d > 0) echo $intervalo->d . ' días ';
                if ($intervalo->h > 0) echo $intervalo->h . ' horas ';
                if ($intervalo->i > 0) echo $intervalo->i . ' minutos ';
                if ($intervalo->d == 0 && $intervalo->h == 0 && $intervalo->i == 0) echo 'Menos de 1 minuto';
            ?>
        </div>
    <?php endif; ?>
    <a href="<?= APP_URL ?>/?c=Tecnico&a=ticketsAsignados" class="btn">Volver</a>
</div>
</body>
</html>