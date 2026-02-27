<link rel="stylesheet" href="css/styles.css">
<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!---- Header ---->
<header class="site-header">
  <div class="container header-left">
    <!-- mejor usar SVG inline o como <img> -->
    <img src="logo2.JPEG" alt="Escudo Cancha Los Almendros" class="escudo">
    <span class="site-title">Cancha Los Almendros</span>
  </div>

  <nav class="header-nav">
    <a href="index.php">Inicio</a>
    <?php if (isset($_SESSION['idusuario'])): ?>
      <a href="FORMULARIO/reserva.php">Reservar turno</a>
      <a href="FORMULARIO/mis_turnos.php">Mis turnos</a>
    <?php endif; ?>
  </nav>

  <div class="header-right">
    <?php if (isset($_SESSION['idusuario'])): ?>
      <button class="icon-btn" aria-label="Notificaciones">🔔</button>
      <div class="user-info" aria-live="polite">
        <span class="user-name"><?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
        <a href="../logout.php" class="logout-link">Cerrar sesión</a>
      </div>
    <?php endif; ?>
  </div>
</header>
