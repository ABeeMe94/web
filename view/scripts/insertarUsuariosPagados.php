<?php
//session_start();
include_once '../../scripts/conexion.php';

$arraySeleccionados = $_REQUEST['arraySeleccionados'];
$pago = $_REQUEST['pago'];
foreach ($arraySeleccionados as $usuario){
    $query = "SELECT * from usuario_pago where id_usuario=".$usuario." and id_pago=".$pago.";";
    $result = mysqli_query($con, $query);
    $count = mysqli_num_rows($result);
    if ($count == 1){
    } else {
        $query2 = "INSERT INTO usuario_pago (id_usuario,id_pago) VALUES (".$usuario.",".$pago.")";
        if (mysqli_query($con, $query2)){
        }else { ?>
        <?php }
    }
}
echo 'Usuarios actualizados';