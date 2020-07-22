<?php
//session_start();
include_once '../../scripts/conexion.php';

$id = $_REQUEST['id'];

$query = "UPDATE usuario SET  estado_activo = 0 WHERE id = $id ;";
$sql = mysqli_query($con, $query);
if($row = mysqli_fetch_array($sql)){
    error_log('Usuario deshabilitado');
}
