<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Ruta base absoluta del proyecto
$basePath = ''; // si tu proyecto está en la raíz del servidor
$assetVersion = 'v1.2';
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>El Gran Descanso - Panel</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS global -->
    <link rel="stylesheet" href="<?= $basePath ?>/assets/css/style.css?v=<?= $assetVersion ?>">

    <!-- Favicon -->
    <link rel="icon" href="<?= $basePath ?>/assets/img/favicon.ico" type="image/x-icon">
</head>
<body>
<header class="site-header">
    <div class="container header-inner">
        <h2 class="brand">El Gran Descanso</h2>
        <!-- Acciones del usuario -->
        <nav class="header-actions">
            <?php if (isset($_SESSION['usuario'])): ?>
                <span class="user">Usuario: <?= htmlspecialchars($_SESSION['usuario']) ?></span>
                <a class="btn" href="<?= $basePath ?>/login/logout.php">Cerrar sesión</a>
            <?php else: ?>
                <a class="btn" href="<?= $basePath ?>/login/login.php">Iniciar sesión</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
