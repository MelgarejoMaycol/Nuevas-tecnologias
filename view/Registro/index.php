<?php
$error = $_GET['error'] ?? null;
$success = $_GET['success'] ?? null;
$name = $_POST['name'] ?? '';
?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>StartUI - Premium Bootstrap 4 Admin Dashboard Template</title>

	<link href="<?= APP_URL ?>/public/img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
	<link href="<?= APP_URL ?>/public/img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
	<link href="<?= APP_URL ?>/public/img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
	<link href="<?= APP_URL ?>/public/img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
	<link href="<?= APP_URL ?>/public/img/favicon.png" rel="icon" type="image/png">
	<link href="<?= APP_URL ?>/public/img/favicon.ico" rel="shortcut icon">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
<link rel="stylesheet" href="<?= APP_URL ?>/public/css/separate/pages/login.min.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="<?= APP_URL ?>/public/css/main.css">
</head>
<body>

    <div class="page-center">
        <div class="page-center-in">
            <div class="container-fluid">
                <form class="sign-box" method="POST" action="<?= APP_URL ?>/?c=Auth&a=processRegister" novalidate>
                    <div class="sign-avatar no-photo">&plus;</div>
                    <header class="sign-title">Sign Up</header>
                    
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" placeholder="Nombre completo" required/>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="E-Mail" required/>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password" required/>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="confirm_password" placeholder="Repeat password" required/>
                    </div>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    
                    <?php if ($success): ?>
                        <div class="alert alert-success">
                          <?= htmlspecialchars($success) ?>
                          <br>
                          <a href="<?= APP_URL ?>/?c=Home&a=index" class="btn btn-sm btn-primary mt-2">
                            Ir al Login
                          </a>
                        </div>
                    <?php endif; ?>
                    
                    <button type="submit" class="btn btn-rounded btn-success sign-up">Sign up</button>
                    <p class="sign-note">Already have an account? <a href="<?= APP_URL ?>/?c=Home&a=index">Sign in</a></p>
                    <!--<button type="button" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>-->
                </form>
            </div>
        </div>
    </div><!--.page-center-->

<script src="<?= APP_URL ?>/public/js/lib/jquery/jquery.min.js"></script>
<script src="<?= APP_URL ?>/public/js/lib/tether/tether.min.js"></script>
<script src="<?= APP_URL ?>/public/js/lib/bootstrap/bootstrap.min.js"></script>
<script src="<?= APP_URL ?>/public/js/plugins.js"></script>
    <script type="text/javascript" src="<?= APP_URL ?>/public/js/lib/match-height/jquery.matchHeight.min.js"></script>
    <script>
        $(function() {
            $('.page-center').matchHeight({
                target: $('html')
            });

            $(window).resize(function(){
                setTimeout(function(){
                    $('.page-center').matchHeight({ remove: true });
                    $('.page-center').matchHeight({
                        target: $('html')
                    });
                },100);
            });
        });
    </script>
<script src="<?= APP_URL ?>/public/js/app.js"></script>
<script src="<?= APP_URL ?>/public/js/auth.js"></script>
</body>
</html>
