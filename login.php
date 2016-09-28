<?php

$link = mysqli_connect('sql.njit.edu', 'ad473', '-----', 'ad473', 3306, '/usr/local/bin/mysql');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}


	if(isset($_POST['username']) && isset($_POST['password'])) {
		$sql = "SELECT * FROM test WHERE username='" . $_POST["username"] . "' AND password='" . $_POST["password"] . "';";

		$result = mysqli_query($link, $sql);

		if (mysqli_num_rows($result) == 1) {

			$response = array( "status" => 200,
								"msg" => "OK" );

		} else {

			$response = array( "status" => 404,
								"msg" => "username / password incorrect" );

		}

		echo json_encode($response);

	}

	mysqli_close($link);


?>