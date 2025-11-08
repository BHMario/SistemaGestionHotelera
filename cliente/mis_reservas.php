<?php
session_start();
if(!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'usuario'){
    header('Location: ../login/login.php');
    exit;
}

require_once '../config/db.php';

// Obtener id_huesped según el usuario
$stmt = $conn->prepare("SELECT id_huesped FROM huespedes h 
                        JOIN usuarios u ON u.usuario = ? 
                        WHERE h.email = CONCAT(u.usuario, '@example.com')");
$stmt->execute([$_SESSION['usuario']]);
$id_huesped = $stmt->fetchColumn();

// Consultar reservas del cliente
$stmt = $conn->prepare("
    SELECT r.*, h.numero AS habitacion_num, h.tipo AS habitacion_tipo
    FROM reservas r
    JOIN habitaciones h ON r.id_habitacion = h.id_habitacion
    WHERE r.id_huesped = ?
    ORDER BY r.fecha_reserva DESC
");
$stmt->execute([$id_huesped]);
$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Incluir header unificado (contiene <html>, <head>, <body> y header visual)
include '../includes/header.php';
?>

<main class="container">
    <div class="habitaciones-container">
        <div class="habitaciones-header">
            <h1>Mis Reservas</h1>
            <a href="index.php" class="btn">← Volver</a>
        </div>
        
        <div class="dashboard-tabla">
            <h2>Mis Reservas</h2>
            <table>
                <thead>
                    <tr>
                        <th>Habitación</th>
                        <th>Tipo</th>
                        <th>Fecha Reserva</th>
                        <th>Fecha Llegada</th>
                        <th>Fecha Salida</th>
                        <th>Precio Total</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($reservas): ?>
                        <?php foreach($reservas as $r): ?>
                            <tr>
                                <td><?= htmlspecialchars($r['habitacion_num']) ?></td>
                                <td><?= htmlspecialchars($r['habitacion_tipo']) ?></td>
                                <td><?= htmlspecialchars($r['fecha_reserva']) ?></td>
                                <td><?= htmlspecialchars($r['fecha_llegada']) ?></td>
                                <td><?= htmlspecialchars($r['fecha_salida']) ?></td>
                                <td><?= htmlspecialchars($r['precio_total']) ?> €</td>
                                <td><?= htmlspecialchars($r['estado']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" style="text-align:center;">No tienes reservas.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
