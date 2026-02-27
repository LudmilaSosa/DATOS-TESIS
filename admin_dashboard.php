<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../login.php");
    exit;
}
?>

<h1>Panel Administrador</h1>
<a href="../SESION/logout.php">Cerrar sesión</a>
<br>
<a href="../ADMIN/procesar_turno.php">reserva</a>

<form action="procesar_turno.php" method="POST">

<label>Tipo de cliente:</label>
<select name="tipo_cliente" required>
    <option value="">Seleccionar</option>
    <option value="registrado">Cliente registrado</option>
    <option value="anonimo">Cliente anónimo</option>
</select>

<input type="submit" value="Guardar turno">
</form>
