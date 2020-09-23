<?php
//session_start();
include_once '../../scripts/conexion.php';
$id = $_REQUEST['id'];

$query = "UPDATE usuario SET  estado_activo = 0 WHERE id = ".$id.";";

if($sql = mysqli_query($con, $query)){
    echo 'Usuario deshabilitado';
} else {
    echo 'No se ha podido deshabilitar el usuario.';
}
