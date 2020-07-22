<?php
// Conexion a la base de datos
include_once '../../scripts/conexion.php';

if (isset($_REQUEST['Event'][0]) && isset($_REQUEST['Event'][1]) && isset($_REQUEST['Event'][2])){


	$id = $_REQUEST['Event'][0];
	$start = $_REQUEST['Event'][1];
	$end = $_REQUEST['Event'][2];

	$sql = "UPDATE actividad SET  start = '$start', end = '$end' WHERE id = $id ";


	$query = $con->prepare( $sql );
	if ($query == false) {
	 print_r($con->errorInfo());
	 die ('Error');
	}
	$sth = $query->execute();
	if ($sth == false) {
	 print_r($query->errorInfo());
	 die ('Error');
	}else{
		die ('OK');
	}

}
//header('Location: '.$_SERVER['HTTP_REFERER']);

	
?>
