<?php
require_once __DIR__ . '/config/config.php';

$c = $_GET['c'] ?? 'Home';
$a = $_GET['a'] ?? 'index';

$controllerFile = __DIR__ . "/controllers/{$c}Controller.php";
if (!file_exists($controllerFile)) { http_response_code(404); exit('Controlador no encontrado'); }
require_once $controllerFile;

$controllerClass = $c . 'Controller';
$controller = new $controllerClass;

if (!method_exists($controller, $a)) { http_response_code(404); exit('Acción no encontrada'); }
$controller->$a();
