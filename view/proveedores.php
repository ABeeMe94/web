<div class="container">
    <div class="jumbotron text-center">
        <div class="col-lg-12 col-xl-12">
            <div class="row">
                <div class="col-11">
                    <h1>PROVEEDORES</h1>
                </div>
                <div class="col-1">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crearProveedor"><i class="fas fa-plus-circle"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <?php $consultaProveedores = mysqli_query($con, "SELECT * FROM proveedores WHERE estado_activo = 1"); ?>
            <div class="table-responsive">
                <div class="jumbotron">
                    <script type="application/javascript">
                        $(function(){
                            var $tabla = $('#proveedores');
                            $('#selectTipo').change(function(){
                                var value = $(this).val();
                                if (value){
                                    $('tbody tr.' + value, $tabla).show();
                                    $('tbody tr:not(.' + value + ')', $tabla).hide();
                                }
                                else{
                                    $('tbody tr', $tabla).show();
                                }
                            });
                        });
                    </script>
                    <div class="text-right">
                        <span>Tipo de proveedor: </span>
                        <select id="selectTipo">
                            <option value="">TODOS</option>
                            <?php $tipos = mysqli_query($con, "SELECT * FROM tipo_proveedor");
                            while ($tipo = mysqli_fetch_array($tipos)){ ?>
                                <option value="<?php echo $tipo['tipo_proveedor']; ?>"><?php echo $tipo['tipo_proveedor']; ?></option>
                            <?php }?>
                        </select>
                    </div><br>
<!-- ------------------------------------- TABLA PROVEEDORES ------------------------------------------- -->
                    <table class="table table-dark table-bordered table-striped" id="proveedores">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Datos</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while($row2= mysqli_fetch_array($consultaProveedores)) {
                            if ($row2['estado_activo'] == 1) {
                                $tipo_proveedor = mysqli_query($con, "Select TP.tipo_proveedor 
                                                                                    from tipo_proveedor TP
                                                                                    inner join proveedor_tipo_proveedor PTP
                                                                                    on TP.id = PTP.id_tipo_proveedor
                                                                                    where PTP.id_proveedor = '" . $row2['id'] . "';");
                                $txt_tipo = "";
                                $first = true;
                                while ($tipo = mysqli_fetch_array($tipo_proveedor)) {
                                    if ($first) {
                                        $txt_tipo = $tipo['tipo_proveedor'];
                                        $first = false;
                                    } else {
                                        $txt_tipo = $txt_tipo . " " . $tipo['tipo_proveedor'];
                                    }
                                };

                                $datos_proveedor = mysqli_query($con, "select TP.tipo_dato, DP.dato
                                                                                            from datos_proveedor DP
                                                                                            inner join tipo_dato TP
                                                                                            on TP.id = DP.id_tipo_dato
                                                                                            where DP.id_proveedor = '" . $row2['id'] . "';");
                                $datosProveedor ="";
                                $primero=true;
                                while ($dato = mysqli_fetch_array($datos_proveedor)) {
                                    if ($primero) {
                                        $datosProveedor = $dato['tipo_dato'] . ': ' . $dato['dato'];
                                        $primero = false;
                                    } else {
                                        $datosProveedor = $datosProveedor . ";" . $dato['tipo_dato'] . ': ' . $dato['dato'];
                                    }
                                }; ?>
                                <tr id="<?php echo $row2['id'];?>" class="<?php echo $txt_tipo ?>">
                                    <td><?php echo $row2['nombre'] ?></td>
                                    <td>
                                        <?php
                                            echo str_replace(' ', '<br>', $txt_tipo);
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo str_replace(';', '<br>', $datosProveedor);
                                         ?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editarProveedor" onclick="editarProveedor(<?php echo $row2['id'];?>)"><i class="fas fa-edit"></i></button>
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<!-- ----------------------------- Modal Nuevo ---------------------------------------------- -->
    <div class="modal fade bd-example-modal-lg" id="crearProveedor" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Nuevo proveedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="view/scripts/guardarProveedorBD.php" method="post" name="formCrearProveedor" id="formCrearProveedor">
                        <table class="table">
                            <tr>
                                <td>Nombre: </td>
                                <td><input type="text" name="nombre" id="nombre" autofocus required/></td>
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
                                                clone.find("select").attr("name", "selectTipoDato[]");
                                                clone.find("input").attr("name", "dato[]");
                                            });
                                        });
                                    </script>
                                </td>
                            </tr>
                            <tr valign="top">
                                <td>Tipo de proveedor: </td>
                                <td>
                                    <select name="selectTipo[]" id="selectTipo" multiple>
                                        <?php $tipos = mysqli_query($con, "SELECT * FROM tipo_proveedor");
                                        while ($tipo = mysqli_fetch_array($tipos)){ ?>
                                            <option value="<?php echo $tipo['id']; ?>"><?php echo $tipo['tipo_proveedor']; ?></option>
                                        <?php }?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <input type="submit" name="submit" value="Dar de alta proveedor">
                        <input type="reset" name="clear" value="Borrar">
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- ----------------------------- Modal Editar ---------------------------------------------- -->
    <div class="modal fade bd-example-modal-lg" id="editarProveedor" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Editar proveedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="view/scripts/actualizarProveedorBD.php" method="post" name="formActualizarProveedor" id="formActualizarProveedor">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>