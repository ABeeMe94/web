<div class="container">
    <div class="jumbotron text-center">
        <h1>INFORMACIÓN DEL USUARIO</h1>
    </div>
    <div class="jumbotron">
        <div class="row">
            <div class="col-4">
                <?php if($_SESSION['usr_url_foto']){ ?>
                    <div class="img-container">
                        <img class="img-fluid rounded-circle" style="border:5px solid black;" src="public/img-contacto/<?php echo $_SESSION['usr_url_foto'] ?>">
                    </div>
                <?php } else { ?>
                    <div class="img-container">
                        <img class="img-fluid rounded-circle" style="border:5px solid black;" src="public/img-contacto/imagen.png">
                    </div>
                <?php } ?>
            </div>
            <div class="col-8">
                <table class="table table-striped col-12">
                    <tbody>
                        <tr>
                            <td><h6>NOMBRE</h6></td>
                            <td><?php echo $_SESSION['usr_nombre'] ?></td>
                        </tr>
                        <tr>
                            <td><h6>APELLIDOS</h6></td>
                            <td><?php echo $_SESSION['usr_apellidos'] ?></td>
                        </tr>
                        <tr>
                            <td><h6>DNI</h6></td>
                            <td><?php echo $_SESSION['usr_dni'] ?></td>
                        </tr>
                        <?php if($_SESSION['usr_id_tipo'] == '1' || $_SESSION['usr_id_tipo'] == '2') { ?>
                        <tr>
                            <td><h6>FECHA DE NACIMIENTO</h6></td>
                            <td><?php echo $_SESSION['usr_fecha'] ?></td>
                        </tr>
                        <?php } ?>
                        <?php if($_SESSION['usr_id_tipo'] == '1' || $_SESSION['usr_id_tipo'] == '2') { ?>
                        <tr>
                            <td><h6>SECTOR</h6></td>
                            <td><?php echo $_SESSION['usr_sector'] ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td><h6>DATOS</h6></td>
                            <td><?php
                                foreach ($_SESSION['usr_datos'] as $dato){
                                    echo $dato['tipo_dato']?>: <?php echo $dato['dato'] ?> </br>
                                <?php }?>
                            </td>
                        </tr>
                        <?php if($_SESSION['usr_id_tipo'] == '1' || $_SESSION['usr_id_tipo'] == '2') { ?>
                        <tr>
                            <td><h6>ENFERMEDADES</h6></td>
                            <td>
                                <ul>
                                    <?php
                                    if (isset($_SESSION['usr_enfermedades'])) {
                                        foreach ($_SESSION['usr_enfermedades'] as $enfermedad) { ?>
                                            <li><?php echo $enfermedad ?></li>
                                        <?php }
                                    }?>
                                </ul>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php if($_SESSION['usr_id_tipo'] == '1' || $_SESSION['usr_id_tipo'] == '2' || $_SESSION['usr_id_tipo'] == ''){ ?>
                        <tr>
                            <td><h6>PADRE/MADRE/TUTOR</h6></td>
                            <td><?php $ids_padres = mysqli_query($con, "SELECT id_usuario_padre FROM usuario_usuario WHERE id_usuario_nino = '".$_SESSION['usr_id']."';");
                                while ($padre = mysqli_fetch_array($ids_padres)){
                                    $info_padre = mysqli_query($con, "SELECT * FROM usuario WHERE id = '".$padre['id_usuario_padre']."';");
                                    while ($row = mysqli_fetch_array($info_padre)){ ?>
                                        <ul class="list-unstyled">
                                            <li><b><?php echo $row['nombre'].' '.$row['apellidos']; ?></b>
                                                <ul>
                                                    <?php if($row['dni']) { ?>
                                                        <li>DNI:  <?php echo $row['dni']; ?></li>
                                                    <?php } ?>
                                                    <?php
                                                    $datosPadre = mysqli_query($con, "SELECT tipo_dato, dato from(SELECT D.id_usuario ,TD.tipo_dato, D.dato FROM datos D INNER JOIN tipo_dato TD ON TD.id = D.id_tipo_dato) as X where X.id_usuario = '".$row['id']."'");
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
                            <td><?php $ids_padres2 = mysqli_query($con, "SELECT id_usuario_padre FROM usuario_usuario WHERE id_usuario_nino = '".$_SESSION['usr_id']."';");
                                $query = "select distinct U.* from usuario U inner join usuario_usuario UU on U.id = UU.id_usuario_nino where U.id != '".$_SESSION['usr_id']."' and (";
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
                                                    $datosHermano = mysqli_query($con, "SELECT tipo_dato, dato from(SELECT D.id_usuario ,TD.tipo_dato, D.dato FROM datos D INNER JOIN tipo_dato TD ON TD.id = D.id_tipo_dato) as X where X.id_usuario = '" . $hermano['id'] . "'");

                                                    while ($dato = mysqli_fetch_array($datosHermano)) { ?>
                                                        <li> <?php echo $dato['tipo_dato'] ?>: <?php echo $dato['dato'] ?> </li>
                                                    <?php }
                                                    $sector_hermano = mysqli_query($con, "SELECT * FROM (SELECT USTU.id_usuario, S.sector, TU.tipo_usuario, USTU.ano FROM usuario_sector_tipo_usuario USTU INNER JOIN sector S ON S.id = USTU.id_sector INNER JOIN tipo_usuario TU ON TU.id = USTU.id_tipo_usuario) as X where X.id_usuario = '" . $hermano['id'] . "' and X.ano = '" . $_SESSION['ano_actual'] . "' order by X.ano;");
                                                    if ($row = mysqli_fetch_array($sector_hermano)) {
                                                        if ($row['tipo_usuario'] == 'monitor') { ?>
                                                            <li>Sector: <?php echo $row['sector'] . ' (monitor)' ?></li>
                                                        <?php } else { ?>
                                                            <li>Sector: <?php echo $row['sector'] ?></li>
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
                         if($_SESSION['usr_id_tipo'] == '3' || $_SESSION['usr_id_tipo'] == '4' || $_SESSION['usr_id_tipo'] == '5'){ ?>
                        <tr>
                            <td><h6>HIJO/S</h6></td>
                            <td><?php $ids_hijos = mysqli_query($con, "SELECT id_usuario_nino FROM usuario_usuario WHERE id_usuario_padre = '".$_SESSION['usr_id']."';");
                                while ($hijo = mysqli_fetch_array($ids_hijos)){
                                    $info_hijo = mysqli_query($con, "SELECT * FROM usuario WHERE id = '".$hijo['id_usuario_nino']."';");
                                    while ($row = mysqli_fetch_array($info_hijo)){ ?>
                                        <ul class="list-unstyled">
                                            <li><b><?php echo $row['nombre'].' '.$row['apellidos']; ?></b>
                                                <ul>
                                                    <?php if($row['dni']) { ?>
                                                        <li>DNI:  <?php echo $row['dni']; ?></li>
                                                    <?php } ?>
                                                    <?php
                                                    $datosHijo = mysqli_query($con, "SELECT tipo_dato, dato from(SELECT D.id_usuario ,TD.tipo_dato, D.dato FROM datos D INNER JOIN tipo_dato TD ON TD.id = D.id_tipo_dato) as X where X.id_usuario = '".$row['id']."'");
                                                    while ($dato = mysqli_fetch_array($datosHijo)){ ?>
                                                        <li> <?php echo $dato['tipo_dato']?>: <?php echo $dato['dato'] ?> </li>
                                                    <?php }
                                                    $sector_hijo = mysqli_query($con, "SELECT * FROM (SELECT USTU.id_usuario, S.sector, TU.tipo_usuario, USTU.ano FROM usuario_sector_tipo_usuario USTU INNER JOIN sector S ON S.id = USTU.id_sector INNER JOIN tipo_usuario TU ON TU.id = USTU.id_tipo_usuario) as X where X.id_usuario = '".$row['id']."' and X.ano = '".$_SESSION['ano_actual']."' order by X.ano;");
                                                    if ($row = mysqli_fetch_array($sector_hijo)) {
                                                        if ($row['tipo_usuario'] == 'monitor') {?>
                                                            <li>Sector: <?php echo $row['sector'].' (monitor)' ?></li>
                                                        <?php } else { ?>
                                                            <li>Sector: <?php echo $row['sector'] ?></li>
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
        </div>
    </div>
</div>