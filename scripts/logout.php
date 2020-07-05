<?php
//Inicia una nueva sesión o reanuda la existente
session_start();
if (!isset($_SESSION[alumno])) {
    header("location:../index.php");
}

/* usamos la función session_unset() para liberar la variable
de sesión que se encuentra registrada */
session_unset($_SESSION[alumno]);

// Destruye la información de la sesión
session_destroy();

//volvemos a la página principal
header("location:../login.php");
?>