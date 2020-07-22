<?php
session_start();
include_once '../../scripts/conexion.php';

$nombre = $_REQUEST['nombre'];
$cantidad = $_REQUEST['cantidad'];
$buscarPago = "SELECT * from pagos WHERE nombre='".$nombre."' and ano='".$_SESSION['ano_actual']."';";

$result = mysqli_query($con, $buscarPago);
$count = mysqli_num_rows($result);
if ($count == 1){ ?>
<?php } else {
    $query = "INSERT INTO pagos (id,nombre,ano, cantidad) VALUES ('','".$nombre."','".$_SESSION['ano_actual']."','".$cantidad."')";
    if (mysqli_query($con, $query)){
    }else { ?>
    <?php }
}

header('Location: '.$_SERVER['HTTP_REFERER']);
?>