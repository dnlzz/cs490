<?php
session_start();
//Kyle Van Kirk
//Login Curl PHP Code Front End
//ver. 10/10/2016
//CS490

//Set functions to
//all functions fill usrInf to pass to middle end

//login fill function
function login(){
    $usr=$_POST["user"];
    $pswd=$_POST["pass"];
    $request = "login";
    $param=array (
	"user" => $usr,
	"pass" => $pswd
    );
    $usrInf = array (
			"request" => $request,
            "param" => $param
		);
    return $usrInf;
}

function getEvent(){
    $request = "getEvent";
    $param = array("user_id" => $_SESSION["id"]);
    $usrInf = array(
        "request" => $request,
        "param" => $param
    );
    return $usrInf;
}

function addEvent(){
//uses post to fill fields and then create an array that passes the requestType and all the event metadata
    $ev_id=$_POST["event_id"];
    $ev_name=$_POST["event_name"];
    $ev_start_date=$_POST["event_start_date"];
    $ev_end_date=$_POST["event_end_date"];
    $ev_start_time=$_POST["event_start_time"];
    $ev_end_time=$_POST["event_end_time"];
    $ev_repeated=$_POST["event_repeated"];
    $ev_desc=$_POST["event_description"];
    $ev_cal=$_POST["event_calendar"];
    $ev_loc_lat=$_POST["event_location_lat"];
    $ev_loc_long=$_POST["event_location_long"];
    $ev_public=$_POST["event_public"];
    $usr=$_POST["user"];
    $usrInf = array( "request" => $addEvent = "addEvent", "param" => $param = array(
        "event_id" => $ev_id,
        "event_name" => $ev_name,
        "event_start_time" => $ev_start_date,
        "event_end_date" => $ev_end_date,
        "event_start_time" => $ev_start_time,
        "event_end_time" => $ev_end_time,
        "event_repeated" => $ev_repeated,
        "event_description" => $ev_desc,
        "event_calendar" => $ev_cal,
        "event_location_lat" => $ev_loc_lat,
        "event_location_long" => $ev_loc_long,
        "event_public" => $ev_public,
        "user_id" => $_SESSION["id"]
    )
    );
    return $usrInf;
}

function rmEvent(){
    //slack fields
    $ev_id=$_POST["event_id"];
    $usr=$_POST["user"];
    $usrInf = array( "request" => "rmEvent", array(
        "user" => $usr,
        "event_id" => $ev_id
    )
    );
    return $usrInf;
}

function editEvent(){
    //slack fields
    //create field form to post
    $ev_id=$_POST["event_id"];
    $ev_name=$_POST["event_name"];
    $ev_start_date=$_POST["event_start_date"];
    $ev_end_date=$_POST["event_end_date"];
    $ev_start_time=$_POST["event_start_time"];
    $ev_end_time=$_POST["event_end_time"];
    $ev_repeated=$_POST["event_repeated"];
    $ev_desc=$_POST["event_description"];
    $ev_cal=$_POST["event_calendar"];
    $ev_loc_lat=$_POST["event_location_lat"];
    $ev_loc_long=$_POST["event_location_long"];
    $ev_public=$_POST["event_public"];
    $usr=$_POST["user"];
    $usrInf = array( "request" => $request= "editEvent", "param" => $param = array(
        "event_id" => $ev_id,
        "event_name" => $ev_name,
        "event_start_date" => $ev_start_date,
        "event_end_date" => $ev_end_date,
        "event_start_time" => $ev_start_time,
        "event_end_time" => $ev_end_time,
        "event_repeated" => $ev_repeated,
        "event_description" => $ev_desc,
        "event_calendar" => $ev_cal,
        "event_location_lat" => $ev_loc_lat,
        "event_location_long" => $ev_loc_long,
        "event_public" => $ev_public,
        "user_id" => $_SESSION["id"]
    )
    );
    print_r($usrInf);
    return $usrInf;
}

echo "start";
//CODE starts here, check request type then call specified request to fill usrInf
$request=$_POST["request"];
if(isset($_POST["loginbtn"])){
    $usrInf = login();
}
else if (isset($_POST["addbtn"])){
    $usrInf=addEvent();
}
else if(isset($_POST["editbtn"])){
    echo "edit";
    $usrInf=editEvent();
}
else if(isset($_POST["removebtn"])){
    $usrInf=rmEvent();
}

//echo json_encode($usrInf);
function curlFunc($usrInf){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~ar548/cs490/router.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($usrInf));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
$dec = json_decode(curlFunc(login()), true);

//echo $dec[0][0];
//echo $dec["result"]["status"];


if ($dec["result"]["status"] == 200) {
    $_SESSION["id"] = $dec["result"]["msg"];
    session_write_close();

    header('Location: https://web.njit.edu/~ksv22/calendar.php');

}
else {echo $dec["msg"]; }
return strpos($result, "loginok.html") !== false;

?>
