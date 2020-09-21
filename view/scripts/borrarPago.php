<?php
//session_start();
include_once '../../scripts/conexion.php';
$id = $_REQUEST['id'];
$query = "DELETE FROM pagos WHERE id = '".$id."';";
if($sql = mysqli_query($con, $query)){
    echo 'Pago eliminado';
} else {
    echo 'No se ha podido eliminar el pago.';
}