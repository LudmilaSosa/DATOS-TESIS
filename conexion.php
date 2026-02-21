<?php
$conexion = mysqli_connect("localhost", "root", "", "canchaalmen3");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
