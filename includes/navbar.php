<?php
// includes/navbar.php - Menú principal del sistema

$base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
if ($base_url === '') {
    $base_url = '/';
}
?>
<nav class="main-nav">
    <div class="container nav-inner">
        <ul>
            <li><a href="<?php echo BASE_URL; ?>index.php">Inicio</a></li>
            <li><a href="<?php echo BASE_URL; ?>modules/habitaciones/listar.php">Habitaciones</a></li>
            <li><a href="<?php echo BASE_URL; ?>modules/reservas/listar.php">Reservas</a></li>
            <li><a href="<?php echo BASE_URL; ?>modules/mantenimiento/listar.php">Mantenimiento</a></li>
        </ul>
    </div>
</nav>
