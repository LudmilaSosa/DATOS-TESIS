<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

session_start();
require_once("conexion.php");
include("header.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usuario = $_POST['nomusuario'];
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT idusuario, nomusuario, contrasena, roles_idroles 
            FROM usuario 
            WHERE nomusuario = '$usuario'";

    $res = mysqli_query($conexion, $sql);

    if ($fila = mysqli_fetch_assoc($res)) {

        if (password_verify($contrasena, $fila['contrasena'])) {

            $_SESSION['idusuario'] = $fila['idusuario'];
            $_SESSION['usuario'] = $fila['nomusuario'];
            $_SESSION['rol'] = $fila['roles_idroles'];

            if ($_SESSION['rol'] == 1) {
                header("Location: DASHBOARD/admin_dashboard.php");
            } elseif ($_SESSION['rol'] == 2) {
                header("Location: DASHBOARD/empleado_dashboard.php");
            } else {
                header("Location: DASHBOARD/cliente_dashboard.php");
            }
            exit;
        }
    }
}
?>
 
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<div class="login-wrapper">

    <div class="login-box">

        <h2>Iniciar sesión</h2>

        <?php if (!empty($error)): ?>
            <div class="login-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="post">
            <input type="text" name="nomusuario" placeholder="Usuario" required>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
        </form>

        <div class="login-links">
            <a href="recuperacioncontraseña(1).php">¿Olvidaste tu contraseña?</a>
            <a href="SESION/registrar.php">Crear cuenta</a>
        </div>

    </div>

</div>

</body>
</html>
