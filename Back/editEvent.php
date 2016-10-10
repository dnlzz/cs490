<?php session_start(); ?>

<?php require 'config.php'; ?>

<?php


if (isset($_POST['event_id'])) {
	$event_id = $_POST['event_id'];

	$sql = "SELECT * FROM EVENTS WHERE event_id=" . $_POST["event_id"] . ";";

	$result = mysqli_query($link, $sql);

	if (mysqli_num_rows($result) < 1) {
		$response = array( "status" => 404,
			"msg" => "No Events Matching Criteria!" );
	} else {

		while($row = mysql_fetch_array($query)) {

			$event_id 				= $row["event_id"],
			$event_name 			= $row["event_name"],
			$event_start_date	 	= $row["event_start_date"],
			$event_end_date 		= $row["event_end_date"],
			$event_start_time 		= $row["event_start_time"],
			$event_end_time 		= $row["event_end_time"],
			$event_repeated			= $row["event_repeated"],
			$event_description 		= $row["event_description"],
			$event_calendar 		= $row["event_calendar"],
			$event_location_lat		= $row["event_location_lat"],
			$event_location_long 	= $row["event_location_long"],
			$user_id 				= $row["user_id"]

		}
		


		$event_name = (!empty($_POST['event_name'])) ? $_POST['event_name'] : $event_name;
		$event_start_date = (!empty($_POST['event_start_date'])) ? $_POST['event_start_date'] : $event_start_date;
		$event_end_date = (!empty($_POST['event_end_date'])) ? $_POST['event_end_date'] : $event_end_date;
		$event_start_time = (!empty($_POST['event_start_time'])) ? $_POST['event_start_time'] : $event_start_time;
		$event_end_time = (!empty($_POST['event_end_time'])) ? $_POST['event_end_time'] : $event_end_time;
		$event_repeated = (!empty($_POST['event_repeated'])) ? $_POST['event_repeated'] : $event_repeated;
		$event_description = (!empty($_POST['event_description'])) ? $_POST['event_description'] : $event_description;
		$event_calendar = (!empty($_POST['event_calendar'])) ? $_POST['event_calendar'] : $event_calendar;
		$event_location_lat = (!empty($_POST['event_location_lat'])) ? $_POST['event_location_lat'] : $event_location_lat;
		$event_location_long = (!empty($_POST['event_location_long'])) ? $_POST['event_location_long'] : $event_location_long;

		$sql = "UPDATE EVENTS SET event_name = '$event_name', event_start_date = '$event_start_date', event_end_date = '$event_end_date', event_start_time = '$event_start_time', event_end_time = '$event_end_time', event_repeated = '$event_repeated', event_description = '$event_description', event_calendar = '$event_calendar', event_location_lat = '$event_location_lat', event_location_long = '$event_location_long' WHERE event_id = '$event_id'"; 

		if (mysqli_query($link, $sql)) {
			echo "Event updated successfully";
			$response = array( "status" => 200,
				"msg" => "Event Updated!" );
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($link);
			$response = array( "status" => 404,
				"msg" => "Error Updating Event!" );
		}



	}

}	
		//echo json_encode($response);

	//}

mysqli_close($link);

echo '<pre>';
print_r($response);
echo '</pre>';


?>