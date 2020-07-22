<div class="container d-flex w-100 h-100 mx-auto flex-column">
    <div class="row jumbotron text-center">
        <div class="col-lg-12 col-xl-12">
            <div class="row">
                <div class="col-11">
                    <h1>FICHAS MEDICAS</h1>
                </div>
            </div>
        </div>
    </div>
    <script type="application/javascript">
        $(function(){
            var $tabla = $('#enfermedades');
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
            <?php $consultaEnfermedades = mysqli_query($con, "SELECT distinct U.* 
                                                                    FROM usuario U
                                                                    inner join usuario_enfermedad UE
                                                                    on UE.id_usuario= U.id;"); ?>
            <div class="table-responsive">
                <div class="jumbotron">
                    <table class="table table-dark table-bordered table-striped" id="enfermedades">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Alergias o Enfermedades</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while($row= mysqli_fetch_array($consultaEnfermedades)){
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
                            <tr class="<?php echo $txt_class ?>">
                                <td><?php echo $row['nombre'] ?></td>
                                <td><?php echo $row['apellidos'] ?></td>
                                <td>
                                    <?php $enfermedades = mysqli_query($con, "select nombre from enfermedad E inner join usuario_enfermedad UE on UE.id_enfermedad = E.id where UE.id_usuario = '".$row['id']."';");?>
                                    <ul>
                                        <?php while ($enfermedad = mysqli_fetch_array($enfermedades)){ ?>
                                            <li>
                                                <?php echo $enfermedad['nombre']; ?>
                                            </li>
                                        <?php } ?>
                                    </ul>
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