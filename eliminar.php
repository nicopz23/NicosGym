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
        $sql_banco = "DELETE from usuarios where idusuarios = ?";
        $stmt_banco = $conn->prepare($sql_banco);
        $stmt_banco->bindParam(1, $id_usuario);
        $stmt_banco->execute();

        $rowCount = $stmt_banco->rowCount(); // Obtiene el número de filas afectadas por la última operación
        var_dump($rowCount);
        if ($rowCount > 0) {
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

<body>
    <div class="container mt-5">
        <h2>Eliminar usuario</h2>
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

    <!-- Bootstrap JS (opcional, para funcionalidades adicionales) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/editar.js"></script>
</body>

</html>