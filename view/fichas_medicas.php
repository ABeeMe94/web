<div class="container d-flex w-100 h-100 mx-auto flex-column">
    <div class="row jumbotron">
        <div class="col-lg-12 col-xl-12">
            <h1>FICHAS MEDICAS</h1>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter"><i class="fas fa-plus-circle"></i></button>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <?php $consultaEnfermedades = mysqli_query($con, "SELECT * FROM usuario"); ?>
            <div class="table-responsive">
                <div class="jumbotron">
                    <table class="table table-dark table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Alergias o Enfermedades</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while($row= mysqli_fetch_array($consultaEnfermedades)){ ?>
                            <tr>
                                <td><?php echo $row['nombre'] ?></td>
                                <td><?php echo $row['apellidos'] ?></td>
                                <td></td>
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