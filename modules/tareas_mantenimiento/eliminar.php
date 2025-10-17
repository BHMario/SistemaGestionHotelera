<?php
// modules/mantenimiento/eliminar.php
require_once '../../config/db.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $conn->prepare("DELETE FROM tareas_mantenimiento WHERE id_tarea = ?");
    $stmt->execute([$id]);
}

header('Location: listar.php');
exit;
