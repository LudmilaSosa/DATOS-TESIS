<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != "empleado") {
    header("Location: ../login.php");
    exit();
}
?>

<h1>Panel Empleado</h1>
<p>Bienvenido <?php echo $_SESSION['usuario']; ?></p>

<a href="../SESION/logout.php">Cerrar sesión</a>
