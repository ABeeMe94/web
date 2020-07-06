<div class="container">
    <div class="jumbotron text-center">
        <h1>INFORMACIÓN DEL USUARIO</h1>
    </div>
    <div class="jumbotron">
        <div class="row">
            <div class="col-4">
                <img class="img-fluid rounded-circle" src="public/img-contacto/<?php echo $_SESSION['usr_url_foto'] ?>">
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
                        <tr>
                            <td><h6>FECHA DE NACIMIENTO</h6></td>
                            <td><?php echo $_SESSION['usr_fecha'] ?></td>
                        </tr>
                        <tr>
                            <td><h6>USUARIO</h6></td>
                            <td><?php echo $_SESSION['usr_usuario'] ?></td>
                        </tr>
                        <tr>
                            <td><h6>SECTOR</h6></td>
                            <td><?php echo $_SESSION['usr_sector'] ?></td>
                        </tr>
                        <tr>
                            <td><h6>DATOS</h6></td>
                            <td><?php $datos = mysqli_query($con, "SELECT tipo_dato, dato 
                                                                          from(SELECT D.id_usuario ,TD.tipo_dato, D.dato
                                                                                  FROM datos D 
                                                                                  INNER JOIN tipo_dato TD ON TD.id = D.id_tipo_dato) as X 
                                                                          where X.id_usuario = '".$_SESSION['usr_id']."'");
                                while ($dato = mysqli_fetch_array($datos)){
                                    echo $dato['tipo_dato']?>: <?php echo $dato['dato'] ?> </br>
                                <?php }?>
                            </td>
                        </tr>
                        <tr>
                        <td><h6>ENFERMEDADES</h6></td>
                        <td><?php $enfermedades = mysqli_query($con, "SELECT nombre
                                                                            from (SELECT U.id, E.nombre 
                                                                                    FROM usuario U
                                                                                    INNER JOIN usuario_enfermedad UE ON UE.id_usuario = U.id 
                                                                                    INNER JOIN enfermedad E ON E.id = UE.id_enfermedad) as E 
                                                                            where E.id = '".$_SESSION['usr_id']."'");?>
                            <ul>
                                <?php
                                while ($enfermedad = mysqli_fetch_array($enfermedades)){ ?>
                                    <li><?php echo $enfermedad['nombre'] ?></li>
                                <?php } ?>
                            </ul>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>