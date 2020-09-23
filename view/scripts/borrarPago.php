<?php
//session_start();
include_once '../../scripts/conexion.php';
$id = $_REQUEST['id'];
$query = "DELETE FROM usuario_pago WHERE id_pago = '".$id."';";
if($sql = mysqli_query($con, $query)){
    $query2 = "DELETE FROM pagos WHERE id = '".$id."';";
    if($sql2 = mysqli_query($con, $query2)){
        echo 'Pago eliminado';
    } else {
        echo 'No se ha podido eliminar el pago.';
    }
}else{
    echo 'No se ha podido eliminar el pago.';
}
