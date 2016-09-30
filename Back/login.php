<?php require 'config.php'; ?>

<?php

	if(isset($_POST['user']) && isset($_POST['pass'])) {
		$sql = "SELECT * FROM test WHERE username='" . $_POST["user"] . "' AND password='" . $_POST["pass"] . "';";

		$result = mysqli_query($link, $sql);

		if (mysqli_num_rows($result) == 1) {

			$response = array( "status" => 200,
								"msg" => "Successful project back-end login" );

		} else {

			$response = array( "status" => 404,
								"msg" => "Failed project back-end login" );

		}

		echo json_encode($response);

	}

	mysqli_close($link);


?>