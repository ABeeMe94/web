<?php
//session_start();
include_once '../../scripts/conexion.php';

$id = $_REQUEST['id'];
$proveedor = mysqli_query($con, "select * from proveedores where id='".$id."';");
if ($proveedor1 = mysqli_fetch_array($proveedor)) { ?>
    <form action="view/scripts/actualizarProveedorBD.php" method="post" name="formActualizarProveedor"
          id="formActualizarProveedor">
    <input type="hidden" name="idProveedor" value="<?php echo $id; ?>">
    <table class="table">
    <tr>
        <td>Nombre:</td>
        <td><input type="text" name="nombre" id="nombre" value="<?php echo $proveedor1['nombre']; ?>" autofocus
                   required/></td>
    </tr>
    <tr>
    <td>Dato/s:</td>
    <td>
    <table class="table-borderless">
    <tr id="datoOriginal" hidden>
        <td>
            <select>
                <option value=""></option>
                <?php $tiposDatos = mysqli_query($con, "SELECT * FROM tipo_dato");
                while ($tipoDato = mysqli_fetch_array($tiposDatos)) { ?>
                    <option value="<?php echo $tipoDato['id']; ?>"><?php echo $tipoDato['tipo_dato']; ?></option>
                <?php } ?>
            </select>
        </td>
        <td>
            <input type="text"/>
        </td>
        <td>
            <input type="button" id="borrar" class="borrar btn-outline-danger" value="X"/>
        </td>
    </tr>
    <div id="datoClonado"></div>
    <?php $datos = mysqli_query($con, "select DP.id, TD.tipo_dato, DP.dato from datos_proveedor DP inner join tipo_dato TD on TD.id = DP.id_tipo_dato where DP.id_proveedor='" . $id . "';");
    while ($row = mysqli_fetch_array($datos)) { ?>
        <tr>
            <td>
                <select name="selectTipoDatoEditar[]">
                    <option value=""></option>
                    <?php $tiposDatos = mysqli_query($con, "SELECT * FROM tipo_dato");
                    while ($tipoDato = mysqli_fetch_array($tiposDatos)) {
                        if ($tipoDato['tipo_dato'] == $row['tipo_dato']) { ?>
                            <option value="<?php echo $tipoDato['id']; ?>" selected><?php echo $tipoDato['tipo_dato']; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $tipoDato['id']; ?>"><?php echo $tipoDato['tipo_dato']; ?></option>
                        <?php }
                    }?>
                </select>
            </td>
            <td>
                <input type="text" name="datoEditar[]" value="<?php echo $row['dato']; ?>"/>
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
                    while ($tipoDato = mysqli_fetch_array($tiposDatos)) { ?>
                        <option value="<?php echo $tipoDato['id']; ?>"><?php echo $tipoDato['tipo_dato']; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td>
                <input type="text" name="datoEditar[]"/>
            </td>
            <td>
                <input type="button" id="anadir" class="anadir btn-outline-primary" value="+" style="display: block;"/>
                <input type="button" id="borrar" class="borrar btn-outline-danger" value="X" style="display: none;"/>
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
        <tr valign="top">
            <td>Tipo de proveedor:</td>
            <td>
                <?php $query = "SELECT id_tipo_proveedor from proveedor_tipo_proveedor WHERE id_proveedor = " . $id . " ;";
                $sql = mysqli_query($con, $query);
                $arrayIdTipo = array();
                while ($row = mysqli_fetch_array($sql)) {
                    array_push($arrayIdTipo, $row['id_tipo_proveedor']);
                } ?>
                <select name="selectTipoEditar[]" id="selectTipo" multiple>
                    <?php $tipos = mysqli_query($con, "SELECT * FROM tipo_proveedor");
                    while ($tipo = mysqli_fetch_array($tipos)) {
                        $find = false;
                        foreach ($arrayIdTipo as $tipoProveedor) {
                            if ($tipo['id'] == $tipoProveedor) {
                                ?>
                                <option value="<?php echo $tipo['id']; ?>" selected><?php echo $tipo['tipo_proveedor']; ?></option>
                                <?php $find = true;
                                break;
                            }
                        }
                        if ($find == false) { ?>
                            <option value="<?php echo $tipo['id']; ?>"><?php echo $tipo['tipo_proveedor']; ?></option>
                        <?php }
                    } ?>
                </select>
            </td>
        </tr>
        </table>
        <input type="submit" name="submit" value="Actualizar proveedor">
        <input type="reset" name="clear" value="Borrar">
        </form>
    <?php } ?>

