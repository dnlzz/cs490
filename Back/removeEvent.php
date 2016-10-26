<?php require 'config.php'; ?>

<?php 

	if (isset($_POST['event_id'])) {

	$sql = "DELETE FROM EVENTS WHERE event_id = " . $_POST["event_id"] . " AND user_id = " . $_POST["user_id"] . ";";

	$response = array(
			"sql" => $sql
		);

		//The first if statement on line 14 can be split into two more ifs.
		//if -> query
		//    |-> if affected > 0 => event deleted
		//	  |-> if affected < 0 => event doesnt exist anymore
		if (mysqli_query($link, $sql) ) {
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