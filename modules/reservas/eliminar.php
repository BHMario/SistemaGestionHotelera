<?php
// modules/reservas/eliminar.php
require_once '../../config/db.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $conn->prepare("DELETE FROM reservas WHERE id_reserva = ?");
    $stmt->execute([$id]);
}

header('Location: listar.php');
exit;
