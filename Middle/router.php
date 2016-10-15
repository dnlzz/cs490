<?php

/**.
 * User: Alex Rosen
 * Date: 10/8/2016
 */
session_start();


// read in the post requests
$toURL = "";
$output = "";
$result = "";
$input = json_decode(file_get_contents('php://input'), true);
//$input = json_decode($_POST, true);
//echo $_POST;
$requestType = $input["request"];
$isValid = true;
$requestData = $input["param"];


// what do i do with each post request type
$isValid = true;
switch ($requestType) {
    case "addEvent":
        $toURL = "https://web.njit.edu/~ad473/addEvent.php";
        break;
    case "fileICS":
        // TODO figure out what logic i need to read an .ICS file and put it here (or in another file as chris suggested)
        break;
    case "filePST":
        // TODO figure out what logic i need to read an .pst file and put it here (or in another file as chris suggested)
        break;
    case "getEvent":
        $requestData = Array( "user_id" => $requestData);
        $toURL = "https://web.njit.edu/~ad473/getEvents.php";
        break;
    case "login":
        $toURL = "https://web.njit.edu/~ad473/login.php";
        break;
    case "rmEvent":
        $toURL = "https://web.njit.edu/~ad473/removeEvent.php";
        break;
    case "editEvent":
        $toURL = "https://web.njit.edu/~ad473/editEvent.php";
        break;
    default:
        // echo json_encode("request not valid");
        $isValid = false;
        $result = "invalid request";
        break;
}

if ($isValid) {
    $ch = curl_init($toURL);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    /*curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($requestData)
    ));*/

    $result = curl_exec($ch);
    //echo $requestType;
/*    if($requestType == "login"){
        //$_SESSION["id"] = $result["sesh"]["id"];
        $_SESSION["id"] = 23;
        echo $_SESSION["id"];
    }
    if($requestType == "getEvent"){

        echo("SESSION = ".$_SESSION["id"]);

    }*/

    curl_close($ch);

    if (!$result) {
        //result was empty
        $result = "failed";
    }
}

echo '{"response": "' . $requestType . '","result":' . $result . '}';
?>
