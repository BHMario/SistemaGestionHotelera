<?php
require_once '../../config/db.php';
include '../../includes/header.php';
include '../../includes/navbar.php';

// Obtener datos de la reserva
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: listar.php');
    exit;
}

$stmt = $conn->prepare("SELECT * FROM reservas WHERE id_reserva = ?");
$stmt->execute([$id]);
$reserva = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reserva) {
    header('Location: listar.php');
    exit;
}

// Obtener habitaciones y huéspedes para el select
$habitaciones = $conn->query("SELECT id_habitacion, numero FROM habitaciones ORDER BY numero ASC")->fetchAll();
$huespedes = $conn->query("SELECT id_huesped, nombre FROM huespedes ORDER BY nombre ASC")->fetchAll();
?>

<div class="habitaciones-container">
    <div class="habitaciones-header">
        <h1>Editar Reserva</h1>
        <a href="listar.php" class="btn">← Volver</a>
    </div>
    <div class="habitaciones-form">
        <form action="editar.php" method="POST">
            <input type="hidden" name="id_reserva" value="<?= $reserva['id_reserva'] ?>">

            <label>Huésped</label>
            <select name="id_huesped" required>
                <?php foreach ($huespedes as $huesped): ?>
                    <option value="<?= $huesped['id_huesped'] ?>" <?= $huesped['id_huesped'] == $reserva['id_huesped'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($huesped['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Habitación</label>
            <select name="id_habitacion" required>
                <?php foreach ($habitaciones as $hab): ?>
                    <option value="<?= $hab['id_habitacion'] ?>" <?= $hab['id_habitacion'] == $reserva['id_habitacion'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($hab['numero']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Fecha Llegada</label>
            <input type="date" name="fecha_llegada" value="<?= $reserva['fecha_llegada'] ?>" required>

            <label>Fecha Salida</label>
            <input type="date" name="fecha_salida" value="<?= $reserva['fecha_salida'] ?>" required>

            <label>Precio Total (€)</label>
            <input type="number" step="0.01" name="precio_total" value="<?= $reserva['precio_total'] ?>" required>

            <label>Estado</label>
            <select name="estado" required>
                <option value="Pendiente" <?= $reserva['estado'] === 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                <option value="Confirmada" <?= $reserva['estado'] === 'Confirmada' ? 'selected' : '' ?>>Confirmada</option>
                <option value="Cancelada" <?= $reserva['estado'] === 'Cancelada' ? 'selected' : '' ?>>Cancelada</option>
            </select>

            <button type="submit">Actualizar</button>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
