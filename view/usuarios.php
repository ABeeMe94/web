<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script type="application/javascript">
function deshabilitarUsuario(idUsuario) {
    swal({
        title: "¿Esta seguro de deshabilitar el usuario?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.post("view/scripts/deshabilitarUsuario.php", {id: idUsuario}, function (dato) {
                swal(dato, {
                    icon: "success",
                });
                setTimeout(function(){
                    window.location.reload(1);
                }, 5000);
            });
        } else {
            swal("No se ha deshabilitado el usuario");
            setTimeout(function(){
                window.location.reload(1);
            }, 5000);
        }
    });
};
function verUsuario(idUsuario) {
    var idUser = idUsuario;
    $.post("view/scripts/verUsuario.php", {id: idUser}, function(datos){
        $("#resultadoBusqueda").html(datos);
    });
    console.log(idUser);
};
function mostrar2(id) {
    console.log(id);
    if (id == "") {
        $("#sector2").hide();
        $("#fecha_nacimiento2").hide();
        $("#enfermedades2").hide();
        $("#padres2").hide();
    }
    if (id == "1" || id == "2") {
        $("#sector2").show();
        $("#fecha_nacimiento2").show();
        $("#enfermedades2").show();
        $("#padres2").show();
    }
    if (id == "3" || id == "4" || id == "5") {
        $("#sector2").hide();
        $("#fecha_nacimiento2").hide();
        $("#enfermedades2").hide();
        $("#padres2").hide();
    }
    if (id == "7" || id == "6" || id == "8") {
        $("#sector2").hide();
        $("#fecha_nacimiento2").hide();
        $("#enfermedades2").hide();
        $("#padres2").hide();
    }
};
function getValueTipo() {
    var id = $('#status2').val();
    mostrar2(id);
};
function editarUsuario(idUsuario) {
    var idUser = idUsuario;
    $.post("view/scripts/editarUsuario.php", {id: idUser}, function(datos){
        $("#resultadoBusquedaEditar").html(datos);
        getValueTipo();
    });
};
$(function(){
    $(document).on('click', '.borrar', function (event) {
        event.preventDefault();
        $(this).closest('tr').remove();
    });
    $(document).on('click', '.anadir', function (event) {
        var clone = $('#datoOriginal').clone();
        clone.removeAttr('hidden');
        clone.removeAttr('id');
        clone.find("select").attr("name", "selectTipoDato[]");
        clone.find("input").attr("name", "dato[]");
        clone.appendTo('#datoClonado');
    });
    var $tabla = $('#usuarios');
    $('#selectTipo').change(function(){
        var value = $(this).val();
        value = value.replace(/ /g, "_");
        console.log(value);
        if (value){
            $('tbody tr.' + value, $tabla).show();
            $('tbody tr:not(.' + value + ')', $tabla).hide();
        }
        else{
            // Se ha seleccionado All
            $('tbody tr', $tabla).show();
        }
    });
});
function mostrar(id) {
    if (id == "") {
        $("#sector").hide();
        $("#fecha_nacimiento").hide();
        $("#enfermedades").hide();
        $("#padres").hide();
    }
    if (id == "1" || id == "2") {
        $("#sector").show();
        $("#fecha_nacimiento").show();
        $("#enfermedades").show();
        $("#padres").show();
    }
    if (id == "3" || id == "4" || id == "5") {
        $("#sector").hide();
        $("#fecha_nacimiento").hide();
        $("#enfermedades").hide();
        $("#padres").hide();
    }
    if (id == "7" || id == "6" || id == "8") {
        $("#sector").hide();
        $("#fecha_nacimiento").hide();
        $("#enfermedades").hide();
        $("#padres").hide();
    }
}
</script>

<div class="container">
    <div class="jumbotron text-center">
        <div class="row">
            <div class="col-11">
                <h1>USUARIOS</h1>
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crearUsuario"><i class="fas fa-plus-circle"></i></button>
            </div>
        </div>
    </div>
    <div class="text-right">
        <span>SECTORES: </span>
        <select id="selectTipo">
            <option value="">TODOS</option>
            <?php $sectores = mysqli_query($con, "SELECT * FROM sector");
            while ($sector = mysqli_fetch_array($sectores)){ ?>
                <option value="<?php echo $sector['sector']; ?>"><?php echo $sector['sector']; ?></option>
            <?php }?>
        </select>
    </div><br>
    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <?php $consultaUsuarios = mysqli_query($con, "SELECT * FROM usuario where estado_activo=1 order by apellidos;"); ?>
            <div class="table-responsive">
                <div class="jumbotron">
                    <table class="table table-dark table-bordered table-striped" id="usuarios">
                        <thead>
                        <tr>
                            <th style="width: 10%;">DNI</th>
                            <th style="width: 15%;">Nombre</th>
                            <th style="width: 15%;">Apellidos</th>
                            <th style="width: 32%;">Datos</th>
                            <th style="width: 10%;">Sector</th>
                            <th style="width: 20%;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while($row= mysqli_fetch_array($consultaUsuarios)){
                            $sectorUser = mysqli_query($con, "SELECT S.sector from sector S inner join usuario_sector_tipo_usuario USTU on S.id = USTU.id_sector where USTU.id_usuario = '".$row['id']."' and USTU.ano = '".$_SESSION['ano_actual']."';");
                            $txt_class ="";
                            $txt_sector ="";
                            if ($row2 = mysqli_fetch_array($sectorUser)){
                                $txt_sector = $row2['sector'];
                                $txt_class = str_replace(' ', '_', $txt_sector);
                            }?>
                            <tr class="<?php echo $txt_class ?>" id="<?php echo $row['id'];?>"">
                                <td><?php echo $row['dni'] ?></td>
                                <td><?php echo $row['nombre'] ?></td>
                                <td><?php echo $row['apellidos'] ?></td>
                                <td>
                                    <?php
                                    $datos = mysqli_query($con, "SELECT tipo_dato, dato from(SELECT D.id_usuario ,TD.tipo_dato, D.dato FROM datos D INNER JOIN tipo_dato TD ON TD.id = D.id_tipo_dato) as X where X.id_usuario = '".$row['id']."';");
                                    $datosArray = array();
                                    while ($dato = mysqli_fetch_array($datos)){
                                        array_push($datosArray, $dato);
                                    }
                                    $datosUsuario['usr_datos'] = $datosArray;
                                    foreach ($datosUsuario['usr_datos'] as $dato){
                                        if ($dato['tipo_dato'] == 'email'){
                                            echo $dato['tipo_dato']?>: <a style="color: cadetblue;" href="mailto:<?php echo $dato['dato'] ?>"><?php echo $dato['dato'] ?></a></br>
                                        <?php } else {
                                            echo $dato['tipo_dato']?>: <?php echo $dato['dato'] ?> </br>
                                        <?php }
                                    }?>
                                </td>
                                <td><?php echo $txt_sector; ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#verUsuario" value="<?php echo $row['id'];?>" onclick="verUsuario(<?php echo $row['id'];?>)"><i class="fas fa-eye"></i></button>
                                    <?php $queryTipoUser = "select id_tipo_usuario from usuario_sector_tipo_usuario where id_usuario= '".$row['id']."' and ano = '".$_SESSION['ano_actual']."';";
                                    $idTipoUsuarioConsulta = mysqli_query($con, $queryTipoUser);
                                    if ($idTipoUsuario = mysqli_fetch_array($idTipoUsuarioConsulta)){
                                        if($_SESSION['usr_id_tipo'] == '6'){ ?>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editarUsuario" value="<?php echo $row['id'];?>" onclick="editarUsuario(<?php echo $row['id'];?>)"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-danger" data-toggle="modal" data-target="#eliminarUsuario" onclick="deshabilitarUsuario(<?php echo $row['id'];?>)"><i class="fas fa-trash"></i></button>
                                    <?php } else if($_SESSION['usr_id_tipo'] == '7') {
                                            if ($idTipoUsuario['id_tipo_usuario'] == 6) { ?>
                                                <button type="button" disabled class="btn btn-primary" data-toggle="modal" data-target="#editarUsuario" value="<?php echo $row['id'];?>" onclick="editarUsuario(<?php echo $row['id'];?>)"><i class="fas fa-edit"></i></button>
                                                <button disabled class="btn btn-danger" data-toggle="modal" data-target="#eliminarUsuario" onclick="deshabilitarUsuario(<?php echo $row['id'];?>)"><i class="fas fa-trash"></i></button>
                                            <?php } else { ?>
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editarUsuario" value="<?php echo $row['id'];?>" onclick="editarUsuario(<?php echo $row['id'];?>)"><i class="fas fa-edit"></i></button>
                                                <button class="btn btn-danger" data-toggle="modal" data-target="#eliminarUsuario" onclick="deshabilitarUsuario(<?php echo $row['id'];?>)"><i class="fas fa-trash"></i></button>
                                            <?php }
                                        } else {
                                            if ($idTipoUsuario['id_tipo_usuario'] == 6 || $idTipoUsuario['id_tipo_usuario'] == 7) { ?>
                                                <button type="button" disabled class="btn btn-primary" data-toggle="modal" data-target="#editarUsuario" value="<?php echo $row['id']; ?>" onclick="editarUsuario(<?php echo $row['id']; ?>)"><i class="fas fa-edit"></i></button>
                                                <button disabled class="btn btn-danger" data-toggle="modal" data-target="#eliminarUsuario" onclick="deshabilitarUsuario(<?php echo $row['id']; ?>)"><i class="fas fa-trash"></i></button>
                                            <?php } else{ ?>
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editarUsuario" value="<?php echo $row['id'];?>" onclick="editarUsuario(<?php echo $row['id'];?>)"><i class="fas fa-edit"></i></button>
                                                <button class="btn btn-danger" data-toggle="modal" data-target="#eliminarUsuario" onclick="deshabilitarUsuario(<?php echo $row['id'];?>)"><i class="fas fa-trash"></i></button>
                                            <?php }
                                        }
                                    } else {?>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editarUsuario" value="<?php echo $row['id'];?>" onclick="editarUsuario(<?php echo $row['id'];?>)"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-danger" data-toggle="modal" data-target="#eliminarUsuario" onclick="deshabilitarUsuario(<?php echo $row['id'];?>)"><i class="fas fa-trash"></i></button>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- -------------------------------------------------------- Modal Nuevo ----------------------------------------------------------- -->
<div class="modal fade bd-example-modal-lg" id="crearUsuario" tabindex="-1" role="dialog" aria-labelledby="crearUsuario" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Crear usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="view/scripts/guardarUsuarioBD.php" method="post" name="formCrearUsuario" id="formCrearUsuario" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-3"></div>
                        <div class="col-6">
                            <input type="file" name="picture" id="fileInput"/>
                        </div>
                        <div class="col-3"></div>
                    </div>
                    <br>
                    <table class="table">
                        <?php if($_SESSION['usr_id_tipo'] == '6') {
                            $tipos = mysqli_query($con, "SELECT * FROM tipo_usuario;");
                        } else if ($_SESSION['usr_id_tipo'] == '7') {
                            $tipos = mysqli_query($con, "SELECT * FROM tipo_usuario WHERE id != 6;");
                        }else {
                            $tipos = mysqli_query($con, "SELECT * FROM tipo_usuario WHERE id != 6 AND id != 7 AND id!= 8;");
                        }?>
                        <tr>
                            <td>Tipo de usuario: </td>
                            <td>
                                <form action="./" method="post">
                                    <select id="status" name="status" onChange="mostrar(this.value);" required>
                                        <option value=""></option>
                                        <?php while ($tipo = mysqli_fetch_array($tipos)){ ?>
                                            <option value="<?php echo $tipo['id']; ?>"><?php echo $tipo['tipo_usuario']; ?></option>
                                        <?php } ?>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        <tr id="dni">
                            <td>DNI (sin letra): </td>
                            <td><input type="text" name="dni" id="dni" maxlength="8" required/></td>
                        </tr>
                        <tr id="nombre">
                            <td>Nombre: </td>
                            <td><input type="text" name="nombre" id="nombre" autofocus required/></td>
                        </tr>
                        <tr id="apellidos">
                            <td>Apellidos: </td>
                            <td><input type="text" name="apellidos" id="apellidos" required/></td>
                        </tr>
                        <tr id="sector" style="display: none;">
                            <td>Sector: </td>
                            <td>
                                <select id="selectSector" name="sector">
                                    <option value=""></option>
                                    <?php $sectores = mysqli_query($con, "SELECT * FROM sector");
                                    while ($sector = mysqli_fetch_array($sectores)){ ?>
                                        <option value="<?php echo $sector['id']; ?>"><?php echo $sector['sector']; ?></option>
                                    <?php }?>
                                </select>
                            </td>
                        </tr>
                        <tr id="password">
                            <td>Password: </td>
                            <td><input type="password" name="password" id="password" required/></td>
                        </tr>
                        <tr id="fecha_nacimiento" style="display: none;">
                            <td>Fecha de nacimiento: </td>
                            <td><input type="date" name="fecha_nacimiento" id="fecha_nacimiento"></td>
                        </tr>
                        <tr id="datos">
                            <td>Dato/s: </td>
                            <td>
                                <table class="table-borderless">
                                    <tr id="datoOriginal" hidden>
                                        <td>
                                            <select>
                                                <option value=""></option>
                                                <?php $tiposDatos = mysqli_query($con, "SELECT * FROM tipo_dato");
                                                while ($tipoDato = mysqli_fetch_array($tiposDatos)){ ?>
                                                    <option value="<?php echo $tipoDato['id']; ?>"><?php echo $tipoDato['tipo_dato']; ?></option>
                                                <?php }?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text"/>
                                        </td>
                                        <td>
                                            <input type="button" id="borrar" class="borrar btn-outline-danger" value="X" />
                                        </td>
                                    </tr>
                                    <div id="datoClonado"></div>
                                    <tr>
                                        <td>
                                            <select name="selectTipoDato[]">
                                                <option value=""></option>
                                                <?php $tiposDatos = mysqli_query($con, "SELECT * FROM tipo_dato");
                                                while ($tipoDato = mysqli_fetch_array($tiposDatos)){ ?>
                                                    <option value="<?php echo $tipoDato['id']; ?>"><?php echo $tipoDato['tipo_dato']; ?></option>
                                                <?php }?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="dato[]"/>
                                        </td>
                                        <td>
                                            <input type="button" class="anadir btn-outline-primary" value="+" />
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr id="enfermedades" style="display:none;">
                            <td>Enfermedades: </td>
                            <td>
                                <select name="selectEnfermedad[]" id="selectEnfermedad" multiple>
                                    <option value="" selected></option>
                                    <?php $enfermedades = mysqli_query($con, "SELECT * FROM enfermedad");
                                    while ($enfermedad = mysqli_fetch_array($enfermedades)){ ?>
                                        <option value="<?php echo $enfermedad['id']; ?>"><?php echo $enfermedad['nombre']; ?></option>
                                    <?php }?>
                                </select>
                            </td>
                        </tr>
                        <tr id="padres" style="display:none;">
                            <td>Padre/Madre/Tutor: </td>
                            <td>
                                <select name="selectPadre[]" id="selectPadre" multiple>
                                    <option value="" selected></option>
                                    <?php $padres = mysqli_query($con, "select distinct U.id, U.nombre, U.apellidos
                                                                                from usuario U
                                                                                inner join usuario_sector_tipo_usuario USTU
                                                                                on U.id = USTU.id_usuario
                                                                                where USTU.id_tipo_usuario = '3' || USTU.id_tipo_usuario = '4' || USTU.id_tipo_usuario = '5';");
                                    while ($padre = mysqli_fetch_array($padres)){ ?>
                                        <option value="<?php echo $padre['id']; ?>"><?php echo $padre['nombre'].' '.$padre['apellidos']; ?></option>
                                    <?php }?>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <input type="submit" name="submit" value="Añadir usuario">
                    <input type="reset" name="clear" value="Borrar">
                </form>
            </div>
        </div>
    </div>
</div>
<!-- -------------------------------------------------------- Modal ver usuario------------------------------------------------------ -->
<div class="modal fade bd-example-modal-lg" id="verUsuario" tabindex="-1" role="dialog" aria-labelledby="verUsuario" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Ver usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="resultadoBusqueda"></div>
        </div>
    </div>
</div>
<!-- -------------------------------------------------------- Modal editar usuario------------------------------------------------------ -->
<div class="modal fade bd-example-modal-lg" id="editarUsuario" tabindex="-1" role="dialog" aria-labelledby="editarUsuario" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Editar usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="resultadoBusquedaEditar"></div>
        </div>
    </div>
</div>