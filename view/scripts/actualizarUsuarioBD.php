<?php
include_once '../../scripts/conexion.php';
session_start();

$idUsuario = $_REQUEST['idUsuario'];

$tipo_usuario = $_REQUEST['status2'];
$dni = $_REQUEST['dni2'];
$nombre = $_REQUEST['nombre2'];
$apellidos = $_REQUEST['apellidos2'];
$fecha_nacimiento = $_REQUEST['fecha_nacimiento2'];
$sector = $_REQUEST['sector2'];
$password = $_REQUEST['password2'];

if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
    $fileSubmit = $_FILES['picture'];
    $url_foto = $fileSubmit['name'];
    $ext = explode('.',$url_foto);
    $extension = $ext[count($ext)-1];
    $urlFile = '../../public/img-contacto/'.$dni.'.'.$extension;

    if (!file_exists($urlFile)) {
        move_uploaded_file($fileSubmit["tmp_name"], $urlFile);
    } else {
        unlink($urlFile);
        move_uploaded_file($fileSubmit["tmp_name"], $urlFile);
    }

    if($tipo_usuario == 1 || $tipo_usuario == 2) {
        $query = "UPDATE usuario SET dni = '" . $dni . "', nombre = '" . $nombre . "', apellidos = '" . $apellidos . "', fecha_nacimiento = '" . $fecha_nacimiento . "', password = '" . $password . "', url_foto = '" . $dni.'.'.$extension . "' WHERE id = ".$idUsuario.";";
    } else {
        $query = "UPDATE usuario SET dni = '" . $dni . "', nombre = '" . $nombre . "', apellidos = '" . $apellidos . "', password = '" . $password . "', url_foto = '" . $dni.'.'.$extension . "' WHERE id = ".$idUsuario.";";
    }
} else {
    if($tipo_usuario == 1 || $tipo_usuario == 2) {
        $query = "UPDATE usuario SET dni = '" . $dni . "', nombre = '" . $nombre . "', apellidos = '" . $apellidos . "', fecha_nacimiento = '" . $fecha_nacimiento . "', password = '" . $password . "' WHERE id = ".$idUsuario.";";
    } else {
        $query = "UPDATE usuario SET dni = '" . $dni . "', nombre = '" . $nombre . "', apellidos = '" . $apellidos . "', password = '" . $password . "' WHERE id = ".$idUsuario.";";
    }
}

if (mysqli_query($con, $query)) {
    if($tipo_usuario == 1 || $tipo_usuario == 2){
        $consulta = "UPDATE usuario_sector_tipo_usuario SET id_sector = '".$sector."', id_tipo_usuario = '".$tipo_usuario."' WHERE id_usuario = '".$idUsuario."' AND ano = '".$_SESSION['ano_actual']."';";
    } else {
        $consulta = "UPDATE usuario_sector_tipo_usuario SET id_tipo_usuario = '".$tipo_usuario."' WHERE id_usuario = '".$idUsuario."' AND ano = '".$_SESSION['ano_actual']."';";
    }
    $sql = mysqli_query($con, $consulta);
    
    if(mysqli_query($con, $sql)){};
    
    /*DATOS*/
    $tdatos = $_REQUEST['selectTipoDatoEditar'];
    $datos = $_REQUEST['datoEditar'];
    $querys = "";
    if (!empty($datos) && is_array($datos)) {
        $deleteDatos = "DELETE FROM datos WHERE id_usuario = '".$idUsuario."';";
        if(mysqli_query($con, $deleteDatos)) {
            for ($i = 0; $i < count($tdatos); $i++) {
                $querys = "INSERT INTO datos (id_usuario, id_tipo_dato, dato) VALUES (" . $idUsuario . "," . $tdatos[$i] . ",'" . $datos[$i] . "');";
                if ($con->query($querys)) {
                } else {}
            }
        }
    }
    /*ENFERMEDADES*/
    if(isset($_REQUEST['selectEnfermedadEditar'])) {
        $enfermedades = $_REQUEST['selectEnfermedadEditar'];
        $deleteEnfermedades = "DELETE FROM usuario_enfermedad WHERE id_usuario = '".$idUsuario."';";
        if(mysqli_query($con, $deleteEnfermedades)){
            if (!empty($enfermedades) && is_array($enfermedades)){
                foreach ($enfermedades as $enfermedad) {
                    $query2 = "INSERT INTO usuario_enfermedad (id_usuario, id_enfermedad) VALUES (" . $idUsuario . "," . $enfermedad . ");";
                    if (mysqli_query($con, $query2)) {}
                }
            }
        }
    }

    /*PADRES*/
    if(isset($_REQUEST['selectPadreEditar'])) {
        $padres = $_REQUEST['selectPadreEditar'];
        $deletePadres = "DELETE FROM usuario_usuario WHERE id_usuario_nino = '" . $idUsuario . "';";
        if (mysqli_query($con, $deletePadres)) {
            if (!empty($padres) && is_array($padres)) {
                foreach ($padres as $padre) {
                    $query2 = "INSERT INTO usuario_usuario (id_usuario_nino, id_usuario_padre) VALUES (" . $idUsuario . "," . $padre . ");";
                    if (mysqli_query($con, $query2)) {
                    }
                }
            }
        }
    }
    echo 'Usuario actualizado';
} else {
    echo 'No se ha podido actualizar el usuario.';
}

header('Location: '.$_SERVER['HTTP_REFERER']);
?>