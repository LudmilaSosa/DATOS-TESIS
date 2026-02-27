<?php
session_start();
include("../conexion.php");

/* PROTEGER ACCESO */
if (!isset($_SESSION['idusuario']) || 
   ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2)) {
    header("Location: ../login.php");
    exit;
}

/* =========================
   PROCESAR FORMULARIO
========================= */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $tipo = $_POST['tipo_cliente'] ?? '';

    if ($tipo == "registrado") {

        $cliente_id = $_POST['cliente_id'];

    } elseif ($tipo == "anonimo") {

        $nombre = $_POST['nombre_anonimo'];
        $telefono = $_POST['telefono_anonimo'];

        mysqli_query($conexion, "
            INSERT INTO cliente (Nombre, telefono, anonimo)
            VALUES ('$nombre', '$telefono', 1)
        ");

        $cliente_id = mysqli_insert_id($conexion);
    }

    echo "✅ Cliente ID generado: " . $cliente_id;
}
?>

<h2>Asignar Turno</h2>

<form method="POST">

    <label>Tipo de cliente:</label>
    <select name="tipo_cliente" required>
        <option value="">Seleccionar</option>
        <option value="registrado">Cliente registrado</option>
        <option value="anonimo">Cliente anónimo</option>
    </select>

    <hr>

    <h3>Cliente registrado</h3>
    <input type="number" name="cliente_id" 
           placeholder="ID Cliente">

    <hr>

    <h3>Cliente anónimo</h3>
    <input type="text" name="nombre_anonimo"
           placeholder="Nombre">

    <input type="text" name="telefono_anonimo"
           placeholder="Teléfono">

    <br><br>
    <button type="submit">Guardar turno</button>

</form>     
