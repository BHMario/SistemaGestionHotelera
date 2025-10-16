<?php
// modules/huespedes/eliminar.php
require_once '../../config/db.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $conn->prepare("DELETE FROM huespedes WHERE id_huesped = ?");
    $stmt->execute([$id]);
}

header('Location: listar.php');
exit;
