<?php
include_once './scripts/conexion.php';
session_start();

if (!isset($_SESSION['usr_id'])){
    header("Location: login.php");
}
$page="view/index.php";
$var_page = isset($_REQUEST['page'])?$_REQUEST['page']:null;
if($var_page) {
    if (file_exists("view/" . $_REQUEST['page'] . ".php"))
        $page = "view/" . $_REQUEST['page'] . ".php";
}
require 'view/partials/header.php';
require $page;
require 'view/partials/footer.php';
$con -> close();
?>