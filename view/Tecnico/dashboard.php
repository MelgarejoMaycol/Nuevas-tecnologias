<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Dashboard Técnico - Sistema de Tickets</title>

    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/main.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/dashboard-styles.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="container">
            <!-- Header del Dashboard -->
            <div class="row fade-in-up">
                <div class="col-12">
                    <div class="card dashboard-header">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="user-info">
                                    <span class="user-badge">
                                        <i class="fa fa-user"></i> Bienvenido, <?= $_SESSION['user_name'] ?>
                                    </span>
                                </div>
                                <div class="text-center flex-grow-1">
                                    <h2 class="dashboard-title mb-0">
                                        <i class="fa fa-user-circle"></i> Dashboard del Técnico
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

            <!-- Cards de Acciones -->
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card action-card card-primary fade-in-up">
                        <div class="card-body action-card-body">
                            <h4 class="card-title">Tickets Asignados</h4>
                            <p class="card-description">Ver los tickets que tienes asignados</p>
                            <a href="<?= APP_URL ?>/?c=Tecnico&a=ticketsAsignados" class="btn btn-primary">
                                <i class="fa fa-tasks"></i> Ver Tickets
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card action-card card-info fade-in-up">
                        <div class="card-body action-card-body">
                            <h4 class="card-title">Historial de Tickets</h4>
                            <p class="card-description">Ver el historial de tickets cerrados</p>
                            <a href="<?= APP_URL ?>/?c=Tecnico&a=historialTickets" class="btn btn-info">
                                <i class="fa fa-history"></i> Ver Historial
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Resumen de Tickets -->
                <div class="col-lg-4 col-md-12 mb-4">
                    <div class="card stats-card card-success fade-in-up">
                        <div class="card-body text-center">
                            <h4 class="card-title">Resumen de Tickets</h4>
                            <div class="stat-group">
                                <div>
                                    <span class="stat-label">Total:</span>
                                    <span class="stat-number"><?= $totalTickets ?? 0 ?></span>
                                </div>
                                <div>
                                    <span class="stat-label">Abiertos:</span>
                                    <span class="stat-number"><?= $ticketsAbiertos ?? 0 ?></span>
                                </div>
                                <div>
                                    <span class="stat-label">Cerrados:</span>
                                    <span class="stat-number"><?= $ticketsCerrados ?? 0 ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= APP_URL ?>/public/js/lib/jquery/jquery.min.js"></script>
    <script src="<?= APP_URL ?>/public/js/lib/bootstrap/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.stats-card').hover(
                function() {
                    $(this).addClass('shadow-lg');
                },
                function() {
                    $(this).removeClass('shadow-lg');
                }
            );
        });
    </script>
</body>
</html>
