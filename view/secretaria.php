<?php
if($_SESSION['usr_tipo'] != 'admin' && $_SESSION['usr_tipo'] != 'jefatura' && $_SESSION['usr_tipo'] != 'secretaria'){
    header('Location: ?page=index');
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="application/javascript">
    function borrarActividad(idPago) {
        $.post("view/scripts/borrarPago.php", {id: idPago}, function (dato) {
            alert(dato);
        });
        location.reload();
    };
    $(document).ready(function() {
        $('#actualizar').click(function(){
            var selected = '';
            $('#formularioUsuariosPago input[type=checkbox]').each(function(){
                if (this.checked) {
                    selected += $(this).val()+',';
                }
            });

            pago = $('#usuariosNumPago').text();
            nombrePago = $('#nombreActividad').text();
            cantidadPago = $('#cantidadPago').text();

            if (selected != ''){
                seleccionados=selected.split(',');
                seleccionados.pop();
                $.post("view/scripts/insertarUsuariosPagados.php",{"arraySeleccionados":seleccionados, "pago":pago},function(respuesta){
                    alert(respuesta);
                    buscarUsuariosPago(pago, nombrePago, cantidadPago);
                });
            }
            else{
                alert('Debes seleccionar al menos una opción.');
            }
            return false;
        });
        var $tabla = $('#usuarios');
        $('#selectTipo').change(function(){
            var value = $(this).val();
            console.log(value);
            if (value){
                console.log($('tbody tr td form div.' + value));
                $('tbody tr td form .row.' + value, $tabla).show();
                $('tbody tr td form .row:not(.' + value + ')', $tabla).hide();
            }
            else{
                // Se ha seleccionado All
                $('tbody tr td form .row', $tabla).show();
            }
        });
    });
    function buscarUsuariosPago(idPago, nombrePago, cantidadPago) {
        $('input:checkbox').removeAttr('checked');
        $('#usuariosNumPago').text(idPago);
        $('#nombreActividad').text(nombrePago);
        $('#cantidadPago').text(cantidadPago);

        $.post("view/scripts/buscarUsuariosPagados.php", {id: idPago}, function(datos){
            console.log(datos);
            if (datos != ''){
                ids = datos.split(';');
            } else {
                ids = [];
            }
            var lenghtIds = ids.length;
            for (var i = 0; i<lenghtIds ;i++){
                $("#"+ids[i]).prop('checked', 'true');
            }
            $('#totalNinos').html(lenghtIds);
            $('#totalEuros').html(cantidadPago*lenghtIds);
            $('#calculoTotal').html('('+cantidadPago+' * '+lenghtIds+')');
        });
    };
</script>
<div class="container d-flex w-100 h-100 mx-auto flex-column">
    <div class="row jumbotron text-center">
        <div class="col-lg-12 col-xl-12">
            <div class="row">
                <div class="col-11">
                    <h1>SECRETARÍA</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="jumbotron col-6">
            <!------------------------------------- Modal Pago ------------------------------------- -->
            <div class="modal fade" id="modalNuevoPago" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Añadir Actividad</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="view/scripts/guardarPagoBD.php" method="post" name="formCrearProveedor" id="formCrearProveedor">
                                <div class="form-group">
                                    <label for="inputNombre">Nombre de la actividad:</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputCantidad">Precio (€):</label>
                                    <input type="decimal" class="form-control" name="cantidad" id="cantidad" required>
                                </div>
                                <input type="submit" name="submit" value="Añadir actividad">
                                <input type="reset" name="clear" value="Borrar">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <table class="table table-striped thead-dark" id="pagos">
                    <thead>
                    <tr>
                        <th>Actividad</th>
                        <th>Precio</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $pagos = mysqli_query($con, "SELECT * FROM pagos where ano = '".$_SESSION['ano_actual']."';");
                    while ($pago = mysqli_fetch_array($pagos)){ ?>
                        <tr value="<?php echo $pago['id']; ?>">
                            <td><?php echo $pago['nombre']; ?></td>
                            <td><?php echo $pago['cantidad']; ?> €</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editarPago" onclick="buscarUsuariosPago(<?php echo $pago['id']; ?>,'<?php echo $pago['nombre']; ?>',<?php echo $pago['cantidad']; ?>)"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger" data-toggle="modal" data-target="#eliminarPago" onclick="borrarActividad(<?php echo $pago['id'];?>)"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
                <table class="table table-striped thead-dark">
                    <tbody>
                        <tr>
                            <td>
                                <h4>Añadir Actividad</h4>
                            </td>
                            <td>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalNuevoPago"><i class="fas fa-plus-circle"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-1"></div>
        <div class="jumbotron col-5">
            <?php $usuarios = mysqli_query($con, "select U.id, U.nombre, U.apellidos from usuario U inner join usuario_sector_tipo_usuario USTU on USTU.id_usuario = U.id where USTU.id_tipo_usuario='2' and USTU.ano = '".$_SESSION['ano_actual']."' order by nombre;"); ?>
            <div class="form-group" id="usuariosPago">
                <table class="table thead-dark" id="usuarios">
                    <thead>
                    <tr>
                        <th>
                            <?php ?>
                            <h4>Actividad: <b id="nombreActividad">---</b></h4>
                            <b id="usuariosNumPago" hidden></b>
                            <b id="cantidadPago" hidden></b>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <div class="row">
                                <div class="col-8">
                                    <h6>Pagos realizados</h6>
                                </div>
                                <div class="col-4">
                                    <select id="selectTipo">
                                        <option value="">TODOS</option>
                                        <?php $sectores = mysqli_query($con, "SELECT * FROM sector");
                                        while ($sector = mysqli_fetch_array($sectores)){ ?>
                                            <option value="<?php echo $sector['id']; ?>"><?php echo $sector['sector']; ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>


                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <form id="formularioUsuariosPago">
                                <?php while ($row = mysqli_fetch_array($usuarios)){
                                    $sectorUser = mysqli_query($con, "SELECT S.id from sector S inner join usuario_sector_tipo_usuario USTU on S.id = USTU.id_sector where USTU.id_usuario = '".$row['id']."' and USTU.ano = '".$_SESSION['ano_actual']."';");
                                    if ($row2 = mysqli_fetch_array($sectorUser)) {
                                        $idSector = $row2['id'];
                                    }?>
                                    <div class="row <?php echo $idSector; ?>">
                                        <div class="col-1">
                                            <input name="usuariosPago[]" class="usuarioPago" type="checkbox" value="<?php echo $row['id'] ?>" id="<?php echo $row['id'] ?>">
                                        </div>
                                        <div class="col-11">
                                            <?php echo $row['nombre'].' '.$row['apellidos']; ?> <br>
                                        </div>
                                    </div>
                                <?php } ?>
                                <br><br>
                                TOTAL NIÑOS: <span id="totalNinos"></span><br><br>
                                TOTAL PAGADO: <span id="totalEuros"></span> € <span id="calculoTotal"></span><br><br>
                            </form>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <input id="actualizar" type="button" value="Actualizar" />
            </div>
        </div>
    </div>
    <div class="row"></div>
</div>