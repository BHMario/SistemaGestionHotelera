<?php
session_start();
require_once '../config/db.php';
if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'usuario') {
    header('Location: ../login/login.php');
    exit;
}

include '../includes/header.php';
include '../includes/navbar.php';

// Obtener reservas del usuario actual
$stmt = $conn->prepare("SELECT r.id_reserva, h.numero, h.tipo, r.fecha_inicio, r.fecha_fin, r.estado 
                        FROM reservas r
                        JOIN habitaciones h ON r.id_habitacion = h.id_habitacion
                        JOIN usuarios u ON r.id_usuario = u.id_usuario
                        WHERE u.usuario = ?");
$stmt->execute([$_SESSION['usuario']]);
$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <div class="header-section">
        <h1>Mis Reservas</h1>
        <a href="index.php" class="btn">← Volver</a>
    </div>

    <?php if (count($reservas) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Habitación</th>
                    <th>Tipo</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservas as $reserva): ?>
                    <tr>
                        <td><?= htmlspecialchars($reserva['id_reserva']) ?></td>
                        <td><?= htmlspecialchars($reserva['numero']) ?></td>
                        <td><?= htmlspecialchars($reserva['tipo']) ?></td>
                        <td><?= htmlspecialchars($reserva['fecha_inicio']) ?></td>
                        <td><?= htmlspecialchars($reserva['fecha_fin']) ?></td>
                        <td><?= htmlspecialchars($reserva['estado']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No tienes reservas registradas todavía.</p>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
