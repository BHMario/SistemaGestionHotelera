<?php
session_start();

$_SESSION = [];
session_destroy();

// Redirigir al login
header('Location: login.php');
exit;
