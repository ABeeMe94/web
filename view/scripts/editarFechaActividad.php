<?php
include_once '../../scripts/conexion.php';
if (isset($_REQUEST['Actividad'][0]) && isset($_REQUEST['Actividad'][1]) && isset($_REQUEST['Actividad'][2])){
	
	
	$id = $_REQUEST['Actividad'][0];
	$start = $_REQUEST['Actividad'][1];
	$end = $_REQUEST['Actividad'][2];

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
