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
//$input = $_POST;
//$input = json_decode($_POST, true);
//echo $_POST;
$requestType = $input["request"];
$isValid = true;
$requestData = $input["param"];


// what do i do with each post request type
$isValid = true;
switch ($requestType) {
    case "addEvent":
        $requestData = http_build_query($requestData);
        $toURL = "https://web.njit.edu/~ad473/addEvent.php";
        break;
    case "editEvent":
        $requestData = http_build_query($requestData);
        $toURL = "https://web.njit.edu/~ad473/editEvent.php";
        break;
    case "fileICS":
        //$result = json_encode($requestData["contents"].'}');
//        $toSend = json_encode($requestData["contents"]);
//        $chh = curl_init("https://web.njit.edu/~ar548/cs490/ICSread.php");
//        curl_setopt($chh, CURLOPT_CUSTOMREQUEST, 'POST');
//        curl_setopt($chh, CURLOPT_POSTFIELDS, http_build_query($toSend));
//        curl_setopt($chh, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//            'Content-Type: application/json',
//            'Content-Length: ' . strlen($toSend)
//        ));
//        //$result = json_encode(curl_exec($chh));
//        $result = curl_exec($chh);
//        curl_close($chh);


        $fileContents = $requestData["contents"];
        $str = explode("\n", $fileContents);

        $evt = [];
        $events = [];
        $inEvent = false;
        $result = count($str)."\n";

        for($i = 0; $i < 1000; $i++){
            if(!$inEvent){
                // look for the start of an evenr
                if(strpos($str[$i], "BEGIN:VEVENT") !== false){
                    $result = $result."opening event\n";
                    $inEvent = true;
                    continue;
                }
                else{
                    continue;
                }
            }
            else{
                if (strpos($str[$i], "SUMMARY") !== false) {
                    $result = $result."naming event\n";
                    $evt["event_name"] = substr($str, 8);
                }
                if (strpos($str[$i], "DTSTART") !== false) {
                    $result = $result."starting event\n";
                    $evt["event_start_date"] = substr($str[$i], 8, 4) . "-" . substr($str[$i], 12, 2) . "-" . substr($str[$i], 14, 2);
                    $t = intval(substr($str[$i], 17));
                    $h = intdiv($t, 3600);
                    $m = intdiv($t, 60) - 60 * $h;
                    $s = $t % 60;
                    $format = "%02d-%02d-%02d";
                    $evt["event_start_time"] = sprintf($format, $h, $m, $s);
                }
                if (strpos($str[$i], "DTEND") !== false) {
                    $result = $result."ending event\n";
                    $evt["event_end_date"] = substr($str[$i], 6, 4) . "-" . substr($str[$i], 10, 2) . "-" . substr($str[$i], 12, 2);
                    $t = intval(substr($str[$i], 15));
                    $h = intdiv($t, 3600);
                    $m = intdiv($t, 60) - 60 * $h;
                    $s = $t % 60;
                    $format = "%02d-%02d-%02d";
                    $evt["event_end_time"] = sprintf($format, $h, $m, $s);
                }
                if(strpos($str[$i], "END:VEVENT") !== $fileContents){
                    $result = $result."closing event\n";
                    $inEvent = false;
                    //$result = $evt;
//                    print_r($evt);
//                    $events.array_push($evt);
//                    $evt = [];
                }
            }
        }



        $result = json_encode($result);
//        print_r($events);
//        exit();



        $isValid = false;
        // TODO figure out what logic i need to read an .ICS file and put it here (or in another file as chris suggested)
        break;
    case "filePST":
        // TODO figure out what logic i need to read an .pst file and put it here (or in another file as chris suggested)
        break;
    case "getEvent":
        //$requestData = Array( "user_id" => $requestData);
        $toURL = "https://web.njit.edu/~ad473/getEvents.php";
        break;
    case "getNearby":
        $toURL = "https://web.njit.edu/~ad473/getNearbyEvents.php";
        break;
    case "login":
        $toURL = "https://web.njit.edu/~ad473/login.php";
        break;
    case "rmEvent":
        $toURL = "https://web.njit.edu/~ad473/removeEvent.php";
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
    $result = curl_exec($ch);

    curl_close($ch);

    if (!$result) {
        //result was empty
        $result = "failed";
    }
}

echo '{"response": "' . $requestType . '","result":' . $result . '}';
?>
