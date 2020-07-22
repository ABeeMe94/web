<?php
//session_start();
include_once '../../scripts/conexion.php';

$id = $_REQUEST['id'];
$txt_ids ="";
$first = true;

$query = "SELECT id_usuario, id_pago from usuario_pago WHERE id_pago = ".$id." ;";
$sql = mysqli_query($con, $query);
while($row = mysqli_fetch_array($sql)){
    if($first){
        $txt_ids = $row['id_usuario'];
        $first = false;
    } else {
        $txt_ids = $txt_ids.';'.$row['id_usuario'];
    }

}

echo $txt_ids;