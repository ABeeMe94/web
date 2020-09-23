<?php
//session_start();
include_once '../../scripts/conexion.php';
$dni = $_REQUEST['dni'];

$query = "UPDATE usuario SET  estado_activo = 1 WHERE dni = ".$dni.";";

if($sql = mysqli_query($con, $query)){
    echo 'Usuario habilitado';
} else {
    echo 'No se ha podido habilitar el usuario.';
}