<?php
$conexion = mysqli_connect("localhost", "root", "", "canchaalmen3");
if (!$conexion) die("Error en la conexión: " . mysqli_connect_error());

$sql = "UPDATE turnos_dados 
        SET estado='cancelado' 
        WHERE estado='pendiente' AND vencimiento_pago < NOW()";

mysqli_query($conexion, $sql);

echo "Turnos vencidos cancelados.";
