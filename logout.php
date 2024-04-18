<?php
// Inicia la sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Destruye la sesión actual
session_destroy();

// Redirige al usuario a la página de inicio o a donde desees
header("Location: ./");
exit();
