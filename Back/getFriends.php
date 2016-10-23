
<?php require 'config.php'; ?>

<?php
	//if(isset($_POST['user']) && isset($_POST['pass'])) {

		// $sql = "SELECT * FROM EVENTS WHERE user_id=" . $_POST["user_id"] . ";";
		$sql = "SELECT * FROM FRIENDS WHERE user_id=" . $_POST["user_id"] . ";";

		$result = mysqli_query($link, $sql);

		$friends = array();
		$response = array();

		if (mysqli_num_rows($result) < 1) {
			$res = array( "status" => 404,
							   "msg" => "No Such User!",
							   "user_id" => $_POST["user_id"]);
		} else {

			while ($row = mysqli_fetch_array($result)) {

				$friends[] = array( 
						"friend_id" => $row["friend_id"]
					);
			} 


		}

		for ($i=0; $i < count($friends); $i++) { 
			
			$sql = "SELECT first_name, last_name FROM test WHERE id = " . $friends[$i]["friend_id"] . ";";

			$result = mysqli_query($link, $sql);

				if (mysqli_num_rows($result) < 1) {
				$res = array( "status" => 404,
								   "msg" => "No Friends, Loser!", 
								   "sql" => $sql);
			} else {

				while ($row = mysqli_fetch_array($result)) {

					$response[] = array( 
							"first_name" => $row["first_name"],
							"last_name"	 => $row["last_name"]
						);
				} 


				$res = array(
							"status" => 200,
							"msg" => $response
				);


			}


		}


		echo json_encode($res);
		
	//}

	mysqli_close($link);

?>