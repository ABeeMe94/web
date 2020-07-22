<?php
//session_start();
include_once '../../scripts/conexion.php';

$dni = $_REQUEST['dni'];
$nombre = $_REQUEST['nombre'];
$apellidos = $_REQUEST['apellidos'];
$fecha_nacimiento = $_REQUEST['fecha_nacimiento'];
$usuario = "";
$password = "";
$estado = 1;
$url_foto = "";

$buscar_usuario = "SELECT * from usuario where nombre='".$nombre."' and apellidos='".$apellidos."';";
$result = mysqli_query($con, $buscar_usuario);
$count = mysqli_num_rows($result);
if ($count == 1){ ?>
    <script type="application/javascript">
        alert('El pago ya existe!!');
    </script>
<?php } else {
    $query = "INSERT INTO usuario (dni, nombre, apellidos, fecha_nacimiento, usuario, password, estado, url_foto) VALUES ('" . $dni . "','" . $nombre . "','" . $apellidos . "','" . $fecha_nacimiento . "','" . $usuario . "','" . $password . "','" . $estado . "','" . $url_foto . "');";
}
