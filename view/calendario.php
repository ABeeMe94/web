<?php
$sql = "SELECT id, title, descripcion, start, end, id_sector FROM actividad ";
$req = $con->prepare($sql);
$actividades = null;
if($req->execute()){
    $resultSet = $req->get_result();
    if($resultSet){
        //$actividades = $resultSet->fetch_all();
        $actividades = $resultSet;
    }
}
?>
<!-- FullCalendar -->
<link href='public/css/fullcalendar.css' rel='stylesheet' />

<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <div class="jumbotron">
                <h1>CALENDARIO SECTOR</h1>
            </div>
            <div id="calendar" class="col-centered"></div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form-horizontal" method="POST" action="view/scripts/añadirActividad.php">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Agregar Actividad</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Titulo</label>
                            <div class="col-sm-10">
                                <input type="text" name="title" class="form-control" id="title" placeholder="Titulo">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="descripcion" class="col-sm-2 control-label">Descripción</label>
                            <div class="col-sm-10">
                                <input type="text" name="descripcion" class="form-control" id="descripcion" placeholder="Descripción">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sector" class="col-sm-2 control-label">Sector</label>
                            <div class="col-sm-10">
                                <select name="sector" class="form-control" id="sector">
                                    <option value="">Seleccionar</option>
                                    <option style="color:#0071c5;" value="1">PACTO</option>
                                    <option style="color:#40E0D0;" value="2">ID1</option>
                                    <option style="color:#008000;" value="3">ID2</option>
                                    <option style="color:#FFD700;" value="4">EXP1</option>
                                    <option style="color:#FF8C00;" value="5">EXP2</option>
                                    <option style="color:#FF0000;" value="6">EV1</option>
                                    <option value="7">EV2</option>
                                    <option value="8">EV3</option>
                                    <option style="color:#000;" value="9">EV4</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="start" class="col-sm-2 control-label">Fecha Inicial</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" name="start" class="form-control" id="start">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="end" class="col-sm-2 control-label">Fecha Final</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" name="end" class="form-control" id="end">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form-horizontal" method="POST" action="scripts/editarTituloActividad.php">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Modificar Actividad</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Titulo</label>
                            <div class="col-sm-10">
                                <input type="text" name="title" class="form-control" id="title" placeholder="Titulo">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="descripcion" class="col-sm-2 control-label">Descripción</label>
                            <div class="col-sm-10">
                                <input type="text" name="descripcion" class="form-control" id="descripcion" placeholder="Descripción">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sector" class="col-sm-2 control-label">Sector</label>
                            <div class="col-sm-10">
                                <select name="sector" class="form-control" id="sector">
                                    <option value="">Seleccionar</option>
                                    <option style="color:#0071c5;" value="1">PACTO</option>
                                    <option style="color:#40E0D0;" value="2">ID1</option>
                                    <option style="color:#008000;" value="3">ID2</option>
                                    <option style="color:#FFD700;" value="4">EXP1</option>
                                    <option style="color:#FF8C00;" value="5">EXP2</option>
                                    <option style="color:#FF0000;" value="6">EV1</option>
                                    <option value="7">EV2</option>
                                    <option value="8">EV3</option>
                                    <option style="color:#000;" value="9">EV4</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="start" class="col-sm-2 control-label">Fecha Inicial</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" name="start" class="form-control" id="start">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="end" class="col-sm-2 control-label">Fecha Final</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" name="end" class="form-control" id="end">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="checkbox">
                                    <label class="text-danger"><input type="checkbox"  name="delete"> Eliminar Actividad</label>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" class="form-control" id="id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- FullCalendar -->
<script src='public/js/moment.min.js'></script>
<script src='public/js/fullcalendar/fullcalendar.min.js'></script>
<script src='public/js/fullcalendar/fullcalendar.js'></script>
<script src='public/js/fullcalendar/locale/es.js'></script>

<script type="text/javascript">
    $(document).ready(function() {
        var date = new Date();
        var yyyy = date.getFullYear().toString();
        var mm = (date.getMonth()+1).toString().length == 1 ? "0"+(date.getMonth()+1).toString() : (date.getMonth()+1).toString();
        var dd  = (date.getDate()).toString().length == 1 ? "0"+(date.getDate()).toString() : (date.getDate()).toString();

        $('#calendar').fullCalendar({
            header: {
                language: 'es',
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay',
            },
            defaultDate: yyyy+"-"+mm+"-"+dd,
            editable: true,
            eventLimit: true,
            selectable: true,
            selectHelper: true,
            select: function(start, end) {
                $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
                $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
                $('#ModalAdd').modal('show');
            },
            eventRender: function(actividad, element) {
                element.bind('dblclick', function() {
                    $('#ModalEdit #id').val(actividad.id);
                    $('#ModalEdit #title').val(actividad.title);
                    $('#ModalEdit #descripcion').val(actividad.descripcion);
                    $('#ModalEdit #sector').val(actividad.sector);
                    $('#ModalEdit #descripcion').val(actividad.descripcion);
                    $('#ModalEdit').modal('show');
                });
            },
            eventDrop: function(actividad, delta, revertFunc) { // si changement de position
                edit(actividad);
            },
            eventResize: function(actividad,dayDelta,minuteDelta,revertFunc) { // si changement de longueur
                edit(actividad);
            },
            events: [
                <?php foreach($actividades as $actividad):
                $start = explode(" ", $actividad['start']);
                $end = explode(" ", $actividad['end']);
                if($start[1] == '00:00:00'){
                    $start = $start[0];
                }else{
                    $start = $actividad['start'];
                }
                if($end[1] == '00:00:00'){
                    $end = $end[0];
                }else{
                    $end = $actividad['end'];
                }
                ?>
                {
                    id: '<?php echo $actividad['id']; ?>',
                    title: '<?php echo $actividad['title']; ?>',
                    start: '<?php echo $start; ?>',
                    end: '<?php echo $end; ?>',
                },
                <?php endforeach; ?>
            ]
        });

        function edit(actividad){
            start = actividad.start.format('YYYY-MM-DD HH:mm:ss');
            if(actividad.end){
                end = actividad.end.format('YYYY-MM-DD HH:mm:ss');
            }else{
                end = start;
            }

            id =  actividad.id;

            Actividad = [];
            Actividad[0] = id;
            Actividad[1] = start;
            Actividad[2] = end;

            $.ajax({
                url: 'scripts/editarFechaActividad.php',
                type: "REQUEST",
                data: {Actividad:Actividad},
                success: function(rep) {
                    if(rep == 'OK'){
                        alert('Actividad guardada correctamente');
                    }else{
                        alert('No se pudo guardar. Inténtalo de nuevo.');
                    }
                }
            });
        }

    });
</script>