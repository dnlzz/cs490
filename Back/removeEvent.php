<?php require 'config.php'; ?>

<?php 

	if (isset($_POST['event_id'])) {

	$input = $_POST;

	$sql = "DELETE FROM EVENTS WHERE event_id=" . $_POST["event_id"] . ";";

	$response = array(
			"sql" => $sql,
			"post" => $input
		);

/*
		if (mysqli_query($link, $sql_edit)) {
			// echo "Event updated successfully";
			$response = array( "status" => 200,
				"msg" => "Event Deleted!");
		} else {
			// echo "Error: " . $sql_edit . "<br>" . mysqli_error($link);
			$response = array( "status" => 404,
				"msg" => "Error Deleting Event!" );
		}
*/
	}

		echo json_encode($response);

}

mysqli_close($link);


 ?>