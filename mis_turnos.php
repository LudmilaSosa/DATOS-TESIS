<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['idusuario'])) {
    header("Location: index.php");
    exit();
}

$conexion = mysqli_connect("localhost", "root", "", "canchaalmen3");
if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}

$idusuario = $_SESSION['idusuario'];

// Buscar ID del cliente asociado
$sqlCliente = "SELECT idcliente FROM cliente WHERE usuario_idusuario = $idusuario LIMIT 1";
$resCliente = mysqli_query($conexion, $sqlCliente);
$rowCliente = mysqli_fetch_assoc($resCliente);
$idcliente = $rowCliente['idcliente'] ?? 0;

if (!$idcliente) {
    echo "<p>No se encontró un cliente asociado a este usuario.</p>";
    exit;
}

// Buscar turnos del cliente
$sql = "SELECT tt.nombre AS tipo_turno, f.fechaN, h.hora, td.estado
        FROM turnos_dados td
        INNER JOIN tipo_turno tt ON td.tipo_turno_idtipo_turno = tt.idtipo_turno
        INNER JOIN fecha f ON td.fecha_idfecha = f.idfecha
        INNER JOIN hora h ON td.hora_idhora = h.idhora
        WHERE td.cliente_idcliente = $idcliente
        ORDER BY f.fechaN ASC, h.hora ASC";

$res = mysqli_query($conexion, $sql);
?>

<h2>Mis turnos</h2>
<table border="1" cellpadding="8">
    <tr style="background-color:#eee;">
        <th>Tipo de turno</th>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Estado</th>
    </tr>
    <?php
    if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            echo "<tr>
                    <td>{$row['tipo_turno']}</td>
                    <td>{$row['fechaN']}</td>
                    <td>{$row['hora']}</td>
                    <td>{$row['estado']}</td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No tenés turnos registrados.</td></tr>";
    }
    ?>
</table>

<p><a href="reserva.php">Reservar nuevo turno</a> | <a href="../sesion/logout.php">Cerrar sesión</a></p>
