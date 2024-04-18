<?php

// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "1234";
$database = "nicosgym";

try {
    // Crear una conexión con PDO
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);

    // Establecer el modo de error de PDO a excepción
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
   // Obtener los valores del formulario (suponiendo que se ha enviado por método POST)
   /*if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $passwordl = $_POST["password"];

    $sql = "SELECT * FROM usuarios WHERE email = ? AND password = ?";

    // Consulta preparada para evitar la inyección de SQL
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $email);
    $stmt->bindParam(2, $passwordl);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        // Usuario autenticado correctamente
        echo "Inicio de sesión exitoso";
    } else {
        // Usuario no encontrado o contraseña incorrecta
        echo "Credenciales incorrectas";
    }*/
} catch(PDOException $e) {
   
    die("Error de conexión: " . $e->getMessage());
}

