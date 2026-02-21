<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION['rol'])) {
    header("Location: login.php");
    exit();
}

switch ($_SESSION['rol']) {

    case "admin":
        header("Location: /tesis_prueba/DASHBOARD/admin_dashboard.php");
        break;

    case "empleado":
        header("Location: /tesis_prueba/DASHBOARD/empleado_dashboard.php");
        break;

    case "cliente":
        header("Location: /tesis_prueba/DASHBOARD/cliente_dashboard.php");
        break;

    default:
        header("Location: login.php");
}

exit();
