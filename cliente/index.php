<?php
session_start();

// Solo usuarios con rol 'cliente' pueden entrar
if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'usuario') {
    header('Location: ../login/login.php');
    exit;
}

require_once '../config/db.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Cliente</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Bienvenido, <?= htmlspecialchars($_SESSION['usuario']) ?></h1>
    <nav>
        <a href="mis_reservas.php">Mis Reservas</a> |
        <a href="nueva_reserva.php">Hacer Nueva Reserva</a> |
        <a href="../login/logout.php">Cerrar Sesión</a>
    </nav>
</body>
</html>
