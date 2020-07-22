<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!--script src="public/js/jquery.tabledit.js"></script-->
<?php
/*function deshabilitarUsuario(idUsuario) {
    $.post("view/scripts/deshabilitarUsuario.php", {id: idUsuario}, function(dato){
        id = dato;
        console.log(ids);
        var lenghtIds = ids.length;
        for (var i = 0; i<lenghtIds ;i++){
            $("#"+ids[i]).attr('checked', 'true');
        }
        });
    }*/
?>
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
    <script type="application/javascript">
        $(function(){
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
    </script>
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
                            <th>DNI</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Fecha nacimiento</th>
                            <th>Sector</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while($row= mysqli_fetch_array($consultaUsuarios)){
                            $sectorUser = mysqli_query($con, "SELECT S.sector
                                                                        from sector S
                                                                        inner join usuario_sector_tipo_usuario USTU
                                                                        on S.id = USTU.id_sector
                                                                        where USTU.id_usuario = '" . $row['id'] . "' and USTU.ano = '" . $_SESSION['ano_actual'] . "';");
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
                                <td><?php echo $row['fecha_nacimiento'] ?></td>
                                <td><?php echo $txt_sector; ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#verUsuario"><i class="fas fa-eye"></i></button>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editarUsuario"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#eliminarUsuario<?php echo $row['id'];?>" id="borrarUsuario(<?php echo $row['id'];?>)"><i class="fas fa-trash"></i></button>
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

<!-- Modal -->
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
                <form action="view/scripts/guardarUsuarioBD.php" method="post" name="formCrearUsuario" id="formCrearUsuario">
                    <table class="table">
                        <script type="text/javascript">
                            function mostrarReferencia(){
                                $(".tiposUsuarios").removeAttr('checked');
                                if (document.formCrearUsuario.monitor.checked == true) {
                                    document.getElementById('enfermedades').style.display='';
                                } else {
                                    document.getElementById('enfermedades').style.display='none';
                                }
                            }
                            -->
                        </script>
                        <tr valign="top" id="tipo_usuario">
                            <td>Tipo de usuario: </td>
                            <td>
                                <?php $tipos = mysqli_query($con, "SELECT * FROM tipo_usuario");
                                while ($tipo = mysqli_fetch_array($tipos)){ ?>
                                    <div class="tiposUsuarios">
                                        <input type="radio" name="<?php echo $tipo['tipo_usuario']; ?>" value="<?php echo $tipo['tipo_usuario']; ?>" id="<?php echo $tipo['tipo_usuario']; ?>" onclick="mostrarReferencia();">
                                        <label for="dewey"><?php echo $tipo['tipo_usuario']; ?></label>
                                    </div>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr id="dni">
                            <td>DNI: </td>
                            <td><input type="text" name="dni" id="dni"/></td>
                        </tr>
                        <tr id="nombre">
                            <td>Nombre: </td>
                            <td><input type="text" name="nombre" id="nombre" autofocus required/></td>
                        </tr>
                        <tr>
                            <td>Apellidos: </td>
                            <td><input type="text" name="apellidos" id="apellidos" required/></td>
                        </tr>
                        <tr id="fecha_nacimiento">
                            <td>Fecha de nacimiento: </td>
                            <td><input type="date" name="fecha_nacimiento" id="fecha_nacimiento"></td>
                        </tr>
                        <tr>
                            <td>Dato/s: </td>
                            <td>
                                <table class="table-borderless">
                                    <tr id="datoOriginal" hidden>
                                        <td>
                                            <select>
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
                                <script type="application/javascript">
                                    $(function () {
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
                                    });
                                </script>
                            </td>
                        </tr>
                        <tr id="enfermedades" style="display:none;">
                            <td>Enfermedades: </td>
                            <td>
                                <select name="selectTipo" id="selectTipo" multiple>
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
                                <select name="selectPadre" id="selectPadre" multiple>
                                    <option value="" selected></option>
                                    <?php $padres = mysqli_query($con, "select distinct U.id U.nombre, U.apellidos
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
                        <tr id="hijos" style="display:none;">
                            <td>Hijos: </td>
                            <td>
                                <select name="selectHijo" id="selectHijo" multiple>
                                    <option value="" selected></option>
                                    <?php $hijos = mysqli_query($con, "select distinct U.id U.nombre, U.apellidos
                                                                                from usuario U
                                                                                inner join usuario_sector_tipo_usuario USTU
                                                                                on U.id = USTU.id_usuario
                                                                                where USTU.id_tipo_usuario = '1' || USTU.id_tipo_usuario = '2';");
                                    while ($hijo = mysqli_fetch_array($hijos)){ ?>
                                        <option value="<?php echo $hijo['id']; ?>"><?php echo $hijo['nombre'].' '.$hijo['apellidos']; ?></option>
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
<!-- -------------------------------ELIMINAR USUARIO ----------------------------------------------- -->
<div class="modal fade" id="eliminarUsuario<?php echo $row['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Eliminar usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p style="color:red;">Vas a eliminar el usuario. ¿Estás seguro?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-danger" onclick="deshabilitarUsuario(<?php echo $row['id'];?>)">Borrar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>