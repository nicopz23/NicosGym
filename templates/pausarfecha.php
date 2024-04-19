<?php
session_start();
include '../conexion.php'; // Incluir el archivo de conexión a la base de datos

if (isset($_GET['pausarMembresia'])) {
    // Recibir el valor de pausarMembresia
    $meses = intval($_GET['pausarMembresia']);

    // Obtener la fecha actual
    $fechaActual = date('Y-m-d H:i:s');

    // Consultar la fecha de inicio y fecha final desde la base de datos
    $idUsuario = $_SESSION['idusuario'];

    $sqlFechas = "SELECT fecha_inicio, fecha_final FROM usuarios WHERE idusuarios = ?";
    $stmtFechas = $conn->prepare($sqlFechas);
    $stmtFechas->bindParam(1, $idUsuario);
    $stmtFechas->execute();
    $filaFechas = $stmtFechas->fetch(PDO::FETCH_ASSOC);
    $fechaInicio = $filaFechas['fecha_inicio'];
    $fechaFinal = $filaFechas['fecha_final'];

    // Calcular la diferencia entre las fechas
    $diferenciaFechas = strtotime($fechaFinal) - strtotime($fechaInicio);
    $diasDiferencia = floor($diferenciaFechas / (60 * 60 * 24)); // Convertir la diferencia a días

    // Calcular la nueva fecha de inicio sumando los meses
    $nuevaFechaInicio = date('Y-m-d H:i:s', strtotime($fechaInicio . ' + ' . $meses . ' months'));

    // Calcular la nueva fecha final sumando la diferencia de días a la nueva fecha de inicio
    $nuevaFechaFinal = date('Y-m-d H:i:s', strtotime($nuevaFechaInicio . ' + ' . $diasDiferencia . ' days'));

    // Realizar la actualización en la base de datos
    $sql = "UPDATE usuarios SET fecha_inicio = ?, fecha_final = ? WHERE idusuarios = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $nuevaFechaInicio);
    $stmt->bindParam(2, $nuevaFechaFinal);
    $stmt->bindParam(3, $idUsuario);
    
    if ($stmt->execute()) {
        // La actualización fue exitosa
        $response = array(
            'success' => true,
            'message' => 'Fechas actualizadas correctamente.'
        );
    } else {
        // La actualización falló
        $response = array(
            'success' => false,
            'message' => 'Error al actualizar las fechas.'
        );
    }

    // Devolver la respuesta en formato JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Si no se proporcionó el valor de pausarMembresia en la solicitud
    $response = array(
        'success' => false,
        'message' => 'No se proporcionó el valor de pausarMembresia en la solicitud.'
    );

    // Devolver la respuesta en formato JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}

