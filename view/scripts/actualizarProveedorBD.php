<?php
include_once '../../scripts/conexion.php';

$idProveedor = $_REQUEST['idProveedor'];
$nombre = $_REQUEST['nombre'];

$sql = "UPDATE proveedores SET  nombre = '$nombre' WHERE id = ".$idProveedor.";";
if ($con -> query($sql) === TRUE){
        $tipos_provedoor = $_REQUEST['selectTipoEditar'];
        $deleteTipos = "DELETE FROM proveedor_tipo_proveedor WHERE id_proveedor = '".$idProveedor."';";
        if(mysqli_query($con, $deleteTipos)){
            if (!empty($tipos_provedoor) && is_array($tipos_provedoor)){
                foreach ($tipos_provedoor as $tipo) {
                    $query2 = "INSERT INTO proveedor_tipo_proveedor (id_proveedor, id_tipo_proveedor) VALUES (" . $idProveedor . "," . $tipo . ");";
                    if (mysqli_query($con, $query2)) {}
                }
            }
        }

        $tdatos = $_REQUEST['selectTipoDatoEditar'];
        $datos = $_REQUEST['datoEditar'];
        $querys = "";
        if (!empty($datos) && is_array($datos)) {
            $deleteDatos = "DELETE FROM datos_proveedor WHERE id_proveedor = '".$idProveedor."';";
            if(mysqli_query($con, $deleteDatos)) {
                for ($i = 0; $i < count($tdatos); $i++) {
                    $querys = "INSERT INTO datos_proveedor (id_proveedor, id_tipo_dato, dato) VALUES (" . $idProveedor . "," . $tdatos[$i] . ",'" . $datos[$i] . "');";
                    if ($con->query($querys)) {
                    } else {}
                }
            }
        }
} else {}

header('Location: '.$_SERVER['HTTP_REFERER']);
?>