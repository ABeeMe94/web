<?php
//usuario de la BBDD "admin" y contraseña "123456"
//Conexion a la base de datos
$con = mysqli_connect("localhost", "admin", "123456", "gestapp") or die("Error " . mysqli_error($con));
?>