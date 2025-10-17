<?php
require_once '../../config/db.php';
include '../../includes/header.php';
include '../../includes/navbar.php';
?>

<div class="habitaciones-container">
    <div class="habitaciones-header">
        <h1>Nueva Habitación</h1>
        <a href="listar.php" class="btn">← Volver</a>
    </div>
    <div class="habitaciones-form">
        <form action="insertar.php" method="POST">
            <label>Número</label>
            <input type="text" name="numero" required>

            <label>Tipo</label>
            <select name="tipo" required>
                <option value="Sencilla">Sencilla</option>
                <option value="Doble">Doble</option>
                <option value="Suite">Suite</option>
            </select>

            <label>Precio Base (€)</label>
            <input type="number" step="0.01" name="precio_base" required>

            <button type="submit">Agregar</button>
        </form>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
