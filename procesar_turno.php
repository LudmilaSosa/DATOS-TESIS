<?php
session_start();
include("../conexion.php");

if (!isset($_SESSION['idusuario']) || ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2)) {
    header("Location: ../login.php");
    exit;
}

$tipo = $_POST['tipo_cliente'];

if ($tipo === 'registrado') {
    $cliente_id = $_POST['cliente_id'];
} else {
    mysqli_query($conexion, "
        INSERT INTO cliente (nombre, telefono, anonimo)
        VALUES ('{$_POST['nombre_anonimo']}', '{$_POST['telefono_anonimo']}', 1)
    ");
    $cliente_id = mysqli_insert_id($conexion);
}

