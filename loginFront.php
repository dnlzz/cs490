<!DOCTYPE HTML>

    <html>
<body>
<?php

//Kyle Van Kirk
//Login Curl PHP Code
//ver. 09/28/2016
//CS490


$usr=$_POST["usr"];
$pswd=$_POST["pswd"];

$ch = curl_init();

$usrInf = array(
    "user" => $usr,
    "pass" => $pswd,
    "uuid" => "0xACA021"
);


curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~ad473/login.php");
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($usrInf));
curl_setopt($ch, CUFRLOPT_RETURNTRANSFER, 1);

$result = curl_exec($ch);
curl_close($ch);

$dec = json_decode($result, true);
if ($dec["status"] == 200) { echo $dec["msg"]; }
	else {echo $dec["msg"]; }

//kill session
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~ad473/login.php");
curl_exec($ch);
curl_close($ch);

return strpos($result, "loginok.html") !== false;
?>
</body>
</html>
