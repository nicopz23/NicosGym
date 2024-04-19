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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST["id"];
    $nombre = $_POST["nombre"];
    $fecha_inicio = $_POST["fecha_inicio"];
    $fecha_final = $_POST["fecha_final"];
    $plazo = $_POST["plazo"];

    include 'conexion.php';

    $nueva_fecha_final = date("Y-m-d H:i:s", strtotime($fecha_final . " + $plazo months"));
    var_dump($nueva_fecha_final);
    $sql = "UPDATE usuarios SET fecha_final = ? WHERE idusuarios = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $nueva_fecha_final);
    $stmt->bindParam(2, $id_usuario);
    $stmt->execute();

    // Verifica si la consulta se ejecutó correctamente
    if ($stmt->rowCount() > 0) {
        // La actualización fue exitosa, puedes redirigir a alguna página o mostrar un mensaje de éxito
        header("Location: adm.php");
        exit();
    } else {
        // La actualización falló, muestra un mensaje de error si es necesario
        $error = "No se ha podido actualizar la fecha final";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renovar Fecha</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    body {
        background: linear-gradient(to right, #7fb3d5, #85a2b6);
        /* Degradado de colores más suaves */
        color: #333;
        /* Color del texto oscuro para contrastar */

    }

    .form-container {
        background-color: #404040;
        /* Gris oscuro */
        color: white;
        /* Texto blanco para contrastar */
    }

    .form-control {
        max-width: 500px;

    }

    #id {
        max-width: 100px;
        /* Ancho máximo para el input de ID */
    }

    #nombre,
    #contraseña,
    #fecha_inicio,
    #fecha_final {
        max-width: 250px;
        /* Ancho máximo para el resto de inputs */
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
</style>

<body>
    <div id="logout">
        <?php if (isset($_SESSION['usuario'])) : ?>
            <p style="color: maroon;position: relative;position: relative;bottom: 42px;right: 8px;"> Bienvenido, <?php echo $_SESSION['usuario']; ?> | <a href="logout.php">Cerrar sesión</a></p>
        <?php endif; ?>
    </div>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body form-container">
                        <h2 class="card-title text-center">Editar usuario</h2>
                        <form method="post">
                            <div class="form-group">
                                <label for="id">ID usuario:</label>
                                <input type="text" class="form-control" id="id" name="id" onkeyup="buscarUsuario()" maxlength="10">
                            </div>
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" maxlength="50" readonly>
                            </div>
                            <div class="form-group">
                                <label for="fecha_inicio">Fecha de Inicio:</label>
                                <input type="datetime" class="form-control" id="fecha_inicio" name="fecha_inicio" readonly>
                            </div>
                            <div class="form-group">
                                <label for="fecha_final">Fecha de Finalización:</label>
                                <input type="datetime" class="form-control" id="fecha_final" name="fecha_final" maxlength="15" readonly>
                            </div>
                            <div class="form-group">
                                <label for="plazo">Plazo:</label>
                                <select class="form-control" id="plazo" name="plazo">
                                    <option value="3">3 meses</option>
                                    <option value="6">6 meses</option>
                                    <option value="9">9 meses</option>
                                    <option value="12">12 meses</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Editar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (opcional, para funcionalidades adicionales) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/editar.js"></script>
</body>

</html>