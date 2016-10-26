<?php require 'config.php'; ?>

<?php

if (isset($_POST['event_id'])) {

	$input = $_POST["event_info"];

	$sql = "SELECT * FROM EVENTS WHERE event_id=" . $_POST["event_id"] . ";";
	//$sql = "SELECT * FROM EVENTS WHERE event_id=4;";
	$result = mysqli_query($link, $sql);

	if (mysqli_num_rows($result) != 1) {
		$response = array( "status" => 404,
							"msg" 	=> "No Events Matching Criteria!" );
	} else {

		$row = mysqli_fetch_array($result);

		$event_id 				= $row["event_id"];
		$event_name 			= $row["event_name"];
		$event_start_date	 	= $row["event_start_date"];
		$event_end_date 		= $row["event_end_date"];
		$event_start_time 		= $row["event_start_time"];
		$event_end_time 		= $row["event_end_time"];
		$event_repeated			= $row["event_repeated"];
		$event_description 		= $row["event_description"];
		$event_calendar 		= $row["event_calendar"];
		$event_location_lat		= $row["event_location_lat"];
		$event_location_long 	= $row["event_location_long"];
		$user_id 				= $row["user_id"];
		
		

		$event_name = (!empty($_POST["event_info"]['event_name'])) ? $_POST["event_info"]['event_name'] : $event_name;
		$event_start_date = (!empty($_POST["event_info"]['event_start_date'])) ? $_POST["event_info"]['event_start_date'] : $event_start_date;
		$event_end_date = (!empty($_POST["event_info"]['event_end_date'])) ? $_POST["event_info"]['event_end_date'] : $event_end_date;
		$event_start_time = (!empty($_POST["event_info"]['event_start_time'])) ? $_POST["event_info"]['event_start_time'] : $event_start_time;
		$event_end_time = (!empty($_POST["event_info"]['event_end_time'])) ? $_POST["event_info"]['event_end_time'] : $event_end_time;
		$event_repeated = (!empty($_POST["event_info"]['event_repeated'])) ? $_POST["event_info"]['event_repeated'] : 'NULL';
		$event_description = (!empty($_POST["event_info"]['event_description'])) ? $_POST["event_info"]['event_description'] : 'NULL';
		$event_calendar = (!empty($_POST["event_info"]['event_calendar'])) ? $_POST["event_info"]['event_calendar'] : $event_calendar;
		$event_location_lat = (!empty($_POST["event_info"]['event_location_lat'])) ? $_POST["event_info"]['event_location_lat'] : 'NULL';
		$event_location_long = (!empty($_POST["event_info"]['event_location_long'])) ? $_POST["event_info"]['event_location_long'] : 'NULL';

		$sql_edit = "UPDATE EVENTS SET event_name = '$event_name', event_start_date = '$event_start_date', event_end_date = '$event_end_date', event_start_time = '$event_start_time', event_end_time = '$event_end_time', event_repeated = $event_repeated, event_description = '$event_description', event_calendar = '$event_calendar', event_location_lat = $event_location_lat, event_location_long = $event_location_long WHERE event_id = $event_id"; 

		if (mysqli_query($link, $sql_edit)) {
			// echo "Event updated successfully";
			$response = array( "status" => 200,
				"msg" => "Event Updated!");
		} else {
			// echo "Error: " . $sql_edit . "<br>" . mysqli_error($link);
			$response = array( "status" => 404,
				"msg" => "Error Updating Event!",
				"sql_edit" => $sql_edit);
		}


/*
		$response = array( 
				"event_id" 				=> $event_id,
			   	"event_name" 			=> $event_name,
			   	"event_start_date"	 	=> $event_start_date,
				"event_end_date" 		=> $event_end_date,
				"event_start_time" 		=> $event_start_time,
				"event_end_time" 		=> $event_end_time,
				"event_repeated" 		=> $event_repeated,
				"event_description" 	=> $event_description,
				"event_calendar" 		=> $event_calendar,
				"event_location_lat" 	=> $event_location_lat,
				"event_location_long" 	=> $event_location_long,
				"user_id" 				=> $user_id,
				"sql"					=> $sql_edit
			);
*/
	}

		echo json_encode($response);

}
		//echo json_encode($response);

	//}

mysqli_close($link);

// echo '<pre>';
// print_r($response);
// echo '</pre>';


?>