<?php
// modules/mantenimiento/editar.php
require_once '../../config/db.php';
include '../../includes/header.php';
include '../../includes/navbar.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: listar.php');
    exit;
}

// Obtener datos existentes
$stmt = $conn->prepare("SELECT * FROM tareas_mantenimiento WHERE id_tarea = ?");
$stmt->execute([$id]);
$tarea = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$tarea) {
    header('Location: listar.php');
    exit;
}

// Obtener habitaciones
$habitacionesStmt = $conn->query("SELECT id_habitacion, numero FROM habitaciones ORDER BY CAST(numero AS UNSIGNED), numero");
$habitaciones = $habitacionesStmt->fetchAll(PDO::FETCH_ASSOC);

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_habitacion = $_POST['id_habitacion'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $fecha_inicio = $_POST['fecha_inicio'] ?? '';
    $fecha_fin = $_POST['fecha_fin'] ?? '';
    $estado = $_POST['estado'] ?? 'Activa';

    if (!$id_habitacion) $errores[] = "Debe seleccionar una habitación.";
    if (!$descripcion) $errores[] = "La descripción es obligatoria.";
    if (!$fecha_inicio) $errores[] = "La fecha de inicio es obligatoria.";

    if (empty($errores)) {
        $stmt = $conn->prepare("UPDATE tareas_mantenimiento SET id_habitacion=?, descripcion=?, fecha_inicio=?, fecha_fin=?, estado=? WHERE id_tarea=?");
        $stmt->execute([$id_habitacion, $descripcion, $fecha_inicio, $fecha_fin ?: null, $estado, $id]);
        header('Location: listar.php');
        exit;
    }
}
?>

<div class="habitaciones-container">
    <div class="habitaciones-header">
        <h1>Editar Tarea de Mantenimiento</h1>
        <a href="listar.php" class="btn">Volver</a>
    </div>

    <div class="habitaciones-form">
        <?php if (!empty($errores)): ?>
            <ul style="color: red; margin-bottom:1rem;">
                <?php foreach ($errores as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form action="" method="post">
            <label for="id_habitacion">Habitación</label>
            <select name="id_habitacion" id="id_habitacion" required>
                <option value="">Selecciona una habitación</option>
                <?php foreach ($habitaciones as $hab): ?>
                    <option value="<?= $hab['id_habitacion'] ?>" <?= $hab['id_habitacion']==$tarea['id_habitacion'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($hab['numero']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" required><?= htmlspecialchars($tarea['descripcion']) ?></textarea>

            <label for="fecha_inicio">Fecha Inicio</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" value="<?= htmlspecialchars($tarea['fecha_inicio']) ?>" required>

            <label for="fecha_fin">Fecha Fin</label>
            <input type="date" name="fecha_fin" id="fecha_fin" value="<?= htmlspecialchars($tarea['fecha_fin']) ?>">

            <label for="estado">Estado</label>
            <select name="estado" id="estado">
                <option value="Activa" <?= $tarea['estado']=='Activa' ? 'selected' : '' ?>>Activa</option>
                <option value="Finalizada" <?= $tarea['estado']=='Finalizada' ? 'selected' : '' ?>>Finalizada</option>
            </select>

            <button type="submit">Guardar Cambios</button>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
