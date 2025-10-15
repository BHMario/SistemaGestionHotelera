<?php
// ==========================================
// INCLUDES Y CONEXIÓN A LA BASE DE DATOS
// ==========================================
include 'includes/header.php';
include 'includes/navbar.php';
include 'config/db.php'; // conexión PDO

// ==========================================
// CONSULTAS PARA EL DASHBOARD
// ==========================================

// Total habitaciones
$stmt = $conn->query("SELECT COUNT(*) AS total FROM habitaciones");
$totalHabitaciones = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Reservas activas
$stmt = $conn->query("SELECT COUNT(*) AS total FROM reservas WHERE estado='Confirmada'");
$reservasActivas = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Reservas pendientes
$stmt = $conn->query("SELECT COUNT(*) AS total FROM reservas WHERE estado='Pendiente'");
$reservasPendientes = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Alertas de mantenimiento
$stmt = $conn->query("SELECT COUNT(*) AS total FROM tareas_mantenimiento WHERE estado='Activa'");
$alertasMantenimiento = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Reservas recientes (últimas 5)
$tablaReservas = $conn->query("
    SELECT r.id_habitacion, h.nombre AS cliente, r.fecha_llegada AS fecha_entrada, r.fecha_salida, r.estado 
    FROM reservas r 
    JOIN huespedes h ON r.id_huesped = h.id_huesped
    ORDER BY r.fecha_llegada DESC 
    LIMIT 5
");
?>

<main class="dashboard container">

    <!-- =========================================
         TÍTULO PRINCIPAL
         ========================================= -->
    <section class="dashboard-header">
        <h1>Panel de Gestión <span class="resaltado">Hotel Aurea</span></h1>
        <p>Resumen rápido de la actividad del hotel</p>
    </section>

    <!-- =========================================
         TARJETAS DE RESUMEN
         ========================================= -->
    <section class="dashboard-resumen cards">
        <div class="card resumen">
            <h3>Total Habitaciones</h3>
            <p><?= $totalHabitaciones ?></p>
        </div>
        <div class="card resumen">
            <h3>Reservas Activas</h3>
            <p><?= $reservasActivas ?></p>
        </div>
        <div class="card resumen">
            <h3>Reservas Pendientes</h3>
            <p><?= $reservasPendientes ?></p>
        </div>
        <div class="card resumen">
            <h3>Alertas de Mantenimiento</h3>
            <p><?= $alertasMantenimiento ?></p>
        </div>
    </section>

    <!-- =========================================
         ACCESOS RÁPIDOS A MÓDULOS
         ========================================= -->
    <section class="dashboard-modulos cards">
        <a href="modules/habitaciones/listar.php" class="card acceso">
            <h3>Habitaciones</h3>
            <p>Ver y gestionar habitaciones</p>
        </a>
        <a href="modules/reservas/listar.php" class="card acceso">
            <h3>Reservas</h3>
            <p>Ver y gestionar reservas</p>
        </a>
        <a href="modules/mantenimiento/listar.php" class="card acceso">
            <h3>Mantenimiento</h3>
            <p>Revisar alertas y tareas</p>
        </a>
        <a href="modules/clientes/listar.php" class="card acceso">
            <h3>Clientes</h3>
            <p>Administrar información de clientes</p>
        </a>
    </section>

    <!-- =========================================
         TABLA DE RESERVAS RECIENTES
         ========================================= -->
    <section class="dashboard-tabla">
        <h2>Reservas Recientes</h2>
        <table>
            <thead>
                <tr>
                    <th>Habitación</th>
                    <th>Cliente</th>
                    <th>Fecha Entrada</th>
                    <th>Fecha Salida</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php while($reserva = $tablaReservas->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?= $reserva['id_habitacion'] ?></td>
                    <td><?= $reserva['cliente'] ?></td>
                    <td><?= $reserva['fecha_entrada'] ?></td>
                    <td><?= $reserva['fecha_salida'] ?></td>
                    <td><?= $reserva['estado'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>

</main>

<?php include 'includes/footer.php'; ?>
