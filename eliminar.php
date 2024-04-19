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

if (isset($_POST["nombre"])) {
    $id_usuario = $_POST["id"];
    include "conexion.php";

    try {
        $sql_banco = "Select * from usuarios where idusuarios= ?";
        $stm_banco = $conn->prepare($sql_banco);
        $stm_banco->bindParam(1, $id_usuario);
        $stm_banco->execute();
        $fila = $stm_banco->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $error = "No se ha podido encontrar al usuario";
    }


    try {
        $sql = "DELETE from usuarios where idusuarios = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $id_usuario);
        $stmt->execute();

        $sql_borrar = "delete from cuenta_banco where idcuenta_banco = ?";
        $stmt_borrar = $conn->prepare($sql_borrar);
        $stmt_borrar->bindParam(1, $fila['idcuenta_banco']);
        $stmt_borrar->execute();

        $rowCount = $stmt->rowCount(); // Obtiene el número de filas afectadas por la última operación
        $rowCountbanco = $stmt_borrar->rowCount();
        if ($rowCountbanco > 0 && $rowCount > 0) {
            // La inserción fue exitosa, muestra el mensaje
            header("Location: adm.php");
            exit();
        } else {
            // La inserción falló, muestra un mensaje de error si es necesario
            $error = "No se ha podido eliminar el usuario";
        }
    } catch (PDOException $e) {
        $error = "No se ha podido eliminar";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar</title>
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
    #num_banco,
    #banco {
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
    @media (max-width: 768px) {
        .form-container {
            padding: 10px;
            margin-left: 35px;
            margin-top: 50px;
            position: fixed;
            /* Reducir el espacio alrededor del formulario */
        }

        .form-control {
            max-width: 100%;
            /* Hacer que los inputs ocupen todo el ancho */
           
        }
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
                        <h2 class="card-title text-center">Eliminar usuario</h2>
                        <form method="post">
                            <div class="form-group">
                                <label for="id">ID:</label>
                                <input type="text" class="form-control" id="id" name="id" onkeyup="buscarUsuario()">
                            </div>
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre">
                            </div>
                            <div class="form-group">
                                <label for="contraseña">Contraseña:</label>
                                <input type="password" class="form-control" id="contraseña" name="contraseña">
                            </div>
                            <div class="form-group">
                                <label for="num_banco">Número de Banco:</label>
                                <input type="text" class="form-control" id="num_banco" name="num_banco">
                            </div>
                            <div class="form-group">
                                <label for="banco">Banco:</label>
                                <input type="text" class="form-control" id="banco" name="banco">
                            </div>
                            <button type="submit" class="btn btn-primary">Eliminar</button>
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