<?php
session_start();
require_once '../config/db.php';
if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'usuario') {
    header('Location: ../login/login.php');
    exit;
}

include '../includes/header.php';
include '../includes/navbar.php';

// Obtener habitaciones disponibles
$stmt = $conn->query("SELECT id_habitacion, numero, tipo FROM habitaciones WHERE estado = 'Disponible'");
$habitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Manejo del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_habitacion = $_POST['id_habitacion'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $id_usuario = $_SESSION['id_usuario'];

    $insert = $conn->prepare("INSERT INTO reservas (id_usuario, id_habitacion, fecha_inicio, fecha_fin, estado) 
                              VALUES (?, ?, ?, ?, 'Pendiente')");
    $insert->execute([$id_usuario, $id_habitacion, $fecha_inicio, $fecha_fin]);

    header('Location: mis_reservas.php');
    exit;
}
?>

<div class="container">
    <div class="header-section">
        <h1>Nueva Reserva</h1>
        <a href="index.php" class="btn">← Volver</a>
    </div>

    <form method="POST" class="formulario">
        <label>Habitación</label>
        <select name="id_habitacion" required>
            <?php foreach ($habitaciones as $hab): ?>
                <option value="<?= $hab['id_habitacion'] ?>">
                    <?= htmlspecialchars($hab['numero']) ?> - <?= htmlspecialchars($hab['tipo']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Fecha de inicio</label>
        <input type="date" name="fecha_inicio" required>

        <label>Fecha de fin</label>
        <input type="date" name="fecha_fin" required>

        <button type="submit" class="btn">Reservar</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
