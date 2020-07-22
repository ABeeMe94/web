<?php
if($_SESSION['usr_tipo'] != 'admin' && $_SESSION['usr_tipo'] != 'jefatura' && $_SESSION['usr_tipo'] != 'secretaria'){
    header('Location: ?page=index');
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="application/javascript">
    $(document).ready(function() {
        $('#actualizar').click(function(){
            var selected = '';
            $('#formularioUsuariosPago input[type=checkbox]').each(function(){
                if (this.checked) {
                    selected += $(this).val()+',';
                }
            });
            pago = $('#usuariosNumPago').text();
            if (selected != ''){
                seleccionados=selected.split(',');
                seleccionados.pop();
                console.log(seleccionados);
                alert('Has seleccionado: '+selected);
                $.post("view/scripts/insertarUsuariosPagados.php",{"arraySeleccionados":seleccionados, "pago":pago},function(respuesta){
                    alert(respuesta);
                });
            }

            else{
                alert('Debes seleccionar al menos una opción.');
            }
            return false;
        });
    });
    function buscarUsuariosPago(idPago) {
        $('input:checkbox').removeAttr('checked');
        $('#usuariosNumPago').text(idPago);
        $.post("view/scripts/buscarUsuariosPagados.php", {id: idPago}, function(datos){
            ids = datos.split(';');
            console.log(ids);
            var lenghtIds = ids.length;
            for (var i = 0; i<lenghtIds ;i++){
                $("#"+ids[i]).prop('checked', 'true');
            }
        });
        $('#formularioUsuariosPago').refresh();
    }
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
            <div class="row">
                <div class="col-10"><h4>Pagos activos</h4></div>
                <div class="col-2">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalNuevoPago"><i class="fas fa-plus-circle"></i></button>
                </div>
            </div>
            <!------------------------------------- Modal Pago ------------------------------------- -->
            <div class="modal fade" id="modalNuevoPago" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Añadir pago</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="view/scripts/guardarPagoBD.php" method="post" name="formCrearProveedor" id="formCrearProveedor">
                                <div class="form-group">
                                    <label for="inputNombre">Nombre:</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputCantidad">Cantidad (€):</label>
                                    <input type="decimal" class="form-control" name="cantidad" id="cantidad" required>
                                </div>
                                <input type="submit" name="submit" value="Añadir pago">
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
                        <th>Nombre del pago</th>
                        <th>Cantidad</th>
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
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editarPago" onclick="buscarUsuariosPago(<?php echo $pago['id']; ?>)"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-1"></div>
        <div class="jumbotron col-5">
            <?php $usuarios = mysqli_query($con, "Select id, nombre, apellidos from usuario;"); ?>
            <div class="form-group" id="usuariosPago">
                <table class="table thead-dark" id="usuarios">
                    <thead>
                    <tr>
                        <th>
                            <h4>Usuarios</h4>
                            <b id="usuariosNumPago" hidden>-</b>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <form id="formularioUsuariosPago">
                                <?php while ($row = mysqli_fetch_array($usuarios)){ ?>
                                    <input name="usuariosPago[]" class="usuarioPago" type="checkbox" value="<?php echo $row['id'] ?>" id="<?php echo $row['id'] ?>">
                                    <?php echo $row['nombre'].' '.$row['apellidos']; ?> <br>
                                <?php } ?>
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