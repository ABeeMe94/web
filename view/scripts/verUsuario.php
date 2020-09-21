<?php
session_start();
include_once '../../scripts/conexion.php';
$id = $_REQUEST['id'];

$query = "SELECT * from usuario where id='".$id."';";
error_log($query);
$usuario = mysqli_query($con, $query);
if ($row = mysqli_fetch_array($usuario)) {
    $tipo_usuario = mysqli_query($con, "SELECT id_tipo_usuario, id_sector from usuario_sector_tipo_usuario where id_usuario = '".$row['id']."' and ano = '".$_SESSION['ano_actual']."';");
    if ($row2 = mysqli_fetch_array($tipo_usuario)) {
        $tipo = $row2['id_tipo_usuario'];
        $sector = $row2['id_sector'];
    } else{
        $tipo = "";
        $sector = "";
    }
    ?>
    <div class="row">
        <div class="col-4"></div>
        <div class="col-4">
            <?php if($row['url_foto']){ ?>
                <div class="img-container">
                    <img class="img-fluid rounded-circle" style="border:5px solid black;" src="public/img-contacto/<?php echo $row['url_foto'] ?>">
                </div>
            <?php } else { ?>
                <div class="img-container">
                    <img class="img-fluid rounded-circle" style="border:5px solid black;" src="public/img-contacto/imagen.png">
                </div>
            <?php } ?>
        </div>
        <div class="col-4"></div>
    </div>
    <br>
    <div>
        <table class="table table-striped col-12">
            <tbody>
            <tr>
                <td><h6>TIPO DE USUARIO</h6></td>
                <td><?php $sql1 = mysqli_query($con, "SELECT tipo_usuario from tipo_usuario where id='".$tipo."';");
                    if($row5 = mysqli_fetch_array($sql1)){
                    echo $row5['tipo_usuario'];
                    } ?></td>
            </tr>
            <tr>
                <td><h6>NOMBRE</h6></td>
                <td><?php echo $row['nombre'] ?></td>
            </tr>
            <tr>
                <td><h6>APELLIDOS</h6></td>
                <td><?php echo $row['apellidos'] ?></td>
            </tr>
            <tr>
                <td><h6>DNI</h6></td>
                <td><?php echo $row['dni'] ?></td>
            </tr>
            <?php if($tipo !== '3' && $tipo !== '4' && $tipo !== '5' && $tipo !== '6' && $tipo !== '7' && $tipo !== '8') { ?>
                <tr>
                    <td><h6>FECHA DE NACIMIENTO</h6></td>
                    <td><?php echo $row['fecha_nacimiento'] ?></td>
                </tr>
            <?php } ?>
            <?php if($tipo !== '3' && $tipo !== '4' && $tipo !== '5' && $tipo !== '6' && $tipo !== '7' && $tipo !== '8') { ?>
                <tr>
                    <td><h6>SECTOR</h6></td>
                    <td><?php $sql = mysqli_query($con, "SELECT sector from sector where id='".$sector."';");
                        if($row3 = mysqli_fetch_array($sql)){
                            echo $row3['sector'];
                        } ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td><h6>DATOS</h6></td>
                <td><?php
                    $datos = mysqli_query($con, "SELECT tipo_dato, dato 
                                            from(SELECT D.id_usuario ,TD.tipo_dato, D.dato
                                                    FROM datos D 
                                                    INNER JOIN tipo_dato TD ON TD.id = D.id_tipo_dato) as X 
                                            where X.id_usuario = '".$row['id']."'");
                    $datosArray = array();
                    while ($dato = mysqli_fetch_array($datos)){
                        array_push($datosArray, $dato);
                    }
                    $datosUsuario['usr_datos'] = $datosArray;
                    foreach ($datosUsuario['usr_datos'] as $dato){
                        echo $dato['tipo_dato']?>: <?php echo $dato['dato'] ?> </br>
                    <?php }?>
                </td>
            </tr>
            <?php if($tipo == '1' || $tipo == '2') { ?>
                <tr>
                    <td><h6>ENFERMEDADES</h6></td>
                    <td>
                        <ul>
                            <?php $enfermedades = mysqli_query($con, "SELECT nombre from (SELECT U.id, E.nombre FROM usuario U INNER JOIN usuario_enfermedad UE ON UE.id_usuario = U.id INNER JOIN enfermedad E ON E.id = UE.id_enfermedad) as E where E.id = '" . $row['id'] . "'");
                            $enfermedadesArray = array();
                            while ($enfermedad = mysqli_fetch_array($enfermedades)) {
                                array_push($enfermedadesArray, $enfermedad['nombre']);
                            }
                            $enfermedadesUsuario['usr_enfermedades'] = $enfermedadesArray;
                            if (isset($enfermedadesUsuario['usr_enfermedades'])) {
                                foreach ($enfermedadesUsuario['usr_enfermedades'] as $enfermedad) { ?>
                                    <li><?php echo $enfermedad ?></li>
                                <?php }
                            }?>
                        </ul>
                    </td>
                </tr>
            <?php } ?>
            <?php if($tipo == '1' || $tipo == '2' || $tipo == ''){ ?>
                <tr>
                    <td><h6>PADRE/MADRE/TUTOR</h6></td>
                    <td><?php $ids_padres = mysqli_query($con, "SELECT id_usuario_padre FROM usuario_usuario WHERE id_usuario_nino = '".$row['id']."';");
                        while ($padre = mysqli_fetch_array($ids_padres)){
                            $info_padre = mysqli_query($con, "SELECT *
                                                                        FROM usuario
                                                                        WHERE id = '".$padre['id_usuario_padre']."';");
                            while ($row4 = mysqli_fetch_array($info_padre)){ ?>
                                <ul class="list-unstyled">
                                    <li><b><?php echo $row4['nombre'].' '.$row4['apellidos']; ?></b>
                                        <ul>
                                            <?php if($row4['dni']) { ?>
                                                <li>DNI:  <?php echo $row4['dni']; ?></li>
                                            <?php } ?>
                                            <?php
                                            $datosPadre = mysqli_query($con, "SELECT tipo_dato, dato 
                                                                                        from(SELECT D.id_usuario ,TD.tipo_dato, D.dato
                                                                                                FROM datos D 
                                                                                                INNER JOIN tipo_dato TD ON TD.id = D.id_tipo_dato) as X 
                                                                                        where X.id_usuario = '".$row4['id']."'");

                                            while ($dato = mysqli_fetch_array($datosPadre)){ ?>
                                                <li> <?php echo $dato['tipo_dato']?>: <?php echo $dato['dato'] ?> </li>
                                            <?php }?>
                                        </ul>
                                    </li>
                                </ul>
                            <?php }
                        } ?>
                    </td>
                </tr>
                <tr>
                    <td><h6>HERMANO/A/OS/AS</h6></td>
                    <td><?php $ids_padres2 = mysqli_query($con, "SELECT id_usuario_padre FROM usuario_usuario WHERE id_usuario_nino = '".$row['id']."';");
                        $query = "select distinct U.* 
                                        from usuario U 
                                        inner join usuario_usuario UU
                                        on U.id = UU.id_usuario_nino
                                        where U.id != '".$row['id']."' and (";
                        $first = true;
                        while ($padre = mysqli_fetch_array($ids_padres2)){
                            $id_padre = $padre['id_usuario_padre'];
                            if ($first){
                                $query = $query." UU.id_usuario_padre = '".$id_padre."'";
                                $first = false;
                            } else {
                                $query = $query. " or UU.id_usuario_padre = '" . $id_padre . "'";
                            }
                        }
                        $query = $query.");";
                        $hermanos = mysqli_query($con, $query);
                        if ($hermanos) {
                            while ($hermano = mysqli_fetch_array($hermanos)) { ?>
                                <ul class="list-unstyled">
                                    <li><b><?php echo $hermano['nombre'] . ' ' . $hermano['apellidos']; ?></b>
                                        <ul>
                                            <?php if ($hermano['dni']) { ?>
                                                <li>DNI: <?php echo $hermano['dni']; ?></li>
                                            <?php } ?>
                                            <?php
                                            $datosHermano = mysqli_query($con, "SELECT tipo_dato, dato 
                                                                                                        from(SELECT D.id_usuario ,TD.tipo_dato, D.dato
                                                                                                                FROM datos D 
                                                                                                                INNER JOIN tipo_dato TD ON TD.id = D.id_tipo_dato) as X 
                                                                                                        where X.id_usuario = '" . $hermano['id'] . "'");

                                            while ($dato = mysqli_fetch_array($datosHermano)) { ?>
                                                <li> <?php echo $dato['tipo_dato'] ?>
                                                    : <?php echo $dato['dato'] ?> </li>
                                            <?php }
                                            $sector_hermano = mysqli_query($con, "SELECT *
                                                                                            FROM (  SELECT USTU.id_usuario, S.sector, TU.tipo_usuario, USTU.ano
                                                                                                    FROM usuario_sector_tipo_usuario USTU
                                                                                                    INNER JOIN sector S
                                                                                                    ON S.id = USTU.id_sector
                                                                                                    INNER JOIN tipo_usuario TU
                                                                                                    ON TU.id = USTU.id_tipo_usuario) as X
                                                                                            where X.id_usuario = '" . $hermano['id'] . "' and X.ano = '" . $_SESSION['ano_actual'] . "'
                                                                                            order by X.ano;");
                                            if ($row = mysqli_fetch_array($sector_hermano)) {
                                                if ($row['tipo_usuario'] == 'monitor') { ?>
                                                    <li><?php echo $row['sector'] . ' (monitor)' ?></li>
                                                <?php } else { ?>
                                                    <li><?php echo $row['sector'] ?></li>
                                                <?php } ?>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                </ul>
                            <?php }
                        }?>
                    </td>
                </tr>
            <?php }
            if($tipo == '3' || $tipo == '4' || $tipo == '5'){ ?>
                <tr>
                    <td><h6>HIJO/S</h6></td>
                    <td><?php $ids_hijos = mysqli_query($con, "SELECT id_usuario_nino FROM usuario_usuario WHERE id_usuario_padre = '".$row['id']."';");
                        while ($hijo = mysqli_fetch_array($ids_hijos)){
                            $info_hijo = mysqli_query($con, "SELECT *
                                                                    FROM usuario
                                                                    WHERE id = '".$hijo['id_usuario_nino']."';");
                            while ($row6 = mysqli_fetch_array($info_hijo)){ ?>
                                <ul class="list-unstyled">
                                    <li><b><?php echo $row6['nombre'].' '.$row6['apellidos']; ?></b>
                                        <ul>
                                            <?php if($row6['dni']) { ?>
                                                <li>DNI:  <?php echo $row6['dni']; ?></li>
                                            <?php } ?>
                                            <?php
                                            $datosHijo = mysqli_query($con, "SELECT tipo_dato, dato 
                                                                                    from(SELECT D.id_usuario ,TD.tipo_dato, D.dato
                                                                                            FROM datos D 
                                                                                            INNER JOIN tipo_dato TD ON TD.id = D.id_tipo_dato) as X 
                                                                                    where X.id_usuario = '".$row6['id']."'");
                                            while ($dato = mysqli_fetch_array($datosHijo)){ ?>
                                                <li> <?php echo $dato['tipo_dato']?>: <?php echo $dato['dato'] ?> </li>
                                            <?php }
                                            $sector_hijo = mysqli_query($con, "SELECT *
                                                                                            FROM (  SELECT USTU.id_usuario, S.sector, TU.tipo_usuario, USTU.ano
                                                                                                    FROM usuario_sector_tipo_usuario USTU
                                                                                                    INNER JOIN sector S
                                                                                                    ON S.id = USTU.id_sector
                                                                                                    INNER JOIN tipo_usuario TU
                                                                                                    ON TU.id = USTU.id_tipo_usuario) as X
                                                                                            where X.id_usuario = '".$row6['id']."' and X.ano = '".$_SESSION['ano_actual']."'
                                                                                            order by X.ano;");
                                            if ($row7 = mysqli_fetch_array($sector_hijo)) {
                                                if ($row7['tipo_usuario'] == 'monitor') {?>
                                                    <li><?php echo $row7['sector'].' (monitor)' ?></li>
                                                <?php } else { ?>
                                                    <li><?php echo $row7['sector'] ?></li>
                                                <?php } ?>
                                            <?php }?>
                                        </ul>
                                    </li>
                                </ul>
                            <?php }
                        } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

<?php } ?>