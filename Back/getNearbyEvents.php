
<?php require 'config.php'; ?>

<?php
	//if(isset($_POST['user']) && isset($_POST['pass'])) {

		// $sql = "SELECT * FROM EVENTS WHERE user_id=" . $_POST["user_id"] . ";";

		$user_id = $_POST["user_id"];

		$lat = $_POST["event_location_lat"];
		$long = $_POST["event_location_long"];

		$latLowerRange = $lat - 1;
		$latUpperRange = $lat + 1;

		$longLowerRange = $long - 1;
		$longUpperRange = $long + 1;


		$sql = "SELECT * FROM EVENTS WHERE (event_location_lat BETWEEN '$latLowerRange' AND '$latUpperRange') AND (event_location_long BETWEEN '$longLowerRange' AND '$longUpperRange') AND user_id = '$user_id';";

		$result = mysqli_query($link, $sql);

		$response = array();

		if (mysqli_num_rows($result) < 1) {
			$res = array( "status" => 404,
							   "msg" => "No Events Matching Criteria!",
							   "p" => $user_id);
		} else {

			while ($row = mysqli_fetch_array($result)) {

				$response[] = array( 
						"event_id" 				=> $row["event_id"],
					   	"event_name" 			=> $row["event_name"],
					   	"event_start_date"	 	=> $row["event_start_date"],
						"event_end_date" 		=> $row["event_end_date"],
						"event_start_time" 		=> $row["event_start_time"],
						"event_end_time" 		=> $row["event_end_time"],
						"event_repeated" 		=> $row["event_repeated"],
						"event_description" 	=> $row["event_description"],
						"event_calendar" 		=> $row["event_calendar"],
						"event_location_lat" 	=> $row["event_location_lat"],
						"event_location_long" 	=> $row["event_location_long"],
						"user_id" 				=> $row["user_id"]
					);
			} 

				$res = array(
								"status" => 200,
								"msg" => $response
					);

		}

		echo json_encode($res);
		
	//}

	mysqli_close($link);

?>