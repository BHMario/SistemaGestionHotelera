<?php
// modules/reservas/editar.php
require_once '../../config/db.php';
include '../../includes/header.php';
include '../../includes/navbar.php';

$id = $_GET['id'];
$reserva = $conn->query("SELECT * FROM reservas WHERE id_reserva = $id")->fetch();
$habitaciones = $conn->query("SELECT * FROM habitaciones")->fetchAll();
$huespedes = $conn->query("SELECT * FROM huespedes")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_huesped = $_POST['id_huesped'];
    $id_habitacion = $_POST['id_habitacion'];
    $fecha_llegada = $_POST['fecha_llegada'];
    $fecha_salida = $_POST['fecha_salida'];
    $precio_total = $_POST['precio_total'];
    $estado = $_POST['estado'];

    $stmt = $conn->prepare("
        UPDATE reservas
        SET id_huesped = ?, id_habitacion = ?, fecha_llegada = ?, fecha_salida = ?, precio_total = ?, estado = ?
        WHERE id_reserva = ?
    ");
    $stmt->execute([$id_huesped, $id_habitacion, $fecha_llegada, $fecha_salida, $precio_total, $estado, $id]);

    header('Location: listar.php');
    exit;
}
?>

<div class="habitaciones-container">
    <div class="habitaciones-header">
        <h1>Editar Reserva</h1>
    </div>

    <form method="POST" class="habitaciones-form">
        <label for="id_huesped">Huésped</label>
        <select name="id_huesped" required>
            <?php foreach ($huespedes as $huesped): ?>
                <option value="<?= $huesped['id_huesped'] ?>" <?= $reserva['id_huesped'] == $huesped['id_huesped'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($huesped['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="id_habitacion">Habitación</label>
        <select name="id_habitacion" required>
            <?php foreach ($habitaciones as $hab): ?>
                <option value="<?= $hab['id_habitacion'] ?>" <?= $reserva['id_habitacion'] == $hab['id_habitacion'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($hab['numero']) ?> - <?= $hab['tipo'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="fecha_llegada">Fecha Llegada</label>
        <input type="date" name="fecha_llegada" value="<?= $reserva['fecha_llegada'] ?>" required>

        <label for="fecha_salida">Fecha Salida</label>
        <input type="date" name="fecha_salida" value="<?= $reserva['fecha_salida'] ?>" required>

        <label for="precio_total">Precio Total</label>
        <input type="number" name="precio_total" value="<?= $reserva['precio_total'] ?>" step="0.01" required>

        <label for="estado">Estado</label>
        <select name="estado">
            <option value="Pendiente" <?= $reserva['estado'] == 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
            <option value="Confirmada" <?= $reserva['estado'] == 'Confirmada' ? 'selected' : '' ?>>Confirmada</option>
            <option value="Cancelada" <?= $reserva['estado'] == 'Cancelada' ? 'selected' : '' ?>>Cancelada</option>
        </select>

        <button type="submit">Actualizar Reserva</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
