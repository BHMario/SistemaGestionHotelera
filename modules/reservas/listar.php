<?php
// listar.php - módulo reservas (PDO)
require_once '../../config/db.php';
include '../../includes/header.php';
include '../../includes/navbar.php';

// Consulta de reservas
$stmt = $conn->query("
    SELECT r.id_reserva, h.numero AS habitacion, hu.nombre AS cliente,
           r.fecha_llegada, r.fecha_salida, r.estado, r.precio_total
    FROM reservas r
    INNER JOIN habitaciones h ON r.id_habitacion = h.id_habitacion
    INNER JOIN huespedes hu ON r.id_huesped = hu.id_huesped
    ORDER BY r.id_reserva ASC
");
$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="habitaciones-container">
    <div class="habitaciones-header">
        <h1>Gestión de <span class="resaltado">Reservas</span></h1>
        <a href="agregar.php" class="btn">+ Nueva Reserva</a>
    </div>

    <?php if (!empty($reservas)): ?>
        <table class="habitaciones-tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Huésped</th>
                    <th>Habitación</th>
                    <th>Fecha Llegada</th>
                    <th>Fecha Salida</th>
                    <th>Precio Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservas as $reserva): ?>
                    <tr>
                        <td><?= htmlspecialchars($reserva['id_reserva']) ?></td>
                        <td><?= htmlspecialchars($reserva['cliente']) ?></td>
                        <td><?= htmlspecialchars($reserva['habitacion']) ?></td>
                        <td><?= htmlspecialchars($reserva['fecha_llegada']) ?></td>
                        <td><?= htmlspecialchars($reserva['fecha_salida']) ?></td>
                        <td><?= number_format($reserva['precio_total'], 2) ?> €</td>
                        <td><?= htmlspecialchars($reserva['estado']) ?></td>
                        <td class="habitaciones-acciones">
                            <a href="editar.php?id=<?= $reserva['id_reserva'] ?>" class="editar btn">Editar</a>
                            <a href="eliminar.php?id=<?= $reserva['id_reserva'] ?>" class="eliminar btn" onclick="return confirm('¿Seguro que deseas eliminar esta reserva?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align:center; color:var(--color-texto-sec)">No hay reservas registradas.</p>
    <?php endif; ?>
</div>

<?php include '../../includes/footer.php'; ?>
