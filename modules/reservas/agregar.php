<?php
// modules/reservas/crear.php
require_once '../../config/db.php';
include '../../includes/header.php';
include '../../includes/navbar.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_huesped = $_POST['id_huesped'];
    $id_habitacion = $_POST['id_habitacion'];
    $fecha_llegada = $_POST['fecha_llegada'];
    $fecha_salida = $_POST['fecha_salida'];
    $precio_total = $_POST['precio_total'];
    $estado = $_POST['estado'];

    $stmt = $conn->prepare("
        INSERT INTO reservas (id_huesped, id_habitacion, fecha_llegada, fecha_salida, precio_total, estado)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$id_huesped, $id_habitacion, $fecha_llegada, $fecha_salida, $precio_total, $estado]);

    header('Location: listar.php');
    exit;
}

// Datos para selects
$habitaciones = $conn->query("SELECT * FROM habitaciones")->fetchAll();
$huespedes = $conn->query("SELECT * FROM huespedes")->fetchAll();
?>

<div class="habitaciones-container">
    <div class="habitaciones-header">
        <h1>Nueva Reserva</h1>
        <a href="listar.php" class="btn">Volver</a>
    </div>

    <form method="POST" class="habitaciones-form">
        <label for="id_huesped">Huésped</label>
        <select name="id_huesped" required>
            <?php foreach ($huespedes as $huesped): ?>
                <option value="<?= $huesped['id_huesped'] ?>"><?= htmlspecialchars($huesped['nombre']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="id_habitacion">Habitación</label>
        <select name="id_habitacion" required>
            <?php foreach ($habitaciones as $hab): ?>
                <option value="<?= $hab['id_habitacion'] ?>"><?= htmlspecialchars($hab['numero']) ?> - <?= $hab['tipo'] ?></option>
            <?php endforeach; ?>
        </select>

        <label for="fecha_llegada">Fecha Llegada</label>
        <input type="date" name="fecha_llegada" required>

        <label for="fecha_salida">Fecha Salida</label>
        <input type="date" name="fecha_salida" required>

        <label for="precio_total">Precio Total</label>
        <input type="number" name="precio_total" step="0.01" required>

        <label for="estado">Estado</label>
        <select name="estado">
            <option value="Pendiente">Pendiente</option>
            <option value="Confirmada">Confirmada</option>
            <option value="Cancelada">Cancelada</option>
        </select>

        <button type="submit">Guardar Reserva</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
