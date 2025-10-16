<?php
// modules/huespedes/crear.php
require_once '../../config/db.php';
include '../../includes/header.php';
include '../../includes/navbar.php';

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $documento = $_POST['documento'] ?? '';

    if (!$nombre) $errores[] = "El nombre es obligatorio.";
    if (!$email) $errores[] = "El email es obligatorio.";
    if (!$documento) $errores[] = "El documento de identidad es obligatorio.";

    if (empty($errores)) {
        $stmt = $conn->prepare("INSERT INTO huespedes (nombre, email, documento_identidad) VALUES (?, ?, ?)");
        $stmt->execute([$nombre, $email, $documento]);
        header('Location: listar.php');
        exit;
    }
}
?>

<div class="habitaciones-container">
    <div class="habitaciones-header">
        <h1>Nuevo Huésped</h1>
        <a href="listar.php" class="btn">Volver</a>
    </div>

    <div class="habitaciones-form">
        <?php if (!empty($errores)): ?>
            <ul style="color: red; margin-bottom:1rem;">
                <?php foreach ($errores as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form action="" method="post">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="documento">Documento de Identidad</label>
            <input type="text" name="documento" id="documento" required>

            <button type="submit">Guardar</button>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
