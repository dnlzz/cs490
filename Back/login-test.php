<?php session_start(); ?>

<?php require '../config.php'; ?>

<?php
	$input = json_decode(file_get_contents('php://input'), true);

	$usr = $input['usr'];
	$pwd = $input['pwd'];
	$id = 0;

	$sql = "SELECT * FROM test WHERE username='" . $usr . "' AND password=" . $pwd . ";";

		$result = mysqli_query($link, $sql);

		if (mysqli_num_rows($result) == 1) {

			// $response = array( "status" => 200,
			// 					  "msg" => "Successful project back-end login" );

			$row = mysqli_fetch_array($result);
			$response["id"] = $row["id"];
			$_SESSION["id"] = $row["id"];
			$id = $row["id"];

		} else {
			$row = mysqli_fetch_array($result);
			$response = array( "status" => 404,
								  "msg" => "Failed project back-end login" );
			$response["row"] = $row;

		}

		$response['sql'] = $sql;
		$response['sesh'] = $_SESSION;

		// echo json_encode($response);
		echo $id;


		mysqli_close($link);

?>


