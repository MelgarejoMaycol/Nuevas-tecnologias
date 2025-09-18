<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Ticket</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/main.css">
    <style>
        body {
            background: #f5f7f9;
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #333;
        }
        .asignar-container {
            max-width: 420px;
            margin: 60px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 16px #0002;
            padding: 32px 36px 28px 36px;
        }
        h2 {
            margin-bottom: 18px;
            color: #2c3e50;
            font-weight: 600;
            text-align: center;
        }
        label {
            font-weight: 500;
            margin-bottom: 8px;
            display: block;
        }
        select, input[type="text"], input[type="email"] {
            width: 100%;
            padding: 8px 10px;
            margin-bottom: 18px;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            font-size: 1em;
            background: #f9fafb;
            transition: border-color 0.2s;
        }
        select:focus, input:focus {
            border-color: #3498db;
            outline: none;
        }
        .ticket-info {
            background: #f0f4f8;
            border-radius: 6px;
            padding: 10px 14px;
            margin-bottom: 20px;
            font-size: 1.05em;
        }
        .btn-group {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 10px;
        }
        button, .btn-cancelar {
            padding: 8px 22px;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background 0.2s;
        }
        button {
            background: #3498db;
            color: #fff;
        }
        button:hover {
            background: #217dbb;
        }
        .btn-cancelar {
            background: #e0e0e0;
            color: #444;
            text-decoration: none;
            display: inline-block;
        }
        .btn-cancelar:hover {
            background: #bdbdbd;
        }
    </style>
</head>
<body>
    <div class="asignar-container">
        <h2>Asignar Ticket #<?= htmlspecialchars($ticket['id']) ?></h2>
        <div class="ticket-info">
            <strong>Asunto:</strong> <?= htmlspecialchars($ticket['asunto'] ?? '') ?>
        </div>
        <form method="post" action="<?= APP_URL ?>/?c=Ticket&a=asignar">
            <input type="hidden" name="ticket_id" value="<?= htmlspecialchars($ticket['id']) ?>">
            <label for="tecnico_id">Selecciona un técnico:</label>
            <select name="tecnico_id" id="tecnico_id" required>
                <option value="">-- Selecciona --</option>
                <?php foreach ($tecnicos as $tecnico): ?>
                    <option value="<?= $tecnico['id'] ?>">
                        <?= htmlspecialchars($tecnico['name']) ?> (<?= htmlspecialchars($tecnico['email']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="btn-group">
                <button type="submit">Asignar</button>
                <a href="<?= APP_URL ?>/?c=Admin&a=dashboard" class="btn-cancelar">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>