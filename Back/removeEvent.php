<?php require 'config.php'; ?>

<?php 

	if (isset($_POST['event_id'])) {

	$sql = "DELETE FROM EVENTS WHERE event_id = " . $_POST["event_id"] . ";";

	$response = array(
			"sql" => $sql
		);


		if (mysqli_query($link, $sql) && mysql_affected_rows() > 0) {
			// echo "Event updated successfully";
			$response = array( "status" => 200,
				"msg" => "Event Deleted!",
				"sql" => $sql );
		} else {
			// echo "Error: " . $sql_edit . "<br>" . mysqli_error($link);
			$response = array( "status" => 404,
				"msg" => "Error Deleting Event!",
				"sql" => $sql );
		}

		echo json_encode($response);

}

mysqli_close($link);


 ?>