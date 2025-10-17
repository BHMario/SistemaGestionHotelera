<?php
// modules/mantenimiento/listar.php
require_once '../../config/db.php';
include '../../includes/header.php';
include '../../includes/navbar.php';

// Consulta: traer tareas con habitación asociada
$stmt = $conn->query("
    SELECT tm.id_tarea, h.numero AS habitacion, tm.descripcion, tm.fecha_inicio, tm.fecha_fin, tm.estado
    FROM tareas_mantenimiento tm
    INNER JOIN habitaciones h ON tm.id_habitacion = h.id_habitacion
    ORDER BY tm.fecha_inicio DESC
");
$tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="habitaciones-container">
    <div class="habitaciones-header">
        <h1>Tareas de Mantenimiento</h1>
        <a href="agregar.php" class="btn">+ Nueva Tarea</a>
    </div>

    <table class="habitaciones-tabla">
        <thead>
            <tr>
                <th>ID</th>
                <th>Habitación</th>
                <th>Descripción</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($tareas)): ?>
                <?php foreach ($tareas as $tarea): ?>
                    <tr>
                        <td><?= htmlspecialchars($tarea['id_tarea']) ?></td>
                        <td><?= htmlspecialchars($tarea['habitacion']) ?></td>
                        <td><?= htmlspecialchars($tarea['descripcion']) ?></td>
                        <td><?= htmlspecialchars($tarea['fecha_inicio']) ?></td>
                        <td><?= htmlspecialchars($tarea['fecha_fin'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($tarea['estado']) ?></td>
                        <td class="habitaciones-acciones">
                            <a href="editar.php?id=<?= $tarea['id_tarea'] ?>" class="editar btn">Editar</a>
                            <a href="eliminar.php?id=<?= $tarea['id_tarea'] ?>" class="eliminar btn" onclick="return confirm('¿Seguro que deseas eliminar esta tarea?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align:center;">No hay tareas registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../../includes/footer.php'; ?>
