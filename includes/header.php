<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Ruta base del proyecto (ajústala si no está en raíz)
$basePath = '';
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
            <button id="theme-toggle" class="btn" title="Cambiar tema">🌙</button>

            <?php if (isset($_SESSION['usuario'])): ?>
                <span class="user">Usuario: <?= htmlspecialchars($_SESSION['usuario']) ?></span>
                <a class="btn" href="<?= $basePath ?>/login/logout.php">Cerrar sesión</a>
            <?php else: ?>
                <a class="btn" href="<?= $basePath ?>/login/login.php">Iniciar sesión</a>
            <?php endif; ?>
        </nav>
    </div>
</header> 

<script>
// Función para leer cookies
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}

// Función para establecer cookies (30 días)
function setCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + (days*24*60*60*1000));
    document.cookie = `${name}=${value}; expires=${d.toUTCString()}; path=/`;
}

// Aplicar tema según cookie
const temaGuardado = getCookie('tema');
if (temaGuardado === 'light') {
    document.body.classList.add('light-mode');
    document.getElementById('theme-toggle').textContent = '☀️';
}

// Evento del botón
document.getElementById('theme-toggle').addEventListener('click', function() {
    document.body.classList.toggle('light-mode');
    const esClaro = document.body.classList.contains('light-mode');
    setCookie('tema', esClaro ? 'light' : 'dark', 30);
    this.textContent = esClaro ? '☀️' : '🌙';
});
</script>
