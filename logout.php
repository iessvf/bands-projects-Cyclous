<?php
session_start();
session_destroy(); // Destruye la sesión

// Redirige a la página de inicio de sesión u otra página que desees
header("Location: login.php"); // Cambia "login.php" al URL que desees
exit();
?>