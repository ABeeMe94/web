<?php
include_once '../../scripts/conexion.php';
if (isset($_REQUEST['title']) && isset($_REQUEST['descripcion']) && isset($_REQUEST['sector']) && isset($_REQUEST['color']) && isset($_REQUEST['start']) && isset($_REQUEST['end'])){
	
	$title = $_REQUEST['title'];
	$descripcion = $_REQUEST['descripcion'];
	$sector = $_REQUEST['sector'];
	$color = $_REQUEST['color'];
	$start = $_REQUEST['start'];
	$end = $_REQUEST['end'];

	$sql = "INSERT INTO actividad(title, descripcion, id_sector, color, start, end) values ('$title', '$descripcion', '$sector', '$color', '$start', '$end')";
	echo $sql;
	
	$query = $con->prepare( $sql );
	if ($query == false) {
	 print_r($con->error);
	 die ('Erreur prepare');
	}
	$sth = $query->execute();
	if ($sth == false) {
	 print_r($query->errorInfo());
	 die ('Erreur execute');
	}
}
header('Location: '.$_SERVER['HTTP_REFERER']);
?>
