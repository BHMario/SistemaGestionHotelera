-- ==========================
-- 1️. CREAR BASE DE DATOS
-- ==========================
DROP DATABASE IF EXISTS gestionHotelera;
CREATE DATABASE gestionHotelera CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE gestionHotelera;

-- ==========================
-- 2️. TABLA: estados_limpieza
-- ==========================
CREATE TABLE estados_limpieza (
    id_estado INT AUTO_INCREMENT PRIMARY KEY,
    descripcion ENUM('Limpia', 'Sucia', 'En Limpieza') NOT NULL
) ENGINE=InnoDB;

-- ==========================
-- 3️. TABLA: habitaciones
-- ==========================
CREATE TABLE habitaciones (
    id_habitacion INT AUTO_INCREMENT PRIMARY KEY,
    numero VARCHAR(10) NOT NULL UNIQUE,
    tipo ENUM('Sencilla', 'Doble', 'Suite') NOT NULL,
    precio_base DECIMAL(10,2) NOT NULL,
    id_estado_limpieza INT,
    FOREIGN KEY (id_estado_limpieza) REFERENCES estados_limpieza(id_estado)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB;

-- ==========================
-- 4️. TABLA: huespedes
-- ==========================
CREATE TABLE huespedes (
    id_huesped INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    documento_identidad VARCHAR(20) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- ==========================
-- 5️. TABLA: reservas
-- ==========================
CREATE TABLE reservas (
    id_reserva INT AUTO_INCREMENT PRIMARY KEY,
    id_huesped INT NOT NULL,
    id_habitacion INT NOT NULL,
    fecha_reserva DATE NOT NULL DEFAULT (CURRENT_DATE),
    fecha_llegada DATE NOT NULL,
    fecha_salida DATE NOT NULL,
    precio_total DECIMAL(10,2) NOT NULL,
    estado ENUM('Pendiente', 'Confirmada', 'Cancelada') DEFAULT 'Pendiente',
    FOREIGN KEY (id_huesped) REFERENCES huespedes(id_huesped)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY (id_habitacion) REFERENCES habitaciones(id_habitacion)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ==========================
-- 6️. TABLA: tareas_mantenimiento
-- ==========================
CREATE TABLE tareas_mantenimiento (
    id_tarea INT AUTO_INCREMENT PRIMARY KEY,
    id_habitacion INT NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE,
    estado ENUM('Activa', 'Finalizada') DEFAULT 'Activa',
    FOREIGN KEY (id_habitacion) REFERENCES habitaciones(id_habitacion)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ==========================
-- 7️. TABLA: usuarios
-- ==========================
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
	rol ENUM('admin','usuario') NOT NULL DEFAULT 'usuario'
);

-- ==========================
-- 8. DATOS INICIALES
-- ==========================
INSERT INTO estados_limpieza (descripcion) VALUES
('Limpia'),
('Sucia'),
('En Limpieza');

INSERT INTO habitaciones (numero, tipo, precio_base, id_estado_limpieza) VALUES
('101', 'Sencilla', 50.00, 1),
('102', 'Doble', 80.00, 1),
('201', 'Suite', 120.00, 2);

INSERT INTO huespedes (nombre, email, documento_identidad) VALUES
('Laura G.', 'laura@example.com', '12345678A'),
('Carlos M.', 'carlos@example.com', '87654321B'),
('Sofía R.', 'sofia@example.com', '11223344C');

INSERT INTO reservas (id_huesped, id_habitacion, fecha_llegada, fecha_salida, precio_total, estado) VALUES
(1, 1, '2025-10-15', '2025-10-20', 200.00, 'Confirmada'),
(2, 2, '2025-10-16', '2025-10-18', 150.00, 'Pendiente'),
(3, 3, '2025-10-17', '2025-10-22', 300.00, 'Confirmada');

INSERT INTO tareas_mantenimiento (id_habitacion, descripcion, fecha_inicio, fecha_fin, estado) VALUES
(1, 'Revisión de aire acondicionado', '2025-10-10', '2025-10-12', 'Finalizada'),
(2, 'Cambio de bombillas', '2025-10-14', NULL, 'Activa'),
(3, 'Reparación del baño', '2025-10-15', NULL, 'Activa');

-- Usuario admin
INSERT INTO usuarios (usuario, password, rol) VALUES
('admin', '$2y$10$u7pruBCoFaNhkqNzOgv7H.T4QRf3G31yaNOTCesRFWhGQ/NPFAybC', 'admin'); 

-- Usuario normal para reservas
INSERT INTO usuarios (usuario, password, rol) VALUES
('cliente1', '$2b$12$ItLFxqlfpFe6DGpPRPf/dOFxFIPV/Xx5s6H4ERP2jhZsihfQthkku', 'usuario');

-- ==========================
-- 9. VISTA OPCIONAL: habitaciones_disponibles
-- ==========================
CREATE OR REPLACE VIEW habitaciones_disponibles AS
SELECT h.*
FROM habitaciones h
LEFT JOIN tareas_mantenimiento tm
    ON h.id_habitacion = tm.id_habitacion AND tm.estado = 'Activa'
WHERE tm.id_tarea IS NULL;

-- ==========================
-- 10. TRIGGER: Validar solapamiento de reservas
-- ==========================
DELIMITER $$
CREATE TRIGGER validar_solapamiento_reserva
BEFORE INSERT ON reservas
FOR EACH ROW
BEGIN
    DECLARE conflicto INT;

    -- Verifica si la habitación ya está reservada (estado Confirmada) en el mismo rango de fechas
    SELECT COUNT(*) INTO conflicto
    FROM reservas
    WHERE id_habitacion = NEW.id_habitacion
      AND estado = 'Confirmada'
      AND (
            (NEW.fecha_llegada BETWEEN fecha_llegada AND fecha_salida)
         OR (NEW.fecha_salida BETWEEN fecha_llegada AND fecha_salida)
         OR (fecha_llegada BETWEEN NEW.fecha_llegada AND NEW.fecha_salida)
         OR (fecha_salida BETWEEN NEW.fecha_llegada AND NEW.fecha_salida)
      );

    IF conflicto > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = '❌ Error: La habitación ya está reservada en esas fechas.';
    END IF;
END$$
DELIMITER ;

-- ==========================
-- 11. TRIGGER: Impedir reservas con mantenimiento activo
-- ==========================
DELIMITER $$
CREATE TRIGGER validar_mantenimiento_activo
BEFORE INSERT ON reservas
FOR EACH ROW
BEGIN
    DECLARE mantenimiento_activo INT;

    SELECT COUNT(*) INTO mantenimiento_activo
    FROM tareas_mantenimiento
    WHERE id_habitacion = NEW.id_habitacion
      AND estado = 'Activa'
      AND (
            (NEW.fecha_llegada BETWEEN fecha_inicio AND IFNULL(fecha_fin, NEW.fecha_salida))
         OR (NEW.fecha_salida BETWEEN fecha_inicio AND IFNULL(fecha_fin, NEW.fecha_salida))
         OR (fecha_inicio BETWEEN NEW.fecha_llegada AND NEW.fecha_salida)
         OR (fecha_fin BETWEEN NEW.fecha_llegada AND NEW.fecha_salida)
      );

    IF mantenimiento_activo > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = '⚠️ Error: La habitación tiene una tarea de mantenimiento activa.';
    END IF;
END$$
DELIMITER ;
