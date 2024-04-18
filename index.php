<?php
session_start();

if (isset($_POST["usuario"])) {

    include "conexion.php";

    $usuario = $_POST["usuario"];
    $password = $_POST["password"];
    $sql = "select * from usuarios where nombre=? and contraseña=?";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $usuario);
    $stmt->bindParam(2, $password);
    $stmt->execute();


    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $idrol = $row['idrol'];
        $id_usuario = $row['idusuarios'];
        $_SESSION["idusuario"] = $id_usuario;
        $_SESSION["usuario"] = $usuario;
        $_SESSION["idrol"] = $idrol;

        // Redirige al usuario según el idrol obtenido
        if ($idrol == 1) {
            header("Location: adm.php");
        } else {
            header("Location: usr.php");
        }
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<?php
include "./templates/header.php";
?>

<section class="vh-100" style="background: linear-gradient(to right, #7fb3d5, #85a2b6);">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-xl-10">
                <div class="card" style="border-radius: 1rem;">
                    <div class="row g-0">
                        <div class="col-md-6 col-lg-5 d-none d-md-block">
                            <img src="assets/img/gym.webp" alt="login form" class="img-fluid h-100 w-10" style="border-radius: 1rem 0 0 1rem;" />

                        </div>
                        <div class="col-md-6 col-lg-7 d-flex align-items-center">
                            <div class="card-body p-4 p-lg-5 text-black">

                                <form action="" method="post">

                                    <div class="d-flex align-items-center mb-3 pb-1">
                                        <i class="fa-solid fa-dumbbell" style="font-size: 30px;"></i>
                                        <span class="h1 fw-bold mb-0">NicosGym</span>
                                    </div>

                                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Inicia sesion</h5>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="text" name="usuario" id="form2Example17" class="form-control form-control-lg" />
                                        <label class="form-label" for="form2Example17">Usuario</label>
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="password" name="password" id="form2Example27" class="form-control form-control-lg" />
                                        <label class="form-label" for="form2Example27">Contraseña</label>
                                    </div>

                                    <div class="pt-1 mb-4">
                                        <button data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
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