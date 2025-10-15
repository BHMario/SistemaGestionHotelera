<?php
require_once '../../config/db.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $conn->prepare("DELETE FROM habitaciones WHERE id_habitacion = :id");
    $stmt->execute([':id' => $id]);
}

header('Location: listar.php');
exit;
