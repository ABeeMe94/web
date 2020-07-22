<?php
//session_start();
include_once '../../scripts/conexion.php';

$nombre = $_REQUEST['nombre'];
$buscarProveedor = "SELECT * from proveedores WHERE nombre='".$nombre."';";
echo $buscarProveedor;
$result = mysqli_query($con, $buscarProveedor);
$count = mysqli_num_rows($result);
echo $count;
if ($count == 1){ ?>
    <script type="application/javascript">
        alert('El usuario ya existe!!');
    </script>
<?php } else {
    $query = "INSERT INTO proveedores (nombre,estado_activo) VALUES ('".$nombre."',1)";
    echo $query;
    if ($con -> query($query) === TRUE){
        $idProveedorNuevo = mysqli_query($con, "SELECT id FROM proveedores WHERE nombre = '".$nombre."';");
        if($row = mysqli_fetch_array($idProveedorNuevo)){
            $tipos_provedoor = $_REQUEST['selectTipo'];
            if (!empty($tipos_provedoor) && is_array($tipos_provedoor)){
                //$query2 = "";
                foreach ($tipos_provedoor as $tipo) {
                    $query2 = "INSERT INTO proveedor_tipo_proveedor (id_proveedor, id_tipo_proveedor) VALUES (".$row['id'].",".$tipo.");";
                    if(mysqli_query($con, $query2)){
                    }else{ ?>
                        <script type="application/javascript">
                            alert('No se han podido registrar los tipos. Revisarlo en la tabla.');
                        </script>
                    <?php }
                }
            }
            $tdatos = $_REQUEST['selectTipoDato'];
            $datos = $_REQUEST['dato'];
            $querys = "";
            for ($i=0; $i<count($tdatos);$i++) {
                echo '/'.$row['id'].'-------'.$tdatos[$i].'--------'.$datos[$i].'/';
                $querys = "INSERT INTO datos_proveedor (id_proveedor, id_tipo_dato, dato) VALUES (".$row['id'].",".$tdatos[$i].",'".$datos[$i]."');";
                if ($con -> query($querys)) {  } else { ?>
                    <script type="application/javascript">
                        alert('No se han podido registrar los datos. Revisarlo en la tabla.');
                    </script>
                    <?php
                }
            }echo $querys;
        }
    } else { ?>
        <script type="application/javascript">
            alert('No se ha podido dar de alta el proveedor. Vuelva a intentarlo.');
        </script>
    <?php }
}

header('Location: '.$_SERVER['HTTP_REFERER']);
?>