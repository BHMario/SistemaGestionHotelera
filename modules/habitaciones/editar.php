<?php
require_once '../../config/db.php';
include '../../includes/header.php';
include '../../includes/navbar.php';

// Obtener datos de la habitación
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: listar.php');
    exit;
}

$stmt = $conn->prepare("SELECT * FROM habitaciones WHERE id_habitacion = ?");
$stmt->execute([$id]);
$habitacion = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$habitacion) {
    header('Location: listar.php');
    exit;
}
?>

<div class="habitaciones-container">
    <div class="habitaciones-header">
        <h1>Editar Habitación</h1>
        <a href="listar.php" class="btn">← Volver</a>
    </div>
    <div class="habitaciones-form">
        <form action="editar.php" method="POST">
            <input type="hidden" name="id" value="<?= $habitacion['id_habitacion'] ?>">

            <label>Número</label>
            <input type="text" name="numero" value="<?= htmlspecialchars($habitacion['numero']) ?>" required>

            <label>Tipo</label>
            <select name="tipo" required>
                <option value="Sencilla" <?= $habitacion['tipo'] === 'Sencilla' ? 'selected' : '' ?>>Sencilla</option>
                <option value="Doble" <?= $habitacion['tipo'] === 'Doble' ? 'selected' : '' ?>>Doble</option>
                <option value="Suite" <?= $habitacion['tipo'] === 'Suite' ? 'selected' : '' ?>>Suite</option>
            </select>

            <label>Precio Base (€)</label>
            <input type="number" step="0.01" name="precio_base" value="<?= $habitacion['precio_base'] ?>" required>

            <button type="submit">Actualizar</button>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
