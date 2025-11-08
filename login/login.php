<?php
ob_start();
session_start();
require_once '../config/db.php';

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($usuario) || empty($password)) {
        $errores[] = "Todos los campos son obligatorios.";
    } else {
        try {
            $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ?");
            $stmt->execute([$usuario]);
            $usuarioBD = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuarioBD && password_verify($password, $usuarioBD['password'])) {
                $_SESSION['usuario'] = $usuarioBD['usuario'];
                $_SESSION['rol'] = $usuarioBD['rol'];
                $_SESSION['id_usuario'] = $usuarioBD['id'] ?? null;

                if ($usuarioBD['rol'] === 'admin') {
                    header('Location: ../index.php');
                    exit;
                } elseif ($usuarioBD['rol'] === 'usuario') {
                    header('Location: ../cliente/index.php');
                    exit;
                } else {
                    $errores[] = "Rol de usuario no reconocido.";
                }
            } else {
                $errores[] = "Usuario o contraseña incorrectos.";
            }
        } catch (PDOException $e) {
            $errores[] = "Error en la base de datos.";
        }
    }
}

ob_end_flush();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - El Gran Descanso</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="login-body">
    <div class="login-container">
        <button id="theme-toggle" class="theme-toggle" title="Cambiar tema">🌙</button>

        <h1>Iniciar Sesión</h1>

        <?php if (!empty($errores)): ?>
            <div class="login-error">
                <ul>
                    <?php foreach ($errores as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="form-login">
            <label for="usuario">Usuario</label>
            <input type="text" name="usuario" id="usuario" class="input-login" required>

            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" class="input-login" required>

            <button type="submit" class="btn-login">Iniciar Sesión</button>
        </form>
    </div>

    <script>
        // === Script para alternar tema y guardar cookie ===
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        function setCookie(name, value, days) {
            const d = new Date();
            d.setTime(d.getTime() + (days*24*60*60*1000));
            document.cookie = `${name}=${value}; expires=${d.toUTCString()}; path=/`;
        }

        // Aplicar tema al cargar la página según cookie
        const temaGuardado = getCookie('tema');
        if (temaGuardado === 'light') {
            document.body.classList.add('light-mode');
            document.getElementById('theme-toggle').textContent = '☀️';
        }

        // Evento del botón de cambio de tema
        document.getElementById('theme-toggle').addEventListener('click', function() {
            document.body.classList.toggle('light-mode');
            const esClaro = document.body.classList.contains('light-mode');
            setCookie('tema', esClaro ? 'light' : 'dark', 30);
            this.textContent = esClaro ? '☀️' : '🌙';
        });
    </script>
</body>
</html>
