<?php
session_start();
if (isset($_SESSION["usuario"])) {
    $usuario = $_SESSION["usuario"];

    // Verifica el rol del usuario y redirige según el rol
    if (isset($_SESSION["idrol"])) {
        $idrol = $_SESSION["idrol"];

        if ($idrol == 2) {
            // Si el rol es 2 (usuario), permitir el acceso a la página
        } else {
            // Si el rol no es 2 (usuario), redirigir a alguna otra página o mostrar un mensaje de error
            header("Location: adm.php");
            exit();
        }
    }
} else {
    // Si no se encuentra el usuario en la sesión, redirigir al usuario al inicio de sesión
    header("Location: ./");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario</title>
    
</head>

<body>
    <h1>usuario</h1>
</body>

</html>