# 🏨 Sistema de Gestión Hotelera - *El Gran Descanso*

Este proyecto es un **sistema completo de gestión hotelera** desarrollado en **PHP** con una base de datos **MySQL**, que permite administrar de forma centralizada las habitaciones, reservas, huéspedes y tareas de mantenimiento de un hotel.  
Está diseñado con un **panel de control moderno, responsive y oscuro**, con una interfaz clara y consistente.

---

## 🚀 Características Principales

- **Inicio de sesión seguro** con contraseñas cifradas.
- **Panel principal (Dashboard)** con resumen visual de:
  - Total de habitaciones
  - Reservas activas y pendientes
  - Alertas de mantenimiento
- **Módulos independientes** para cada área:
  - 🛏️ Habitaciones
  - 📅 Reservas
  - 👤 Huéspedes
  - 🧰 Tareas de mantenimiento
- **CRUD completo (Crear, Leer, Actualizar, Eliminar)** en todos los módulos.
- **Interfaz moderna y adaptativa**, diseñada con CSS puro.
- **Control de sesión:** acceso al sistema restringido solo a usuarios autenticados.

---

## 🧩 Estructura del Proyecto

```
SistemaGestionHotelera/
│
├── assets/
│   └── css/
│       └── style.css
│
├── config/
│   └── db.php
│
├── includes/
│   ├── header.php
│   ├── navbar.php
│   └── footer.php
│
├── login/
│   ├── login.php
│   └── logout.php
│
├── modules/
│   ├── habitaciones/
│   │   ├── listar.php
│   │   ├── agregar.php
│   │   ├── editar.php
│   │   └── eliminar.php
│   │
│   ├── reservas/
│   │   ├── listar.php
│   │   ├── agregar.php
│   │   ├── editar.php
│   │   └── eliminar.php
│   │
│   ├── huespedes/
│   │   ├── listar.php
│   │   ├── agregar.php
│   │   ├── editar.php
│   │   └── eliminar.php
│   │
│   └── tareas_mantenimiento/
│       ├── listar.php
│       ├── agregar.php
│       ├── editar.php
│       └── eliminar.php
│
├── index.php
└── README.md
```

---

## 🗃️ Base de Datos

El sistema utiliza **MySQL**.  
Puedes importar el script `hotel_db.sql` que crea todas las tablas necesarias:

### Tablas principales:
- `usuarios`
- `habitaciones`
- `reservas`
- `huespedes`
- `tareas_mantenimiento`

### ⚙️ Configuración de conexión
Edita el archivo `/config/db.php` con tus credenciales:
```php
$host = 'localhost';
$dbname = 'hotel_db';
$username = 'root';
$password = '';
```

---

## 🔐 Acceso al sistema

### 1️⃣ Generar un usuario administrador
Ejecuta este script para generar la contraseña cifrada:

```php
<?php
echo password_hash('tu_password', PASSWORD_DEFAULT);
?>
```

Copia el hash resultante y crea un usuario en la tabla `usuarios`:
```sql
INSERT INTO usuarios (usuario, password)
VALUES ('admin', 'AQUÍ_TU_HASH');
```

### 2️⃣ Iniciar sesión
Abre el navegador y entra a:
```
http://localhost/SistemaGestionHotelera/login/login.php
```
Luego accede con tus credenciales.

---

## 💅 Estilo y Diseño

- Tema oscuro elegante y moderno.
- Basado en la tipografía **Poppins** (Google Fonts).
- Botones, formularios y tablas con estilos coherentes en toda la aplicación.
- Totalmente **responsive** (adaptado a escritorio, tablet y móvil).

---

## 📦 Requisitos del Sistema

- PHP 8.0 o superior  
- MySQL 5.7 o superior  
- Servidor local (XAMPP, WAMP, Laragon o similar)  
- Navegador moderno (Chrome, Edge, Firefox)

---

## ▶️ Instrucciones de Uso

1. Clona este repositorio:
   ```bash
   git clone https://github.com/tu_usuario/SistemaGestionHotelera.git
   ```
2. Coloca la carpeta en tu servidor local (por ejemplo, `htdocs` de XAMPP).
3. Importa la base de datos `hotel_db.sql` desde phpMyAdmin.
4. Ajusta la configuración en `config/db.php`.
5. Abre el navegador y entra en:
   ```
   http://localhost/SistemaGestionHotelera/login/login.php
   ```
6. Inicia sesión con tu usuario.

---

## 🧑‍💻 Tecnologías Utilizadas

- **PHP (PDO)** → Conexión segura con base de datos  
- **MySQL** → Gestión de datos  
- **HTML5 / CSS3** → Interfaz moderna y responsive  
- **Google Fonts (Poppins)** → Tipografía principal  

---

### 👨‍💼 Autor
**Mario Sánchez Ruiz**   
