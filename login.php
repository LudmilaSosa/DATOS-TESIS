<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once("conexion.php");

$error = "";

// Si ya está logueado
if (isset($_SESSION['idusuario'])) {
    header("Location: /tesis_prueba/index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $usuario = $_POST['nomusuario'];
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT idusuario, nomusuario, contrasena, roles_idroles
            FROM usuario
            WHERE nomusuario = '$usuario'";

    $res = mysqli_query($conexion, $sql);

    if ($res && mysqli_num_rows($res) > 0) {

        $row = mysqli_fetch_assoc($res);

if (password_verify($contrasena, $row['contrasena'])) {

            $_SESSION['idusuario'] = $row['idusuario'];
            $_SESSION['usuario'] = $row['nomusuario'];
            $_SESSION['rol'] = $row['roles_idroles'];

            // Redirección por rol
            if ($row['roles_idroles'] == 1) {
                header("Location:index.php");
                exit();
            } elseif ($row['roles_idroles'] == 2) {
                header("Location: ../index.php");
                exit();
            } elseif ($row['roles_idroles'] == 3) {
                header("Location: ../index.php");
                exit();
            } else {
                header("Location: ../index.php");
            }

            exit;

        } else {
            $error = "Contraseña incorrecta";
        }

    } else {
        $error = "Usuario no encontrado";
    }
}
?>

<?php include("header.php"); ?>

<div class="login-wrapper">
    <div class="login-box">
        <h2>Iniciar sesión</h2>

        <?php if ($error): ?>
            <div class="login-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="post">
            <input type="text" name="nomusuario" placeholder="Usuario" required>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
        </form>
    </div>
</div>

<div class="login-wrapper">

    <div class="login-box">

        <h2>Iniciar sesión</h2>

        <?php if (!empty($error)): ?>
            <div class="login-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="post">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
        </form>

        <div class="login-links">
            <a href="recuperacioncontraseña(1).php">¿Olvidaste tu contraseña?</a>
            <a href="SESION/registrar.php">Crear cuenta</a>
        </div>

    </div>

</div>
