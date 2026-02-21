<?php
header('Content-Type: application/json');

$conexion = mysqli_connect("localhost", "root", "", "canchaalmen3");
if (!$conexion) {
    echo json_encode(["disponible"=>false, "mensaje"=>"Error en la conexión"]);
    exit;
}

$fecha = $_POST['fecha'] ?? '';
$hora = $_POST['hora'] ?? '';

if (empty($fecha) || empty($hora)) {
    echo json_encode(["disponible"=>false, "mensaje"=>"Faltan datos"]);
    exit;
}

$sql = "SELECT td.idturnos_dados
        FROM turnos_dados td
        INNER JOIN fecha f ON td.fecha_idfecha = f.idfecha
        WHERE f.fechaN = '$fecha' AND td.hora_idhora = $hora AND td.estado != 'cancelado'";

$res = mysqli_query($conexion, $sql);

if (mysqli_num_rows($res) > 0) {
    echo json_encode(["disponible"=>false, "mensaje"=>"❌ Turno ocupado"]);
} else {
    echo json_encode(["disponible"=>true, "mensaje"=>"✅ Turno disponible"]);
}
