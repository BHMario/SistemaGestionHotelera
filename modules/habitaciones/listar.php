<?php
// listar.php - módulo habitaciones (PDO)
require_once '../../config/db.php';
include '../../includes/header.php';
include '../../includes/navbar.php';

// Consulta: traer habitaciones con su estado de limpieza (si existe)
$stmt = $conn->query("
    SELECT 
        h.id_habitacion,
        h.numero,
        h.tipo,
        h.precio_base,
        e.descripcion AS estado_limpieza
    FROM habitaciones h
    LEFT JOIN estados_limpieza e ON h.id_estado_limpieza = e.id_estado
    ORDER BY CAST(h.numero AS UNSIGNED) ASC, h.numero ASC
");
$habitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="habitaciones-container">
    <div class="habitaciones-header">
        <h1>Gestión de <span class="resaltado">Habitaciones</span></h1>
        <a href="agregar.php" class="btn">+ Nueva Habitación</a>
    </div>

    <?php if (count($habitaciones) > 0): ?>
        <table class="habitaciones-tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Número</th>
                    <th>Tipo</th>
                    <th>Precio base (€)</th>
                    <th>Estado limpieza</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($habitaciones as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id_habitacion']) ?></td>
                        <td><?= htmlspecialchars($row['numero']) ?></td>
                        <td><?= htmlspecialchars($row['tipo']) ?></td>
                        <td><?= number_format($row['precio_base'], 2) ?></td>
                        <td><?= htmlspecialchars($row['estado_limpieza'] ?? 'Sin asignar') ?></td>
                        <td class="habitaciones-acciones">
                            <a href="editar.php?id=<?= $row['id_habitacion'] ?>" class="editar btn">Editar</a>
                            <a href="eliminar.php?id=<?= $row['id_habitacion'] ?>" class="eliminar btn" onclick="return confirm('¿Seguro que deseas eliminar esta habitación?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align:center; color:var(--color-texto-sec)">No hay habitaciones registradas.</p>
    <?php endif; ?>
</div>

<?php include '../../includes/footer.php'; ?>
