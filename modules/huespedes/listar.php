<?php
// modules/huespedes/listar.php
require_once '../../config/db.php';
include '../../includes/header.php';
include '../../includes/navbar.php';

// Consulta: traer todos los huespedes
$stmt = $conn->query("
    SELECT id_huesped, nombre, email, documento_identidad
    FROM huespedes
    ORDER BY nombre ASC
");
$huespedes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="habitaciones-container">
    <div class="habitaciones-header">
        <h1>Huéspedes</h1>
        <a href="agregar.php" class="btn">+ Nuevo Huésped</a>
    </div>

    <?php if (count($huespedes) > 0): ?>
        <table class="habitaciones-tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Documento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($huespedes as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id_huesped']) ?></td>
                        <td><?= htmlspecialchars($row['nombre']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['documento_identidad']) ?></td>
                        <td class="habitaciones-acciones">
                            <a href="editar.php?id=<?= $row['id_huesped'] ?>" class="editar btn">Editar</a>
                            <a href="eliminar.php?id=<?= $row['id_huesped'] ?>" class="eliminar btn" onclick="return confirm('¿Seguro que deseas eliminar este huésped?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align:center; color:var(--color-texto-sec)">No hay huéspedes registrados.</p>
    <?php endif; ?>
</div>

<?php include '../../includes/footer.php'; ?>
