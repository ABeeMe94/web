<?php
include_once '../../scripts/conexion.php';

$input = filter_input_array(INPUT_POST);
if ($input['action'] == 'edit') {
    $update_field='';
    if(isset($input['dni'])) {
        $update_field.= "dni='".$input['dni']."'";
    } else if(isset($input['nombre'])) {
        $update_field.= "nombre='".$input['nombre']."'";
    } else if(isset($input['apellidos'])) {
        $update_field.= "apellidos='".$input['apellidos']."'";
    } else if(isset($input['fecha_nacimiento'])) {
        $update_field.= "fecha_nacimiento='".$input['fecha_nacimiento']."'";
    }
    if($update_field && $input['id_usuario']) {
        $sql_query = "UPDATE usuario SET $update_field WHERE id_usuario='" . $input['id_usuario'] . "'";
        mysqli_query($con, $sql_query) or die("database error:".
        mysqli_error($con));
    }
}


