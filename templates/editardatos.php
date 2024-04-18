<?php
// Verificar si se ha enviado un ID de usuario para editar
if (isset($_GET['id'])) {
    // Obtener el ID del usuario a editar
    $id_usuario = $_GET['id'];

    // Realizar la consulta a la base de datos para obtener los datos del usuario
    include "../conexion.php"; // Incluir el archivo de conexión a la base de datos

    $sql = "SELECT * FROM usuarios as s join cuenta_banco as c on c.idcuenta_banco = s.idcuenta_banco WHERE idusuarios = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_usuario]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    // Verificar si se encontró un usuario con el ID proporcionado
    if ($usuario) {
        // Rellenar los campos del formulario con los datos del usuario
        $nombre = $usuario['nombre'];
        $contraseña = $usuario['contraseña'];
        $num_banco = $usuario['numero'];
        $banco = $usuario['banco'];
        $fecha_inicio = $usuario['fecha_inicio'];
        $fecha_final = $usuario['fecha_final'];
        echo json_encode($usuario);
    } else {
        // Si no se encontró un usuario con el ID proporcionado, mostrar un mensaje de error o redirigir a alguna otra página
        echo "Usuario no encontrado.";
    }
}
