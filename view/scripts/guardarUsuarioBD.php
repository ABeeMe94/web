<?php
session_start();
include_once '../../scripts/conexion.php';

$tipo_usuario = $_REQUEST['status'];
$dni = $_REQUEST['dni'];
$nombre = $_REQUEST['nombre'];
$apellidos = $_REQUEST['apellidos'];
$fecha_nacimiento = $_REQUEST['fecha_nacimiento'];
$sector = $_REQUEST['sector'];
$password = $_REQUEST['password'];
$estado = 1;
$url_foto = "";

$buscar_usuario = "SELECT * from usuario where dni='".$dni."';";
$result = mysqli_query($con, $buscar_usuario);
$count = mysqli_num_rows($result);
if ($count == 1){
    $query1 = "UPDATE usuario SET  estado_activo = 1 WHERE dni='".$dni."';";
    if(mysqli_query($con, $query1)){}
} else {
    $fileSubmit = $_FILES['picture'];
    $url_foto = $fileSubmit['name'];
    $ext = explode('.',$url_foto);
    $extension = $ext[count($ext)-1];

    $urlFile = '../../public/img-contacto/'.$dni.'.'.$extension;

    if (!file_exists($urlFile)) {
        move_uploaded_file($fileSubmit["tmp_name"], $urlFile);
    }
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        if($tipo_usuario == 1 || $tipo_usuario == 2) {
            $query = "INSERT INTO usuario (dni, nombre, apellidos, fecha_nacimiento, password, estado_activo, url_foto) VALUES ('" . $dni . "','" . $nombre . "','" . $apellidos . "','" . $fecha_nacimiento . "','" . $password . "','" . $estado . "','" . $dni.'.'.$extension . "');";
            echo $query;
        } else {
            $query = "INSERT INTO usuario (dni, nombre, apellidos, fecha_nacimiento, password, estado_activo, url_foto) VALUES ('" . $dni . "','" . $nombre . "','" . $apellidos . "',NULL,'" . $password . "','" . $estado . "','" . $dni.'.'.$extension . "');";
            echo $query;
        }
    } else {
        if($tipo_usuario == 1 || $tipo_usuario == 2) {
            $query = "INSERT INTO usuario (dni, nombre, apellidos, fecha_nacimiento, password, estado_activo, url_foto) VALUES ('" . $dni . "','" . $nombre . "','" . $apellidos . "','" . $fecha_nacimiento . "','" . $password . "','" . $estado . "','" . '' . "');";
            echo $query;
        } else {
            $query = "INSERT INTO usuario (dni, nombre, apellidos, fecha_nacimiento, password, estado_activo, url_foto) VALUES ('" . $dni . "','" . $nombre . "','" . $apellidos . "',NULL,'" . $password . "','" . $estado . "','" . '' . "');";
            echo $query;
        }
    }

    if (mysqli_query($con, $query)) {
        $idUsuarioNuevo = "SELECT id FROM usuario WHERE dni = '" . $dni . "';";
        echo $idUsuarioNuevo;
        $idUsuarioNuevo2 = mysqli_query($con, $idUsuarioNuevo);
        if ($row = mysqli_fetch_array($idUsuarioNuevo2)) {
            if($tipo_usuario == 1 || $tipo_usuario == 2){
                $tipoUsuarioSector = "INSERT INTO usuario_sector_tipo_usuario (id_usuario, id_sector, id_tipo_usuario, ano) VALUES (" . $row['id'] . "," . $sector . "," . $tipo_usuario . ",'" . $_SESSION['ano_actual'] . "');";
            } else {
                $tipoUsuarioSector = "INSERT INTO usuario_sector_tipo_usuario (id_usuario, id_sector, id_tipo_usuario, ano) VALUES (" . $row['id'] . ",'13'," . $tipo_usuario . ",'" . $_SESSION['ano_actual'] . "');";
                echo $tipoUsuarioSector;
            }
            echo $tipoUsuarioSector;
            if (mysqli_query($con, $tipoUsuarioSector)) {
                if ($tipo_usuario == 1 || $tipo_usuario == 2) {
                    $enfermedades = $_REQUEST['selectEnfermedad'];
                    if (!empty($enfermedades) && is_array($enfermedades)) {
                        foreach ($enfermedades as $enfermedad) {
                            $query3 = "INSERT INTO usuario_enfermedad (id_usuario, id_enfermedad) VALUES (" . $row['id'] . "," . $enfermedad . ");";
                            if (mysqli_query($con, $query3)) {
                            } else {
                            }
                        }
                    }
                }
                $tdatos = $_REQUEST['selectTipoDato'];
                $datos = $_REQUEST['dato'];
                $querys = "";
                if (!empty($datos) && is_array($datos)) {
                    for ($i = 0; $i < count($tdatos); $i++) {
                        $querys = "INSERT INTO datos (id_usuario, id_tipo_dato, dato) VALUES (" . $row['id'] . "," . $tdatos[$i] . ",'" . $datos[$i] . "');";
                        if ($con->query($querys)) {
                        } else {
                        }
                    }
                }
                if ($tipo_usuario == 1 || $tipo_usuario == 2) {
                    $padres = $_REQUEST['selectPadre'];
                    if (!empty($padres) && is_array($padres)) {
                        foreach ($padres as $padre) {
                            $query4 = "INSERT INTO usuario_usuario (id_usuario_nino, id_usuario_padre) VALUES (" . $row['id'] . "," . $padre . ");";
                            if (mysqli_query($con, $query4)) {
                            } else {
                            }
                        }
                    }
                }
            }
        }
    }
}
header('Location: '.$_SERVER['HTTP_REFERER']);