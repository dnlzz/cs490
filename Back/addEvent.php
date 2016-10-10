<?php session_start(); ?>

<?php require 'config.php'; ?>

<?php

	
	$event_name = (!empty($_POST['event_name'])) ? $_POST['event_name'] : 'NULL';
	$event_start_date = (!empty($_POST['event_start_date'])) ? $_POST['event_start_date'] : 'NULL';
	$event_end_date = (!empty($_POST['event_end_date'])) ? $_POST['event_end_date'] : 'NULL';
	$event_start_time = (!empty($_POST['event_start_time'])) ? $_POST['event_start_time'] : 'NULL';
	$event_end_time = (!empty($_POST['event_end_time'])) ? $_POST['event_end_time'] : 'NULL';
	$event_repeated = (!empty($_POST['event_repeated'])) ? $_POST['event_repeated'] : 'NULL';
	$event_description = (!empty($_POST['event_description'])) ? $_POST['event_description'] : 'NULL';
	$event_calendar = (!empty($_POST['event_calendar'])) ? $_POST['event_calendar'] : 'NULL';
	$event_location_lat = (!empty($_POST['event_location_lat'])) ? $_POST['event_location_lat'] : 'NULL';
	$event_location_long = (!empty($_POST['event_location_long'])) ? $_POST['event_location_long'] : 'NULL';
	

	//if(isset($_POST['user']) && isset($_POST['pass'])) {
	/*
		$sql = "INSERT INTO EVENTS (event_name, event_start_date, event_end_date, event_start_time, 
		event_end_time, event_repeated, event_description, event_calendar, 
		event_location_lat, event_location_long, user_id) VALUES (" . $event_name . ", " . $event_start_date . ", " . $event_end_date . ", " . $event_start_time . ", " . $event_end_time . ", " . $event_repeated . ", " . $event_description . ", " . $event_calendar . ", " . $event_location_lat . ", " . $event_location_long . ", " $_SESSION["user_id"] . ");";
		*/

		$sql = "INSERT INTO EVENTS (event_name, event_start_date, event_end_date, event_start_time, event_end_time, event_repeated, event_description, event_calendar, event_location_lat, event_location_long, user_id) VALUES ('Event 5', '2016-10-11', '$event_end_date', '$event_start_time','$event_end_time', '$event_repeated', '$event_description', '$event_calendar', '$event_location_lat', '$event_location_long', '4')";

		if (mysqli_query($link, $sql)) {
			echo "New record created successfully";
			$response = array( "status" => 200,
							      "msg" => "Event Added!" );
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($link);
			$response = array( "status" => 404,
							      "msg" => "Error Adding Event!" );
		}

		//echo json_encode($response);

	//}

	mysqli_close($link);

echo '<pre>';
print_r($response);
echo '</pre>';


?>