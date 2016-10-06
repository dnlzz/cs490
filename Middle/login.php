
<?php
/* Alex Rosen (Middle end)*/
	$un = $_POST["user"];
	$pw = $_POST["pass"];
	
	
	$frontres = array();

	$post_data_njit = array (
	        "user" => $un,
		"pass" => $pw,
		"uuid" => 0xACA021
	);
	
	$ch = curl_init("https://cp4.njit.edu/cp/home/login");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTREDIR, 3);
	curl_setopt($ch, CURLOPT_POSTFIELDS,  "user=$un&pass=$pw&uuid=0xACA021"/* $post_data_njit*/);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	//$result = rtrim(curl_exec($ch));
	$result = curl_exec($ch);
	
	curl_close($ch);
	//echo $result;
	
	$valid = (strpos($result,"loginok.html"));
	if($valid) {
		echo "Successful NJIT login | ";
		//$frontres["njit"] = "Successful NJIT login | "
	}
	else{
		echo "Failed NJIT login | ";
		//$fontres["njit"] = "Failed.";
	}
	curl_close($ch);

	//echo $result;

	$post_data = array (
		"user" => $un,
		"pass" => $pw
    	);
	$ch = curl_init("https://web.njit.edu/~ad473/login.php" );
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTREDIR, 3);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$res = curl_exec($ch);

	curl_close($ch);

	//$dec = json_decode($res, true);
	echo $res;
/*
	if ($res["status"] == 200) { 
		echo $res["msg"];
		$frontres["back"] = "Backed Success";
	}
	else {
		echo $res["msg"];
		$frontres["back"] = "Backend Failed";
	}
*/
	//echo $s


	//$response = array( "status" => 200, "msg" => $res );
	//echo json_encode($res);
	echo json_encode($frontres);
	//header("Location: https://www.google.com/");

?>
