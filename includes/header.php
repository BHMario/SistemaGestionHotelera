<?php
// includes/header.php - Cabecera HTML común y premium para todo el sistema
if (session_status() === PHP_SESSION_NONE) session_start();

// Calcula la ruta base del proyecto (funciona cuando includes se usan desde subcarpetas)
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])); // por ejemplo "/SistemaGestionHotelera" o "/hotel" o "/"
$basePath = $scriptDir === '/' ? '' : $scriptDir; // convierte "/" en cadena vacía

// opcional: versión para busting de caché
$assetVersion = 'v1.2'; // incrementa cuando actualices CSS/JS para forzar recarga
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>El Gran Descanso - Panel</title>
    <!-- Google Fonts para estilo premium -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS global (ruta calculada dinámicamente) -->
    <link rel="stylesheet" href="<?php 
    echo strpos($_SERVER['SCRIPT_NAME'], '/modules/') !== false ? '../../assets/css/style.css' : 'assets/css/style.css'; 
    ?>">

    <!-- Favicon (ruta calculada dinámicamente) -->
    <link rel="icon" href="<?php echo BASE_URL; ?>assets/img/favicon.ico" type="image/x-icon">
</head>
<body>
<header class="site-header">
    <div class="container header-inner">
        <!-- Marca del hotel -->
        <h2 class="brand">El Gran Descanso</h2>
        <!-- Acciones del usuario -->
        <nav class="header-actions">
            <?php if (isset($_SESSION['user'])): ?>
                <span class="user">Usuario: <?php echo htmlspecialchars($_SESSION['user']); ?></span>
                <a class="btn" href="<?= $basePath ?>/login/logout.php">Cerrar sesión</a>
            <?php else: ?>
                <a class="btn" href="<?= $basePath ?>/login/login.php">Iniciar sesión</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
