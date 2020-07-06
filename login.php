<?php
include_once './scripts/conexion.php';

session_start();
//Si existe sesión, se redirecciona
if(isset($_SESSION['usr_id'])) {
    header("Location: index.php");
}
//Comprobar de envío el formulario
if (isset($_REQUEST['login'])) {
    $usuario = mysqli_real_escape_string($con, $_REQUEST['usuario']);
    $password = mysqli_real_escape_string($con, $_REQUEST['password']);
    $datos_usuario = mysqli_query($con, "SELECT * FROM usuario WHERE usuario = '".$usuario."' and password = '".$password."';");
    //Comprobación inicio de sesión
    if ($row = mysqli_fetch_array($datos_usuario)) {
        if($row['estado_activo']==1){
            $_SESSION['usr_id'] = $row['id'];
            echo $_SESSION['usr_id'];
            $_SESSION['usr_nombre'] = $row['nombre'];
            $_SESSION['usr_apellidos'] = $row['apellidos'];
            $_SESSION['usr_dni'] = $row['dni'];
            $_SESSION['usr_fecha'] = $row['fecha_nacimiento'];
            $_SESSION['usr_usuario'] = $row['usuario'];
            $_SESSION['usr_url_foto'] = $row['url_foto'];

            $mes_actual = date("n");
            $ano_actual = date("Y");
            $ano_anterior = $ano_actual-1;
            $ano_proximo = $ano_actual+1;

            if ($mes_actual < 9){
                $curso_actual = $ano_anterior.'/'.$ano_actual;
            } else {
                $curso_actual = $ano_actual.'/'.$ano_proximo;
            }
            $sector_tipo_actual = mysqli_query($con, "SELECT *
                                                            FROM (  SELECT USTU.id_usuario, S.sector, TU.tipo_usuario, USTU.ano
                                                                    FROM usuario_sector_tipo_usuario USTU
                                                                    INNER JOIN sector S
                                                                    ON S.id = USTU.id_sector
                                                                    INNER JOIN tipo_usuario TU
                                                                    ON TU.id = USTU.id_tipo_usuario) as X
                                                            where X.id_usuario = '".$_SESSION['usr_id']."' and X.ano = '".$curso_actual."'
                                                            order by X.ano;");
            if ($row = mysqli_fetch_array($sector_tipo_actual)) {
                $_SESSION['usr_tipo'] = $row['tipo_usuario'];
                $_SESSION['usr_sector'] = $row['sector'];
            }

            header("Location: index.php");
        }else
            //Error cuenta desactivada estado=0
            $errormsg = "Esta cuenta esta desactivada";
    } else {
        //Error usuario o contraseña incorrectas
        $errormsg = "Revisa los datos!!!";
    }
}
?>

<html>
    <head>
        <title>GestiApp</title>
        <link rel="stylesheet" type="text/css" href="public/css/login.css" media="screen" />
        <link rel="stylesheet" href="css/bootstrap.min.css" >
        <link rel="stylesheet" href="css/bootstrap-theme.min.css" >
        <script src="js/bootstrap.min.js" ></script>
    </head>
    <body class="align">
        <h1 class="titulo_login">GestiApp</h1>
        <div class="grid">
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" class="form login">
                <div class="form__field">
                    <label for="login__usuario"><svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#user"></use></svg><span class="hidden">Usuario</span></label>
                    <input id="usuario" type="text" name="usuario" class="form__input" placeholder="usuario" required>
                </div>
                <div class="form__field">
                    <label for="login__password"><svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#lock"></use></svg><span class="hidden">Contraseña</span></label>
                    <input id="password" type="password" name="password" class="form__input" placeholder="contraseña" required>
                </div>
                <div class="form__field">
                    <input name="login" type="submit" value="Iniciar sesión">
                </div>
            </form>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" class="icons"><symbol id="arrow-right" viewBox="0 0 1792 1792"><path d="M1600 960q0 54-37 91l-651 651q-39 37-91 37-51 0-90-37l-75-75q-38-38-38-91t38-91l293-293H245q-52 0-84.5-37.5T128 1024V896q0-53 32.5-90.5T245 768h704L656 474q-38-36-38-90t38-90l75-75q38-38 90-38 53 0 91 38l651 651q37 35 37 90z"/></symbol><symbol id="lock" viewBox="0 0 1792 1792"><path d="M640 768h512V576q0-106-75-181t-181-75-181 75-75 181v192zm832 96v576q0 40-28 68t-68 28H416q-40 0-68-28t-28-68V864q0-40 28-68t68-28h32V576q0-184 132-316t316-132 316 132 132 316v192h32q40 0 68 28t28 68z"/></symbol><symbol id="user" viewBox="0 0 1792 1792"><path d="M1600 1405q0 120-73 189.5t-194 69.5H459q-121 0-194-69.5T192 1405q0-53 3.5-103.5t14-109T236 1084t43-97.5 62-81 85.5-53.5T538 832q9 0 42 21.5t74.5 48 108 48T896 971t133.5-21.5 108-48 74.5-48 42-21.5q61 0 111.5 20t85.5 53.5 62 81 43 97.5 26.5 108.5 14 109 3.5 103.5zm-320-893q0 159-112.5 271.5T896 896 624.5 783.5 512 512t112.5-271.5T896 128t271.5 112.5T1280 512z"/></symbol></svg>
    </body>
</html>
