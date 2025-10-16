<?php
// modules/huespedes/editar.php
require_once '../../config/db.php';
include '../../includes/header.php';
include '../../includes/navbar.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: listar.php');
    exit;
}

// Obtener datos existentes
$stmt = $conn->prepare("SELECT * FROM huespedes WHERE id_huesped = ?");
$stmt->execute([$id]);
$huesped = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$huesped) {
    header('Location: listar.php');
    exit;
}

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $documento = $_POST['documento'] ?? '';

    if (!$nombre) $errores[] = "El nombre es obligatorio.";
    if (!$email) $errores[] = "El email es obligatorio.";
    if (!$documento) $errores[] = "El documento de identidad es obligatorio.";

    if (empty($errores)) {
        $stmt = $conn->prepare("UPDATE huespedes SET nombre=?, email=?, documento_identidad=? WHERE id_huesped=?");
        $stmt->execute([$nombre, $email, $documento, $id]);
        header('Location: listar.php');
        exit;
    }
}
?>

<div class="habitaciones-container">
    <div class="habitaciones-header">
        <h1>Editar Huésped</h1>
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
            <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($huesped['nombre']) ?>" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($huesped['email']) ?>" required>

            <label for="documento">Documento de Identidad</label>
            <input type="text" name="documento" id="documento" value="<?= htmlspecialchars($huesped['documento_identidad']) ?>" required>

            <button type="submit">Guardar Cambios</button>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
