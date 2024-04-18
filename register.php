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

if (isset($_POST["usuario"])) {
    $usuario = $_POST["usuario"];
    $passwordl = $_POST["password"];
    $banco = $_POST["banco"];
    $numero = $_POST["numero"];
    include "conexion.php";
    try {
        $sql_banco = "INSERT INTO cuenta_banco (banco, numero) VALUES (?, ?)";
        $stmt_banco = $conn->prepare($sql_banco);
        $stmt_banco->bindParam(1, $banco);
        $stmt_banco->bindParam(2, $numero);
        $stmt_banco->execute();

        // Obtener el idbanco generado por la inserción
        $idbanco = $conn->lastInsertId();

        $sql = "insert into usuarios (nombre, contraseña, idcuenta_banco) values(?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $usuario);
        $stmt->bindParam(2, $passwordl);
        $stmt->bindParam(3, $idbanco);

        $stmt->execute();

        $rowCount = $stmt->rowCount(); // Obtiene el número de filas afectadas por la última operación

        if ($rowCount > 0) {
            // La inserción fue exitosa, muestra el mensaje
            header("Location: ./");
            exit();
        } else {
            // La inserción falló, muestra un mensaje de error si es necesario
            $error = "No se ha podido crear el usuario";
        }
    } catch (PDOException $e) {
        $error = "No se ha podido crear el usuario";
    }
}

?>


<?php
include "./templates/header.php";
?>
<div id="logout">
    <?php if (isset($_SESSION['usuario'])) : ?>
        <p style="color: maroon;"> Bienvenido, <?php echo $_SESSION['usuario']; ?> | <a href="logout.php">Cerrar sesión</a></p>
    <?php endif; ?>
</div>
<section class="vh-100" style="background: linear-gradient(to right, #7fb3d5, #85a2b6);">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-xl-10">
                <div class="card" style="border-radius: 1rem;">
                    <div class="row g-0">
                        <div class="col-md-6 col-lg-5 d-none d-md-block">
                            <img src="assets/img/gym.webp" alt="login form" class="img-fluid h-100 w-auto" style="border-radius: 1rem 0 0 1rem;" />
                        </div>
                        <div class="col-md-6 col-lg-7 d-flex align-items-center">
                            <div class="card-body p-4 p-lg-5 text-black">

                                <form action="" method="post">

                                    <div class="d-flex align-items-center mb-3 pb-1">
                                        <i class="fa-solid fa-dumbbell" style="font-size: 30px;"></i>
                                        <span class="h1 fw-bold mb-0"> NicosGym</span>
                                    </div>

                                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Registrate</h5>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="text" name="usuario" id="usuario" class="form-control form-control-lg" required />
                                        <label class="form-label" for="usuario">Nombre de Usuario</label>
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="password" name="password" id="password" class="form-control form-control-lg password" />
                                        <label class="form-label" for="password">Contraseña</label>
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="password" name="repassword" id="repassword" class="form-control form-control-lg password" />
                                        <label class="form-label" for="password">Repite Contraseña</label>
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="text" name="banco" id="banco" class="form-control form-control-lg password" />
                                        <label class="form-label" for="banco">Nombre del banco</label>
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="text" name="numero" id="numero" class="form-control form-control-lg password" />
                                        <label class="form-label" for="numero">Numero de banco</label>
                                    </div>

                                    <div class="pt-1 mb-4">
                                        <button data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-lg btn-block" id="btnregister" disabled type="submit">Registrate</button>
                                    </div>
                                    <?php
                                    if (isset($error)) {
                                        echo "<p>" . $error . "</p>";
                                    }
                                    ?>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include "./templates/footer.php";
?>