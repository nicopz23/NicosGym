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

include 'conexion.php';

if (!isset($_SESSION['idusuario'])) {
  header("Location: ./");
  exit();
}

// Obtener el ID de usuario de la sesión
$id_usuario = $_SESSION['idusuario'];

$sql = "SELECT * FROM usuarios as u 
join cuenta_banco as cb 
on u.idcuenta_banco=cb.idcuenta_banco
WHERE idusuarios = ?";

// Preparar y ejecutar la consulta para obtener los datos del usuario
$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $id_usuario);
$stmt->execute();
$fila = $stmt->fetch(PDO::FETCH_ASSOC);

/*$fila = array(
  'idusuario' => 'valor_predeterminado',
  'nombre' => 'valor_predeterminado',
  'fecha_inicio' => 'valor_predeterminado',
  'fecha_final' => 'valor_predeterminado',
  'numero' => 'valor_predeterminado',
  'banco' => 'valor_predeterminado'
);*/
if (!$fila) {
  $mensaje_predeterminado = "No se encontraron datos para este usuario.";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Usuario</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #7fb3d5, #85a2b6);
      /* Degradado de colores más suaves */
      color: #333;
      /* Color del texto oscuro para contrastar */
    }

    .container {
      background-color: #fff;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    h2 {
      color: #007bff;
      margin-bottom: 30px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      font-weight: bold;
    }

    .form-control-static {
      border: none;
      border-bottom: 1px solid #ced4da;
      background-color: transparent;
      padding: 0;
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
</head>

<body>
  <div id="logout">
    <?php if (isset($_SESSION['usuario'])) : ?>
      <p style="color: maroon;"> Bienvenido, <?php echo $_SESSION['usuario']; ?> | <a href="logout.php">Cerrar sesión</a></p>
    <?php endif; ?>
  </div>
  <div class="container mt-5">
    <h2 class="text-center">Informacion de Usuario</h2>
    <div class="row">
      <?php if (isset($mensaje_predeterminado)) : ?>
        <div class="col-md-12">
          <p class="text-center"><?php echo $mensaje_predeterminado; ?></p>
        </div>
      <?php else : ?>
        <div class="col-md-6">
          <div class="form-group">
            <label for="id">ID:</label>
            <p class="form-control-static" id="id"><?php echo $fila['idusuarios']; ?></p>
          </div>
          <div class="form-group">
            <label for="nombre">Nombre:</label>
            <p class="form-control-static" id="nombre"><?php echo $fila['nombre']; ?></p>
          </div>
          <div class="form-group">
            <label for="fecha_inicio">Fecha de Inicio:</label>
            <p class="form-control-static" id="fecha_inicio"><?php echo $fila['fecha_inicio']; ?></p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="fecha_final">Fecha Final:</label>
            <p class="form-control-static" id="fecha_final"><?php echo $fila['fecha_final']; ?></p>
          </div>
          <div class="form-group">
            <label for="numero">Número de Banco:</label>
            <p class="form-control-static" id="numero"><?php echo $fila['numero']; ?></p>
          </div>
          <div class="form-group">
            <label for="banco">Banco:</label>
            <p class="form-control-static" id="banco"><?php echo $fila['banco']; ?></p>
          </div>
        </div>
    </div>
  </div>
<?php endif; ?>
<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>