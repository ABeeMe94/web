<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!--script src="public/js/jquery.tabledit.js"></script-->

<div class="container">
    <div class="jumbotron text-center">
            <h1>
                USUARIOS
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter"><i class="fas fa-plus-circle"></i></button>
            </h1>
    </div>
    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <?php $consultaUsuarios = mysqli_query($con, "SELECT * FROM usuario where estado_activo=1"); ?>
            <div class="table-responsive">
                <div class="jumbotron">
                    <table class="table table-dark table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>DNI</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Fecha nacimiento</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while($row= mysqli_fetch_array($consultaUsuarios)){ ?>
                            <tr>
                                <td><?php echo $row['id_usuario'] ?></td>
                                <td><?php echo $row['dni'] ?></td>
                                <td><?php echo $row['nombre'] ?></td>
                                <td><?php echo $row['apellidos'] ?></td>
                                <td><?php echo $row['fecha_nacimiento'] ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter"><i class="fas fa-eye"></i></button>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
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
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!--script type="application/javascript">
    $(document).ready(function () {
        //$('#data_table').DataTable();
        $('#data_table').Tabledit ({
            deleteButton: true,
            editButton: true,
            columns: {
                identifier: [0, 'id_usuario'],
                editable: [[1, 'dni'], [2, 'nombre'], [3, 'apellidos'], [4, 'fecha_nacimiento']]
            },
            hideIdentifier: true,
            url: 'view/scripts/editarCelda.php'
        });
    });
</script-->