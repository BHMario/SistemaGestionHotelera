<?php
session_start();
if(!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'usuario'){
    header('Location: ../login/login.php');
    exit;
}

include '../includes/header.php';
?>

<main class="container">
    <div class="dashboard-modulos" style="justify-content:center;">
        <a href="mis_reservas.php" class="card acceso">
            <h3>Mis Reservas</h3>
            <p>Consulta tus reservas pasadas y actuales.</p>
        </a>
        <a href="nueva_reserva.php" class="card acceso">
            <h3>Nueva Reserva</h3>
            <p>Realiza una nueva reserva de habitación.</p>
        </a>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
