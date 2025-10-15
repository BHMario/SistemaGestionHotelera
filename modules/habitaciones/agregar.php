<?php
require_once '../../config/db.php';
include '../../includes/header.php';
include '../../includes/navbar.php';

// obtener estados de limpieza para select
$estados = $conn->query("SELECT * FROM estados_limpieza")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = $_POST['numero'] ?? '';
    $tipo = $_POST['tipo'] ?? '';
    $precio = $_POST['precio_base'] ?? 0;
    $estado = !empty($_POST['estado']) ? $_POST['estado'] : null;

    $stmt = $conn->prepare("INSERT INTO habitaciones (numero, tipo, precio_base, id_estado_limpieza) VALUES (:numero, :tipo, :precio, :estado)");
    $stmt->execute([
        ':numero' => $numero,
        ':tipo'   => $tipo,
        ':precio' => $precio,
        ':estado' => $estado
    ]);

    header('Location: listar.php');
    exit;
}
?>

<div class="habitaciones-form">
    <h1>Agregar Habitación</h1>
    <form method="POST">
        <label>Número:</label>
        <input type="text" name="numero" required>

        <label>Tipo:</label>
        <select name="tipo" required>
            <option value="Sencilla">Sencilla</option>
            <option value="Doble">Doble</option>
            <option value="Suite">Suite</option>
        </select>

        <label>Precio base (€):</label>
        <input type="number" step="0.01" name="precio_base" required>

        <label>Estado de limpieza:</label>
        <select name="estado">
            <option value="">-- Sin asignar --</option>
            <?php foreach($estados as $e): ?>
                <option value="<?= $e['id_estado'] ?>"><?= htmlspecialchars($e['descripcion']) ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Guardar</button>
    </form>
</div>

<?php include '../../includes/footer.php'; ?>
