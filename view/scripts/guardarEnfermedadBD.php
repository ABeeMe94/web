<?php
session_start();
include_once '../../scripts/conexion.php';

$nombre = $_REQUEST['nombre'];
$descripcion = $_REQUEST['descripcion'];
echo $nombre;
echo $descripcion;
$buscarEnfermedad = "SELECT * from enfermedad WHERE nombre='".$nombre."';";

$result = mysqli_query($con, $buscarEnfermedad);
$count = mysqli_num_rows($result);
if ($count == 1){ }
else {
    $query = "INSERT INTO enfermedad (nombre,descripcion) VALUES ('".$nombre."','".$descripcion."';)";
    if (mysqli_query($con, $query)){
    }else { }
}

//header('Location: '.$_SERVER['HTTP_REFERER']);
?>