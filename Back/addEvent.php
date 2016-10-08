
<?php require 'config.php'; ?>

<?php

	//if(isset($_POST['user']) && isset($_POST['pass'])) {
		$sql = "SELECT * FROM EVENTS;";

		$result = mysqli_query($link, $sql);

		$response = array();

		if (mysqli_num_rows($result) < 1) {
			$response = array( "status" => 404,
							   "msg" => "No Events Matching Criteria!" );
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
		}


		echo json_encode($response);

	//}

	mysqli_close($link);

echo '<pre>';
print_r($response);
echo '</pre>';

echo $response[0]["event_description"];

?>