<?php

include_once '../../scripts/conexion.php';

if (isset($_REQUEST['title']) && isset($_REQUEST['color']) && isset($_REQUEST['start']) && isset($_REQUEST['end'])) {

	$title = $_REQUEST['title'];
	$color = $_REQUEST['color'];
	$start = $_REQUEST['start'];
	$end = $_REQUEST['end'];

	$buscarActividad = "SELECT * from actividad WHERE title='" . $title . "' and color='" . $color . "';";

	$result = mysqli_query($con, $buscarActividad);
	$count = mysqli_num_rows($result);
	if ($count == 1) { ?>
	<?php } else {
		$query = "INSERT INTO actividad(title, start, end, color) values ('$title', '$start', '$end', '$color');";
		if ($sql = mysqli_query($con, $query)) {
			echo 'Actividad insertada';
		}
	}
}
header('Location: '.$_SERVER['HTTP_REFERER']);
?>
