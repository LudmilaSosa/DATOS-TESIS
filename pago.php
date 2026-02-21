<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['idusuario'])) {
    header("Location: index.php");
    exit();
}

$conexion = mysqli_connect("localhost", "root", "", "canchaalmen3");
if (!$conexion) die("Error en la conexión: " . mysqli_connect_error());

$idusuario = $_SESSION['idusuario'];
$tipo_turno_id = $_POST['tipo_turno_id'];
$fechaN = $_POST['fechaN'];
$hora_id = $_POST['hora_id'];

$diaSemana = date('N', strtotime($fechaN));

$diasPermitidos = [];
$res = mysqli_query($conexion, "SELECT dia_semana FROM dias_habilitados");

while ($row = mysqli_fetch_assoc($res)) {
    $diasPermitidos[] = $row['dia_semana'];
}

if (!in_array($diaSemana, $diasPermitidos)) {
    die("<p style='color:red;'>Ese día no está habilitado para reservas</p>");
}

// Buscar cliente asociado al usuario
$resCliente = mysqli_query($conexion, "SELECT idcliente FROM cliente WHERE usuario_idusuario = $idusuario LIMIT 1");
$rowCliente = mysqli_fetch_assoc($resCliente);
$idcliente = $rowCliente['idcliente'] ?? 0;

if (!$idcliente) {
    die("No se encontró cliente asociado al usuario.");
}

// Buscar o insertar fecha
$resFecha = mysqli_query($conexion, "SELECT idfecha FROM fecha WHERE fechaN = '$fechaN'");
if (mysqli_num_rows($resFecha) > 0) {
    $f = mysqli_fetch_assoc($resFecha);
    $idfecha = $f['idfecha'];
} else {
    mysqli_query($conexion, "INSERT INTO fecha (fechaN) VALUES ('$fechaN')");
    $idfecha = mysqli_insert_id($conexion);
}

// Generar código de pago único y vencimiento
$codigo_pago = uniqid("PAG-");
$vencimiento = date('Y-m-d H:i:s', strtotime("$fechaN 00:00:00") + 16 * 3600 - 3600); // 1h antes de las 17:00 por ejemplo

// Crear turno pendiente
mysqli_query($conexion, "
INSERT INTO turnos_dados (fecha_idfecha, hora_idhora, cliente_idcliente, tipo_turno_idtipo_turno, estado, codigo_pago, vencimiento_pago)
VALUES ($idfecha, $hora_id, $idcliente, $tipo_turno_id, 'pendiente', '$codigo_pago', '$vencimiento')
");
?>

<h2>Turno pendiente de pago</h2>
<p>Tu turno fue reservado correctamente.</p>
<p>Tiene validez hasta <b><?php echo date("d/m/Y H:i", strtotime($vencimiento)); ?></b>.</p>

<h3>Datos para el pago:</h3>
<ul>
<li>Alias Mercado Pago: <b>cancha.almen.mp</b></li>
<li>CVU: <b>0000003100032429857115</b></li>
<li>Código de pago: <b><?php echo $codigo_pago; ?></b></li>
</ul>

<p>Una vez realizado el pago, el turno se confirmará automáticamente.</p>
<p><a href="mis_turnos.php">Ver mis turnos</a></p>
