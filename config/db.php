<?php
// ==========================================
// CONEXIÓN A LA BASE DE DATOS CON PDO
// ==========================================

$host = 'localhost';
$db   = 'gestionhotelera';
$user = 'root';
$pass = ''; // o tu contraseña de MySQL
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // para ver errores PDO
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $conn = new PDO($dsn, $user, $pass, $options); // <-- esta es la variable que usa index.php
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
