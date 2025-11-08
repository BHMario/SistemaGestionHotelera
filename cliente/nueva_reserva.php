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

// Obtener habitaciones disponibles
$stmt = $conn->query("SELECT * FROM habitaciones_disponibles");
$habitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

$errores = [];
$success = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $habitacion = $_POST['habitacion'] ?? '';
    $fecha_llegada = $_POST['fecha_llegada'] ?? '';
    $fecha_salida = $_POST['fecha_salida'] ?? '';
    $precio_total = $_POST['precio_total'] ?? 0;

    if(!$habitacion || !$fecha_llegada || !$fecha_salida){
        $errores[] = "Todos los campos son obligatorios.";
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO reservas (id_huesped, id_habitacion, fecha_llegada, fecha_salida, precio_total) VALUES (?,?,?,?,?)");
            $stmt->execute([$id_huesped, $habitacion, $fecha_llegada, $fecha_salida, $precio_total]);
            $success = "✅ Reserva realizada correctamente.";
        } catch(PDOException $e){
            $errores[] = $e->getMessage();
        }
    }
}

include '../includes/header.php';
?>

<main class="container">
    <div class="habitaciones-container">
        <div class="habitaciones-header">
            <h1>Nueva Reserva</h1>
            <a href="index.php" class="btn">← Volver</a>
        </div>

        <div class="habitaciones-form">
            <?php if($errores): ?>
                <div class="login-error">
                    <ul>
                        <?php foreach($errores as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if($success): ?>
                <div style="color:#D6B86C; font-weight:600; text-align:center; margin-bottom:1rem;"><?= $success ?></div>
            <?php endif; ?>

            <form method="POST">
                <label for="habitacion">Habitación</label>
                <select name="habitacion" required>
                    <option value="">Selecciona...</option>
                    <?php foreach($habitaciones as $h): ?>
                        <option value="<?= $h['id_habitacion'] ?>"><?= $h['numero'] ?> - <?= $h['tipo'] ?> - <?= $h['precio_base'] ?>€</option>
                    <?php endforeach; ?>
                </select>

                <label for="fecha_llegada">Fecha Llegada</label>
                <input type="date" name="fecha_llegada" required>

                <label for="fecha_salida">Fecha Salida</label>
                <input type="date" name="fecha_salida" required>

                <label for="precio_total">Precio Total (€)</label>
                <input type="number" step="0.01" name="precio_total" required>

                <button type="submit">Reservar</button>
            </form>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
