<?php
$sql = "SELECT id, title, start, end, color FROM actividad;";
$req = $con->prepare($sql);

if($req->execute()){
    $resultSet = $req->get_result();
    if($resultSet){
        //$events = $resultSet->fetch_all();
        $events = $resultSet;
    }
}

$resultINSERT = isset($_REQUEST['registration']) ? $_REQUEST['registration'] : -1;

if($resultINSERT == 1){ ?>
    <script type="application/javascript">
        alert('Se ha registrado la actividad.');
    </script>
<?php } else if ($resultINSERT == 0) { ?>
    <script type="application/javascript">
        alert('No se han podido registrar la actividad. Revisarlo en la tabla.');
    </script>
<?php } else if ($resultINSERT == 2) { ?>
    <script type="application/javascript">
        alert('La actividad ya existe!!');
    </script>
<?php } ?>
<!-- FullCalendar -->
<link href='public/css/fullcalendar.css' rel='stylesheet' />

<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <div class="jumbotron">
                <div class="row">
                    <div class="col-11">
                        <h1>CALENDARIO SECTOR</h1>
                    </div>
                    <div class="col-1">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#infoSector"><i class="fas fa-info"></i></button>
                    </div>
                </div>
            </div>
            <div id="calendar" class="col-centered"></div>
        </div>
    </div>
    <!-- --------------------- INFO SECTOR ----------------------------- -->
    <div class="modal fade" id="infoSector" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="form-horizontal" method="POST" action="view/scripts/anadirActividad.php">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Colores de cada sector</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div style="margin: 30px;">
                            <div class="row">
                                <div class="col-1" style="background: #0071c5"></div>
                                <div class="col-11"> PACTO</div>
                            </div>
                            <div class="row">
                                <div class="col-1" style="background: #40E0D0"></div>
                                <div class="col-11"> IDENTIDAD 1</div>
                            </div>
                            <div class="row">
                                <div class="col-1" style="background: #008000"></div>
                                <div class="col-11">IDENTIDAD 2</div>
                            </div>
                            <div class="row">
                                <div class="col-1" style="background: #FFD700"></div>
                                <div class="col-11">EXPERIENCIA 1</div>
                            </div>
                            <div class="row">
                                <div class="col-1" style="background: #FF8C00"></div>
                                <div class="col-11">EXPERIENCIA 2</div>
                            </div>
                            <div class="row">
                                <div class="col-1" style="background: #FF0000"></div>
                                <div class="col-11">ESTILOS DE VIDA</div>
                            </div>
                            <div class="row">
                                <div class="col-1" style="background: #495057"></div>
                                <div class="col-11">TODOS</div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ---------------------AÑADIR ACTIVIDAD ------------------------ -->
    <?php if(isset($_SESSION['usr_tipo']) && ($_SESSION['usr_tipo'] == "monitor" || $_SESSION['usr_tipo'] == "admin" || $_SESSION['usr_tipo'] == "jefatura")){ ?>
        <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="form-horizontal" method="POST" action="view/scripts/anadirActividad.php">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Agregar Actividad</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="title" class="col-sm-2 control-label">Titulo</label>
                                <div class="col-sm-10">
                                    <input type="text" name="title" class="form-control" id="title" placeholder="Titulo" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="color" class="col-sm-2 control-label">Sector</label>
                                <div class="col-sm-10">
                                    <select name="color" class="form-control" id="color">
                                        <option value="">Seleccionar</option>
                                        <option style="color:#0071c5;" value="#0071c5">&#9724; Pacto</option>
                                        <option style="color:#40E0D0;" value="#40E0D0">&#9724; Identidad 1</option>
                                        <option style="color:#008000;" value="#008000">&#9724; Identidad 2</option>
                                        <option style="color:#FFD700;" value="#FFD700">&#9724; Experiencia 1</option>
                                        <option style="color:#FF8C00;" value="#FF8C00">&#9724; Experiencia 2</option>
                                        <option style="color:#FF0000;" value="#FF0000">&#9724; Estilos de vida</option>
                                        <option style="color:#495057;" value="#495057">&#9724; Todos</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="start" class="col-sm-2 control-label">Fecha Inicial</label>
                                <div class="col-sm-10">
                                    <input type="text" name="start" class="form-control" id="start" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="end" class="col-sm-2 control-label">Fecha Final</label>
                                <div class="col-sm-10">
                                    <input type="text" name="end" class="form-control" id="end" required>
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
    <?php } ?>
    <!-- ----------------------EDITAR ACTIVIDAD ---------------------------- -->
    <?php if(isset($_SESSION['usr_tipo']) && ($_SESSION['usr_tipo'] == "monitor" || $_SESSION['usr_tipo'] == "admin" || $_SESSION['usr_tipo'] == "jefatura")){ ?>
        <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="form-horizontal" method="POST" action="view/scripts/editarTituloActividad.php">
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
                                <label for="color" class="col-sm-2 control-label">Sector</label>
                                <div class="col-sm-10">
                                    <select name="color" class="form-control" id="color">
                                        <option value="">Seleccionar</option>
                                        <option style="color:#0071c5;" value="#0071c5">&#9724; Pacto</option>
                                        <option style="color:#40E0D0;" value="#40E0D0">&#9724; Identidad 1</option>
                                        <option style="color:#008000;" value="#008000">&#9724; Identidad 2</option>
                                        <option style="color:#FFD700;" value="#FFD700">&#9724; Experiencia 1</option>
                                        <option style="color:#FF8C00;" value="#FF8C00">&#9724; Experiencia 2</option>
                                        <option style="color:#FF0000;" value="#FF0000">&#9724; Estilos de vida</option>
                                        <option style="color:#495057;" value="#495057">&#9724; Todos</option>
                                    </select>
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
    <?php } ?>
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
            editable: false,
            eventLimit: true,
            selectable: true,
            selectHelper: true,
            select: function(start, end) {
                $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
                $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
                $('#ModalAdd').modal('show');
            },
            eventRender: function(event, element) {
                element.bind('dblclick', function() {
                    $('#ModalEdit #id').val(event.id);
                    $('#ModalEdit #title').val(event.title);
                    $('#ModalEdit #color').val(event.color);
                    $('#ModalEdit').modal('show');
                });
            },
            eventDrop: function(event, delta, revertFunc) {
                edit(event);
            },
            eventResize: function(event,dayDelta,minuteDelta,revertFunc) {
                edit(event);
            },
            events: [
                <?php foreach($events as $event):
                $start = explode(" ", $event['start']);
                $end = explode(" ", $event['end']);
                if($start[1] == '00:00:00'){
                    $start = $start[0];
                }else{
                    $start = $event['start'];
                }
                if($end[1] == '00:00:00'){
                    $end = $end[0];
                }else{
                    $end = $event['end'];
                }
                ?>
                {
                    id: '<?php echo $event['id']; ?>',
                    title: '<?php echo $event['title']; ?>',
                    start: '<?php echo $start; ?>',
                    end: '<?php echo $end; ?>',
                    color: '<?php echo $event['color']; ?>',
                },
                <?php endforeach; ?>
            ]
        });

        function edit(event){
            start = event.start.format('YYYY-MM-DD HH:mm:ss');
            if(event.end){
                end = event.end.format('YYYY-MM-DD HH:mm:ss');
            }else{
                end = start;
            }

            id =  event.id;

            Actividad = [];
            Actividad[0] = id;
            Actividad[1] = start;
            Actividad[2] = end;

            $.ajax({
                url: 'view/scripts/editarFechaActividad.php',
                type: "REQUEST",
                data: {Event:Event},
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

