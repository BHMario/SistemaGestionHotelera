<?php
session_start();
require_once '../config/db.php';

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!$usuario || !$password) {
        $errores[] = "Todos los campos son obligatorios.";
    } else {
        // Buscar usuario en la base de datos
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $stmt->execute([$usuario]);
        $usuarioBD = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuarioBD) {
            // Verifica la contraseña
            if (password_verify($password, $usuarioBD['password'])) {
                // Guardar sesión y redirigir al dashboard
                $_SESSION['usuario'] = $usuarioBD['usuario'];
                header('Location: ../index.php');
                exit;
            } else {
                $errores[] = "Usuario o contraseña incorrectos.";
            }
        } else {
            $errores[] = "Usuario o contraseña incorrectos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - El Gran Descanso</title>
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Ajusta según tu CSS -->
</head>
<body>
    <div class="login-container">
        <h1>Iniciar Sesión</h1>

        <?php if (!empty($errores)): ?>
            <div class="errores">
                <ul>
                    <?php foreach ($errores as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <label for="usuario">Usuario</label>
            <input type="text" name="usuario" id="usuario" required><br>

            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>
