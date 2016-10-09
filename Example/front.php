<?php
session_start();
$toURL = "https://web.njit.edu/~cab56/service/middle.php";
$json_post = file_get_contents('php://input');
$decoded = json_decode($json_post, true);

if($decoded['request']=="logout"){
  session_unset();
  session_destroy();
  return;
}else if(isset($_SESSION['id']) && $decoded['request'] != "login"){
  $decoded['param'] = json_decode('{"id": '.$_SESSION['id'].'}');
  $json_post = json_encode($decoded);
}

$ch = curl_init($toURL);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_post);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	'Content-Type: application/json',
	'Content-Length: ' . strlen($json_post)
));

$response = curl_exec($ch);
curl_close($ch);

$jsonResponse = json_decode($response, true);

if($jsonResponse['response'] == "login" && $jsonResponse['result'] != "failed"){
  $_SESSION['id'] = $jsonResponse['result'];
}

echo $response;
?>
