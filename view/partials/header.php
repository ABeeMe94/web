<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>GestCo</title>
    <!--Bootstrap-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!--Mi css-->
    <link rel="stylesheet" href="public/css/style.css">

    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
</head>

<body>
    <!--jQuery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!--Bootstrap-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <script type="application/javascript">
        /*$(document).ready(function () {
            var selector = '#sidebar #menu ul li';
            $(selector).on('click', function(){
                $(selector).removeClass('active');
                $(this).addClass('active');
            });
        });*/
        $(function(){
            $('#menu ul li a').filter(function(){return this.href==location.href}).parent().addClass('active').siblings().removeClass('active');
            $('#menu ul li a').click(function(){
                $(this).parent().addClass('active').siblings().removeClass('active')
            });
        })
    </script>

    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <img src="public/img-contacto/gestco.png">
                <strong>GA</strong>
            </div>
            <div id="menu">
                <ul class="list-unstyled components">
                    <li class=""><a href="?page=index"><i class="fas fa-user-circle"></i>  <span>Información general</span></a></li>
                    <?php if (isset($_SESSION['usr_tipo']) && ($_SESSION['usr_tipo'] == "monitor" || $_SESSION['usr_tipo'] == "admin" || $_SESSION['usr_tipo'] == "secretaria" || $_SESSION['usr_tipo'] == "jefatura")) { ?>
                        <li class=""><a href="?page=usuarios"><i class="fas fa-users"></i>  <span>Usuarios</span></a></li>
                        <li class=""><a href="?page=fichas_medicas"><i class="fas fa-medkit"></i>  <span>Fichas Médicas</span></a></li>
                        <li class=""><a href="?page=proveedores"><i class="fas fa-address-book"></i>  <span>Proveedores</span></a></li>
                    <?php } ?>
                    <?php if (isset($_SESSION['usr_tipo']) && ($_SESSION['usr_tipo'] == "secretaria" || $_SESSION['usr_tipo'] == "admin" || $_SESSION['usr_tipo'] == "jefatura")) { ?>
                        <li class=""><a href="?page=secretaria"><i class="fas fa-calculator"></i>  <span>Secretaria</span></a></li>
                    <?php } ?>
                    <li class=""><a href="?page=calendario"><i class="fas fa-calendar"></i>  <span>Calendario</span></a></li>
                </ul>
            </div>
            <ul class="list-unstyled CTAs">
                <?php if (isset($_SESSION['usr_id'])) { ?>
                    <li>Logeado como: <br><b><?php echo $_SESSION['usr_nombre'].' '. $_SESSION['usr_apellidos']; ?></b></li><br>
                    <li><a href="scripts/logout.php" class="article">Cerrar sesión</a></li>
                <?php } ?>
            </ul>
        </nav>

