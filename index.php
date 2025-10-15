<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

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
            <p>45</p> <!-- valor de ejemplo, luego dinámico -->
        </div>
        <div class="card resumen">
            <h3>Reservas Activas</h3>
            <p>12</p>
        </div>
        <div class="card resumen">
            <h3>Reservas Pendientes</h3>
            <p>3</p>
        </div>
        <div class="card resumen">
            <h3>Alertas de Mantenimiento</h3>
            <p>2</p>
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
                <tr>
                    <td>101</td>
                    <td>Laura G.</td>
                    <td>2025-10-15</td>
                    <td>2025-10-20</td>
                    <td>Activa</td>
                </tr>
                <tr>
                    <td>203</td>
                    <td>Carlos M.</td>
                    <td>2025-10-16</td>
                    <td>2025-10-18</td>
                    <td>Pendiente</td>
                </tr>
                <tr>
                    <td>305</td>
                    <td>Sofía R.</td>
                    <td>2025-10-17</td>
                    <td>2025-10-22</td>
                    <td>Activa</td>
                </tr>
            </tbody>
        </table>
    </section>

</main>

<?php include 'includes/footer.php'; ?>
