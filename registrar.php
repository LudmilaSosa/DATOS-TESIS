<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

$conexion = mysqli_connect("localhost", "root", "", "canchaalmen3");
if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Campos del formulario
    $usuario = $_POST['usuario'] ?? '';
    $contraseña = $_POST['contrasena'] ?? '';
    $contraseña2 = $_POST['contrasena2'] ?? ''; // confirmación
    $nombre = $_POST['nombre'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $email = $_POST['email'] ?? '';

    // ---- Validaciones ----
    if (empty($usuario) || empty($contraseña) || empty($contraseña2) || empty($nombre) || empty($telefono) || empty($email)) {
        echo "<p style='color:red;'>Todos los campos son obligatorios.</p>";
    } elseif ($contraseña !== $contraseña2) {
        echo "<p style='color:red;'>Las contraseñas no coinciden.</p>";
        echo "<p><a href='registrar.php'>Volver al registro</a></p>";
    } else {
        $errores = [];

        // Validar usuario duplicado
        $res = mysqli_query($conexion, "SELECT idusuario FROM usuario WHERE nomusuario = '$usuario'");
        if (mysqli_num_rows($res) > 0) {
            $errores[] = "El nombre de usuario ya está en uso.";
        }

        // Validar email duplicado
        $res = mysqli_query($conexion, "SELECT idcliente FROM cliente WHERE email = '$email'");
        if (mysqli_num_rows($res) > 0) {
            $errores[] = "El email ya está registrado.";
        }

        if (count($errores) > 0) {
            foreach ($errores as $e) {
                echo "<p style='color:red;'>$e</p>";
            }
            echo "<p><a href='registrar.php'>Volver al registro</a></p>";
        } else {
            // 1️⃣ Encriptar contraseña
            $hash = password_hash($contraseña, PASSWORD_DEFAULT);

            // 2️⃣ Insertar en usuario
            $sql_usuario = "INSERT INTO usuario (nomusuario, contrasena, roles_idroles) 
                            VALUES ('$usuario', '$hash', 2)"; // rol=2 = cliente

            if (mysqli_query($conexion, $sql_usuario)) {
                $idusuario = mysqli_insert_id($conexion);

                // 3️⃣ Insertar en cliente
                $sql_cliente = "INSERT INTO cliente (Nombre, telefono, email, usuario_idusuario) 
                                VALUES ('$nombre', '$telefono', '$email', $idusuario)";

                if (mysqli_query($conexion, $sql_cliente)) {
                    echo "<p style='color:green;'>Registro exitoso. Ya puedes <a href='../index(5).php'>iniciar sesión</a>.</p>";
                } else {
                    echo "<p style='color:red;'>Error al guardar en cliente: " . mysqli_error($conexion) . "</p>";
                }
            } else {
                echo "<p style='color:red;'>Error al guardar usuario: " . mysqli_error($conexion) . "</p>";
            }
        }
    }
} else {
    // ---- FORMULARIO ----
    ?>
    <h2>Registro de usuario</h2>
<div class="login-wrapper">

    <div class="login-box">

        <h2>Registrar</h2>

        <?php if (!empty($error)): ?>
            <div class="login-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="post">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <input type="password" name="contrasena2" placeholder="Confirmar contraseña"required><br>
            <input type="text" name="nombre" placeholder="Nombre"required><br>
            <input type="text" name="telefono" placeholder="Telefono"required><br>
            <input type="email" name="email" placeholder="Correo electronico" required><br>
            <button type="submit">Registrarse</button>
        </form>

              <p><a href="../login.php">Volver </a></p>
    </form>

    </div>

</div>

      
    <?php
}
?>
