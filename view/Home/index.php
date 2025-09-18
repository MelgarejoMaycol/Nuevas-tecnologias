<?php
$error = $_GET['error'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="<?= APP_URL ?>/public/css/separate/pages/login.min.css">
  <link rel="stylesheet" href="<?= APP_URL ?>/public/css/lib/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="<?= APP_URL ?>/public/css/main.css">
  <link rel="stylesheet" href="<?= APP_URL ?>/public/css/auth-styles.css">
</head>
<body>
  <div class="page-center">
    <div class="page-center-in">
      <div class="container-fluid">
        <form class="sign-box" method="POST" action="<?= APP_URL ?>/?c=Auth&a=login" novalidate>
          <div class="sign-avatar">
            <img src="<?= APP_URL ?>/public/img/avatar-sign.png" alt="">
          </div>
          <header class="sign-title">Sign In</header>

          <div class="form-group">
            <input type="email" class="form-control" name="identifier" placeholder="E-Mail" required>
          </div>
          <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
          </div>

          <button type="submit" class="btn btn-rounded">Sign in</button>
          <?php if ($error): ?>
            <div class="alert alert-danger mt-3"><?= htmlspecialchars($error) ?></div>
          <?php endif; ?>
          
          <div class="sign-links mt-3 text-center">
            <a href="<?= APP_URL ?>/?c=Auth&a=register" class="btn btn-outline-primary btn-block">
              <i class="fa fa-user-plus"></i> Crear una cuenta
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="<?= APP_URL ?>/public/js/lib/jquery/jquery.min.js"></script>
  <script src="<?= APP_URL ?>/public/js/lib/bootstrap/bootstrap.min.js"></script>
  <script src="<?= APP_URL ?>/public/js/home.js"></script>
</body>
</html>
