<?php
require_once '../../config/db.php';
include '../../includes/header.php';
include '../../includes/navbar.php';

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: listar.php'); exit; }

// obtener habitación
$stmt = $conn->prepare("SELECT * FROM habitaciones WHERE id_habitacion = :id");
$stmt->execute([':id' => $id]);
$hab = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$hab) { header('Location: listar.php'); exit; }

// estados
$estados = $conn->query("SELECT * FROM estados_limpieza")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = $_POST['numero'] ?? '';
    $tipo = $_POST['tipo'] ?? '';
    $precio = $_POST['precio_base'] ?? 0;
    $estado = !empty($_POST['estado']) ? $_POST['estado'] : null;

    $update = $conn->prepare("UPDATE habitaciones SET numero=:numero, tipo=:tipo, precio_base=:precio, id_estado_limpieza=:estado WHERE id_habitacion=:id");
    $update->execute([
        ':numero' => $numero,
        ':tipo'   => $tipo,
        ':precio' => $precio,
        ':estado' => $estado,
        ':id'     => $id
    ]);

    header('Location: listar.php');
    exit;
}
?>

<div class="habitaciones-form">
    <h1>Editar Habitación</h1>
    <form method="POST">
        <label>Número:</label>
        <input type="text" name="numero" value="<?= htmlspecialchars($hab['numero']) ?>" required>

        <label>Tipo:</label>
        <select name="tipo" required>
            <option value="Sencilla" <?= $hab['tipo']=='Sencilla'?'selected':'' ?>>Sencilla</option>
            <option value="Doble" <?= $hab['tipo']=='Doble'?'selected':'' ?>>Doble</option>
            <option value="Suite" <?= $hab['tipo']=='Suite'?'selected':'' ?>>Suite</option>
        </select>

        <label>Precio base (€):</label>
        <input type="number" step="0.01" name="precio_base" value="<?= htmlspecialchars($hab['precio_base']) ?>" required>

        <label>Estado de limpieza:</label>
        <select name="estado">
            <option value="">-- Sin asignar --</option>
            <?php foreach($estados as $e): ?>
                <option value="<?= $e['id_estado'] ?>" <?= ($hab['id_estado_limpieza']==$e['id_estado'])?'selected':'' ?>>
                    <?= htmlspecialchars($e['descripcion']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Actualizar</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
