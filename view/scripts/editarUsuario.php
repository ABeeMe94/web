<?php
session_start();
include_once '../../scripts/conexion.php';

$id = $_REQUEST['id']; ?>
<?php $usuario = mysqli_query($con, "select * from usuario where id='".$id."';");
if ($usuario1 = mysqli_fetch_array($usuario)) { ?>
    <form action="view/scripts/actualizarUsuarioBD.php" method="post" name="formActualizarUsuario" id="formActualizarUsuario" enctype="multipart/form-data">
        <input type="hidden" name="idUsuario" value="<?php echo $id; ?>">
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
                <?php if($usuario1['url_foto']){ ?>
                    <div class="img-container">
                        <img class="img-fluid rounded-circle" style="border:5px solid black;" src="public/img-contacto/<?php echo $usuario1['url_foto'] ?>" id="imagePreview">
                    </div>
                <?php } else { ?>
                    <div class="img-container">
                        <img class="img-fluid rounded-circle" style="border:5px solid black;" src="public/img-contacto/imagen.png" id="imagePreview">
                    </div>
                <?php } ?>
            </div>
            <div class="col-4"></div>
        </div>
        <br>
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <input type="file" name="picture" id="fileInput"/>
            </div>
            <div class="col-3"></div>
        </div>
        <br>
        <div>
                <table class="table">
                    <?php if ($_SESSION['usr_id_tipo'] == '6') {
                        $tipos = mysqli_query($con, "SELECT * FROM tipo_usuario;");
                    } else if ($_SESSION['usr_id_tipo'] == '7') {
                        $tipos = mysqli_query($con, "SELECT * FROM tipo_usuario WHERE id != 6;");
                    } else {
                        $tipos = mysqli_query($con, "SELECT * FROM tipo_usuario WHERE id != 6 AND id != 7 AND id != 8;");
                    }
                    $tipoUsuario = mysqli_query($con, "select USTU.id_tipo_usuario from usuario_sector_tipo_usuario USTU inner join tipo_usuario TU on TU.id = USTU.id_tipo_usuario where USTU.id_usuario='" . $id . "';");
                    if ($row = mysqli_fetch_array($tipoUsuario)) {} ?>
                    <tr>
                        <td>Tipo de usuario: </td>
                        <td>
                            <form action="./" method="post">
                                <select id="status2" name="status2" onChange="mostrar2(this.value);" required>
                                    <option value=""></option>
                                    <?php while ($tipo = mysqli_fetch_array($tipos)){
                                        if ($tipo['id'] == $row['id_tipo_usuario']) { ?>
                                            <option value="<?php echo $tipo['id']; ?>" selected><?php echo $tipo['tipo_usuario']; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $tipo['id']; ?>"><?php echo $tipo['tipo_usuario']; ?></option>
                                        <?php }
                                    } ?>
                                </select>
                            </form>
                        </td>
                    </tr>
                    <tr id="dni2">
                        <td>DNI (sin letra): </td>
                        <td><input type="text" name="dni2" id="dni2" value="<?php echo $usuario1['dni']; ?>" maxlength="8" required/></td>
                    </tr>
                    <tr id="nombre2">
                        <td>Nombre: </td>
                        <td><input type="text" name="nombre2" id="nombre2" value="<?php echo $usuario1['nombre']; ?>" autofocus required/></td>
                    </tr>
                    <tr id="apellidos2">
                        <td>Apellidos: </td>
                        <td><input type="text" name="apellidos2" id="apellidos2" value="<?php echo $usuario1['apellidos']; ?>" required/></td>
                    </tr>
                    <tr id="sector2" style="display: none;">
                        <td>Sector: </td>
                        <td>
                            <?php $sectorUsuario = mysqli_query($con, "select USTU.id_sector from usuario_sector_tipo_usuario USTU inner join sector S on S.id = USTU.id_sector where USTU.id_usuario='" . $id . "';");
                            if ($row3 = mysqli_fetch_array($sectorUsuario)) {} ?>
                            <select id="selectSector" name="sector2">
                                <option value=""></option>
                                <?php $sectores = mysqli_query($con, "SELECT * FROM sector");
                                while ($sector = mysqli_fetch_array($sectores)){
                                    if ($sector['id'] == $row3['id_sector']) { ?>
                                        <option value="<?php echo $sector['id']; ?>" selected><?php echo $sector['sector']; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $sector['id']; ?>"><?php echo $sector['sector']; ?></option>
                                    <?php }
                                }?>
                            </select>
                        </td>
                    </tr>
                    <tr id="password2">
                        <td>Password: </td>
                        <td><input type="password" name="password2" id="password2" value="<?php echo $usuario1['password']; ?>" required/></td>
                    </tr>
                    <tr id="fecha_nacimiento2" style="display: none;">
                        <td>Fecha de nacimiento: </td>
                        <td><input type="date" name="fecha_nacimiento2" id="fecha_nacimiento2"  value="<?php echo $usuario1['fecha_nacimiento']; ?>"></td>
                    </tr>
                    <tr id="datos2">
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
                                <?php $datos = mysqli_query($con, "select D.id, TD.tipo_dato, D.dato from datos D inner join tipo_dato TD on TD.id = D.id_tipo_dato where D.id_usuario='" . $id . "';");
                                while ($row2 = mysqli_fetch_array($datos)) { ?>
                                    <tr>
                                        <td>
                                            <select name="selectTipoDatoEditar[]">
                                                <option value=""></option>
                                                <?php $tiposDatos = mysqli_query($con, "SELECT * FROM tipo_dato");
                                                while ($tipoDato = mysqli_fetch_array($tiposDatos)) {
                                                    if ($tipoDato['tipo_dato'] == $row2['tipo_dato']) { ?>
                                                        <option value="<?php echo $tipoDato['id']; ?>" selected><?php echo $tipoDato['tipo_dato']; ?></option>
                                                    <?php } else { ?>
                                                        <option value="<?php echo $tipoDato['id']; ?>"><?php echo $tipoDato['tipo_dato']; ?></option>
                                                    <?php }
                                                }?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="datoEditar[]" value="<?php echo $row2['dato']; ?>"/>
                                        </td>
                                        <td>
                                            <input type="button" id="borrar" class="borrar btn-outline-danger" value="X"/>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td>
                                        <select name="selectTipoDatoEditar[]">
                                            <option value=""></option>
                                            <?php $tiposDatos = mysqli_query($con, "SELECT * FROM tipo_dato");
                                            while ($tipoDato = mysqli_fetch_array($tiposDatos)){ ?>
                                                <option value="<?php echo $tipoDato['id']; ?>"><?php echo $tipoDato['tipo_dato']; ?></option>
                                            <?php }?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="datoEditar[]"/>
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
                                        var clone = $('#datoOriginal').clone().appendTo('#datoClonado');
                                        clone.removeAttr('hidden');
                                        clone.removeAttr('id');
                                        clone.find("select").attr("name", "selectTipoDatoEditar[]");
                                        clone.find("input").attr("name", "datoEditar[]");
                                    });
                                });
                            </script>
                        </td>
                    </tr>
                    <tr id="enfermedades2" style="display:none;">
                        <td>Enfermedades: </td>
                        <td>
                            <?php $query = "select E.id from usuario_enfermedad UE inner join enfermedad E on E.id = UE.id_enfermedad where UE.id_usuario = " . $id . " ;";
                            $sql = mysqli_query($con, $query);
                            $arrayPadresUser = array();
                            while ($row5 = mysqli_fetch_array($sql)) {
                                array_push($arrayPadresUser, $row5['id']);
                            } ?>
                            <select name="selectEnfermedadEditar[]" id="selectEnfermedad" multiple>
                                <option value=""></option>
                                <?php $enfermedades = mysqli_query($con, "SELECT * FROM enfermedad");
                                while ($enfermedad = mysqli_fetch_array($enfermedades)){
                                    $find = false;
                                    foreach ($arrayPadresUser as $padreUser) {
                                        if ($enfermedad['id'] == $padreUser) { ?>
                                            <option value="<?php echo $enfermedad['id']; ?>" selected><?php echo $enfermedad['nombre']; ?></option>
                                            <?php $find = true;
                                            break;
                                        }
                                    }
                                    if ($find == false) { ?>
                                        <option value="<?php echo $enfermedad['id']; ?>"><?php echo $enfermedad['nombre']; ?></option>
                                    <?php }
                                }?>
                            </select>
                        </td>
                    </tr>
                    <tr id="padres2" style="display:none;">
                        <td>Padre/Madre/Tutor: </td>
                        <td>
                            <?php $query = "select id_usuario_padre from usuario_usuario where id_usuario_nino = " . $id . ";";
                            $sql = mysqli_query($con, $query);
                            $arrayPadresUser = array();
                            while ($row6 = mysqli_fetch_array($sql)) {
                                array_push($arrayPadresUser, $row6['id_usuario_padre']);
                            } ?>
                            <select name="selectPadreEditar[]" id="selectPadre" multiple>
                                <option value=""></option>
                                <?php $padres = mysqli_query($con, "select distinct U.id, U.nombre, U.apellidos
                                                                                    from usuario U
                                                                                    inner join usuario_sector_tipo_usuario USTU
                                                                                    on U.id = USTU.id_usuario
                                                                                    where USTU.id_tipo_usuario = '3' || USTU.id_tipo_usuario = '4' || USTU.id_tipo_usuario = '5';");
                                while ($padre = mysqli_fetch_array($padres)){
                                    $find2 = false;
                                    foreach ($arrayPadresUser as $padreUser) {
                                        if ($padre['id'] == $padreUser) { ?>
                                            <option value="<?php echo $padre['id']; ?>" selected><?php echo $padre['nombre'].' '.$padre['apellidos']; ?></option>
                                            <?php $find2 = true;
                                            break;
                                        }
                                    }
                                    if ($find2 == false) { ?>
                                        <option value="<?php echo $padre['id']; ?>"><?php echo $padre['nombre'].' '.$padre['apellidos']; ?></option>
                                    <?php }
                                }?>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>

        <input type="submit" name="submit" value="Editar usuario">
    </form>
<?php } ?>