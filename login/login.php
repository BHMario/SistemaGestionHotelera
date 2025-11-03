<?php
ob_start(); // Evita problemas de encabezados
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
            // Buscar usuario en la base de datos
            $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ?");
            $stmt->execute([$usuario]);
            $usuarioBD = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuarioBD && password_verify($password, $usuarioBD['password'])) {
                // Guardar sesión con datos importantes
                $_SESSION['usuario'] = $usuarioBD['usuario'];
                $_SESSION['rol'] = $usuarioBD['rol'];

                echo "*********************" . $usuarioBD['rol'];

                // Redirigir según el rol
                if ($usuarioBD['rol'] === 'admin') {
                    header('Location: ../index.php');
                    exit;
                } elseif ($usuarioBD['rol'] === 'usuario') {
                    header('Location: ../cliente/index.php');
                    exit;
                } else {
                    $errores[] = "Rol de usuario no válido. Contacte con el administrador.";
                }
            } else {
                $errores[] = "Usuario o contraseña incorrectos.";
            }
        } catch (PDOException $e) {
            $errores[] = "Error de conexión: " . $e->getMessage();
        }
    }
}

ob_end_flush(); // Envía todo el contenido acumulado
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
</body>
</html>
