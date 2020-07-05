<?php
include_once '../../scripts/conexion.php';
if (isset($_REQUEST['delete']) && isset($_REQUEST['id'])){
	$id = $_REQUEST['id'];
	
	$sql = "DELETE FROM actividad WHERE id = $id";
	$query = $con->prepare( $sql );
	if ($query == false) {
	 print_r($con->errorInfo());
	 die ('Erreur prepare');
	}
	$res = $query->execute();
	if ($res == false) {
	 print_r($query->errorInfo());
	 die ('Erreur execute');
	}
	
}elseif (isset($_REQUEST['title']) && isset($_REQUEST['color']) && isset($_REQUEST['id'])){
	
	$id = $_REQUEST['id'];
	$title = $_REQUEST['title'];
	$color = $_REQUEST['color'];
	
	$sql = "UPDATE actividad SET  title = '$title', color = '$color' WHERE id = $id ";

	
	$query = $con->prepare( $sql );
	if ($query == false) {
	 print_r($con->errorInfo());
	 die ('Erreur prepare');
	}
	$sth = $query->execute();
	if ($sth == false) {
	 print_r($query->errorInfo());
	 die ('Erreur execute');
	}

}
header('Location: ../calendar.php');

	
?>
