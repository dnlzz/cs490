<?php
$toURL = "";
$output = "";
$result = "";
$input = json_decode(file_get_contents('php://input'),true);
$request = $input['request'];
$isValid = true;
$json_post = json_encode($input['param']);


switch ($request){
  case "login":
  	$toURL = "https://web.njit.edu/~cab56/service/back-login.php";
	break;
  case "get-events":
  	$toURL = "https://web.njit.edu/~cab56/service/back-get-events.php";
	break;
  default:
  	$isValid = false;
	$result = "invalid request";
	break;
}


if($isValid){
  $ch = curl_init($toURL);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
  curl_setopt($ch, CURLOPT_POSTFIELDS, $json_post);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	'Content-Type: application/json',
	'Content-Length: ' . strlen($json_post)
  ));

  $result = curl_exec($ch);
  curl_close($ch);

  if(!$result){
  	//result was empty
  	$result = "failed";
  }
}

echo '{"response": "'.$request.'","result":"'.$result.'"}';

?>
