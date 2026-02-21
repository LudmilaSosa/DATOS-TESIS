<?php

session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Conexion

$conexion=mysqli_connect("localhost","root","","canchaalmen3");
if(!$conexion){
    die("Error de conexion: ".mysqli_connect_error());
}

//----FORMULARIO----
function formRegistro($conexion){
    ?>
<form action="" method="post">
        <h3>Seleccionar cliente registrado</h3>
        <select name="cliente_id">
            <option value="">-- Seleccione un cliente --</option>
            <?php
            $clientes = mysqli_query($conexion, "SELECT idcliente, Nombre FROM cliente");
            while ($cli = mysqli_fetch_assoc($clientes)) {
                echo "<option value='{$cli['idcliente']}'>{$cli['Nombre']}</option>";
            }
            ?>
        </select>

        <h3>O ingresar cliente rápido</h3>
        <input type="text" name="nombre_rapido" placeholder="Nombre">
        <input type="text" name="telefono_rapido" placeholder="Teléfono">

        <h3>Tipo de turno</h3>
        <select name="tipo_turno_id" required>
            <?php
            $tipos = mysqli_query($conexion, "SELECT idtipo_turno, nombre, precio FROM tipo_turno");
            while ($tipo = mysqli_fetch_assoc($tipos)) {
                echo "<option value='{$tipo['idtipo_turno']}'>{$tipo['nombre']} - $ {$tipo['precio']}</option>";
            }
            ?>
        </select>

        <h3>Fecha</h3>
        <input type="date" name="fechaN" required>

        <h3>Hora</h3>
        <select name="hora_id" required>
            <?php
            $horas = mysqli_query($conexion, "SELECT idhora, hora FROM hora");
            while ($h = mysqli_fetch_assoc($horas)) {
                echo "<option value='{$h['idhora']}'>{$h['hora']}</option>";
            }
            ?>
        </select>

        <br><br>
        <input type="submit" value="Reservar">
    </form>
<?php
}

// ---- PROCESAMIENTO ----
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cliente_id = $_POST['cliente_id'] ?? '';
    $nombre_rapido = trim($_POST['nombre_rapido'] ?? '');
    $telefono_rapido = trim($_POST['telefono_rapido'] ?? '');
    $tipo_turno_id = $_POST['tipo_turno_id'] ?? '';
    $fechaN = $_POST['fechaN'] ?? '';
    $hora_id = $_POST['hora_id'] ?? '';

    // 1️⃣ Determinar cliente a usar
    if (!empty($cliente_id)) {
        // Cliente registrado
        $id_cliente_final = $cliente_id;
    } elseif (!empty($nombre_rapido)) {
        // Crear cliente rápido
        mysqli_query($conexion, "INSERT INTO cliente (Nombre, telefono, usuario_idusuario, email) 
                                 VALUES ('$nombre_rapido', '$telefono_rapido', 1, NULL)");
        $id_cliente_final = mysqli_insert_id($conexion);
    } else {
        // Cliente anónimo (id=1)
        $id_cliente_final = 1;
    }

    // 2️⃣ Insertar o buscar fecha
    $res = mysqli_query($conexion, "SELECT idfecha FROM fecha WHERE fechaN = '$fechaN'");
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $id_fecha = $row['idfecha'];
    } else {
        mysqli_query($conexion, "INSERT INTO fecha (fechaN) VALUES ('$fechaN')");
        $id_fecha = mysqli_insert_id($conexion);
    }

    // 3️⃣ Verificar si ya existe el turno
    $verificar = mysqli_query($conexion, "SELECT * FROM turnos_dados 
        WHERE fecha_idfecha = $id_fecha AND hora_idhora = $hora_id");
    if (mysqli_num_rows($verificar) > 0) {
        echo "<p style='color:red;'>La fecha y hora ya están reservadas.</p>";
    } else {
        // 4️⃣ Insertar turno
        $sql = "INSERT INTO turnos_dados (fecha_idfecha, hora_idhora, cliente_idcliente, tipo_turno_idtipo_turno) 
                VALUES ($id_fecha, $hora_id, $id_cliente_final, $tipo_turno_id)";
        if (mysqli_query($conexion, $sql)) {
            echo "<p style='color:green;'>Turno reservado exitosamente.</p>";
        } else {
            echo "<p style='color:red;'>Error al guardar turno: " . mysqli_error($conexion) . "</p>";
        }
    }
}

// Mostrar formulario siempre
formRegistro($conexion);
?>

    </form>
