<div class="container">
    <div class="jumbotron text-center">
        <h1>INFORMACIÓN DEL USUARIO</h1>
    </div>
    <div class="jumbotron">
        <table class="table table-striped">
            <tbody>
                <?php $sql = mysqli_query($con, "SELECT * FROM usuario where id_usuario='".$_SESSION['usr_id']."'");
                while ($row = mysqli_fetch_array($sql)){ ?>
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
                    <tr>
                        <td><h6>FECHA DE NACIMIENTO</h6></td>
                        <td><?php echo $row['fecha_nacimiento'] ?></td>
                    </tr>
                    <tr>
                        <td><h6>USUARIO</h6></td>
                        <td><?php echo $row['usuario'] ?></td>
                    </tr>
                    <tr>
                        <td><h6>SECTORES</h6></td>
                        <td>
                            <?php $sectores = mysqli_query($con, "SELECT *
                            FROM usuario_sector US
                            INNER JOIN usuario U
                            ON U.id_usuario = US.id_usuario");
                            while ($sector = mysqli_fetch_array($sectores)){
                                echo $sector['nombre']; ?>
                            <br>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td><h6>DATOS</h6></td>
                        <td><?php $datos = mysqli_query($con, "SELECT tipo_dato, dato 
                                            from(SELECT UD.id_usuario_dato,TD.tipo_dato,D.dato 
                                                    FROM dato D 
                                                    INNER JOIN tipo_dato TD ON TD.id_tipo_dato = D.id_tipo_dato 
                                                    INNER JOIN usuario_dato UD ON UD.id_dato = D.id_dato) as X 
                                            where X.id_usuario_dato = '".$_SESSION['usr_id']."'");
                                while ($dato = mysqli_fetch_array($datos)){
                                    echo $dato['tipo_dato']?>: <?php echo $dato['dato'] ?> </br>
                                <?php }?>
                        </td>
                    </tr>
                    <tr>
                        <td><h6>ENFERMEDADES</h6></td>
                        <td><?php $enfermedades = mysqli_query($con, "SELECT enfermedad 
                                                    from (SELECT U.id_usuario,U.nombre, U.apellidos, E.enfermedad 
                                                            FROM usuario U 
                                                            INNER JOIN usuario_enfermedad UE ON UE.id_usuario = U.id_usuario 
                                                            INNER JOIN enfermedad E ON E.id_enfermedad = UE.id_enfermedad) as E 
                                                    where E.id_usuario = '".$_SESSION['usr_id']."'");?>
                            <ul>
                            <?php
                            while ($enfermedad = mysqli_fetch_array($enfermedades)){ ?>
                                <li><?php echo $enfermedad['enfermedad'] ?></li>
                            <?php } ?>
                            </ul>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>