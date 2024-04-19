<?php
session_start();

if (isset($_SESSION["usuario"])) {
    $usuario = $_SESSION["usuario"];

    // Verifica el rol del usuario y redirige según el rol
    if (isset($_SESSION["idrol"])) {
        $idrol = $_SESSION["idrol"];

        if ($idrol == 1) {
            // Si el rol es 1 (administrador), permitir el acceso a la página
        } else {
            // Si el rol no es 1 (administrador), redirigir a alguna otra página o mostrar un mensaje de error
            header("Location: usr.php");
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
    <title>Admin</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

</head>

<style>
    body {
        background: linear-gradient(to right, #7fb3d5, #85a2b6);
        /* Degradado de colores más suaves */
        color: #333;
        /* Color del texto oscuro para contrastar */
    }

    .action-buttons {
        position: fixed;
        top: 50%;
        right: 190px;
        transform: translateY(-50%);
    }

    .action-buttons .btn {
        margin-bottom: 50px;
        display: block;
    }

    table {
        width: 100%;
        /* Ancho completo */
        border-collapse: collapse;
        /* Para asegurar que los bordes se colapsen */
        background-color: #ffffff;
        /* Fondo blanco */
    }

    th,
    td {
        border: 1px solid black;
        /* Borde de 1px de ancho y color negro */
        padding: 8px;
        /* Espaciado interno para contenido */
    }

    /* Estilo para el encabezado de la tabla */
    th {
        background-color: #404040;
        /* Color de fondo gris claro */
        color: white;
        /* Color del texto */
    }

    #logout {
        float: right;
    }

    #logout a {
        color: white;
        text-decoration: none;
        /* Para quitar el subrayado predeterminado */
    }

    #logout a:visited {
        color: maroon;
    }
    @media (max-width: 768px) {
    .action-buttons {
        display: block; /* Mostrar los botones en dispositivos móviles */
        position: fixed;
        top: 50%;
        right: 10px; /* Ajustar la posición de los botones */
        transform: translateY(-50%);
    }

    .action-buttons .btn {
        margin-bottom: 10px; /* Reducir el espacio entre botones */
    }
}
</style>
</head>

<body>
    <div id="logout">
        <?php if (isset($_SESSION['usuario'])) : ?>
            <p style="color: maroon;position: relative;position: relative;bottom: 42px;right: 8px;"> Bienvenido, <?php echo $_SESSION['usuario']; ?> | <a href="logout.php">Cerrar sesión</a></p>
        <?php endif; ?>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <h2>Usuarios</h2>
                <table class="">
                    <thead class="">
                        <tr>
                            <th>ID de usuario</th>
                            <th>Nombre</th>
                            <th>Fecha de Inicio</th>
                            <th>Fecha Finalización</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Conexión a la base de datos (suponiendo que ya tienes un archivo de conexión)
                        include "conexion.php";

                        // Realizar la consulta a la base de datos
                        $sql = "SELECT idusuarios, nombre, fecha_inicio, fecha_final FROM usuarios";
                        $resultado = $conn->query($sql);

                        // Verificar si hay resultados
                        if ($resultado->rowCount() > 0) {
                            // Si hay resultados, iterar sobre cada fila y mostrar los datos en la tabla
                            while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . $fila["idusuarios"] . "</td>";
                                echo "<td>" . $fila["nombre"] . "</td>";
                                echo "<td>" . $fila["fecha_inicio"] . "</td>";
                                echo "<td>" . $fila["fecha_final"] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            // Si no hay resultados, mostrar un mensaje indicando que no hay datos
                            echo "<tr><td colspan='4'>No hay datos disponibles</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <div class="action-buttons">
                    <a href="register.php" class="btn btn-info">Añadir usuario</a>
                    <a href="editar.php" class="btn btn-info">Editar usuario</a>
                    <a href="eliminar.php" class="btn btn-info">Eliminar usuario</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>