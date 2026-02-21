<link rel="stylesheet" href="css/styles.css">
<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!---- Header ---->
<header class="site-header">
  <div class="container header-left">
    <!-- mejor usar SVG inline o como <img> -->
    <img src="logocancha.jpg" alt="Escudo Cancha Los Almendros" class="escudo">
    <span class="site-title">Cancha Los Almendros</span>
  </div>

  <nav class="header-nav">
    <a href="index(5).php">Inicio</a>
    <?php if (isset($_SESSION['idusuario'])): ?>
      <a href="formulario/reserva.php">Reservar turno</a>
      <a href="formulario/mis_turnos.php">Mis turnos</a>
    <?php endif; ?>
  </nav>

  <div class="header-right">
    <?php if (isset($_SESSION['idusuario'])): ?>
      <button class="icon-btn" aria-label="Notificaciones">🔔</button>
      <div class="user-info" aria-live="polite">
        <span class="user-name"><?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
        <a href="sesion/logout.php" class="logout-link">Cerrar sesión</a>
      </div>
    <?php else: ?>
      <a href="login.php" class="login-link">Iniciar sesión</a>
      <a href="SESION/registrar.php" class="reg-link">Registrar</a>
    <?php endif; ?>
  </div>
</header>
