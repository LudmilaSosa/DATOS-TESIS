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
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reservar turno</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
body { font-family: Arial, sans-serif; background-color: #fafafa; padding: 20px; }
form { background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px #ccc; width: 400px; }
label { font-weight: bold; }
#disponibilidad { margin: 10px 0; font-weight: bold; }
</style>
</head>
<body>

<h2>Reservar turno</h2>

<form id="formTurno" action="pago.php" method="post">
    <label>Tipo de turno:</label><br>
    <select name="tipo_turno_id" required>
        <option value="">Seleccione...</option>
        <?php
        $tipos = mysqli_query($conexion, "SELECT idtipo_turno, nombre, precio FROM tipo_turno");
        while ($t = mysqli_fetch_assoc($tipos)) {
            echo "<option value='{$t['idtipo_turno']}'>{$t['nombre']} - \${$t['precio']}</option>";
        }
        ?>
    </select><br><br>

    <label>Fecha:</label><br>
    <?php $hoy = date('Y-m-d'); ?>
    <input type="date" id="fecha" name="fechaN" min="<?php echo $hoy; ?>" required><br><br>

    <label>Hora:</label><br>
    <select id="hora" name="hora_id" required>
        <option value="">Seleccione una hora</option>
        <?php
        $horas = mysqli_query($conexion, "SELECT idhora, hora FROM hora ORDER BY hora ASC");
        while ($h = mysqli_fetch_assoc($horas)) {
            echo "<option value='{$h['idhora']}'>{$h['hora']}</option>";
        }
        ?>
    </select>

    <div id="disponibilidad"></div>

    <input type="submit" id="btnReservar" value="Continuar con el pago" disabled>
</form>


<script>
$(document).ready(function(){
    function verificarDisponibilidad() {
        let fecha = $("#fecha").val();
        let hora = $("#hora").val();

        if (fecha && hora) {
            $.post("ajax_verificar_turno.php", { fecha: fecha, hora: hora }, function(respuesta) {
                $("#disponibilidad").html(respuesta.mensaje);
                if (respuesta.disponible) {
                    $("#disponibilidad").css("color", "green");
                    $("#btnReservar").prop("disabled", false);
                } else {
                    $("#disponibilidad").css("color", "red");
                    $("#btnReservar").prop("disabled", true);
                }
            }, "json");
        }
    }

    $("#fecha, #hora").change(verificarDisponibilidad);
});
</script>

</body>
</html>
