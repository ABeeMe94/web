<?php
//session_start();
include_once '../../scripts/conexion.php';

$dni = $_REQUEST['dni'];

$query = "SELECT * from usuario WHERE dni = ".$dni.";";
if($sql = mysqli_query($con, $query)){
    while($row = mysqli_fetch_array($sql)){
        if ($row['estado_activo'] == 1){
            echo '1';
        } else {
            echo '2';
        }
    }
} else {
    echo '3';
}
